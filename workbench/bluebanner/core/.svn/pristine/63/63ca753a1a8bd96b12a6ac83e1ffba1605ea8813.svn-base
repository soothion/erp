<?php
namespace Bluebanner\Core\Warehouse;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ShipMaster;
use Bluebanner\Core\Model\ShipDetail;
use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\PurchasePlanShipLog;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Inventory\InventoryService;
use Bluebanner\Core\Inventory\InventoryBookService;

use Bluebanner\Core\Warehouse\StockIOService;


use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Warehouse\IOStatus;

use Bluebanner\Core\OtherIONotAllowUpdateException;
use Bluebanner\Core\OtherIONotAllowGenerateException;
use Bluebanner\Core\OtherIONotAllowChangeException;
use Bluebanner\Core\StockIOException;
use Bluebanner\Core\ShipmentException;

class ShipmentService implements ShipmentServiceInterface
{

	/**
	 * 创建表头 创建时的默认状态 为 "pending"
	 * @see \Bluebanner\Core\Warehouse\OtherStorageServiceInterface::createOtherMaster()
	 */
	public function createShipMaster(array $master)
	{
	    try{
	        $r=ShipMaster::create($master);
	        return $r->id;
	    }
	    catch (Exception $e)
	    {
	        var_dump($e->getCode()) ;
	        var_dump($e->getMessage()) ;
	        die();
	    }
	}
	
	public function createShipDetails($masterid,array $details)
	{
		foreach($details as $d)
		{
			$this->createShipDetail($masterid,$d);
		}
	}
	
	public function createShipDetail($masterid,array $detail)
	{
		$detail['shipment_id']=intval($masterid);
		$d=ShipDetail::create($detail);
		return $d->id;
	}

	public function createShipment(array $master, array $details)
	{
		$r = ShipMaster::create($master);
		if(!$r)
			throw new ShipmentException("Shipment Create Failed");
				
		foreach ($details as $detail)
		{
			$detail['shipment_id'] = $r->id;

			if(isset($detail['plan_id']) && isset($detail['plan_detail_id']))
			{
				$plan_id = $detail['plan_id'];
				$plan_detail_id = $detail['plan_detail_id'];
				unset($detail['plan_id']);
				unset($detail['plan_detail_id']);
			}

			$d = ShipDetail::create($detail);

			if(($plan_id > 0) && ($plan_detail_id > 0))
			{
				$log = array(
					'shipment_id'		 => $r->id, 
					'shipment_detail_id' => $d->id, 
					'plan_id' 			 => $plan_id, 
					'plan_detail_id' 	 => $plan_detail_id, 
					'item_id' 			 => $detail['item_id'], 
					'qty' 				 => $detail['qty']
				);

				if (!$this->writePlanShipLog($log))
					throw new PurchaseOrderException("创建SHIPMENT日志错误!");
			}
		}

		return $r;
	}

	/*public function getPlanShipmentDetailQty($plan_detail_id)
	{
		PurchasePlanShipLog::getShipmentDetail($plan_detail_id);
	}*/

	/*由计划生成的订单写入日志表*/
	public function writePlanShipLog(array $log) {
		if (!$r = PurchasePlanShipLog::create($log))
			throw new ShipmentException("Plan turn to shipment failed: write log failed!");

		return $r;
	}
	
	/**
	 * 只有Master的status为pending 时 才允许修改 且不允许修改status
	 * 
	 * @see \Bluebanner\Core\Warehouse\OtherStorageServiceInterface::updateOtherMaster()
	 */
	public function updateShipMaster($masterid,array $masterinfo)
	{
	   if(isset($masterinfo['status'])) unset($masterinfo['status']);
	    
		$master=ShipMaster::find($masterid);
		
		if($master->status !="pending" && $master->status !="confirmed")
		{
		    throw new OtherIONotAllowUpdateException("can not update after stocking!");
		}
		foreach($masterinfo as $k => $v)
		{
			$master->$k = $v;
		}
		$master->save();
		return $master->id;
	}
	
