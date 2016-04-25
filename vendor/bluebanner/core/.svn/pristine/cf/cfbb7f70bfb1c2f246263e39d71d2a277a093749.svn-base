<?php

/**
 * Created by EMACS
 * Created at 2014-11-06
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Repo
 * @copyright 2014
 */

namespace Bluebanner\Core\Repo;

use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\InventoryMaster;

use Illuminate\Support\Facades\DB;

class StockIo {
  public function master() {
    return new StockIOMaster();
  }

  public function detail() {
    return new StockIODetail();
  }

  public function inventory() {
    return new InventoryMaster();
  }

  public function genInvoice() {
    $array = DB::table('core_storage_io_master')->where('created_at', '>=', date('Y-m-d'))->get();

    $result = count($array) + 1;
    while (true) {
      if (!in_array($result, $array)) {
        return 'I' . date('ymd') . $result;
      }
      $result++;
    }
  }

}