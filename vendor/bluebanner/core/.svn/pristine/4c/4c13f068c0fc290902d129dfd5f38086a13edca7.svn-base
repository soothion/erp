<?php namespace Bluebanner\Core\Model;


class ItemImageQueue extends BaseModel
{
	
	protected $table = 'core_queue_image_master';
	
	protected $guarded = array('id');
	
	public function validate() {
		
		return true;
	}

	public function errors()
	{
		return $this->hasMany('Bluebanner\Core\Model\ItemImageQueueError', 'queue_id');
	}
}