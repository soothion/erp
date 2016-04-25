<?php namespace Bluebanner\Core\Model;

/**
* 
*/
class Audit extends BaseModel
{
	protected $table = 'core_audit_master';
	
	protected $guarded = array('id');
	
	public function validate() {
		return true;
	}
}