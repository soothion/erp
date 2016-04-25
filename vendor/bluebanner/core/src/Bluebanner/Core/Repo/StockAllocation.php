<?php
/**
 * Created by VIM
 * Created at 2014-10-10
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Repo
 * @copyright 2014 
 */

namespace Bluebanner\Core\Repo;

use Bluebanner\Core\Model\StockAllocationAsk;
use Bluebanner\Core\Model\InventoryAllocate;
use Bluebanner\Core\Model\InventoryMaster;

use Illuminate\Support\Facades\DB;

class StockAllocation {
  public function log() {
    return new InventoryAllocate();
  }
  
  public function ask() {
    return new StockAllocationAsk();
  }

  public function master() {
    return new InventoryMaster();
  }
  
  /**
   * @param array $master => array(['from'], ['to']), array $log => array(['from'], 'to');
   * @throw \Exception
   **/
  public function fetchInventory($master, $log) {
    foreach ($master['from'] as $key => $value) {
      $this->master()->where('id', $key)->update($value);
    }

    foreach ($master['to'] as $key => $value) {
      $record = $this->master()->create($value);
      $log[$key]['to_inventory_id'] = (int)$record['id'];
      $this->log()->create($log[$key]);
    }
  }
  
  public function operateInventory($master, $log) {
    DB::beginTransAction();

    try {
      $this->fetchInventory($master, $log);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      // @todo
      throw new \Exception('operate inventory failed');
    }
  }


  public function allocateInventory($askId, $master, $log) { 
    DB::beginTransAction();

    try {
      $this->fetchInventory($master, $log);
      $this->ask()->where('id', $askId)->update(array('status' => 'complete'));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      // @todo
      throw new \Exception('allocate inventory failed');
    }
  }
  
}
