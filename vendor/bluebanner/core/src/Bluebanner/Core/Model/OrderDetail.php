<?php namespace Bluebanner\Core\Model;

/**
* 
*/
class OrderDetail extends BaseModel
{
	protected $table = 'core_order_detail';
	
	protected $guarded = array('id');
	
	public function validate() {
		return true;
	}
}