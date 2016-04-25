<?php namespace Bluebanner\Core\Model;

class PurchaseOrderDetail extends BaseModel
{
	
	protected $touches = array('order');
	
	protected $table = 'core_purchase_order_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'order_id' => 'required|integer',
		'item_id' => 'required|integer',
	);
	
	public function validate() {}
	
	public function warehouse()
	{
		# code...
	}
	
	public function order()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchaseOrder');
	}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

}