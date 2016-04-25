<?php namespace Bluebanner\Core\Model;


class Queue extends BaseModel
{
	
	protected $table = 'core_queue_master';
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}

	public function errors()
	{
		return $this->hasMany('Bluebanner\Core\Model\QueueError', 'queue_id');
	}
}