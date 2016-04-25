<?php

namespace Form\Stock;

use Bluebanner\Core\Storage\StockServiceInterface;

class IOForm extends \BaseForm {
  public function __construct(StockServiceInterface $serviceStock) {
    $this->serviceStock = $serviceStock;
  }

  public function filterStockToInventory(array $io) {
    $result = array();
    $now = date('Y-m-d H:i:s');
    $uid = \Sentry::getUser()->id;
    $result['io']['id'] = $io['id'];
    $result['io']['exec_agent'] = $uid;
    $result['io']['exec_at'] = $now;

    foreach ($io['details'] as $key => $detail) {
      $qty_lock = $this->serviceStock->allocateLockQty($detail['qty'], $detail['qty_inventory'], $detail['relation']['qty'], $detail['relation']['qty_free']);
      $result['inventory'][$key] = array('created_at' => $now,
        'updated_at' => $now,
        'warehouse_id' => $io['warehouse_id'],
        'item_id' => $detail['item_id'],
        'qty' => $detail['qty'],
        'qty_free_lock' => $qty_lock,
        'qty_free_unlock' => 0,
        'book_qty' => 0,
        'platform_id' => $detail['relation']['platform_id'],
        'rmbprice' => $detail['relation']['rmbprice'],
        'localprice' => $this->serviceStock->calcLocalPrice($detail['relation']['rmbprice'], $io['relation']['rate'], $detail['item']['category']['cost1a'], $detail['item']['category']['cost1b']),
        'restock_id' => $io['id'],
        'status' => 0,
        'io_at' => $io['updated_at'],
        'po_id' => $io['relation']['po_id'],
        'condition' => 'normal');

      $result['log'][$key] = array('created_at' => $now,
        'updated_at' => $now,
        'warehouse_id' => $io['warehouse_id'],
        'item_id' => $detail['item_id'],
        'relation_id' => $io['relation']['id'],
        'agent' => $uid,
        'type' => '1',
        'qty' => $detail['qty']);
    }

    return $result;
  }
}