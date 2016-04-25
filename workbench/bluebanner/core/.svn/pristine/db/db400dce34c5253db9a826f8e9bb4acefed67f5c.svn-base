<?php namespace Bluebanner\Core\Model;


class RequestQueue extends BaseModel
{
	
	protected $table = 'core_queue_request_master';
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}

	public function errors()
	{
		return $this->hasMany('Bluebanner\Core\Model\RequestQueueError', 'queue_id');
	}
}