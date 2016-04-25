<?php namespace Bluebanner\Core\Model;

class PurchaseRequestPlanLog extends BaseModel
{
		
	protected $table = 'core_purchase_request_plan_log';//用于记录申购单明细，采购单明细，以及采购计划之间的关联
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'request_detail_id' => 'required|integer',
		'item_id' => 'required|integer',
		'plan_detail_id' => 'required|integer',
	);
	
	public function validate() {}
	
	public function warehouse()
	{
		# code...
	}

	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}
	
}