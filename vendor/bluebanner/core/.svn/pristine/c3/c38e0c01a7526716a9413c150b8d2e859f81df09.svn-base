<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Warehouse\IOStatus;
use Illuminate\Support\Facades\DB;


class PurchasePlanShipLog extends BaseModel
{
		
	protected $table = 'core_purchase_plan_ship_log';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'plan_detail_id' => 'required|integer',
		'item_id' => 'required|integer',
		'shipment_detail_id' => 'required|integer',
	);
	
	public function validate() {}

	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

	//获取采购订单量
	public static function getShipment($plan_id)
	{
		$res = array();
		#1.先查找转采购日志中对应改计划的所有采购订单id
		$ids =static::select(DB::Raw('group_concat(distinct `shipment_id`) as ids'))
					->where('plan_id','=',$plan_id)->first();
		$idarr = explode(",",$ids->ids);

		#2.订单明细中查找该采购单下所有按照item group的数量
		$query = DB::table('core_storage_shipment_detail')
		->leftJoin('core_storage_shipment_master', 'core_storage_shipment_detail.shipment_id', '=', 'core_storage_shipment_master.id')
		->select('item_id','qty','invoice')
		->whereRaw('lv4_core_storage_shipment_master.deleted_at is null');//

		if(count((array) $idarr) >0){
			$query->whereIn('shipment_id',$idarr);
		}

		$details = $query->get();
		foreach ($details as $d) {
			$res['invoice'][$d->invoice] = $d->invoice;
			$res[$d->item_id][$d->invoice] = isset($res[$d->item_id][$d->invoice])  ? ($res[$d->item_id][$d->invoice] +$d->qty) : $d->qty;
		}
		return $res;
	}
	
}