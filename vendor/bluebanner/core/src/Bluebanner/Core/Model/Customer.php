<?php namespace Bluebanner\Core\Model;

/**
* 
*/
class Customer extends BaseModel
{
	protected $table = 'core_customer';
	
	protected $guarded = array('id');
	
	public function validate() {
		return true;
	}
}