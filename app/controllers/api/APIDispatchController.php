<?php

use Bluebanner\Core\Warehouse\ShipmentService ;
use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Model\ShipMaster;
use Illuminate\Support\Facades\Input;
use Bluebanner\Core\Item\ItemService;

class APIDispatchController extends \BaseController {

	public function __construct(ShipmentService $otherIOService, ShipMaster $modelShipMaster, WarehouseForm $formWarehouse)
	{
		$this->service=$otherIOService;

    $this->modelShipMaster = $modelShipMaster;
    $this->formWarehouse = $formWarehouse;
	}

  public function dispatches() {
    $pg = Input::get('pg', 1);
    $getData = Input::get();

    $formData = $this->formWarehouse->filterDispatchOpt($getData);
    $orders = $this->modelShipMaster->getDispatches($formData, $pg);

    return $orders;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{		
	 
		$condition=array();
		$i=0;
		
		if(($invoice=Input::get("invoice",false))!==false)
		{
			if(!empty($invoice) && $invoice!="undifined")
			{
				$condition[$i]['field'] ="invoice";
				$condition[$i]['opera']='like';
				$condition[$i]['value']='%'.$invoice.'%';
				$i++;
			}
		}
		
		if(($sku=Input::get("sku",false))!==false)
		{
			if(!empty($sku) && is_numeric($sku))
			{
				$ids=$this->service->getMasterIdFromDetailByItemId($sku);				
				if(!empty($ids) && $ids!==array() && count($ids)!==0)
				{
					$condition[$i]['field'] ="id";
					$condition[$i]['opera']='in';
					$condition[$i]['value']=$ids;
					$i++;
				}
				else
				{
					$condition[$i]['field'] ='id';
					$condition[$i]['opera']='=';
					$condition[$i]['value']=0;
					$i++;
				}			
			}			
		}
		
		if(($skuLike=Input::get("skuLike",false))!==false)
		{
		    if(!empty($skuLike))
		    {
		        $ids=$this->service->getMasterIdFromDetailByItemSku($skuLike);		    
		        
		        if(!empty($ids) && $ids!==array() && count($ids)!==0)
		        {
		            $condition[$i]['field'] ="id";
		            $condition[$i]['opera']='in';
		            $condition[$i]['value']=$ids;
		            $i++;
		        }
		        else
		        {
		            $condition[$i]['field'] ='id';
		            $condition[$i]['opera']='=';
		            $condition[$i]['value']=0;
		            $i++;
		        }
		    }
		}
		
		if(($fromwarehouse=Input::get("fromwarehouse",false))!==false)
		{
			if(!empty($fromwarehouse) && is_numeric($fromwarehouse))
			{
				$condition[$i]['field'] ="warehouse_from_id";
				$condition[$i]['opera']='=';
				$condition[$i]['value']=$fromwarehouse;
				$i++;
			}
		}
		
		if(($towarehouse=Input::get("towarehouse",false))!==false)
		{
		    if(!empty($towarehouse) && is_numeric($towarehouse))
		    {
		        $condition[$i]['field'] ="warehouse_to_id";
		        $condition[$i]['opera']='=';
		        $condition[$i]['value']=$towarehouse;
		        $i++;
		    }
		}
		
		if(($status=Input::get("status",false))!==false)
		{
		
			if(!empty($status) && $status!="undifined")
			{
				$condition[$i]['field'] ="status";
				$condition[$i]['opera']='=';
				$condition[$i]['value']=$status;
				$i++;
			}
		}
	
		if(($timeFrom=Input::get("timeFrom",false))!==false)
		{
			if(!empty($timeFrom) && $timeFrom!="undefined")
			{
				
				$condition[$i]['field'] ="created_at";
				$condition[$i]['opera']='>=';
				$condition[$i]['value']=date("Y-m-d H:i:s",strtotime($timeFrom));
				$i++;
			}
		}
		
		if(($timeTo=Input::get("timeTo",false))!==false)
		{
			if(!empty($timeTo) && $timeTo!="undefined")
			{				
				$condition[$i]['field'] ="created_at";
				$condition[$i]['opera']='<=';
				$condition[$i]['value']=date("Y-m-d H:i:s",strtotime($timeTo));
				$i++;
			}
		}	

		if(($outTimeFrom=Input::get("outTimeFrom",false))!==false)
		{
		    if(!empty($outTimeFrom) && $outTimeFrom!="undefined")
		    {
		
		        $condition[$i]['field'] ="date_out";
		        $condition[$i]['opera']='>=';
		        $condition[$i]['value']=date("Y-m-d H:i:s",strtotime($outTimeFrom));
		        $i++;
		    }
		}
		
		if(($outTimeTo=Input::get("outTimeTo",false))!==false)
		{
		    if(!empty($outTimeTo) && $outTimeTo!="undefined")
		    {
		        $condition[$i]['field'] ="date_out";
		        $condition[$i]['opera']='<=';
		        $condition[$i]['value']=date("Y-m-d H:i:s",strtotime($outTimeTo));
		        $i++;
		    }
		}
		
		if(($receiveTimeFrom=Input::get("receiveTimeFrom",false))!==false)
		{
		    if(!empty($receiveTimeFrom) && $receiveTimeFrom!="undefined")
		    {
		
		        $condition[$i]['field'] ="date_receive";
		        $condition[$i]['opera']='>=';
		        $condition[$i]['value']=date("Y-m-d H:i:s",strtotime($receiveTimeFrom));
		        $i++;
		    }
		}
		
		
		if(($receiveTimeTo=Input::get("receiveTimeTo",false))!==false)
		{
		    if(!empty($receiveTimeTo) && $receiveTimeTo!="undefined")
		    {
		        $condition[$i]['field'] ="date_receive";
		        $condition[$i]['opera']='<=';
		        $condition[$i]['value']=date("Y-m-d H:i:s",strtotime($receiveTimeTo));
		        $i++;
		    }
		}
		
		$list=array();
		$list=$this->service->findShipByCondition($condition)->get();
		foreach($list as $stock)
		{
		    $stock->agent;$stock->fromWarehouse;$stock->user;$stock->toWarehouse;	
		}
		return $list;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	    //
		$master=array();
		$master['warehouse_from_id']	=Input::get("fromwarehouse");
		$master['warehouse_to_id']	=Input::get("towarehouse");
		$master['agent']		=Sentry::getUser()->id;
		$master['invoice']		=Input::get("invoice");
		$master['status']		="pending";
		$master['note']		    =Input::get("note");	
		$master['carrier']	=Input::get("carrier");
		$master['currency']	=Input::get("currency");
		$master['exchange_rate']	=floatval(Input::get("exchange_rate"));
		$master['shipping_fee']	=floatval(Input::get("shipping_fee"));
		$master['tracking']	=Input::get("tracking");
		$master['transportation']	=Input::get("transportation");
		$master['date_eta']	=Input::get("date_eta")?date("Y-m-d H:i:s",strtotime(Input::get("date_eta"))):null;
		$master['date_out']	=Input::get("date_out")?date("Y-m-d H:i:s",strtotime(Input::get("date_out"))):null;
		$master['date_receive']	=Input::get("date_receive")?date("Y-m-d H:i:s",strtotime(Input::get("date_receive"))):null;
		
		$id=$this->service->createShipMaster($master);
		return array('return'=>0,'id'=>$id);
	}

	/**
	 * Display the specified resource.
	 * @todo fix the fake data
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($key)
	{
		
		$output = array();
		if(is_numeric($key))
		{
			$model=$this->service->findShipByID($key);
			if(strlen($model->date_eta)>10)
			{
			    $model->date_eta=date("Y-m-d",strtotime( $model->date_eta));
			}
			if(strlen($model->date_out)>10)
			{
			    $model->date_out=date("Y-m-d",strtotime( $model->date_out));
			}
			if(strlen($model->date_receive)>10)
			{
			    $model->date_receive=date("Y-m-d",strtotime( $model->date_receive));
			}
			foreach ($model->details as $detail) {
				$detail->item;
			}
			return $model;	
		}
		else 
		{
			switch ($key) {
				
				case 'new':
				    $output = ShipMaster::GenerateInvoice();
				    $output = array('invoice'=>$output,'status'=>'pending');
				break;
				default:
					$output = array();
				break;
			}
		}
		return $output;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{		
		return $this->service->findOtherByID($id)->get();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$returnCode=0;
		$returnMsg="";
		//try{			
			$master=array();
			$master['warehouse_from_id']	=Input::get("warehouse_from_id");
			$master['warehouse_to_id']	=Input::get("warehouse_to_id");
			$master['agent']		=Sentry::getUser()->id;
			$master['invoice']		=Input::get("invoice");
			$master['status']		="pending";
			$master['note']		    =Input::get("note");
			$master['carrier']	=Input::get("carrier");
			$master['currency']	=Input::get("currency");
			$master['exchange_rate']	=floatval(Input::get("exchange_rate"));
			$master['shipping_fee']	=floatval(Input::get("shipping_fee"));
			$master['tracking']	=Input::get("tracking");
			$master['transportation']	=Input::get("transportation");
			$master['date_eta']	=Input::get("date_eta")?date("Y-m-d H:i:s",strtotime(Input::get("date_eta"))):null;
			$master['date_out']	=Input::get("date_out")?date("Y-m-d H:i:s",strtotime(Input::get("date_out"))):null;
			$master['date_receive']	=Input::get("date_receive")?date("Y-m-d H:i:s",strtotime(Input::get("date_receive"))):null;
			
			$this->service->updateShipMaster($id,$master);
			$detailModels=array();
			$detailsInput=Input::get('details',array());
			if(count($detailsInput)>=1)
			{
				foreach($detailsInput as $key => $detail)
				{
					$detailModels[$key]['id']		=isset($detail['id'])?intval($detail['id']):false;
					
					$detailModels[$key]['item_id']	=isset($detail['item']['id'])?intval($detail['item']['id']):0;
					$detailModels[$key]['qty']		=$detail['qty'];
					$detailModels[$key]['pi_price']	=$detail['pi_price'];
					$detailModels[$key]['box_id']	=isset($detail['box_id'])?$detail['box_id']:'';
				}
				$this->service->UpdateShipDetails($id,$detailModels);
			}
			if(isset($_GET['type'])  && $_GET['type']=="confirmed")	
			{
			    $this->service->confirmMaster($id);
			}	
		/*}
		
		catch(Exception $e)
		{
			$returnCode=1;
			$returnMsg=$e->getMessage();
		}*/
		return array('return'=>$returnCode,'errorMsg'=>$returnMsg);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$returnCode=0;
		$returnMsg="";
		try{
			$type=Input::get('type','master');
			if($type=="master")
			{
				$this->service->deleteShipMaster($id);
			}
			else 
			{
				$this->service->deleteShipDetail($id);
			}
		}
		catch(Exception $e)
		{
			$returnCode=1;
			$returnMsg=$e->getMessage();
		}
		return array('return'=>$returnCode,'errorMsg'=>$returnMsg);
	}
	
