<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\PurchaseReturnInvoiceRequiredException;
use Bluebanner\Core\PurchaseReturnInvoiceDuplicatedException;
use Bluebanner\Core\PurchaseReturnAgentRequiredException;


class PurchaseReturn extends BaseModel
{
	
	protected $table = 'core_purchase_return';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'invoice' => 'required|unique:core_purchase_return',
		'agent' => 'required|integer',
		'warehouse_id' => 'required|integer',
		'vendor_id' => 'required|integer',
	);
	
	public function validate() {
	    
	  if ( ! $invoice = $this->invoice)
			throw new PurchaseReturnInvoiceRequiredException('An invoice is required for a PR, none given.');

		if ( ! $uid = $this->agent)
			throw new PurchaseReturnAgentRequiredException('An Agent is required for a PR, none given.');
		
		$query = $this->newQuery();
		$persisted = $query->where('invoice', '=', $invoice)->first();
		
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new PurchaseReturnInvoiceDuplicatedException("A PR already exists with invoice [$invoice], invoice must be unique for PR.");

		return true;
	}
	
	public function agent()
	{
		return $this->belongsTo('Bluebanner\Core\Model\User');
	}
	
	public function details()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchaseReturnDetail', 'return_id');
	}

	public function vendor()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Vendor','vendor_id');
	}
	
	public function user()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'agent');
	}
	
	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}
	
	public static function isExists($id)
	{
		return self::find($id)===null;
	}
	
	public static function getStatusList()
	{
		return array(
				'pending',
				'confirmed', 
				'stocking', 
				'completely', 			
		);
	}

	public function stocks()
	{
		return $this->morphMany('Bluebanner\Core\Model\StockIOMaster', 'relations');
	}
	
	/**
	 * @desc 		获取最新的invoice
	 * @return 		string
	 */
	public static  function GenerateInvoice()
	{
	
	    $char = 'PR';
	    $prev_invoice  = $char . date('ymd');
	    $model=new PurchaseReturn();
	    $list = DB::table($model->getTable())->where('invoice','like',$prev_invoice.'%')->lists('invoice');
	    $i=	count($list);
	    if($i<1) $i=1;
	    $count = str_pad( $i, 2, "0", STR_PAD_LEFT);
	    $return=$prev_invoice . $count;
	     
	    while(in_array($return,$list))
	    {
	        $i++;
	        $count = str_pad( $i, 2, "0", STR_PAD_LEFT);
	        $return=$prev_invoice . $count;
	    }
	     
	    return $return;
	}
	
	
}