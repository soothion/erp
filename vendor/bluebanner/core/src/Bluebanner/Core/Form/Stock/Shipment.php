<?php

/**
 * Created by EMACS
 * Created at 2014-10-27
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Form
 * @copyright 2014
 */

namespace Bluebanner\Core\Form\Stock;

use Bluebanner\Core\Form\Base;

class Shipment extends Base {
  public function filterIndex($input) {
    $result = array();

    isset($input['warehouse_from_id']) && is_numeric($input['warehouse_from_id']) && $result['eq']['warehouse_from_id'] = $input['warehouse_from_id'];
    isset($input['warehouse_to_id']) && is_numeric($input['warehouse_to_id']) && $result['eq']['warehouse_to_id'] = $input['warehouse_to_id'];

    return $result;
  }

  public function genStoreMaster($input) {
    return $input;
  }

  public function genStoreDetails($input) {
    if (!$input) {
      return array();
    };
    return $input;
  }

  public function genStoreDetail($input) {
    return $input;
  }

  public function filterUpdateMaster($input) {
    return $input;
  }

  public function filterUpdateDetailsAppend($input) {
    if (!$input) {
      return array();
    };
    return $input;
  }

  public function filterUpdateDetailsModify($input) {

    $result = array();

    foreach ($input as $key => $value) {
      if ($value) {
        $result[$key] = $value;
      }
    }

    return $result;
  }

  public function filterUpdateDetailsDelete(array $input) {
    return $input;
  }

  public function filterUpdateDetail($input) {
    return $input;
  }

  public function confirmShipment($inventories, $inventoriesShip, $warehouseId) {
    $result = array();

    foreach ($inventoriesShip as $inventoryId => $ship) {
      $result[$inventories[$inventoryId]['id']] = array('qty' => $inventories[$inventoryId]['qty'] - $ship['qty'],
                                                        'extra_qty' => $inventories[$inventoryId]['extra_qty'] - $ship['extra_qty'],
                                                        'book_qty' => $ship['qty'] + $ship['extra_qty']);
    }

    return $result;
  }

  public function unconfirmShipment($books) {
    $result = array();

    foreach ($books as $book) {
      $result[$book['inventory']['id']] = array(
          'qty' => $book['inventory']['qty'] + $book['qty'],
          'extra_qty' => $book['inventory']['extra_qty'] + $book['extra_qty'],
          'book_qty' => $book['inventory']['book_qty'] - $book['qty'] - $book['extra_qty']);
    }

    return $result;
  }

  public function genConfirmBook($inventories, $inventoriesShip, $warehouseId, $stockMasterId, $stockDetailId) {
    $result = array();

    foreach ($inventoriesShip as $inventoryId => $ship) {
      $result[$inventories[$inventoryId]['id']] = array(
          'inventory_id' => $inventories[$inventoryId]['id'],
          'relation_id' => $stockMasterId,
          'relation_detail_id' => $stockDetailId,
          'qty' => $ship['qty'],
          'extra_qty' => $ship['extra_qty']);
    }

    return $result;    
  }

  public function genInventoryShip($inventories, $inventoriesShip, $warehouseId) {
    $result = array();

    foreach ($inventoriesShip as $inventoryId => $ship) {
      $record = $inventories[$inventoryId];
      $result['from'][$record['id']] = array('qty' => $record['qty'] - $ship['qty'], 'extra_qty' => $record['extra_qty'] - $ship['extra_qty']);

      $result['to'][$record['id']] = $record;
      unset($result['to'][$record['id']]['created_at']);
      unset($result['to'][$record['id']]['updated_at']);
      unset($result['to'][$record['id']]['deleted_at']);
      $result['to'][$record['id']]['warehouse_id'] = $warehouseId;
      $result['to'][$record['id']]['qty'] = $result['to'][$record['id']]['extra_qty'] = 0;
      $result['to'][$record['id']]['book_qty'] = $ship['qty'] + $ship['extra_qty'];
    }

    return $result;
  }

  public function genLogShip($inventories, $inventoriesShip, $warehouseId, $stockMasterId, $stockDetailId) {
    $result = array();

    foreach ($inventoriesShip as $inventoryId => $ship) {
      $result[$inventories[$inventoryId]['id']] = array(
          //'inventory_id' => $inventories[$inventoryId]['id'],
          'relation_id' => $stockMasterId,
          'relation_detail_id' => $stockDetailId,
          'qty' => $ship['qty'],
          'extra_qty' => $ship['extra_qty']);
    }

    return $result;
  }

