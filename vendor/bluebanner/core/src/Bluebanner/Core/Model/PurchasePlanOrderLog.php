<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Warehouse\IOStatus;
use Illuminate\Support\Facades\DB;


class PurchasePlanOrderLog extends BaseModel
{
		
	protected $table = 'core_purchase_plan_order_log';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'plan_detail_id' => 'required|integer',
		'item_id' => 'required|integer',
		'order_detail_id' => 'required|integer',
	);
	
	public function validate() {}
	
	public function warehouse()
	{
		# code...
	}

	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

	//获取采购订单量
	public static function getPurchaseOrder($plan_id)
	{
		$res = array();
		#1.先查找转采购日志中对应改计划的所有采购订单id
		$pur_ids =static::select(DB::Raw('group_concat(distinct `order_id`) as ids'))
					->where('plan_id','=',$plan_id)->first();
		$idarr = explode(",",$pur_ids->ids);

		#2.订单明细中查找该采购单下所有按照item group的数量
		$query = DB::table('core_purchase_order_detail')
				->select('item_id','qty')
				->whereRaw('`deleted_at` is null');//

		if(count((array) $idarr) >0){
			$query->whereIn('order_id',$idarr);
		}

		$details = $query->get();
		foreach ($details as $d) {
			$res[$d->item_id] = isset($res[$d->item_id]) ? ($d->qty + $res[$d->item_id]) : $d->qty;
		}

		return $res;
	}

	//获取采购订单到货量
	public static function getPurchaseOrderStockin($plan_id)
	{
		$res = array();
		#1.先查找转采购日志中对应改计划的所有采购订单id
		$pur_ids =static::select(DB::Raw('group_concat(distinct `order_id`) as ids'))
					->where('plan_id','=',$plan_id)->first();
		$idarr = explode(",",$pur_ids->ids);

		#2.连接出入库单主表，明细表，查询relation_id是这些采购订单下，并且是采购类型，已经入库的item和数量
		$query = DB::table('core_storage_io_master')
				->leftJoin('core_storage_io_detail', 'core_storage_io_master.id','=','core_storage_io_detail.io_id')
				->whereRaw('lv4_core_storage_io_master.deleted_at is null')
				->whereRaw('lv4_core_storage_io_detail.`deleted_at` is null')
				->where('core_storage_io_master.status','=','1')
				->select('core_storage_io_detail.item_id','core_storage_io_detail.qty','core_storage_io_detail.backup_qty');

		if(count((array) $idarr) >0){
			$query->whereIn('core_storage_io_master.relation_id',$idarr);
		}

		$details = $query->get();

		foreach ($details as $d) {
			$res[$d->item_id] = isset($res[$d->item_id]) ? ($d->qty + $d->backup_qty + $res[$d->item_id]) : $d->qty;
		}

		return $res;
	}
	
}