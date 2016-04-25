<?php namespace Bluebanner\Core\Model;

class ItemFeature extends BaseModel
{
	
	protected $table = 'core_item_feature';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;

	public function validate() {
		return true;
	}
}