	public function confirmMaster($masterid)
	{
	    $master=ShipMaster::find($masterid);
	    $master->status="confirmed";
	    $master->save();
	}
	
	public function updateShipDetails($masterId,array $detailInfos)
	{
		foreach($detailInfos as $detailInfo)
		{
			if(!isset($detailInfo['id']))
			{
				throw new \Exception("update details you master set the detail id (false for empty)");
			}
			if($detailInfo['id']!=false)
			{
				$this->updateShipDetail($detailInfo['id'],$detailInfo);
				unset($detailInfo['id']);
			}
			else 
			{
				unset($detailInfo['id']);
				$this->createShipDetail($masterId,$detailInfo);
			}
		}
	}
	
	/**
	 * 
	 * @see \Bluebanner\Core\Warehouse\OtherStorageServiceInterface::updateOtherDetail()
	 * 
	 * 
	 */
	
	public function updateShipDetail($detailId,array $detailInfo)
	{
		$detail=ShipDetail::find($detailId);
		if($detail != null)
			{
			foreach($detailInfo as $k => $v)
			{
				$detail->$k = $v;
			}
			$detail->save();
		}
	
	}
	
	public function findShipByID($id)
	{		
		return	ShipMaster::with('fromWarehouse','toWarehouse','details','user')->find(intval($id));
	}
	
	
	public function findShipByCondition(array $search_condition)
	{
		$temp=ShipMaster::with('fromWarehouse','toWarehouse','details','user');
		foreach($search_condition as $condition)
		{
			if($condition['opera'] == "in")
			{
				$temp->whereIn($condition['field'],$condition['value']);
			}
			else 
			{
				$temp->where($condition['field'],$condition['opera'],$condition['value']);
			}
		}
		return $temp;		
	}
	
	public function findShipDetailsByMasterId($masterId)
	{
		return ShipDetail::with('warehouse','details','user','details.item');
	}
	
	public function findShipDetailByPk($detailId)
	{
	    return ShipDetail:: find(intval($detailId));
	}

	public function deleteShipMaster($id)
	{
		ShipMaster::find($id)->delete();
	}

	public function deleteShipDetail($id)
	{
		ShipDetail::find($id)->delete();
	}
	
	public function getStatus()
	{
		return ShipMaster::getAllStatus();
	}
	
	
	public function getTransStatusList()
	{
	    return ShipMaster::getTransStatusList();
	}
	/**
	 * 查找所有item_id为@item_id的列的other_id(主表主键)
	 * @param interge  $item_id
	 * 
	 * @return array other_id的集合	 
	 * 
	 */
	
	public function getMasterIdFromDetailByItemId($item_id)
	{
	    if(!is_array($item_id))
	    {
	        $item_id=array(intval($item_id));
	    }
		$ids=array();
		$ShipDetailModel=new ShipDetail();
		$ids=DB::table($ShipDetailModel->getTable())->whereIn('item_id',$item_id)->lists('shipment_id');
		if(! is_array($ids)) $ids=array();
		return $ids;
	}
	
	/**
	 * 查找所有item_id为@sku的列的other_id(主表主键)
	 * @param string  $sku
	 *
	 * @return array other_id的集合
	 *
	 */
	
	public function getMasterIdFromDetailByItemSku($sku)
	{
	    $ids=array();
	    $itemModel=new Item();	   
	  
	    $item_ids=DB::table($itemModel->getTable())->where('sku','like','%'.$sku.'%')->lists('id');	 
	  
	    if(count($item_ids)>0)
	    {    
	        $shipDetailModel=new ShipDetail();
	       $ids= DB::table($shipDetailModel->getTable())->whereIn('item_id',$item_ids)->lists('shipment_id');    	 
	    }
	    return $ids;
	}
	
