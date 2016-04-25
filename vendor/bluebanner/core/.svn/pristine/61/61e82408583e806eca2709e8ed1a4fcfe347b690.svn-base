<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\PurchaseVendorNameRequiredException;
use Bluebanner\Core\PurchaseVendorCodeRequiredException;
use Bluebanner\Core\PurcaseVendorCategoryRequiredException;
use Bluebanner\Core\PurchaseVendorDuplicatedException;


class Vendor extends BaseModel
{
	
	protected $table = 'core_purchase_vendor';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public static $rules = array(
		'code' => 'required|unique:core_purchase_vendor'
	);
	
	public function validate() {
		if ( ! $name = $this->name)
			throw new PurchaseVendorNameRequiredException('A name is required for a Vendor, none given.');

		if ( ! $code = $this->code)
			throw new PurchaseVendorCodeRequiredException('A code is required for a Vendor, none given.');

		//if ( ! $categories = $this->categorys_id)//类型可以为空
			//throw new PurcaseVendorCategoryRequiredException('A Category is Required for a Vendor, none given.');

		$query = $this->newQuery();
		$persisted = $query->where('code', '=', $code)->first();
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new PurchaseVendorDuplicatedException("A Vendor already exists with code [$code], code must be unique for Vendor.");

		return true;
	}
}