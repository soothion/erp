<?php

namespace Bluebanner\Core\Repo;

use Bluebanner\Core\Model\InventoryAllocate;
use Bluebanner\Core\Model\StockTransferAsk;

class Transfer {
  public function master() {
    return new InventoryAllocate();
  }

  public function ask() {
    return new StockTransferAsk();
  }

  // @todo exception
  public function validUniquePendingAskRecord($record) {
    $record = array('status' => 'pending',
      'from_platform_id' => $record['from_platform_id'],
      'warehouse_id' => $record['warehouse_id']);

    if ($this->ask()->condsEq($record)->pluck('id')) {
      throw new \Exception('Record has been existed');
    }
  }

  public function transferByAskId($id) {
    DB::beginTransAction;

    try {


    } catch (\Exception $e) {
      throw new \Exception('');
    }
  }
}