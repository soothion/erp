<?php namespace Bluebanner\Core\Model;


class RequestQueueError extends BaseModel
{
	
	protected $table = 'core_queue_request_error';

	public $timestamps = false;
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}
}