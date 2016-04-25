<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\WHCountingInvoiceRequiredException;
use Bluebanner\Core\WHCountingInvoiceDuplicatedException;


class CountingMaster extends BaseModel
{
	
	protected $table = 'core_storage_counting_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {
	    if ( ! $invoice = $this->invoice)
	        throw new WHCountingInvoiceRequiredException('An invoice is required for a OM, none given.');
	    
	    $query = $this->newQuery();
	    $persisted = $query->where('invoice', '=', $invoice)->first();
	    
	    if ($persisted && $persisted->getKey() != $this->getKey())
	        throw new WHCountingInvoiceDuplicatedException("A Counting already exists with invoice [$invoice], invoice must be unique for OM.");
	    
	    return true;
	}

	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}
	
	public function agent()
	{
		return $this->belongsTo('Bluebanner\Core\Model\User');
	}
	
	public function user()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'agent');
	}

	/**
	* 多态实现跟出入库单的关联－属主
	* 
	*/
	public function stocks()
	{
		return $this->morphMany('Bluebanner\Core\Model\StockIOMaster', 'relation','type','id');
	}
	
	public function details()
	{
		return $this->hasMany("Bluebanner\Core\Model\CountingDetail",'counting_id');
	}
	
	public static function getAllStatus()
	{
		return array('pending', 'confirmed', 'stocking','completely');		
	}
	
	/**
	 * @desc 		获取最新的invoice
	 * @return 		string
	 */
	public static  function GenerateInvoice()
	{
	
	    $char = 'C';
	    $prev_invoice  = $char . date('ymd');
	    $model=new CountingMaster();
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

  public function getCountings($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $counting) {
      $counting->warehouse;
      $counting->agent;
      $counting->details;
      $counting->user;
    }

    return $result;
  }
}
