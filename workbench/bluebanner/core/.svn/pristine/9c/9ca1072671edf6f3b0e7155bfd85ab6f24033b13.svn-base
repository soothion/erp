<?php

namespace Bluebanner\Core\Model;

class StockPurchaseDetail extends BaseModel {
  protected $table = 'core_storage_purchase_detail';

  protected $softDelete = true;

  // @todo
  public function validate() {

  }

  public function warehouse() {
    return $this->belongsTo('Bluebanner\Core\Model\Warehouse', 'final_warehouse_id');
  }

  public function item() {
    return $this->belongsTo('Bluebanner\Core\Model\Item', 'item_id');
  }

  public function agent() {
    return $this->belongsTo('Bluebanner\Core\Model\User', 'agent');
  }

  public function master() {
    return $this->belongsTo('Bluebanner\Core\Model\StockPurchaseMaster', 'master_id');
  }

  public function poDetail() {
    return $this->belongsTo('Bluebanner\Core\Model\PurchaseOrderDetail', 'po_detail_id');
  }
}