	/**
	 * @param integer $id
	 * @return void
	 */	
	public function specail($id)
	{
	
	    $returnCode=0;
	    $returnMsg="";
	    $id=intval($id);
	    if($id==0)
	    {
	        throw new Exception("wrong arguments");
	    }
        $type=isset($_GET['type'])?$_GET['type']:'';
        switch ($type)
        {
            //更改sku
            case "updateSkus":
                if(($msg=$this->updateSkus($id))!==true)
                {
                    $returnCode=1;
                    $returnMsg=$msg;
                }
             break;
             //更改单个
            case "setDetail":
                 if(($msg=$this->setDetail($id))!==true)
                 {
                     $returnCode=1;
                     $returnMsg=$msg;
                 }
           break;
           case "setAllDetails":
                 if(($msg=$this->setAllDetails($id))!==true)
                 {
                     $returnCode=1;
                     $returnMsg=$msg;
                 }
            break;
            //改条码
            case "updateBoxId":
                if(($msg=$this->updateBoxId($id))!==true)
                {
                    $returnCode=1;
                    $returnMsg=$msg;
                }
            break;
            case "returnPending":
                if(($msg=$this->returnPending($id,Sentry::getUser()->id))!==true)
                {
                    $returnCode=1;
                    $returnMsg=$msg;
                }
            break;
            
            case "generate":
                if(($msg=$this->generate($id))!==true)
                {
                    $returnCode=1;
                    $returnMsg=$msg;
                }
            break;
             
            default: 
                $returnCode=1;
                $returnMsg="未知或者不允许的操作!";
            break;
               
        }
        
        return array('return'=>$returnCode,'errorMsg'=>$returnMsg);
	}
	
