<?php
namespace Bluebanner\Core\Warehouse;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\OtherIOMaster;
use Bluebanner\Core\Model\OtherIODetail;
use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
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
class OtherStorageService implements OtherStorageServiceInterface
{
	public function createOther($master,$details)
	{
		DB::transaction(function() use ($master, $details) {
			$r = OtherIOMaster::create($master);
		
			foreach ($details as $detail) {
				$detail['other_id'] = $r->id;
				OtherIODetail::create($detail);
			}	
			return $r;
		});
		
	}
	
	/**
	 * 创建表头 创建时的默认状态 为 "pending"
	 * @see \Bluebanner\Core\Warehouse\OtherStorageServiceInterface::createOtherMaster()
	 */
	public function createOtherMaster(array $master)
	{
	    try{
	        $r=OtherIOMaster::create($master);
	        return $r->id;
	    }
	    catch (Exception $e)
	    {
	        var_dump($e->getCode()) ;
	        var_dump($e->getMessage()) ;
	        die();
	    }
	}
	
	public function createOtherDetails($masterid,array $details)
	{
		foreach($details as $d)
		{
			$this->createOtherDetail($masterid,$d);
		}
	}
	
	public function createOtherDetail($masterid,array $detail)
	{
		$detail['other_id']=intval($masterid);
		$d=OtherIODetail::create($detail);
		return $d->id;		
	}
	
	/**
	 * 只有Master的status为pending 时 才允许修改 且不允许修改status
	 * 
	 * @see \Bluebanner\Core\Warehouse\OtherStorageServiceInterface::updateOtherMaster()
	 */
	public function updateOtherMaster($masterid,$masterinfo)
	{
	   if(isset($masterinfo['status'])) unset($masterinfo['status']);
	    
		$master=OtherIOMaster::find($masterid);
		
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
	    $master=OtherIOMaster::find($masterid);
	    $master->status="confirmed";
	    $master->save();
	}
	
	public function UpdateOtherDetails($masterId,$detailInfos)
	{
		foreach($detailInfos as $detailInfo)
		{
			if(!isset($detailInfo['id']))
			{
				throw new \Exception("update details you master set the detail id (false for empty)");
			}
			if($detailInfo['id']!=false)
			{
				$this->updateOtherDetail($detailInfo['id'],$detailInfo);
				unset($detailInfo['id']);
			}
			else 
			{
				unset($detailInfo['id']);
				$this->createOtherDetail($masterId,$detailInfo);
			}
		}
	}
	
	/**
	 * 
	 * @see \Bluebanner\Core\Warehouse\OtherStorageServiceInterface::updateOtherDetail()
	 * 
	 * 
	 */
	
	
	public function updateOtherDetail($detailId,$detailInfo)
	{
		$detail=OtherIODetail::find($detailId);
		if($detail != null)
			{
			foreach($detailInfo as $k => $v)
			{
				$detail->$k = $v;
			}
			$detail->save();
		}
	
	}
	
	public function findOtherByID($id)
	{		
		return	OtherIOMaster::with('warehouse','details','user')->find(intval($id));
	}
	
	
	public function findOtherByCondition(array $search_condition)
	{
		$temp=OtherIOMaster::with('warehouse','details','user');
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
	
	public function findOtherDetailsByMasterId($masterId)
	{
		return OtherIODetail::with('warehouse','details','user','details.item');
	}
	
	public function findOtherDetailByPk($detailId)
	{
	    return OtherIODetail:: find(intval($detailId));
	}

	public function deleteOtherMaster($id)
	{
		OtherIOMaster::find($id)->delete();
	}

	public function deleteOtherDetail($id)
	{
		OtherIODetail::find($id)->delete();
	}
	
	public function getStatus()
	{
		return OtherIOMaster::getAllStatus();
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
		$otherIODetailModel=new OtherIODetail();
		$ids=DB::table($otherIODetailModel->getTable())->whereIn('item_id',$item_id)->lists('other_id');
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
	        $otherIODetailModel=new OtherIODetail();
	       $ids= DB::table($otherIODetailModel->getTable())->whereIn('item_id',$item_ids)->lists('other_id');    	 
	    }
	    return $ids;
	}
	
	/**
	 * @param integer $masterId
	 * @param integer $fromItemId
	 * @param integer $toItemId
	 * @return integer the number has updated
	 */
	
