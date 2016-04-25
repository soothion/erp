<?php namespace Bluebanner\Core\Model;
/**
* 
*/
class Order extends BaseModel
{
	protected $table = 'core_order';
	
	protected $guarded = array('id');
	
 	public function detail()
    {
        return $this->hasMany('Bluebanner\Core\Model\OrderDetail');
    }

	public function validate() {
		return true;
	}
}