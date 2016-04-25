<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\ShipInvoiceDuplicatedException;
use Bluebanner\Core\Model\PurchasePlanShipLog;
use Bluebanner\Core\Model\PurchasePlanDetail;
use Bluebanner\Core\Model\ShipMaster;

class ShipDetail extends BaseModel
{

	const PURCHASE_WAREHOUSE = 7;//默认采购仓库需要去找对应的计划

	protected $table = 'core_storage_shipment_detail';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();
	
	protected static function boot()
	{
		parent::boot();

		//明细表修改需要更改日志，同样主表的发出仓和含税与否，transction改变以后也需要更改对应的明细
		static::updating(function($model) {
			return $model->updateLog();
		});

		static::created(function($model) {
			return $model->createLog();
		});

		static::deleted(function($model) {
			return $model->deleteLog();
		});
		//}
	}

	public function validate() 
	{
		//这里稍后可以添加三个方法，Created, Updated,Deleted，昨晚之后分别添加，修改，删除对应的日志
	}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}
	public function master()
	{
		return $this->belongsTo('Bluebanner\Core\Model\ShipMaster','shipment_id');
	}

	public function planshiplogs()
	{
		return $this->hasMany('Bluebanner\Core\Model\PurchasePlanShipLog','id');
	}
	
	/**
	 * 
	 * 如果SKU是组合SKU，自动按照拆分规则增加记录
	 * 
	 */
	public function childAutoSave()
	{
		if ( ($item = $this->item) && ($boms = $item->bom) ) {

			foreach ($boms as $bom) {
				$row = $this->attributes;
				$row['item_id'] = $bom->child_id;
				$row['parent_id'] = $this->id;
				$row['qty'] = $this->qty * $bom->qty;
				static::create($row);
			}
			
			$this->save();
		}
		return true;
	}

	//如果
	public function createLog()
	{
		$master  = ShipMaster::find($this->shipment_id);
		if($master->warehouse_from_id != 7) return true;

		if($this->qty <=0) throw new ShipInvoiceDuplicatedException("shipment明细数量为0");
		$doArr = array();
		$exec_qty = $this->qty;
		//找出PurchasePlanDetail里面发出
		$planDetail = PurchasePlanDetail::where('warehouse_id','=',$master->warehouse_to_id)
		->where('price_type','=',$master->price_type)
		->where('transportation','=',$master->transportation)
		->where('item_id','=',$this->item_id)
		->where('parent_id','=',0)//成品还是取成品的
		->whereRaw('real_qty > shipment_qty')//还有没有发完的才搜索出来
		->orderBy('id','asc')
		->get();
						//throw new ShipInvoiceDuplicatedException(count($planDetail));

		if($planDetail)
		{
			$i=0;
			foreach ($planDetail as $key => $detail) {
				$l_qty = $detail->real_qty - $detail->shipment_qty;
				if(($l_qty <=0) ||  ($exec_qty <=0)) continue;

				$doArr = array(
							'plan_id' 			=> $detail->plan_id,
							'plan_detail_id' 	=> $detail->id,
							'shipment_id' 		=> $master->id,
							'shipment_detail_id' => $this->id,
							'item_id'			=> $this->item_id,
							);

				if($exec_qty >= $l_qty){
					$doArr['qty'] = $l_qty;
					$exec_qty -= $l_qty;

					if(!PurchasePlanShipLog::create($doArr))
						throw new ShipInvoiceDuplicatedException("添加shipment失败");

					//更新plan_detail的发货量
					if(!$detail->update(array('shipment_qty' => ($detail->shipment_qty+$l_qty))))
						throw new ShipInvoiceDuplicatedException("更新计划明细的shipment数量失败");
				}else{
					$doArr['qty'] = $exec_qty;
					if(!PurchasePlanShipLog::create($doArr))
						throw new ShipInvoiceDuplicatedException("添加shipment失败");

					if(!$detail->update(array('shipment_qty' => ($detail->shipment_qty+$exec_qty))))
						throw new ShipInvoiceDuplicatedException("更新计划明细的shipment数量失败");
					
					$exec_qty =0;//需要最后赋值
				}

				$i++;
			}
		}

		return true;
	}

	public function updateLog()
	{
		$master  = ShipMaster::find($this->shipment_id);
		if($master->warehouse_from_id != 7) return true;
		$detail = $this->newQuery()->where('id','=',$this->id)->first();

		if(($detail->item_id != $this->item_id) || ($detail->qty != $this->qty)){//sku改变了则要删除
			$this->deleteLog();
			$this->createLog();
		}

		return true;
	}

	public function deleteLog()
	{
		$logs = with(new PurchasePlanShipLog)->where('shipment_detail_id','=',$this->id)->get();
		if(count($logs) >0){
			foreach($logs as $l){
				if(!$l->delete()) throw new ShipInvoiceDuplicatedException("删除shipment日志失败");

				$plandetail = PurchasePlanDetail::find($l->plan_detail_id);
				if(!$plandetail->update(array('shipment_qty' => ($plandetail->shipment_qty - $l->qty))))
					 throw new ShipInvoiceDuplicatedException("更新plan detail的shipment数量失败");
			}
		}

		return true;
	}

}