	public function updateOtherDetailItemIdByMasterId($masterId,$fromItemId,$toItemId)
	{
	    
	    // ps   请调用出入库
	    
	    $masterModel= OtherIOMaster::find($masterId);
	    if($masterModel->status =="pending")
	    {
	    	return OtherIODetail::where('other_id','=',intval($masterId))
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
	    $masterModel=OtherIOMaster::find($masterId);
	    	
	    DB::transaction(function() use ($masterModel,$masterId,$agent) {
		        $stockService=new StockIOService();
		        $stockService->reverseInByOrign($masterId,$agent,IOType::OTHER_IN);//如果没有入库单会直接返回
		        $stockService->reverseOutByOrign($masterId,$agent,IOType::OTHER_OUT);//如果没有出库单会直接返回
		        $masterModel->status="pending";
		        $masterModel->save();
		        return true;
	    });

	    return true;
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
		$masterModel=OtherIOMaster::with('details')->find($mid);
		if($masterModel->status != "confirmed")
		{
			throw new OtherIONotAllowGenerateException("this storage can not be generate , please check the status!");
		}
		else
		{
			$masterInModels=$masterOutModels=$detailInModels=$detailOutModels=array();			
			$i=$o=0;
			foreach($masterModel->details as $detail)
			{
				if($detail->type=="in")
				{
					//主表
					if($i==0)
					{
						$masterInModels['relation_id']=$masterModel->id;
						$masterInModels['relation_invoice']=$masterModel->invoice;
						$masterInModels['warehouse_id']=$masterModel->warehouse_id;
						$masterInModels['type']=6;
						$masterInModels['creat_agent']=$agent;
						$masterInModels['status']=0;
					}
					
					
					//附表
					$detailInModels[$i]['item_id']=$detail->item_id;
					$detailInModels[$i]['qty']=$detail->qty;
					$detailInModels[$i]['relation_did']=$detail->id;
					
					$i++;				
				}
				else
				{
					//主表
					if($o==0)
					{
						$masterOutModels['relation_id']=$masterModel->id;
						$masterOutModels['relation_invoice']=$masterModel->invoice;
						$masterOutModels['warehouse_id']=$masterModel->warehouse_id;
						$masterOutModels['type']=-6;
						$masterOutModels['creat_agent']=$agent;
						$masterOutModels['status']=0;	
					}
					
					//附表
					$detailOutModels[$o]['item_id']=$detail->item_id;
					$detailOutModels[$o]['qty']=$detail->qty;
					$detailOutModels[$o]['relation_did']=$detail->id;
					$o++;
				}
			}
			
			DB::transaction(function() use ($masterModel, $masterInModels, $detailInModels, $masterOutModels, $detailOutModels){
				$StockIOService=new StockIOService();
				if($masterInModels!==array())
				{			    
				    $StockIOService->createStockIN($masterInModels,$detailInModels);
				}
				
				if($masterOutModels!==array())
				{
				    $StockIOService->createStockOut($masterOutModels,$detailOutModels);
				}

				$masterModel->status="stocking";
				$masterModel->save();
				
				return true;
			});
		}
	}
	
	/**
	 * 特殊修改 sku 替换
	 * 当otherIoMaster status 为 pending 或者 confirmed 状态时(即未添加到出入库单时) 直接修改
	 *                        其他情况 到 stockService中修改 成功后 再修改 otherIoMaster
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
	    $masterModel=OtherIOMaster::with('details')->find($masterId);
	    
	    //特殊情况
	    if($masterModel->status !="pending" || $masterModel->status !="confirmed" )
	    {
	        $stockService=new StockIOService();
	       
	        $stockService->updateStockInIOItemId($masterId,IOType::OTHER_IN,$agent,$fromItemId,$toItemId);
	        $stockService->updateStockOutIOItemId($masterId,IOType::OTHER_OUT,$agent,$fromItemId,$toItemId);
	    }

	    foreach($masterModel->details as $detail)
	    {
	        if($detail->item_id == $fromItemId)
	         {
	             $detail->item_id=$toItemId;
	             $detail->save();
	         }
	     }
   
// 	    //该item下的数量之和
// 	    $qty_in=$qty_out=$stock_qty_in=$stock_qty_out=0;
// 	    foreach($masterModel->details as $detail)
// 	    {
// 	        if($detail->item_id == $fromItemId)
// 	        {
// 	            if($detail->type=='in')
// 	                $qty_in +=$detail->qty;
// 	            else $qty_out +=$detail->qty;
// 	        }
// 	    }
	    
// 	   $stockIOModelService=new StockIOService();
	   
// 	   $stockIOModelOfIn=$stockIOModelService->stockFindByRelationID($masterId,array(IOType::OTHER_IN));
// 	   $stockIOModelOfOut=$stockIOModelService->stockFindByRelationID($masterId,array(IOType::OTHER_OUT));
	   
// 	    foreach($stockIOModelOfIn->details as $detail)
// 	    {
// 	        if($detail->item_id == $fromItemId)
// 	        {
// 	            $stock_qty_in +=$detail->qty;
// 	        }
// 	    }
	    
// 	    foreach($stockIOModelOfOut->details as $detail)
// 	    {
// 	        if($detail->item_id == $fromItemId)
// 	        {
// 	            $stock_qty_out +=$detail->qty;
// 	        }
// 	    }
	    
// 	    //数量正确时才允许改变
// 	    if($stock_qty_in == $qty_in &&　$qty_out　== $stock_qty_out)
// 	    {
	        
// 	    }
// 	    else
// 	    {
// 	        throw new OtherIONotAllowChangeException("can not change this Storage,because (some of ) the stock has been used!");
// 	    }
	    
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
	    $masterModel=OtherIOMaster::with('details')->find($masterId);
	     
	  
	    
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
    	         
    	        $stockService->updateStockIOOutQty($masterId,$detailId,IOType::OTHER_IN,$agent,$qty);
    	        $stockService->updateStockOutIOItemId($masterId,$detailId,IOType::OTHER_OUT,$agent,$qty);
    	    }
	    }
	    
	}
	


}

