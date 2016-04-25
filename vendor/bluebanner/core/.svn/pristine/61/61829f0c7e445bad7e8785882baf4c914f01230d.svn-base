<?php

namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;

class StockPurchaseMaster extends BaseModel {
  protected $table = 'core_storage_purchase_master';

  protected $softDelete = true;

  // @todo
  public function validate() {

  }

  public function warehouse() {
    return $this->belongsTo('Bluebanner\Core\Model\Warehouse', 'exp_warehouse_id');
  }

  public function agent() {
    return $this->belongsTo('Bluebanner\Core\Model\User', 'agent');
  }

  public function po() {
    return $this->belongsTo('Bluebanner\Core\Model\PurchaseOrder', 'po_id');
  }

  public function details() {
    return $this->hasMany('Bluebanner\Core\Model\StockPurchaseDetail', 'master_id');
  }

  public function detailQueryBuilder() {
    return DB::table(StockPurchaseDetail::getTbl());
  }

  public function poQueryBuilder() {
    return DB::table(PurchaseOrder::getTbl());
  }


  public function getListsByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $stock) {
      $stock->po;
      $stock->po->vendor;
    }

    return $result;
  }

  public function getByIdAndDetailIds($id, $detailIds) {
    $result = array();

    $details = $this->detailQueryBuilder()->where('master_id', $id)->whereIn('id', $detailIds)->get();
    if ($details && count($details) == count($detailIds)) {
      $master = $this->where('id', $id)->first();
      $result = array('master' => $master, 'details' => $details);
    }

    if (!$result) {
      throw new \Exception('Can not find some records in the database');
    }

    return $result;
  }

  public function isDone($id) {
    return $this->detailQueryBuilder()->where('master_id', $id)->where('qty_rest', 0)->pluck('id');
  }

  public function makeStatusDone($id) {
    $update = array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'done');
    $this->where('id', $id)->update($update);
  }

  public function makePurchaseToStock($in) {
    DB::beginTransaction();

    try {
      $this->poQueryBuilder()->where('id', $in['stockMaster']['po_id'])->update($in['purchase']);

      $masterId = $this->createGetId($in['stockMaster']);

      foreach ($in['stockDetails'] as $detail) {
        $detail['master_id'] = $masterId;
        $this->detailQueryBuilder()->insert($detail);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception($e);
    }
  }

  public function rollbackFromPurchase($id) {
    DB::beginTransaction();
    $now = date('Y-m-d H:i:s');

    try {
      $stockId = $this->where('po_id', $id)->pluck('id');
      $this->where('id', $stockId)->delete();
      $this->detailQueryBuilder()->where('master_id', $stockId)->update(array('deleted_at' => $now));

      $this->poQueryBuilder()->where('id', $id)->update(array('status' => 'pending', 'updated_at' => date('Y-m-d H:i:s')));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception($e);
    }
  }

  public function getStatusByPOId($id) {
    return $this->where('po_id', $id)->pluck('status');
  }
}