<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\OtherIOMasterInvoiceRequiredException;
use Bluebanner\Core\OtherIOMasterInvoiceDuplicatedException;
class OtherIOMaster extends BaseModel
{
	
	protected $table = 'core_storage_other_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() {
	    if ( ! $invoice = $this->invoice)
	        throw new OtherIOMasterInvoiceRequiredException('An invoice is required for a OM, none given.');
	    
	    $query = $this->newQuery();
	    $persisted = $query->where('invoice', '=', $invoice)->first();
	    
	    if ($persisted && $persisted->getKey() != $this->getKey())
	        throw new OtherIOMasterInvoiceDuplicatedException("A PR already exists with invoice [$invoice], invoice must be unique for OM.");
	    
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
		return $this->hasMany("Bluebanner\Core\Model\OtherIODetail",'other_id');
	}
	
	public static function getAllStatus()
	{
		return array('pending', 'confirmed', 'stock','done');		
	}
	
	/**
	 * @desc 		获取最新的invoice
	 * @return 		string
	 */
	public static  function GenerateInvoice()
	{
	
	    $char = 'O';
	    $prev_invoice  = $char . date('ymd');
	    $model=new OtherIOMaster();
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
	public static function getInventoryStatusList()
	{
	    return array(
	           'pending'         =>'pending', 
	           'confirmed'       =>'confirmed',
	           'stocking'        =>'stocking',
	           'done'            =>'done',
	    );
	}

  public function getOtherIOLists($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size = 16, 1)->get();

    foreach ($result as $ioList) {
      $ioList->warehouse;
      $ioList->user;
      $ioList->agent;
    }

    return $result;
  }

  public function getOtherIOById($id) {
    $other = $this->find($id);

    if ($other) {
      $order->details;
      $order->details->item;
    }

    return $other;
  }

  public function storeOtherIO($masterData, $childsData) {
    $nowDate = date('Y-m-d H:i:s');

    DB::beginTransaction();

    try {
      $masterData['created_at'] = $masterData['updated_at'] = $nowDate;
      $masterId = $this->createGetId($masterData);

      foreach ($childsData as $childData) {
        $childTbl = $this->childQueryBuilder();

        $childData['other_id'] = $masterId;
        $childData['created_at'] = $childData['updated_at'] = $nowDate;

        $childTbl->insert($childData);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('transaction fail');
    }

    return $masterId;
  }

  public function updateOtherIO($masterId, $masterData, $childsData) {
    $nowDate = date('Y-m-d H:i:s');

    DB::beginTransaction();

    try {
      $this->where('id', $masterId)->update($masterData);

      $this->updateByIdOneTime($childsData);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('transaction fail');
    }
  }
}
