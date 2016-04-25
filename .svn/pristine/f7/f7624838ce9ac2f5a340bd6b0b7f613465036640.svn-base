<?php
/**
 * Created by VIM
 * Created at 2014-10-09
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package API
 * @copyright 2014 
 */

use Bluebanner\Core\Repo\StockAllocation as RepoAllocation;

use Bluebanner\Core\Form\Stock\Allocation as FormAllocation;
use Bluebanner\Core\Form\Inventory\Inventory as FormInventory;

class APIStockAllocationController extends \BaseController {
  public function __construct(RepoAllocation $repoAllocation, FormAllocation $formAllocation, FormInventory $formInventory) {
    $this->repoAllocation = $repoAllocation;

    $this->formAllocation = $formAllocation;
    $this->formInventory = $formInventory;
  }

  /**
   * invoice
   **/
  public function invoice() {
    // @todo
    return 'INVOICE1234';
  } 
  
  /**
   * ask lists
   **/
  public function askLists() {
    $inputGet = Input::get();
    $inputGen = $this->formAllocation->filterAskLists($inputGet);

    // @todo
    $inputGen['eq']['to_platform_id'] = 1;

    $page = $this->formAllocation->page($inputGet);
    $size = $this->formAllocation->size($inputGet) + 1;

    return $this->repoAllocation->ask()->findByConds($inputGen, $page, $size)->get();
  }

  /**
   * ask list
   **/
  public function askList() {

  }

  /**
   * ask list edit
   **/
  public function askListEdit($id) {
    // @todo
    $platformId = '1';
    return $this->repoAllocation->ask()->where('id', $id)->where('to_platform_id', $platformId)->first();
  }

  /**
   * ask list add
   *
   * need from_platform_id to_platform_id quantity
   **/
  public function askListAdd() {
    $inputGet = Input::get();
    $inputGen = $this->formAllocation->filterAskListAdd($inputGet);
    // @todo
    $inputGen['to_platform_id'] = '1';
    $this->repoAllocation->ask()->create($inputGen);
  }
   
  /**
   * ask list delete
   **/
  public function askListDel($id) {
    // @todo
    $platformId = '1';
    $this->repoAllocation->ask()->where('id', $id)->where('to_platform_id', $platformId)->delete();
  }
   
  /**
   * ask list modify
   **/
  public function askListModify($id) {
    $inputGet = Input::get();
    // @todo
    $platformId = '1';
    $inputGen = $this->formAllocation->filterAskListModify($inputGet);
    $this->repoAllocation->ask()->where('id', $id)->where('to_platform_id', $platformId)->update($inputGen);
  }

  /**
   * submit ask list 
   **/
  public function askListSubmit($id) {
    // @todo
    $platformId = '1';
    $this->repoAllocation->ask()->where('id', $id)->where('to_platform_id', $platformId)->update(array('status' => 'confirmed'));
  }

  /**
   * reply lists
   **/ 
  public function replyLists() {
    $inputGet = Input::get();
    $inputGen = $this->formAllocation->filterReplyLists($inputGet);

    // @todo
    $inputGen['eq']['from_platform_id'] = 2;

    $page = $this->formAllocation->page($inputGet);
    $size = $this->formAllocation->size($inputGet);
    return $this->repoAllocation->ask()->findByConds($inputGen, $page, $size)->get();
  }

  /**
   * reply agree
   **/
  public function replyAgree($id) {
    $askList = $this->repoAllocation->ask()->where('id', $id)->first();

    if ($askList) {
      $inventories = $this->repoAllocation->master()->where('item_id', $askList['item_id'])->where('platform_id', $askList['from_platform_id'])->where('warehouse_id', $askList['warehouse_id'])->where('extra_qty', '<>', 0)->get()->toArray();
      $inventoriesUseful = $this->formInventory->filterExtraCanBeOpera($inventories);
      $inventoriesAllocated = $this->fifoAllocate($inventoriesUseful, $askList['qty']);

      $masterGen = $this->formAllocation->genFetchMaster($inventoriesUseful, $inventoriesAllocated, $askList['to_platform_id']);
      $logGen = $this->formAllocation->genFetchLog($inventoriesUseful, $inventoriesAllocated, $askList['to_platform_id']);

      $this->repoAllocation->allocateInventory($askList['id'], $masterGen, $logGen);
    }
  }

  /**
   * send inventory to other platform
   **/
  public function send() {
    $inputGet = Input::get();
    // @todo
    $platformId = '1';

    $inputFiltered = $this->formAllocation->filterSend($inputGet);

    $inventories = $this->repoAllocation->master()->where('platform_id', $platformId)->where('item_id', $inputFiltered['item_id'])->where('warehouse_id', $inputFiltered['warehouse_id'])->where('extra_qty', '<>', 0)->get()->toArray();
    $inventoriesUseful = $this->formInventory->filterExtraCanBeOpera($inventories);
    $inventoriesAllocated = $this->fifoAllocate($inventoriesUseful, $inputFiltered['qty']);

    $masterGen = $this->formAllocation->genFetchMaster($inventoriesUseful, $inventoriesAllocated, $inputFiltered['to_platform_id']);
    $logGen = $this->formAllocation->genFetchLog($inventoriesUseful, $inventoriesAllocated, $inputFiltered['to_platform_id']);

    $this->repoAllocation->operateInventory($masterGen, $logGen);
  } 

