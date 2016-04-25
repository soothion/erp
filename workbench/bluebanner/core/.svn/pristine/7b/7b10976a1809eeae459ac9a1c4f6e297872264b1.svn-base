<?php namespace Bluebanner\Core\Model;


class InventoryChange extends BaseModel
{
	
	protected $table = 'core_inventory_change';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {}

	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}

	public function inventory()
	{
		return $this->belongsTo('Bluebanner\Core\Model\InventoryMaster','inventory_id')->withTrashed();
	}
	
	public function warehouse()
	{
	    return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}
	
	
	/*用下面的替换
	public function getRelationModel()
	{
	    if(!isset($this->relation_id) || !isset($this->type))
	    {
	        throw new Exception("you must set relateion_id and type before use relation Model");	        
	    }
	    $relation_id=intval($this->relation_id);
	    $type=intval($this->type);
	    
	   return StockIOMaster::where('type',$type)->where('relation_id',$relation_id)->first();
	    
	}*/
	

	/**
	* 多态实现仓库其他单跟出入库单的关联[出入库单不是属主]
	* //似乎有问题
	*/
	public function relation()
	{
		//重写里面的morphTo
		list($type, $id) = $this->getMorphs('relation', 'type','relation_id');
		switch ($this->$type){
      case '1':
        $class = 'Bluebanner\Core\Model\StockPurchaseMaster';
        break;
				case '7':
				case '-7':
					break;//order class
				default:
					$class ='Bluebanner\Core\Model\StockIOMaster';
					break;
		}

		return $this->belongsTo($class, $id)->withTrashed();
	}

  public function getInventoryByConds($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $change) {
      $change->item;
      $change->warehouse;
      $change->inventory;
      $change->inventory->restock;
      $change->relation;
    }

    return $result;
  }

  public function getLogsByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $log) {
      $log->item;
      $log->agent;
      $log->relation;
      $log->inventory;
      $log->inventory->restock;
    }

    return $result;
  }
}
