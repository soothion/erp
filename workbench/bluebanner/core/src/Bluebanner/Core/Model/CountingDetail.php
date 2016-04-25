<?php namespace Bluebanner\Core\Model;


class CountingDetail extends BaseModel
{
	
	protected $table = 'core_storage_counting_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}
	public function master()
	{
		return $this->belongsTo('Bluebanner\Core\Model\CountingMaster','io_id');
	}
	
}
