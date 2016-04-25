<?php
/**
 * Created by VIM
 * Created at 2014-10-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Repo
 * @copyright 2014 
 */

namespace Bluebanner\Core\Repo;

use Bluebanner\Core\Model\InventoryAllocate;
use Bluebanner\Core\Model\InventoryBook;
use Bluebanner\Core\Model\InventoryChange;
use Bluebanner\Core\Model\InventoryDailyLog;
use Bluebanner\Core\Model\InventoryMaster;

use Illuminate\Support\Facades\DB;

class Inventory {
  public function allocation() {
    return new InventoryAllocate();
  }

  public function book() {
    return new InventoryBook();
  }
  
  public function change() {
    return new InventoryChange();
  }

  public function daily() {
    return new InventoryDailyLog();
  }
  
  public function master() {
    return new InventoryMaster();
  }


  public function getNowdayLogs($conds, $page, $size) {
    $result = $this->master()->findByConds($conds, $page, $size)->select('*', DB::raw('sum(qty) as all_qty, sum(extra_qty) as all_extra_qty, sum(book_qty) as all_book_qty'))->groupBy('item_id', 'warehouse_id', 'platform_id')->get();

    return $result;
  }
  
}