  public function genIoMasterShip($master, $invoice, $agent) {
    return array('relation_id' => $master['id'],
                 'relation_invoice' => $master['invoice'],
                 'warehouse_id' => $master['warehouse_from_id'],
                 'status' => 1,
                 'type' => -4,
                 'invoice' => $invoice,
                 'creat_agent' => $agent,
                 'exec_at' => $agent);
  }

  public function genIoDetailsShip($details) {
    $result = array();

    foreach ($details as $detail) {
      $result[] = array('item_id' => $detail['item_id'],
                        'qty' => $detail['qty'],
                        'relation_did' => $detail['id']);
    }

    return $result;
  }

  public function genIoDetailShip($detail) {
    return array('item_id' => $detail['item_id'],
                 'qty' => $detail['qty'],
                 'relation_did' => $detail['id']);
  }

  public function genReachInventory($books, $warehouseId) {
    $result = array();

    foreach ($books as $bookId => $book) {
      $result['from'][$book['inventory']['id']] = array('book_qty' => $book['inventory']['book_qty'] - $book['qty'] - $book['extra_qty']);

      unset($books[$bookId]['inventory']['id']);
      unset($books[$bookId]['inventory']['created_at']);
      unset($books[$bookId]['inventory']['updated_at']);
      unset($books[$bookId]['inventory']['deleted_at']);
      unset($books[$bookId]['inventory']['updated_at']);
      $books[$bookId]['inventory']['warehouse_id'] = $warehouseId;
      $books[$bookId]['inventory']['qty'] = $book['qty'];
      $books[$bookId]['inventory']['extra_qty'] = $book['extra_qty'];
      $books[$bookId]['inventory']['book_qty'] = 0;
      $result['to'][] = $books[$bookId]['inventory'];
    }

    return $result;
  }


  public function filterDetailsFromExcel($array, $queueId, &$generater, &$failed) {
    $result = array();

    foreach ($array as $num => $record) {
      $key = $num + 1;
      if (!$record['sku']) {
        $failed[$key] = array('queue_id' => $queueId,
                              'line' => $num + 1,
                              'content' => implode('|', $record),
                              'desc' => 'sku is null');
        continue;
      }

      if (!$record['platform']) {
        $failed[$key] = array('queue_id' => $queueId,
                          'line' => $num + 1,
                          'content' => implode('|', $record),
                          'desc' => 'platform is null');
        continue;
      }

      if (!$record['qty']) {
        $failed[$key] = array('queue_id' => $queueId,
                              'line' => $num + 1,
                              'content' => implode('|', $record),
                              'desc' => 'qty is null');
        continue;
      }

      $generater['sku'][$key] = $record['sku'];
      $generater['platform'][$key] = $record['platform'];
      $result[$key] = $record;
    }

    if (!$generater['sku'] || !$generater['platform']) {
      throw new \Exception('vaild record < 0');
    }

    return $result;
  }

  public function genDetailsFromExcel($queueId, $shipmentId, $columns, $skus, $platforms, &$all, &$success, &$failed) {
    $skusIntersect = array_intersect($skus, $columns['sku']);
    $skusDiff = array_keys(array_diff($columns['sku'], $skus));

    $platformsIntersect = array_intersect($platforms, $columns['platform']);
    $platformsDiff = array_keys(array_diff($columns['platform'], $platforms));

    foreach ($all as $num => $record) {
      if (in_array($num, $skusDiff)) {
        $failed[$num] = array('queue_id' => $queueId,
                              'line' => $num,
                              'content' => implode('|', $record),
                              'desc' => 'invaild sku');
        continue;
      }

      if (in_array($num, $platformsDiff)) {
        $failed[$num] = array('queue_id' => $queueId,
                              'line' => $num,
                              'content' => implode('|', $record),
                              'desc' => 'invaild platform');
        continue;
      }

      if (!$skusIntersect || !$platformsIntersect) {
        continue;
      }

      $success[$num] = array('shipment_id' => $shipmentId,
                             'item_id' => array_search($record['sku'], $skusIntersect),
                             'platform_id' => array_search($record['platform'], $platformsIntersect),
                             'qty' => $record['qty']);
    }
  }
}