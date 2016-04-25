<?php
namespace Bluebanner\Core\Model;

class InventoryDailyLog extends BaseModel
{
    protected $table = 'core_inventory_daily_log';
    
    protected $guarded = array('id');
    
    protected $softDelete = true;
    
    public $rules = array();
    
    public function validate() {
        
    }
    
    public function item()
    {
        return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
    }
    
    public function inventory()
    {
        if(!isset($this->warehouse_id) || !isset($this->item_id) || !isset($this->restock_id) || !isset($this->status) || !isset($this->condition))
	    {
	        throw new Exception("you must set other attributes before link to inventory");	        
	    }
	    
	    $warehouse_id=intval($this->warehouse_id);
	    $item_id=intval($this->item_id);
	    $restock_id=intval($this->restock_id);
	    $status=intval($this->status);
	    $condition=$this->condition;
	    
	   return InventoryMaster::where('warehouse_id',$warehouse_id)->where('item_id',$item_id)
	   ->where('restock_id',$restock_id)->where('status',$status)->where('condition',$condition)->first();
    }

    public function getInventoryByConds($conds, $pg = 1, $size = 16) {
      $result = $this->findByConds($conds, $pg, $size, 1)->get();

      foreach ($result as $key => $log) {
        $inventory = $log->inventory();
        $result[$key]['inventory'] = $inventory ? $inventory->toArray() : array();
      }

      return $result;
    }

  public function getLogsByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $id => $log) {
      $inventory = $log->inventory();
      $result[$id]['inventory'] = $inventory ? $inventory->toArray() : array();
    }

    return $result;
  }
}