	/**
	 * @param integer $id
	 * @return bool 
	 */	
	protected function updateSkus($id)
	{
	    $id=intval($id);
	    $fromSku=Input::get('formSku',false);
	    $toSku=Input::get('toSku',false);
	    if($fromSku==false || $toSku==false)
	    {
	       return "您传入的sku不合法!";
	    }
	    else 
	    {
	        $itemModel=new ItemService();
	        $fromItemModel=$itemModel->itemFindBySKU($fromSku);
	        if(! isset($fromItemModel->id))
	        {
	            return "找不到该Item!";
	        }
	        else 
	            $fromItemid=$fromItemModel->id;
	        $toItemModel=$itemModel->itemFindBySKU($toSku);
	        if(! isset($toItemModel->id))
	        {
	            return "找不到该Item!";
	        }
	        else
	            $toItemid=$toItemModel->id;
	      $this->service->specailUpdateForSkus($id,Sentry::getUser()->id,$fromItemid,$toItemid);       
	    }
	    return true;
	}
	
	/**
	 * @param integer $id
	 * @return bool
	 */
	protected function setDetail($id)
	{
	    $id=intval($id);
	    $detailId=Input::get('subid');
	    $detailModel=$this->service->findOtherDetailByPk($detailId);
	    if($detailModel->other_id != $id)
	    {
	        return "参数不合法!";
	    }
	    else
	    {
	        $attrs=array();
	        if(Input::get('type') !==null)
	        {
	            $attrs['type']    =Input::get('type');
	        }
	        
	        if(Input::get('qty') !==null)
	        {
	            $attrs['qty']    =Input::get('qty');
	        }
	        
	        if(Input::get('reason') !==null)
	        {
	            $attrs['reason']    =Input::get('reason');
	        }
	        if(Input::get('item_id') !==null)
	        {
	            $attrs['item_id']    =Input::get('item_id');
	        }	        
	        $this->service->updateOtherDetail($detailId,$attrs);
	    }
	    return true;
	}
	
	
	/**
	 * @param integer $id
	 * @return bool
	 */
	protected function setAllDetails($id)
	{
	    $id=intval($id);
	    $details=Input::get('details');
	    foreach($details as $detail)
	    {
	        if(isset($detail['id']))
	        {
    	        $detailModel=$this->service->findShipDetailByPk($detail['id']);
    	        
    	        if($detailModel->shipment_id != $id)
    	        {
    	            return "参数不合法!";
    	        }
    	        else 
    	        {
    	            $attrs=array();
    	           
    	            if(isset($detail['qty']))
    	            {
    	                $attrs['qty']    = $detail['qty'];
    	            }
    	            else 
    	                continue;
    	            $this->service->specailUpdateForQty($id,Sentry::getUser()->id,$detail['id'],$attrs);
    	        }
	        }
	    }
	    return true;
	}
	
