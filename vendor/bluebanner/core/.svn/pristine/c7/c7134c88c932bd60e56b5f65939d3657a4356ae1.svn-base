<?php
namespace Bluebanner\Core\Warehouse;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\CountingMaster;
use Bluebanner\Core\Model\CountingDetail;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Inventory\InventoryService;
use Bluebanner\Core\Inventory\InventoryBookService;

use Bluebanner\Core\Warehouse\StockIOService;

use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Warehouse\IOStatus;
use Bluebanner\Core\CountingMasterNotAllowUpdateException;


class CountingService implements CountingServiceInterface
{
    
    /**
     * 新建盘点单
     * 
     * @param array $masterInfo
     * @return Ambigous <\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\static, \Bluebanner\Core\Model\CountingMaster>
     */
    public function createCountMaster($masterInfo)
    {
       return CountingMaster::create($masterInfo);
    }
       
    /**
     * @param integer $masterId
     * @param array $detailInfo
     * @return Ambigous <\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\static, \Bluebanner\Core\Model\CountingDetail>
     */
    public function createCountDetail($masterId,array $detailInfo)
    {
        $detailInfo['counting_id']=intval($masterId);
        return CountingDetail::create($detailInfo);
    }
    
    /**
     * @param integer $masterid
     * @param array $masterinfo
     * @return integer $master id
     * @throws OtherIONotAllowUpdateException
     */
    public function updateCountMaster($masterid,array $masterinfo)
    {
        if(isset($masterinfo['status'])) unset($masterinfo['status']);
         
        $master=CountingMaster::find(intval($masterid));
    
        if($master->status !="pending" && $master->status !="confirmed")
        {
            throw new CountingMasterNotAllowUpdateException("can not update after stocking!");
        }
        foreach($masterinfo as $k => $v)
        {
            $master->$k = $v;
        }
        $master->save();
        return $master->id;
    }
    
    
   /**
    * @param intval $masterId
    */
    public function confirmMaster($masterId)
    {
        $master=CountingMaster::findOrFail($masterId);
        $master->status="confirmed";
        $master->save();
    }
    
    /**
     * @param integer $masterid
     * @param integer $detailId
     * @param array $masterinfo
     * @return update id
     */
    public function updateCountDetail($masterid,$detailId,array $detailInfo)
    {
        $detail=CountingDetail::where("counting_id",'=',intval($masterid))->findOrFail(intval($detailId));
        foreach($detailInfo as $k => $v)
        {
            $detail->$k = $v;
        }
        $detail->save();
        return $detail->id;
              
    }
    
  
    
    /**
     * @param integer $masterId
     * @param array $detailInfos
     * @throws \Exception
     */
    public function UpdateCountDetails($masterId,$detailInfos)
    {
        foreach($detailInfos as $detailInfo)
        {
            if(!isset($detailInfo['id']))
            {
                throw new \Exception("update details you master set the detail id (false for empty)");
            }
            if($detailInfo['id']!=false)
            {
                $this->updateCountDetail($masterId,$detailInfo['id'],$detailInfo);
                unset($detailInfo['id']);
            }
            else
            {
                unset($detailInfo['id']);
                $this->createCountDetail($masterId,$detailInfo);
            }
        }
    }
   
    
    /**
     * @param integer $id
     * @return Ambigous <\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\static, NULL>
     */
    public function findCountByID($id)
    {
        return	CountingMaster::with('warehouse','details','user')->find(intval($id));
    }
    

