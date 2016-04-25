<?php namespace Bluebanner\Core\Model;


class InventoryBook extends BaseModel
{

	protected $table = 'core_inventory_book';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {}
	
//  START
//  不知道是个啥意思  应该没用
	
// 	public function item()
// 	{
// 		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
// 	}

// 	public function warehouse()
// 	{
// 		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
// 	}
//  END
	
	public function inventory()
	{
	    return $this->belongsTo('Bluebanner\Core\Model\InventoryMaster','inventory_id');
	}
	
	public function IORelations()
	{
	    return $this->belongsTo('Bluebanner\Core\Model\StockIOMaster','relation_id')->withTrashed();
	}
	
	public function IODetailRelations()
	{
	    return $this->belongsTo('Bluebanner\Core\Model\StockIODetail','relation_detail_id')->withTrashed();
	}
    
	///数据表未建立  暂时保留
	public function OrderRelations()
	{
	    //return $this->belongsTo('Bluebanner\Core\Model\StockIOMaster','relation_id');
	}
	
	public function OrderDetailRelations()
	{
	    //return $this->belongsTo('Bluebanner\Core\Model\StockIOMaster','relation_id');
	}
	
	/**
	* 多态实现仓库其他单跟出入库单的关联[出入库单不是属主]
	* //似乎有问题
	*/
	public function relation()
	{
		//重写里面的morphTo
		list($type, $id) = $this->getMorphs('relation', 'type','relation_id');
		switch ($this->$type){
				case 'order':
					break;//order class
				case 'io':
				default:
					$class ='Bluebanner\Core\Model\StockIOMaster';
					break;
		}

		return $this->belongsTo($class, $id)->withTrashed();
	}

  public function getInventoryByConds($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $book) {
      $book->inventory;
      $book->relation;

      if ($book->type == 'io') {
        $book->IODetailRelations;
      } else {
        $book->OrderRelations;
      }
    }

    return $result;
  }

  public function getLogsByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $log) {
    }

    return $result;
  }
	
}
