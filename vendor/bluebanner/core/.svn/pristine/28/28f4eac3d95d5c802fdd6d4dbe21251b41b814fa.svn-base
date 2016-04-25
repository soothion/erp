<?php
/**
 * Created by VIM
 * Created at 2014-10-10
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Form
 * @copyright 2014 
 */

namespace Bluebanner\Core\Form\Stock;

use Bluebanner\Core\Form\Base;

class Allocation extends Base {
  public function filterAskLists($input) {
    $result = array();

    isset($input['item_id']) && $result['eq']['item_id'] = $input['item_id'];
    isset($input['warehouse_id']) && $result['eq']['warehouse_id'] = $input['warehouse_id'];
    isset($input['platform_id']) && $result['eq']['platform_id'] = $input['platform_id'];
    isset($input['status']) && $result['eq']['status'] = $input['status'];

    return $result;
  }
  
  public function filterAskListAdd($input) {
    $result = array();

    isset($input['item_id']) && is_numeric($input['item_id']) && $result['item_id'] = $input['item_id'];
    isset($input['warehouse_id']) && is_numeric($input['warehouse_id']) && $result['warehouse_id'] = $input['warehouse_id'];
    isset($input['from_platform_id']) && is_numeric($input['from_platform_id']) && $result['from_platform_id'] = $input['from_platform_id'];
    isset($input['qty']) && is_numeric($input['qty']) && $result['qty'] = $input['qty'];

    return $result;
  }

  public function filterAskListModify($input) {
    $result = array();

    isset($input['item_id']) && is_numeric($input['item_id']) && $result['item_id'] = $input['item_id'];
    isset($input['qty']) && is_numeric($input['qty']) && $result['qty'] = $input['qty'];
    isset($input['warehouse_id']) && is_numeric($input['warehouse_id']) && $result['warehouse_id'] = $input['warehouse_id'];
    isset($input['from_platform_id']) && is_numeric($input['from_platform_id']) && $result['from_platform_id'] = $input['from_platform_id'];

    return $result;
  }
  
  public function filterReplyLists($input) {
    $result = array();

    isset($input['item_id']) && $result['eq']['item_id'] = $input['item_id'];
    isset($input['warehouse_id']) && $result['eq']['warehouse_id'] = $input['warehouse_id'];
    isset($input['to_platform_id']) && $result['eq']['to_platform_id'] = $input['to_platform_id'];
    if (isset($input['status']) && in_array($input['status'], array('confirmed', 'complete'))) {
      $result['eq']['status'] = $input['status'];
    } else {
      $result['ne']['status'] = 'pending';
    }

    return $result;
  }
  
  public function filterFetch($input) {
    return $input;
  }

  public function filterSend($input) {
    return $input;
  }

  public function filterTake($input) {
    return $input;
  }
  
  public function filterDrop($input) {
    return $input;
  }
  
  public function genFetchMaster($inventories, $inventoriesFifo, $platformId) {
    $result = array('from' => array(), 'to' => array());

    foreach ($inventoriesFifo as $inventoryId => $inventoryFifo) {
      $result['from'][$inventoryFifo['id']] = array('extra_qty' => $inventoryFifo['qty_from']);

      $inventories[$inventoryId]['extra_qty'] = $inventoryFifo['qty_to'];
      $inventories[$inventoryId]['platform_id'] = $platformId;
      $inventories[$inventoryId]['qty'] = 0;
      $inventories[$inventoryId]['book_qty'] = 0;
      unset($inventories[$inventoryId]['id']);
      unset($inventories[$inventoryId]['created_at']);
      unset($inventories[$inventoryId]['updated_at']);
      unset($inventories[$inventoryId]['deleted_at']);
      $result['to'][$inventoryId] = $inventories[$inventoryId];
    }

    return $result;
  }

  public function genFetchLog($inventories, $inventoriesFifo, $platformId) {
    $result = array();

    foreach ($inventoriesFifo as $inventoryId => $inventoryFifo) { 
      $result[$inventoryId] = array('warehouse_id' => $inventories[$inventoryId]['warehouse_id'], 'from_platform_id' => $inventories[$inventoryId]['platform_id'], 'to_platform_id' => $platformId, 'from_inventory_id' => $inventoryFifo['id'], 'qty' => $inventoryFifo['qty_to']);
    }

    return $result;
  }
}
