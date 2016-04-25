<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\RMADuplicatedException;
class RMAMaster extends BaseModel
{
	
	protected $table = 'core_storage_rma_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {
	

        $invoice = $this->invoice;		
		$query = $this->newQuery();
		$persisted = $query->where('invoice', '=',$invoice)->first();
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new PurchaseVendorDuplicatedException("A Vendor already exists with code [$invoice], code must be unique for a invoice" );
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
		return $this->hasMany("Bluebanner\Core\Model\RMADetail",'rma_id');
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
	
	    $char = 'R';
	    $prev_invoice  = $char . date('ymd');
	    $model=new RMAMaster();
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
