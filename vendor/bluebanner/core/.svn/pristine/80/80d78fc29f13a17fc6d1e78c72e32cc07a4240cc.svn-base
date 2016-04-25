<?php namespace Bluebanner\Core\Model;


class InventoryAllocate extends BaseModel
{
	
	protected $table = 'core_inventory_allocate';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}

	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}

  public function inventory() {
    
  }

  public function getLogsByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $log) {
    }

    return $result;
  }
}
