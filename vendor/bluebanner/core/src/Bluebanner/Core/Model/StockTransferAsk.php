<?php

namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;

class StockTransferAsk extends BaseModel {
  protected $table = 'core_storage_transfer_ask';

  protected $softDelete = true;

  // @todo
  public function validate() {

  }

  public function warehouse() {
    return $this->belongsTo('Bluebanner\Core\Model\Warehouse', 'warehouse_id');
  }

  public function from_platform() {
    return $this->belongsTo('Bluebanner\Core\Model\Platform', 'from_platform_id');
  }

  public function to_platform() {
    return $this->belongsTo('Bluebanner\Core\Model\Platform', 'to_platform_id');
  }

  public function item() {
    return $this->belongsTo('Bluebanner\Core\Model\Item', 'item_id');
  }
}