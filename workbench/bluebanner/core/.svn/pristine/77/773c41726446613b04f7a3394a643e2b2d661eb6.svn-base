<?php

namespace Bluebanner\Core\Storage;

class StockService implements StockServiceInterface {
  public function __construct() {

  }

  public function calcLocalPrice($unitPrice, $rate, $cost1a, $cost1b) {
    return round($unitPrice * $cost1a / $rate + $cost1b, 2);
  }

  public function allocateLockQty($qty, $qtyStock, $qtyTotal, $qtyFree) {
    if ($qtyTotal - $qtyStock - $qty >= $qtyFree) {
      return 0;
    }

    if ($qtyTotal - $qtyStock < $qtyFree) {
      return $qty;
    }

    return $qty - ($qtyTotal - $qtyFree - $qtyStock);
  }
}