<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\PurchasePlanException;

class PurchasePlan extends BaseModel
{
	
	protected $table = 'core_purchase_plan';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;

	public function scopeOpen($query)
	{
		return $query->where('status', 'open');
	}

	public function validate() {
		if ( ! $name = $this->name)
			throw new PurchasePlanException('A name is required for an Purchase Plan, none given.');

		$query = $this->newQuery();
		$persisted = $query->where('name', '=', $name)->first();
		
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new PurchasePlanException("A name already exists with name [$name], name must be unique for Purchase Plan.");

		return true;
	}
	
	public function user()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User','agent');
	}

	public function details()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanDetail', 'plan_id');
	}


  public function scopeConfirmed($query) {
    return $query->where('status', 'confirmed');
  }
	
  public function GenerateInvoice()
  {
    $const = 'PP' . date('ymd');
    
    //$latest = static::where('invoice', 'like', $const . '%')->orderBy('invoice', 'desc')->first();
    $latest = \DB::table($this->table)->where('invoice', 'like', $const . '%')->orderBy('invoice', 'desc')->first();

    if ($latest) {
      return $const . str_pad(intval(str_replace($const, '', $latest->invoice)) + 1, 2, "0", STR_PAD_LEFT);
    } else {
      return $const . '01';
    }
  }

  public function getByIdOrLast($id) {
    if ($id) {
      $result = $this->where('id', $id)->pluck('id');
    } else {
      $result = $this->orderBy('id', 'desc')->pluck('id');
    }

    if (!$result) {
      throw new \Exception('No such plan');
    }

    return $result;
  }
}