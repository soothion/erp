<?php namespace Bluebanner\Core\Model;
use Bluebanner\Core\PurchaseOrderException;
use Illuminate\Support\Facades\DB;


class PurchaseOrder extends MasterModel
{
	
	protected $table = 'core_purchase_order';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'invoice' => 'required|unique:core_purchase_order',
		'agent' => 'required|integer'
	);
	
	public function validate() {
		if ( ! $invoice = $this->invoice)
			throw new PurchaseOrderException('An invoice is required for a Purchase Order, none given.');
		//修改的排除
		$persisted = $this->newQuery()->where('invoice', '=', $invoice)->first();
		if ($persisted && ($persisted->getKey() != $this->getKey()) && ($persisted->invoice == $this->invoice))
			throw new PurchaseOrderException("A PO already exists with invoice [$invoice].");

		return true;
	}
	
	public function user()
	{
		return $this->belongsTo('Bluebanner\Core\Model\User');
	}

	public function vendor()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Vendor');
	}
	
	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse');
	}
	
	public function details()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchaseOrderDetail', 'order_id');
	}

	public function plan()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchasePlanOrderLog', 'order_id');
	}

	/**
	* @desc 		获取最新的invoice
	* @param 		(int)type "大于0 － 入库"，“小于0 － 出库”
	* @return 		string
	*/
	public static function GenerateInvoice()
	{ 
	    $char = 'P';
	    $prev_invoice  = $char . date('ymd');
	    $model=new PurchaseOrder();
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
	* 多态实现跟出入库单的关联－属主
	* 
	*/
	public function stocks()
	{
		return $this->morphMany('Bluebanner\Core\Model\StockIOMaster', 'relation','type','id');
	}

	public static function getPurchaseQtyByDetails(array $detailIdArr)
	{
		$res = array('qty' => 0,'do_qty' => 0);

		if(count($detailIdArr)>0){
			foreach ($detailIdArr as $key => $value) {
				$orderArr[$value['order_id']] = $value['order_id'];
			}
			$detailArr = array_unique(array_keys($detailIdArr));

			$query = static::leftJoin('core_purchase_order_detail', 'core_purchase_order_detail.order_id', '=', 'core_purchase_order.id')
			->whereIn('core_purchase_order_detail.id',$detailArr);
			$res['qty'] = $query->sum('core_purchase_order_detail.qty');
			
			$query = static::leftJoin('core_storage_io_master', 'core_storage_io_master.relation_id', '=', 'core_purchase_order.id')
			->leftJoin('core_purchase_order_detail', 'core_purchase_order_detail.order_id', '=', 'core_purchase_order.id')
			->whereIn('core_purchase_order.id',$orderArr)
			->whereIn('core_purchase_order_detail.id',$detailArr)
			->where('core_storage_io_master.type','=',1)
			->where('core_storage_io_master.status','=',1);
			$res['do_qty'] = $query->sum('core_purchase_order_detail.qty');
		}

		return $res;
	}

  /**
   * @return object a child table instance
   */
  public function childQueryBuilder() {
    return DB::table(PurchaseOrderDetail::getTbl());
  }

  /**
   * @return object a log table instance
   */
  public function logQueryBuilder() {
    return DB::table(PurchasePlanOrderLog::getTbl());
  }

  public function itemQueryBuilder() {
    return DB::table(Item::getTbl());
  }

  public function planDetailQueryBuilder() {
    return DB::table(PurchasePlanDetail::getTbl());
  }

  public function planQueryBuilder() {
    return DB::table(PurchasePlan::getTbl());
  }

  public function throwException($msg) {
    return new PurchaseOrderException($msg);
  }


  /**
   * allQty in master is the quantity of a item which is summed by different platforms
   * @params int id OrderId
   * @return object master include (object: warehouse, vendor, details include (object: item))
   */
  public function getOrderById($id) {
    $order = $this->find($id);

    if ($order) {
      $order->warehouse;
      $order->vendor;

      $order->details = $this->childQueryBuilder()->select('*', DB::raw('sum(qty_confirmed) as allQty, sum(total) as allTotal'))->where('order_id', $id)->groupBy('item_id')->get();
      foreach ($order->details as $detail) {
        $detail->item = $this->itemQueryBuilder()->where('id', $detail->item_id)->first();
      }

    }

    return $order;
  }

  public function isGenByPlan($orderId) {
    $result = $this->logQueryBuilder()->where('order_id', $orderId)->first();
    if ($result) {
      return true;
    }
    return false;
  }

  public function getStatus($orderId) {
    $result = $this->where('id', $orderId)->pluck('status');
    return $result;
  }

  public function genOrderByPlan(array $master, array $childs, $planId) {
    $masterTbl = $this;

    DB::transaction(function () use ($master, $childs, $planId, $masterTbl) {
      $childTbl = $masterTbl->childQueryBuilder();
      $logTbl = $masterTbl->logQueryBuilder();

      $masterId = $masterTbl->createGetId($master);

      foreach ($childs['main'] as $key => $child) {
        $child['order_id'] = $masterId;
        $childId = $childTbl->insertGetId($child);

        $childs['logs'][$key]['order_id'] = $masterId;
        $childs['logs'][$key]['order_detail_id'] = $childId;
        $logTbl->insert($childs['logs'][$key]);
      }

      foreach ($childs['plans'] as $planDetailId => $planDetail) {
        PurchasePlanDetail::where('id', $planDetailId)->update($planDetail);
      }

      $restPlanDetails = PurchasePlanDetail::where('plan_id', $planId)->where('status', 'pending')->count();
      if ($restPlanDetails == 0) {
        PurchasePlan::where('id', $planId)->update(array('deleted_at' => date('Y-m-d H:i:s')));
      }
      });

  }

}