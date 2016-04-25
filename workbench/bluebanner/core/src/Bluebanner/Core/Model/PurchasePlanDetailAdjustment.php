<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;

class PurchasePlanDetailAdjustment extends BaseModel
{
	
	protected $table = 'core_purchase_plan_detail_adjustment';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;

	public function validate()
	{
		# code...
	}

	public function plan()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchasePlan');
	}

	public function plan_detail()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchasePlanDetail');
	}

	public function user()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User');
	}
}