	/**
	 * @param integer $id
	 * @return bool
	 */
	protected function returnPending($id)
	{
	    $id=intval($id);
	    $this->service->returnPendingByMasterId($id,Sentry::getUser()->id);
	    return true;
	}
	
	/**
	 * @param integer $id
	 * @return bool
	 */
	protected function generate($id)
	{
	
	    try{
	        $userid=Sentry::getUser()->id;
	        $this->service->generateIOMaster(intval($id),$userid);
	    }
	    catch (Exception $e)
	    {
	        $returnCode=1;
	        $returnMsg=$e->getMessage();
	    }
	    return true;
	}
	
	protected function updateBoxId($id)
	{
	    $id=intval($id);
	    $details=Input::get('details');
	    foreach($details as $detail)
	    {
	        if(isset($detail['id']))
	        {
	            $detailModel=$this->service->findShipDetailByPk($detail['id']);
	             
	            if($detailModel->shipment_id != $id)
	            {
	                return "参数不合法!";
	            }
	            else
	            {
	                $attrs=array();
	                if(isset($detail['box_id']))
	                {
	                    $attrs['box_id']    = $detail['box_id'];
	                }
	                else 
	                    continue;	    
	                $this->service->specailUpdateForBoxId($id,Sentry::getUser()->id,$detail['id'],$attrs);
	            }
	        }
	    }
	    return true;
	}
}