	/**
	 * @param integer $masterId
	 * @param integer $fromItemId
	 * @param integer $toItemId
	 * @return integer the number has updated
	 */
	
	public function updateShipDetailItemIdByMasterId($masterId,$fromItemId,$toItemId)
	{
	    
	    // ps   请调用出入库
	    
	    $masterModel= ShipMaster::find($masterId);
	    if($masterModel->status =="pending")
	    {
	    	return ShipDetail::where('other_id','=',intval($masterId))
	        ->where('item_id','=',intval($fromItemId))
	        ->update(array('item_id'=>intval($toItemId)));
	    }
	    else // ps   请调用出入库的
	        return;
	    
	    
// 	   return OtherIODetail::where('other_id','=',intval($masterId))
// 	           ->where('item_id','=',intval($fromItemId))
// 	           ->update(array('item_id'=>intval($toItemId)));
	}
	
	/**
	 * @param integer $masterId
	 * @param integer $agent
	 * @return boolean
	 */
	
	public function returnPendingByMasterId($masterId,$agent = '1')
	{
	    $masterId=intval($masterId);
	    $masterModel=ShipMaster::find($masterId);
	    if($masterModel->status == "pending" || $masterModel->status == "confirmed")
	    {
	        if($masterModel->status == "confirmed")
	        {
	            $masterModel->status = "pending";
	            $masterModel->save();
	        }
	        return true;
	    }
	    else
	    {
	    	DB::transaction(function() use ($masterModel,$masterId,$agent) {
		        $stockService=new StockIOService();
		        $stockService->reverseInByOrign($masterId,$agent,IOType::SHIPMENT_IN);
		        $stockService->reverseOutByOrign($masterId,$agent,IOType::SHIPMENT_OUT);
		        $masterModel->status="pending";
		        $masterModel->save();

		        return true;
	    	});
	    }
	}
	
	/**
	 * 其他出入库单生成 出入库单
	 * 
	 * ps 只有其他出入库单状态为conformed时 才允许生成
	 * 
	 * @param interge $mid master pk
	 * @param interge $agent operar uid
	 * 
	 * @return void 
	 * 
	 * @exception 
	 * 
	 */
	
	public function generateIOMaster($mid,$agent)
	{
		$masterModel=ShipMaster::with('details')->find($mid);
		if($masterModel->status != "confirmed")
		{
			throw new \Exception("this SM can not be generate , please check the status!");
		}
		else
		{
			$masterInModels=$masterOutModels=$detailModels=array();	
			
			$masterInModels['relation_id']=$masterOutModels['relation_id']=$masterModel->id;
			$masterInModels['relation_invoice']=$masterOutModels['relation_invoice']=$masterModel->invoice;
			$masterInModels['creat_agent']=$masterOutModels['creat_agent']=$agent;
			$masterInModels['status']=$masterOutModels['status']=0;
			$masterInModels['type']=IOType::SHIPMENT_IN;
			$masterOutModels['type']=IOType::SHIPMENT_OUT;
			$masterInModels['warehouse_id']=$masterModel->warehouse_to_id;
			$masterOutModels['warehouse_id']=$masterModel->warehouse_from_id;
			
			$i=0;
			foreach($masterModel->details as $detail)
			{
			    $detailModels[$i]['item_id']=$detail->item_id;
			    $detailModels[$i]['qty']=$detail->qty;
			    $detailModels[$i]['relation_did']=$detail->id;
			    $i++;
			}
			
			DB::transaction(function() use ($masterModel, $masterInModels, $detailModels, $masterOutModels){
				$StockIOService=new StockIOService();
				$StockIOService->createStockIN($masterInModels,$detailModels);
				$StockIOService->createStockOut($masterOutModels,$detailModels);
				
				$masterModel->status="on-road";
				$masterModel->save();
				
				return true;
			});
			
		}
	}
	
