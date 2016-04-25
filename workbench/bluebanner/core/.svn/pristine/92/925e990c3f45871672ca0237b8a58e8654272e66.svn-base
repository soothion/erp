<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\ShipInvoiceRequiredException;
use Bluebanner\Core\ShipWarehouseSameException;
use Bluebanner\Core\ShipInvoiceDuplicatedException;
class ShipMaster extends BaseModel
{
	
	protected $table = 'core_storage_shipment_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {
	    if ( ! $invoice = $this->invoice)
	        throw new ShipInvoiceRequiredException('An invoice is required for a SM, none given.');

		if ( $this->warehouse_to_id == $this->warehouse_from_id)
	        throw new ShipWarehouseSameException('same of from and to warehouse');
	    
	    $query = $this->newQuery();
	    $persisted = $query->where('invoice', '=', $invoice)->first();
	    
	    if ($persisted && $persisted->getKey() != $this->getKey())
	        throw new ShipInvoiceDuplicatedException("A PR already exists with invoice [$invoice], invoice must be unique for SM.");
	    
	    return true;
	}

	public function fromWarehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_from_id');
	}    
	
	public function toWarehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_to_id');
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
		return $this->hasMany("Bluebanner\Core\Model\ShipDetail",'shipment_id');
	}
	
	public static function getAllStatus()
	{
		return array('pending','submitted','confirmed','on-road','partially received','completely received','cancel');		
	}
	
	/**
	 * @desc 		获取最新的invoice
	 * @return 		string
	 */
	public static  function GenerateInvoice()
	{
	
	    $char = 'S';
	    $prev_invoice  = $char . date('ymd');
	    $model=new ShipMaster();
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
	
	/**
	 * 
	 * 
	 */
	public static function getShipStatusList()
	{
	    return array(
	           'pending'         =>'pending', 
			   'submitted'         =>'submitted', 
	           'confirmed'       =>'confirmed',
	           'on-road'        =>'on-road',
			   'partially received'        =>'partially received',
			   'completely received'        =>'completely received',			
	           'cancel'            =>'cancel',
	    );
	}

	/**
	 * 
	 * 
	 */
	public static function getTransStatusList()
	{
	
	    return array(
	           'surface'         =>'surface', 
			   'air'         =>'air', 
	           'sea'       =>'sea',
	         
	    );
	}

	public static function getShipQtyByDetails(array $detailIdArr)
	{
		$res = array('qty' => 0,'do_qty' => 0);

		if(count($detailIdArr)>0){
			foreach ($detailIdArr as $key => $value) {
				$orderArr[$value['ship_id']] = $value['ship_id'];
			}
			$detailArr = array_unique(array_keys($detailIdArr));

			$query = static::leftJoin('core_storage_shipment_detail', 'core_storage_shipment_detail.shipment_id', '=', 'core_storage_shipment_master.id')
			->whereIn('core_storage_shipment_detail.id',$detailArr);
			$res['qty'] = $query->sum('core_storage_shipment_detail.qty');
		}

		return $res;
	}

  public function getDispatches($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size, 1)->get();

    foreach ($result as $dispatch) {
      $dispatch->agent;
      $dispatch->fromWarehouse;
      $dispatch->toWarehouse;
      $dispatch->details;
      $dispatch->user;
    }

    return $result;
  }
}
