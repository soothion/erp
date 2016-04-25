<?php

namespace Form\Stock;

//use Cartalyst\Sentry\Facades\FuelPHP\Sentry;

class PurchaseForm extends \BaseForm {

  /**
   * all item_id in the po must be same with the stock purchase record;
   * @param $opts
   * @return array
   */
  public function filterListOpts($opts) {
    $result = array();
    $result['stock']['ne']['status'] = 'done';

    $this->isNumeric('item_id', $opts) && $result['detail']['eq']['item_id'] = $result['item']['eq']['id'] = $opts['item_id'];
    isset($opts['description']) && $opts['description'] && $result['item']['like']['description'] = $opts['description'];
    isset($opts['invoice']) && $opts['invoice'] && $result['purchase']['eq']['invoice'] = $opts['invoice'];

    return $result;
  }

  /**
   * @param array $input
   * @return array array('update' => ..., 'ids' => ...);
   * @throws \Exception
   */
  // @todo exception
  public function filterUpdate(array $input) {
    if (!$input) {
      throw new \Exception('item submitted must be more than 0');
    }

    $result = array();
    foreach ($input as $detail) {
      if ($this->isNumeric('id', $detail) && $this->isNumeric('qty_into', $detail)) {
        $result['ids'][] = $detail['id'];
        $result['update'][$detail['id']] = array('qty_into' => $detail['qty_into']);
      }
    }

    if (!$result) {
      throw new \Exception('item submitted must be more than 0');
    }

    return $result;
  }

  // @todo exception
  public function genStockIO($stock, $update) {
    $result = array('stockDetails' => $update);
    $date = date('Y-m-d H:i:s');
    $uid = \Sentry::getUser()->id;

    foreach ($stock['details'] as $detail) {
      $result['stockDetails'][$detail->id]['agent'] = $uid;
      $result['stockDetails'][$detail->id]['created_at'] = $date;
      $result['stockDetails'][$detail->id]['updated_at'] = $date;
      $result['stockDetails'][$detail->id]['qty_rest'] = $detail->qty_rest - $result['stockDetails'][$detail->id]['qty_into'];

      if ($result['stockDetails'][$detail->id]['qty_rest'] < 0) {
        throw new \Exception('The field qty_rest can not be less than 0');
      }
      unset($result['stockDetails'][$detail->id]['qty_into']);

      $result['stockMaster']['po_id'] = $stock['master']['po_id'];

      $result['ioDetails'][] = array('created_at' => $date, 'updated_at' => $date, 'item_id' => $detail->item_id, 'qty' => $update[$detail->id]['qty_into'], 'relation_did' => $detail->id);
    }

    $result['ioMaster'] = array('created_at' => $date, 'updated_at' => $date, 'relation_id' => $stock['master']['id'], 'type' => 1, 'status' => 0, 'creat_agent' => $uid, 'warehouse_id' => $stock['master']['warehouse_id'], 'relation_invoice' => $stock['master']['relation_invoice']);

    return $result;
  }
}