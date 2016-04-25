<?php

use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\StockPurchaseMaster;

use \Form\Stock\LogForm as StockLogForm;

class APIStockLogController extends \BaseController {
  public function __construct(StockIOMaster $modelStockIOMaster, StockIODetail $modelStockIODetail, StockPurchaseMaster $modelStockPurchaseMaster, StockLogForm $formStockLog) {
    $this->modelStockIOMaster = $modelStockIOMaster;
    $this->modelStockIODetail = $modelStockIODetail;
    $this->modelStockPurchaseMaster = $modelStockPurchaseMaster;

    $this->formStockLog = $formStockLog;
  }

  public function orders() {
    $pg = Input::get('pg', 1);
    $size = (int)Input::get('size');
    $getData = Input::get();

    $size = ($size < 10 || $size > 50) ? 21 : $size + 1;
    $formData = $this->formStockLog->filterOrdersListOpts($getData);
    if (isset($getData['vendor_id']) && is_numeric($getData['vendor_id'])) {
      $relationId = $this->modelStockPurchaseMaster->distinct()->where('vendor_id', $getData['vendor_id'])->lists('id');

      if (!$relationId) {
        return array();
      }

      $formData['in']['id'] = $this->modelStockIOMaster->distinct()->whereIn('relation_id', $relationId)->lists('id');

      if (!$formData['in']['id']) {
        return array();
      }
    }
    if (isset($getData['item_id']) && is_numeric($getData['item_id'])) {
      if (isset($formData['in']['id'])) {
        $formData['in']['id'] = $this->modelStockIODetail->distinct()->where('item_id', $getData['item_id'])->whereIn('id', $formData['in']['id'])->lists('io_id');
      } else {
        $formData['in']['id'] = $this->modelStockIODetail->distinct()->where('item_id', $getData['item_id'])->lists('io_id');
      }

      if (!$formData['in']['id']) {
        return array();
      }
    }
    $orders = $this->modelStockIOMaster->getOrdersByOpts($formData, $pg, $size);

    return $orders;
  }

  public function order($id) {
    $order = $this->modelStockIOMaster->where('id', (int)$id)->first();

    if ($order) {
      foreach ($order->details as $detail) {
        $detail->item;
      }
      return $order;
    }
  }

}