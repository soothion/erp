<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Purchase\POStatus;
//use Bluebanner\Core\Purchase\PurchaselanShipLog;

class PurchasePlanDetail extends BaseModel
{
		
	protected $table = 'core_purchase_plan_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'warehouse_id' => 'required|integer',
		'plan_id' => 'required|integer',
		'item_id' => 'required|integer',
	);

	public function validate() {}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}
	
	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse');
	}

	public function plan()
	{
		return $this->belongsTo('Bluebanner\Core\Model\PurchasePlan');
	}

	public function requestdetails()
	{
		return $this->belongsToMany('Bluebanner\Core\Model\PurchaseRequestDetail', 'core_purchase_request_plan_log', 'plan_detail_id', 'request_detail_id')
			->withPivot('percent');
	}

	public function orderlog()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanOrderLog','plan_detail_id');
	}

	public function shiplog()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanShipLog','plan_detail_id');
	}
	
	public function platform()
	{
	    return $this->belongsTo('Bluebanner\Core\Model\Platform');
	}

	public function subitems()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanDetail','parent_id')->with('vendor','item','warehouse');
	}

	public function splits()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanDetail','splited_id')->with('vendor','item','warehouse');
	}

	public function vendor()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Vendor');
	}

	public function changes()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanDetailAdjustment', 'plan_detail_id');
	}

  public function getQuotation($itemId, $vendorId) {
    return \Bluebanner\Core\Model\VendorQuotation::where('item_id', $itemId)->where('vendor_id', $vendorId)->first();
  }


	public static function getInfoByVendorItem($plan_id)
	{
		$query = static::select(DB::raw('vendor_id,item_id,sum(request_qty) as req_qtys,sum(real_qty) as real_qtys,price_type'))
				->where('plan_id' ,'=',$plan_id)
				->groupBy('vendor_id','item_id','price_type');

		return $query;
	}

	/** 
	* 获取那个三个报表的纵向数据
	* 1.relation_id <= 0 则统计［仓库－运输方式］
	* 2.relation >0 则统计［Order-订单号］
	*/
	public static function getColumns($plan_id) //getColumns
	{
		$columns = array();
		$r = static::select(DB::raw("concat(concat(warehouse_id,'-'),transportation) as fields,warehouse_id"))
				->where('plan_id' ,'=',$plan_id)
				->where('relation_id','<=','0')
				->groupBy('warehouse_id','transportation')->get();
		$i =0;
		foreach ($r as $d) {
			$d->Warehouse;
			$tmp = explode("-",$d->fields);
			$columns[$i] = $d->warehouse->name."-".$tmp[1];
			$i++;
		}

		$r = static::select(DB::raw("concat('Order-',relation_id) as fields"))
				->where('plan_id' ,'=',$plan_id)
				->where('relation_id','>','0')
				->groupBy('relation_id')->get();
		foreach ($r as $d) {
			$columns[$i] = $d->fields;
			$i++;
		}
			
		return $columns;
	}
	
	//单个明细的采购关联明细
	public function getOrderDetailArr()
	{
		$res = array();
		foreach($this->orderlog as $l){
			$res[$l->order_detail_id]['order_id'] = $l->order_id;
		}
		
		return $res;
	}

	//单个明细的ship关联明细
	public function getShipDetailArr()
	{
		$res = array();
		foreach($this->shiplog as $l){
			$res[$l->shipment_detail_id]['ship_id'] = $l->shipment_id;
		}
		
		return $res;
	}

	public function getPurchasingSummary($plan_id)
	{
		$res = array();
		$purchasing = array();

		#2. 查找已经创建了的采购订单量
		$query = DB::table('core_purchase_order')->join('core_purchase_order_detail','core_purchase_order.id','=','core_purchase_order_detail.order_id')
				->select(DB::Raw('item_id,sum(qty) as qty,invoice,lv4_core_purchase_order.id,lv4_core_purchase_order.agent'))
				->where('plan_id','=',$plan_id)
				->whereRaw('lv4_core_purchase_order.`deleted_at` is null')
				->groupBy('item_id')
				->groupBy('core_purchase_order.id');
		$details = $query->get();

		foreach ($details as $d) {
			$purchasing[$d->item_id] = array();
			$purchasing[$d->item_id][$d->invoice] = array('order' => 0,'purchased' => 0);
			$purchasing[$d->item_id][$d->invoice]['order'] = isset($purchasing[$d->item_id][$d->invoice]['order']) ? ($purchasing[$d->item_id][$d->invoice]['order'] + $d->qty) : $purchasing[$d->item_id][$d->invoice]['order'];
			//已经到货的
			if(!isset($Purchased) || !in_array($d->id, $Purchased))
			{
				$Purchased = $this->getStockedByOrderItem($d->id);
			}
			$purchasing[$d->item_id][$d->invoice]['purchased'] = isset($Purchased[$d->item_id]) ? $Purchased[$d->item_id] : 0;
			$purchasing[$d->item_id][$d->invoice]['agent'] = $d->agent;

		}

		$i =0;
		if(isset($purchasing))
		{
			foreach ($purchasing as $item_id => $v)
			{
				foreach ($v as $invoice => $value)
				{
					$res[$i]['item_id'] 	= $item_id;
					$res[$i]['purchased'] 	= $value['purchased'];
					$res[$i]['purchasing'] 	= $value['order'] - $value['purchased'];
					$res[$i]['order'] 		= $value['order'];
					$res[$i]['po'] 			= $invoice;
					$res[$i]['agent'] 		= $value['agent'];
					$i++;
				}
			}
		}

		return $res;
	}

	public function getStockedByOrderItem($order_id)
	{
		$r = array();
		$query = DB::table('core_storage_io_master')
				->leftJoin('core_storage_io_detail', 'core_storage_io_master.id','=','core_storage_io_detail.io_id')
				->select(DB::Raw('item_id,sum(qty+backup_qty) as qty'))
				->whereRaw('lv4_core_storage_io_master.deleted_at is null')
				->whereRaw('lv4_core_storage_io_detail.`deleted_at` is null')
				->where('core_storage_io_master.status','=','1')
				->where('core_storage_io_master.relation_id','=',$order_id)
				->where('core_storage_io_master.type','=',1)
				->groupBy('relation_id')
				->groupBy('item_id');

		$details = $query->get();
		foreach ($details as $d) {
			$r[$order_id][$d->item_id] = $d->qty;
		}	
		return $r;
	}

  public function findPlanDetailByConds(array $tbls, $conds, $pg, $offset = 15) {
    $result = $this->findByConds($conds, $pg, $offset, 1)->get();
    foreach ($result as $row) {
      foreach ($tbls as $tbl) {
        $row->$tbl;
      }
    }

    return $result;
  }

  public function getByPlanAndConds($conds) {
    $result = $this->with('item.quotation.vendor')->conds($conds)->get();

    return $result;
  }
}