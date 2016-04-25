<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\ItemSKURequiredException;
use Bluebanner\Core\ItemCategoryRequiredException;
use Bluebanner\Core\CategoryNotFoundException;
use Bluebanner\Core\ItemSKUDuplicatedException;

class Item extends BaseModel
{
	
	protected $table = 'core_item_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'sku' => 'required|unique:core_item_master',
		'category_id' => 'required|integer|unique:core_item_master'
	);
	
	public function validate() {
		if ( ! $sku = $this->sku)
			throw new ItemSKURequiredException('A SKU is required for an Item, none given.');
		
		if ( ! $cid = $this->category_id)
			throw new ItemCategoryRequiredException('A category is required for an Item, none given.');
			
		if ( ! $category = Category::find($cid))
			throw new CategoryNotFoundException("A category is required for an Item, the given [$cid] can not found.");
			
		$query = $this->newQuery();
		$persisted = $query->where('sku', '=', $sku)->first();
		
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new ItemSKUDuplicatedException("An Item already exists with SKU [$sku], SKU must be unique for items.");

		return true;
	}
	
	public function scopeActive($query)
	{
		return $query->where('is_active', '=', '1');
	}
	
	public function category()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Category');
	}

	public function spq()
	{
		return $this->hasOne('Bluebanner\Core\Model\PurchaseSkuDefault');
	}

	public function bom()
	{
		return $this->hasMany('Bluebanner\Core\Model\ItemBom', 'parent_id');
	}
	
	public function Instrcution()
	{
	    return $this->hasMany('Bluebanner\Core\Model\ItemInstrcution');
	}
	
	public function Attribute()
	{	     
	    return $this->hasMany('Bluebanner\Core\Model\ItemAttribute');
	}
	
	public function Keyword()
	{
	    
	    return $this->hasMany('Bluebanner\Core\Model\ItemKeyword');
	}
	
	public function Feature()
	{
	  
	    return $this->hasMany('Bluebanner\Core\Model\ItemFeature');
	}

	public function cost()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchaseCostParams');
	}

	public function quotations()
	{
		return $this->hasMany('Bluebanner\Core\Model\VendorQuotation');
	}

	public function quotation()
	{
		return $this->hasOne('Bluebanner\Core\Model\PurchaseSkuDefault');
	}

}