	/**
	 * 特殊修改 sku 替换
	 * 当shipMaster status 为 pending 或者 confirmed 状态时(即未添加到出入库单时) 直接修改
	 *                        其他情况 到 stockService中修改 成功后 再修改 ShipMaster
	 * 
	 * @param integer $masterId
	 * @param integer $agent
	 * @param integer $fromItemId
	 * @param integer $toItemId
	 * 
	 * @return void
	 * 
	 */
	public function specailUpdateForSkus($masterId,$agent,$fromItemId,$toItemId)
	{
	    $masterId=intval($masterId);
	    $fromItemId=intval($fromItemId);
	    $toItemId=intval($toItemId);
	    //主model
	    $masterModel=ShipMaster::with('details')->find($masterId);
	    
	    //特殊情况
	    if($masterModel->status !="pending" && $masterModel->status !="confirmed" )
	    {
	        $stockService=new StockIOService();
	       
	        $stockService->updateStockInIOItemId($masterId,IOType::SHIPMENT_IN,$agent,$fromItemId,$toItemId);
	        $stockService->updateStockOutIOItemId($masterId,IOType::SHIPMENT_OUT,$agent,$fromItemId,$toItemId);
	    }

	    foreach($masterModel->details as $detail)
	    {
	        if($detail->item_id == $fromItemId)
	         {
	             $detail->item_id=$toItemId;
	             $detail->save();
	         }
	     }
   
	    return true;
	}
	
	/**
	 * 当otherIoMaster status 为 pending 或者 confirmed 状态时(即未添加到出入库单时) 直接修改
	 *                        其他情况 到 stockService中修改 成功后 再修改 otherIoMaster
	 * 
	 * @param integer $masterId
	 * @param integer $detailId
	 * @param integer $agent
	 * @param array $detailInfo
	 */
	public function specailUpdateForQty($masterId,$agent,$detailId,$detailInfo)
	{
	    $masterId=intval($masterId);
	    $detailId=intval($detailId);
	    $qty     =isset($detailInfo['qty'])?$detailInfo['qty']:false;
	    $hasChangedNum=false;
	    //主model
	    $masterModel=ShipMaster::with('details')->find($masterId);
	     
	  
	    
	    //未生成出入库单时  直接修改
	    foreach($masterModel->details as $detail)
	    {
	        if($detail->id==$detailId)
	        {
	            if($detail->qty != $qty) $hasChangedNum=(bool)( $hasChangedNum || true);
	            foreach ($detailInfo as $key => $v)
	            {
	                $detail->$key=$v;
	            }
	            $detail->save();
	        }
	    }
	    
	    if($qty!==false && $hasChangedNum)
	    {
    	    if($masterModel->status !="pending" && $masterModel->status !="confirmed" )
    	    {
    	        $stockService=new StockIOService();
    	         
    	        $stockService->updateStockIOOutQty($masterId,$detailId,IOType::SHIPMENT_OUT,$agent,$qty);
    	        $stockService->updateStockOutIOItemId($masterId,$detailId,IOType::SHIPMENT_IN,$agent,$qty);
    	    }
	    }
	    
	}
	
	
	public static function getShipStatusList()
	{
	    return ShipMaster::getShipStatusList();
	}
	
	
	/**
	 * 未完成   以后做  这里只是直接修改
	 * 
	 * 
	 */
	
	public function specailUpdateForBoxId($id,$agent,$detail_id,array $attrs)
	{
	    $detailModel=ShipDetail::findOrFail($detail_id);
	    
	    if($detailModel->shipment_id !== $id)
	    {
	        throw  new \Exception("error argument,or bad access!");
	    }
        
	    if(isset($attrs['box_id']))
	    {
	        $detailModel->box_id=$attrs['box_id'];
	        $detailModel->save();
	    }
	    
	    return true;
	}

	/*获取对应明细的数量*/
	public function getShipQtyByDetails($detailIdArr){
		return  ShipMaster::getShipQtyByDetails($detailIdArr);
	}
	
}

