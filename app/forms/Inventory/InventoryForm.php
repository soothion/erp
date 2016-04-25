<?php
/**
 * Short description for Inventory.php
 * Created on 2014-06-12
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage Inventory
 * @package Inventory
 * @category
 * @version 0.1
 */

use Bluebanner\Core\Inventory\InventoryServiceInterface;

use Bluebanner\Core\Model\InventoryMaster;

class InventoryForm extends \BaseForm {

  public function __construct(InventoryMaster $modelInventory) {
    $this->modelInventory = $modelInventory;
  }

  public function transAttrs(array $attrs) {
    $keys = array();

    foreach ($attrs as $attr => $value) {
      if (array_key_exists($attr, $keys)) {
        $attrs[$keys[$attr]] = $value;
        unset($attrs[$attr]);
      }
    }
  }

  public function filterListsOpt($opts) {
    $result = array();

    $this->isNumeric('warehouse_id', $opts) && $result['eq']['warehouse_id'] = $opts['warehouse_id'];
    $this->isNumeric('item_id', $opts) && $result['eq']['item_id'] = $opts['item_id'];

    if (isset($opts['status']) && $opts['status'] && is_array($opts['status'])) {
      $result['in']['status'] = $opts['status'];
    }

    if (isset($opts['condition']) && $opts['condition'] && is_array($opts['condition'])) {
      $result['in']['condition'] = $opts['condition'];
    }

    return $result;
  }

  public function filterStatementOpt($opts) {
    $result = $this->filterListsOpt($opts);

    if (isset($opts['date']) && $opts['date'] && $opts['date'] != 'undefined') {
      $result['ge']['date'] = date('Y-m-d H:i:s', strtotime($opts['date']));
      $result['le']['date'] = date('Y-m-d H:i:s', strtotime($opts['date']) + 86400);
    }

    return $result;
  }

  public function filterLogOpt($opts) {
    $result = array();

    $this->isNumeric('warehouse_id', $opts) && $result['eq']['warehouse_id'] = $opts['warehouse_id'];
    $this->isNumeric('item_id', $opts) && $result['eq']['item_id'] = $opts['item_id'];
    $this->isNumeric('type', $opts) && $result['eq']['type'] = $opts['type'];
    $this->isNumeric('relation_id', $opts) && $result['eq']['relation_id'] = $opts['relation_id'];
    $this->isNumeric('agent', $opts) && $result['eq']['agent'] = $opts['agent'];

    if (isset($opts['from']) && $opts['from']) {
      $result['ge']['created_at'] = date('Y-m-d', strtotime($opts['from']));
    }

    if (isset($opts['to']) && $opts['to']) {
      $result['le']['updated_at'] = date('Y-m-d', strtotime($opts['to']));
    }

    if (isset($opts['description']) && $opts['description']) {
      $result['like']['description'] = $opts['description'];
    }

    return $result;
  }

  public function filterHistoryOpt($opts) {
    $result = $this->filterListsOpt($opts);

    if (isset($result['in']['status'])) {
      $inventoryOpt['in']['status'] = $result['in']['status'];
      unset($result['in']['status']);
    }

    if (isset($result['in']['condition'])) {
      $inventoryOpt['in']['condition'] = $result['in']['condition'];
      unset($result['in']['condition']);      
    }

    if (isset($result['in']) && !$result['in']) {
      unset($result['in']);
    }

    isset($inventoryOpt) && $inventoryIds = $this->modelInventory->conds($inventoryOpt)->lists('id');
    isset($inventoryIds) && $inventoryIds && $result['in']['inventory_id'] = $inventoryIds;

    if (isset($opts['to']) && $opts['to'] && $opts['to'] != 'undefined') {
      $result['ge']['updated_at'] = date('Y-m-d H:i:s', strtotime($opts['to']));
      $result['le']['updated_at'] = date('Y-m-d H:i:s', strtotime($opts['to']) + 86400);
    }

    return $result;
  }

  public function filterBookOpt($opts) {
    $result = array();
    $status = array('pending', 'done', 'cancel');

    if (isset($opts['status']) && $opts['status'] && in_array($opts['status'], $status)) {
      $result['eq']['status'] = $opts['status'];
    }

    if (isset($opts['from']) && $opts['from']) {
      $result['ge']['created_at'] = date('Y-m-d', strtotime($opts['from']));
    }

    if (isset($opts['to']) && $opts['to']) {
      $result['le']['updated_at'] = date('Y-m-d', strtotime($opts['to']));
    }

    if (isset($opts['type']) && $opts['type']) {
      if ($opts['type'] == 'io') {
        $result['eq']['type'] = $opts['type'];

        // @todo
        if (isset($opts['invoice']) && $opts['invoice']) {
          $ids = $this->modelPurchaseOrder->where('invoice', 'like', '%' . $opts['invoice'] . '%');

          if ($ids) {
            $result['in']['relation_id'] = $ids;
          }
        }

      } else if ($opts['type'] == 'order') {
        $result['eq']['type'] = $opts['type'];

        // @todo
        if (isset($opts['invoice']) && $opts['invoice']) {
          $ids = $this->modelIOStock->where('invoice', 'like', '%' . $opts['invoice'] . '%');

          if ($ids) {
            $result['in']['relation_id'] = $ids;
          }
        }
      }
    }

    return $result;
  }

  public function filterBalanceOpt($opts) {
    $result = array();

    $this->isNumeric('warehouse_id', $opts) && $result['eq']['warehouse_id'] = $opts['warehouse_id'];
    $this->isNumeric('item_id', $opts) && $result['eq']['item_id'] = $opts['item_id'];

    if (isset($opts['from']) && $opts['from']) {
      $result['ge']['created_at'] = date('Y-m-d', strtotime($opts['from']));
    }

    if (isset($opts['to']) && $opts['to']) {
      $result['lt']['created_at'] = date('Y-m-d', strtotime($opts['to']) + 86400);
    }

    return $result;
  }
}
?>