<?php
/**
 * Created by VIM
 * Created at 2014-10-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Form
 * @copyright 2014 
 */

namespace Bluebanner\Core\Form\Inventory;

use Bluebanner\Core\Form\Base;

class Inventory extends Base {
  // @todo exception
  public function filterExtraCanBeOpera($inventories, $strict = true) {
    $result = array();

    foreach ($inventories as $inventory) {
      if ($inventory['extra_qty'] != 0 && $inventory['extra_qty'] + $inventory['qty'] > $inventory['book_qty']) {
        $result[] = $inventory;
      }
    }

    if ($strict && !$result) {
      throw new \Exception('no extra inventory can be opera');
    }

    return $result;
  }

  public function filterItemCanBeOpera($inventories, $strict = true) {
    $result = array();

    foreach ($inventories as $inventory) {
      if ($inventory['qty'] + $inventory['extra_qty'] > $inventory['book_qty']) {
        $result[] = $inventory;
      }
    }

    if ($strict && !$result) {
      throw new \Exception('no inventory can be opera');
    }

    return $result;
  }

  public function filterNowday($input) {
    $result = array();

    isset($input['warehouse_id']) && is_numeric($input['warehouse_id']) && $result['eq']['warehouse_id'] = $input['warehouse_id'];
    isset($input['item_id']) && is_numeric($input['item_id']) && $result['eq']['item_id'] = $input['item_id'];
    isset($input['platform_id']) && is_numeric($input['platform_id']) && $result['eq']['platform_id'] = $input['platform_id'];

    return $result;
  }
  
  public function filterAllocations($input) {
    $result = array();

    isset($input['warehouse_id']) && is_numeric($input['warehouse_id']) && $result['eq']['warehouse_id'] = $input['warehouse_id'];
    isset($input['to_platform_id']) && is_numeric($input['to_platform_id']) && $result['eq']['to_platform_id'] = $input['to_platform_id'];
    isset($input['from_platform_id']) && is_numeric($input['from_platform_id']) && $result['eq']['from_platform_id'] = $input['from_platform_id'];

    return $result;
  }

  public function filterBooks($input) {
    $result = array();

    return $result;
  }
  
  public function filterChanges($input) {
    $result = array();

    isset($input['warehouse_id']) && is_numeric($input['warehouse_id']) && $result['eq']['warehouse_id'] = $input['warehouse_id'];
    isset($input['item_id']) && is_numeric($input['item_id']) && $result['eq']['item_id'] = $input['item_id'];
    isset($input['platform_id']) && is_numeric($input['platform_id']) && $result['eq']['platform_id'] = $input['platform_id'];
    isset($input['qty']) && is_numeric($input['qty']) && $result['eq']['qty'] = $input['qty'];

    return $result;
  }
  
}
