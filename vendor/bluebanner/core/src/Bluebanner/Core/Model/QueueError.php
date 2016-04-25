<?php namespace Bluebanner\Core\Model;


class QueueError extends BaseModel
{
	
	protected $table = 'core_queue_error';

	public $timestamps = false;
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}
}