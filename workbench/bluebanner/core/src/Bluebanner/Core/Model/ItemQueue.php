<?php namespace Bluebanner\Core\Model;


class ItemQueue extends BaseModel
{
	
	protected $table = 'core_queue_item_master';
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}

	public function errors()
	{
		return $this->hasMany('Bluebanner\Core\Model\ItemQueueError', 'queue_id');
	}
}