    /**
     * @param array $search_condition
     * @return AmbigousList
     */
    public function findCountByCondition(array $search_condition)
	{
		$temp=CountingMaster::with('warehouse','details','user');
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
	
	/**
	 * 查找所有item_id为@item_id的列的count_id(主表主键)
	 * @param interge  $item_id
	 *
	 * @return array count_id的集合
	 *
	 */
	
	public function getMasterIdFromDetailByItemId($item_id)
	{
	    if(!is_array($item_id))
	    {
	        $item_id=array(intval($item_id));
	    }
	    $ids=array();
	    $countingDetail=new CountingDetail();
	    $ids=DB::table($countingDetail->getTable())->whereIn('item_id',$item_id)->lists('counting_id');
	    if(! is_array($ids)) $ids=array();
	    return $ids;
	}
	
	public function checkNum($id)
	{
	   $masterModel= CountingMaster::with('details')->findOrFail(intval($id));
	   $wareHouseId=intval($masterModel->warehouse_id);
	   $inventoryService=new InventoryService();
	   
	   foreach($masterModel->details as $detail)   
	   {
	       $erp_qty=$inventoryService->getQtySumByItem($wareHouseId,'', $detail->item_id);
	       $diff_qty=intval($detail->qty)-$erp_qty;
	       $detail->erp_qty=$erp_qty;
	       $detail->diff_qty=$diff_qty;
	       $detail->save();
	   }
	}
	
	public function generateIO($id,$agent)
	{
	    $masterModel= CountingMaster::with('details')->findOrFail(intval($id));
	    if($masterModel->status != "confirmed")
	    {
	        throw new \Exception("盘点单状态异常!");
	    }
	    else
	    {
	        $masterInModels=$masterOutModels=$detailInModels=$detailOutModels=array();
	        $i=$o=0;
	        foreach($masterModel->details as $detail)
	        {
	            $diff_qty=intval($detail->diff_qty);
	            //盘盈入库
	            if($diff_qty > 0)
	            {
	                //主表
	                if($i==0)
	                {
	                    $masterInModels['relation_id']=$masterModel->id;
	                    $masterInModels['relation_invoice']=$masterModel->invoice;
	                    $masterInModels['warehouse_id']=$masterModel->warehouse_id;
	                    $masterInModels['type']=IOType::CHECK_STOCK_IN;
	                    $masterInModels['creat_agent']=$agent;
	                    $masterInModels['status']=0;
	                }
	    
	    
	                //附表
	                $detailInModels[$i]['item_id']=$detail->item_id;
	                $detailInModels[$i]['qty']=abs($diff_qty);
	                $detailInModels[$i]['relation_did']=$detail->id;
	    
	                $i++;
	            }
	            //盘亏出库
	            else if($diff_qty < 0)
	            {
	                //主表
	                if($o==0)
	                {
	                    $masterOutModels['relation_id']=$masterModel->id;
	                    $masterOutModels['relation_invoice']=$masterModel->invoice;
	                    $masterOutModels['warehouse_id']=$masterModel->warehouse_id;
	                    $masterOutModels['type']=IOType::CHECK_STOCK_OUT;
	                    $masterOutModels['creat_agent']=$agent;
	                    $masterOutModels['status']=0;
	                }
	    
	                //附表
	                $detailOutModels[$o]['item_id']=$detail->item_id;
	                $detailOutModels[$o]['qty']=abs($diff_qty);
	                $detailOutModels[$o]['relation_did']=$detail->id;
	                $o++;
	            }
	        }
	    
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
	    
	    }
	}
	
	
	/**
	 * @param integer $masterId
	 * @param integer $agent
	 * @return boolean
	 */
	
	public function returnPending($masterId,$agent = '1')
	{
	    $masterId=intval($masterId);
	    $masterModel=CountingMaster::find($masterId);
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
	            $stockService->reverseInByOrign($masterId,$agent,IOType::CHECK_STOCK_IN);
	            $stockService->reverseOutByOrign($masterId,$agent,IOType::CHECK_STOCK_OUT);
	            $masterModel->status="pending";
	            $masterModel->save();	
	            return true;
	        });
	    }
	}
	
	public function deleteOtherMaster($id)
	{
	    CountingMaster::find($id)->delete();
	}
	
	public function deleteOtherDetail($id)
	{
	    CountingDetail::find($id)->delete();
	}
}
