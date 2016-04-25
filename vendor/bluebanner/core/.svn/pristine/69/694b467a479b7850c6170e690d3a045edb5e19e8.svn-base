<?php namespace Bluebanner\Core\Model;

class ItemImage extends BaseModel
{

	protected $table = 'core_item_image';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		
	);
	
	public function validate() {
		return true;
	}

	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

}