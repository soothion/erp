<?php namespace Bluebanner\Core\Model;

class PurchaseReturnDetail extends BaseModel
{
		
	protected $table = 'core_purchase_return_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'return_id' => 'required|integer',
		'item_id' => 'required|integer'
	);
	
	public function validate() {}
	

	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

}