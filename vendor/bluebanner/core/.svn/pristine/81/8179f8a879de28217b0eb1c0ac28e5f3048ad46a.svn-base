<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\PurchaseRequestInvoiceRequiredException;
use Bluebanner\Core\PurchaseRequestInvoiceDuplicatedException;

use Bluebanner\Core\PurchaseRequestAgentRequiredException;

class PurchaseRequest extends BaseModel
{
	const STATUS_OF_PENDING="pending";
	const STATUS_OF_CONFIRMED="confirmed";
	const STATUS_OF_ACCEPT="verified";
	const STATUS_OF_REJECT="rejected";
	const STATUS_OF_COMPLETED="completed";
	const STATUS_OF_EXPIRED="expired";
    
	protected $table = 'core_purchase_request';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'invoice' => 'required|unique:core_purchase_request',
		'agent' => 'required|integer'
	);
	
	public function validate() {
		if ( ! $invoice = $this->invoice)
			throw new PurchaseRequestInvoiceRequiredException('An invoice is required for a PR, none given.');

		if ( ! $uid = $this->agent)
			throw new PurchaseRequestAgentRequiredException('An Agent is required for a PR, none given.');
		
		$query = $this->newQuery();
		$persisted = $query->where('invoice', '=', $invoice)->first();
		
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new PurchaseRequestInvoiceDuplicatedException("A PR already exists with invoice [$invoice], invoice must be unique for PR.");

		return true;
	}
	
	public function user()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'agent');
	}

	public function reviewer()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'verified_agent');
	}
	
    public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}
	
	public function details()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchaseRequestDetail', 'request_id');
	}
	
	public static function getStatusList()
	{
	    return array(
	            'pending'=>'pending',
	            'confirmed'=>'confirmed',
	            'verified'=>'verified',
	            'rejected'=>'rejected',
	            'deleted'=>'deleted',
	            'completed'=>'completed',
	            'expired'=>'expired',
	    );
	}
	
	public static function getTypeList()
	{
	    return array(
	            'Order Direct' =>'Order Direct',
	            'Order' =>'Order',
	            'Shipment'=>'Shipment',
	            'Local'=>'Local',
	    );
	}
	
	
	/**
	 * @desc 		获取最新的invoice
	 * @return 		string
	 */
	public static  function GenerateInvoice($platform = 0)
	{
	
			$platform = Platform::find($platform)->abbreviation;
	    $char = 'PR-' . $platform;
	    $prev_invoice  = $char . date('ymd');
	    $model=new PurchaseRequest();
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

	public function scopeConfirmed($query)
	{
		return $query->where('status', '=', 'confirmed');
	}

	public function scopePending($query)
	{
		return $query->where('status', '=', 'pending');
	}

	public function scopeVerified($query)
	{
		return $query->where('status', '=', 'verified');
	}

  public function isIdBelongUser($id, $userId) {
    $result = $this->where('id', $id)->where('agent', $userId)->pluck('id');
    if ($result) {
      return $result;
    }
    return null;
  }

  public function getStatus($id, $userId = null) {
    if ($userId) {
      $result = $this->where('id', $id)->where('agent', $userId)->pluck('status');
    } else {
      $result = $this->where('id', $id)->pluck('status');
    }


    if (!$result) {
      throw new \Exception('No such item');
    }
    return $result;
  }
}