  /**
   * take inventory from free platform
   **/
  public function take() {
    $inputGet = Input::get();
    // @todo
    $platformId = '1';
    $freePlatformId = '0';

    $inputFiltered = $this->formAllocation->filterTake($inputGet);
    $inventories = $this->repoAllocation->master()->where('platform_id', $freePlatformId)->where('item_id', $inputFiltered['item_id'])->where('warehouse_id', $inputFiltered['warehouse_id'])->where('extra_qty', '<>', 0)->get()->toArray();
    $inventoriesUseful = $this->formInventory->filterExtraCanBeOpera($inventories);
    $inventoriesAllocated = $this->fifoAllocate($inventoriesUseful, $inputFiltered['qty']);
    $masterGen = $this->formAllocation->genFetchMaster($inventoriesUseful, $inventoriesAllocated, $platformId);
    $logGen = $this->formAllocation->genFetchLog($inventoriesUseful, $inventoriesAllocated, $platformId);

    $this->repoAllocation->operateInventory($masterGen, $logGen);
  }

  /**
   * send inventory to free platform
   **/
  public function drop() {
    $inputGet = Input::get();
    // @todo
    $platformId = '1';
    $freePlatformId = '0';

    $inputFiltered = $this->formAllocation->filterTake($inputGet);
    $inventories = $this->repoAllocation->master()->where('platform_id', $platformId)->where('item_id', $inputFiltered['item_id'])->where('warehouse_id', $inputFiltered['warehouse_id'])->where('extra_qty', '<>', 0)->get()->toArray();
    $inventoriesUseful = $this->formInventory->filterExtraCanBeOpera($inventories);
    $inventoriesAllocated = $this->fifoAllocate($inventoriesUseful, $inputFiltered['qty']);
    $masterGen = $this->formAllocation->genFetchMaster($inventoriesUseful, $inventoriesAllocated, $freePlatformId);
    $logGen = $this->formAllocation->genFetchLog($inventoriesUseful, $inventoriesAllocated, $freePlatformId);

    $this->repoAllocation->operateInventory($masterGen, $logGen);
  }

  /**
   * FIFO allocate inventory
   * 
   * @param $inventories
   * @param $allocations
   * @return array
   * @throw \Exception
   **/
  // @todo Exception
  private function fifoAllocate($inventories, $allocations) {
    $result = array();

    foreach ($inventories as $inventoryId => $inventory) {
      $diff = $inventory['book_qty'] - $inventory['qty'];

      if ($diff <= 0) {
        $allocations -= $inventory['extra_qty'];

        if ($allocations > 0) {
          $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $inventory['extra_qty'], 'qty_from' => 0);
        } else {
          $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $allocations + $inventory['extra_qty'], 'qty_from' => -$allocations);
          break;
        }

      } else {
        $allocations -= $inventory['extra_qty'] - $diff;

        if ($allocations > 0) {
          $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $inventory['extra_qty'] - $diff, 'qty_from' => $diff);
        } else {
          $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $allocations + $inventory['extra_qty'] - $diff, 'qty_from' => -$allocations + $diff);
          break;
        }

      }
    }

    if ($allocations > 0) {
      throw new \Exception('inventory can become under-allocated');
    }
    
    return $result;
  }
  
  /**
   * @deprecated
   **/
  private function lockFifoAllocate($inventories, $allocations) {
    $result = array();

    foreach ($inventories as $inventoryId => $inventory) {
      /*$allocations -= $inventory['qty'];
      if ($allocations > 0) {
        $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $inventory['qty'], 'qty_from' => 0);
      } else {
        $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $allocations + $inventory['qty'], 'qty_from' => -$allocations);
        break;
      }*/
      // need book_qty
      $allocations -= $inventory['qty'] - $inventory['book_qty'];
      if ($allocations > 0) {
        $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $inventory['qty'] - $inventory['book_qty'], 'qty_from' => $inventory['book_qty']);
      } else {
        $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $allocations + $inventory['qty'] - $inventory['book_qty'], 'qty_from' => -$allocations + $inventory['book_qty']);
        break;
      }
    }

    if ($allocations > 0) {
      throw new \Exception('inventory can become under-allocated');
    }

    return $result;
  }

  /**
   * @deprecated
   **/
  private function unlockFifoAllocate($inventories, $allocations) {
    $result = array();
    foreach ($inventories as $inventoryId => $inventory) {
      $allocations -= $inventory['unlock_qty'];
      if ($allocations > 0) {
        $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $inventory['unlock_qty'], 'qty_from' => 0);
      } else {
        $result[$inventoryId] = array('id' => $inventory['id'], 'qty_to' => $allocations + $inventory['unlock_qty'], 'qty_from' => -$allocations);
        break;
      }
    }

    if ($allocations > 0) {
      throw new \Exception('inventory can become under-allocated');
    }

    return $result;
  }
  
}
