<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\WarehouseNameRequiredException;
use Bluebanner\Core\WarehouseDuplicatedException;
class Warehouse extends BaseModel
{
	
	protected $table = 'core_storage_warehouse';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array();
	
	public function validate() {
		if ( ! $name = $this->name)
			throw new WarehouseNameRequiredException('A name is required for a Warehouse, none given.');
		
		$query = $this->newQuery();
		$persisted = $query->where('name', '=', $name)->first();
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new WarehouseDuplicatedException("A Warehouse Nmae already exists with [$name], Warehouse name must be unique .");
		
		return true;
	}
	
	
	public function getWithTrashed()
	{
		$this->withTrashed();
	}
	
	//运费系数
	public function Costparams()
	{
	    return $this->hasMany('Bluebanner\Core\Model\PurchaseCostParams','warehouse_id');
	}
	
}