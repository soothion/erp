<?php namespace Bluebanner\Core\Model;


class ItemQueueError extends BaseModel
{
	
	protected $table = 'core_queue_item_error';

	public $timestamps = false;
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}
}