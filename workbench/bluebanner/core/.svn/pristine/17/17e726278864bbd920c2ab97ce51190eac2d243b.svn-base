<?php namespace Bluebanner\Core\Model;

class PurchaseSkuDefault extends BaseModel
{
	
	protected $table = 'core_purchase_sku_default';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public static $rules = array(
		'item_id' => 'required|integer',
	);
	
	public function validate() {}

	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}

	public function vendor()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Vendor','vendor_id');
	}
}