<?php namespace Bluebanner\Core\Model;

class Storage extends BaseModel
{
	
	protected $table = 'core_storage_container';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array();
	
	public function validate() {
		if ( ! $warehouse_id = $this->warehouse_id)
			throw new \Exception('A wharehouse id is required for a Container, none given.');

		if ( is_null($parent_id = $this->parent_id))
			throw new \Exception('A parent id is required for a Container, none given.');

		if ( ! $barcode = $this->barcode)
			throw new \Exception('A barcode is required for a Container, none give.');

		if ( 0 != $parent_id && ! $parent = $this->find($parent_id))
			throw new \Exception("the given parent id [$parent_id] is not found.");
		
		$query = $this->newQuery();
		$persisted = $query->where('barcode', '=', $barcode)->first();
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new \Exception("A barcode already exists with [$barcode], barcode must be unique.");
		
		return true;
	}

	public function warehouse()
	{
		return $this->belongsTo('core_storage_warehouse');
	}
	
	
}