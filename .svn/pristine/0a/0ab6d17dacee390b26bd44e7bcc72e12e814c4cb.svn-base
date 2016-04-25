<?php

use Bluebanner\Core\Warehouse\OtherStorageService;
use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Model\OtherIOMaster;
use Illuminate\Support\Facades\Input;
use Bluebanner\Core\Item\ItemService;

class APIOtherIOController extends \BaseController {

	public function __construct(OtherStorageService $otherIOService, OtherIOMaster $modelOtherIOMaster, WarehouseForm $formWarehouse)
	{
		$this->service=$otherIOService;

    $this->modelOtherIOMaster = $modelOtherIOMaster;
    $this->formWarehouse = $formWarehouse;
	}

  public function others() {
    $pg = Input::get('pg', 1);
    $getData = Input::get();

    $formData = $this->formWarehouse->filterOtherIOListOpt($getData);
    $orders = $this->modelOtherIOMaster->getOtherIOLists($formData, $pg);

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
		
		if(($warehouse=Input::get("warehouse",false))!==false)
		{
			if(!empty($warehouse) && is_numeric($warehouse))
			{
				$condition[$i]['field'] ="warehouse_id";
				$condition[$i]['opera']='=';
				$condition[$i]['value']=$warehouse;
				$i++;
			}
		}
		
		if(($status=Input::get("status",false))!==false)
		{
		
			if(!empty($status) && $status!="undifined")
			{
				$condition[$i]['field'] ="status";
				$condition[$i]['opera']='in';
				$condition[$i]['value']=explode(',',$status);
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
		
		$list=array();
		$list=$this->service->findOtherByCondition($condition)->get();
		foreach($list as $stock)
		{
		    $stock->agent;$stock->warehouse;$stock->user;		
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
  public function store2() {
    $masterGetData = Input::get('master', array());
    $childsGetData = Input::get('childs', array());

    $formMasterData = $this->formWarehouse->filterStoreMasterOtherIO($masterGetData);
    $formChildsData = $this->formWarehouse->filterStoreChildsOtherIO($childGetData);
    $this->modelOtherIOMaster->storeOtherIO($formMasterData, $formChildsData);
  }

	public function store()
	{
		//
		$master=array();
		$master['warehouse_id']	=Input::get("warehouse_id");
		$master['agent']		=Sentry::getUser()->id;
		$master['invoice']		=Input::get("invoice");
		$master['status']		="pending";
		$master['note']		    =Input::get("note");		
		$id=$this->service->createOtherMaster($master);
		return array('return'=>0,'id'=>$id);
	}

	/**
	 * Display the specified resource.
	 * @todo fix the fake data
	 *
	 * @param  int  $id
	 * @return Response
	 */
  public function show2($id) {
    $result = $this->modelOtherIOMaster->getOrderById($id);

    return $result;
  }

	public function show($key)
	{
		
		$output = array();
		if(is_numeric($key))
		{
			$model=$this->service->findOtherByID($key);
			foreach ($model->details as $detail) {
				$detail->item;
			}
			return $model;	
		}
		else 
		{
			switch ($key) {
				
				case 'stateList':
					$output = array_build($this->service->itemStatusList(), function($key, $val) {return array($key, array('data'=>$val));});
					break;
				
				case 'warehouseList':
					// $output = array(array('id' => 1, 'name' => 'US-CA'));
					$output = array_build(Bluebanner\Core\Model\Warehouse::all(), function($key, $val) {return array($key, array('id' => $val['id'], 'name' => $val['name']));});
					break;
	
				case 'requestStatus':
					$output = array( array('id' => 0, 'name' => 'pending'), array('id' => 1, 'name' => 'confirmed'), array('id' => 2, 'name' => 'purchasing'), array('id' => 3, 'name' => 'completely purchased'), array('id' => 4, 'name' => 'shipping'), array('id' => 5, 'name' => 'completely shipped'), array('id' => 6, 'name' => 'completed'), array('id' => 7, 'name' => 'cancelled'));
					break;
				case 'requestTypes':
					$output = array( array('id'=> 0 ,'name' => 'Order Direct'), array('id'=> 1 ,'name' => 'Order'), array('id'=> 2 ,'name' => 'Shipment'), array('id'=> 3 ,'name' => 'Local') );
					break;
	
				case 'chanelList':
					$output = Bluebanner\Core\Model\Account::all();
					break;
	
				case 'transportList':
					$output = array(array('name' => 'surface'), array('name' => 'air'), array('name' => 'sea'), array('name' => 'N/A'));
					break;
					
				case 'taxList': 
					$output = array(array('id' => '0','name' => 'N'),array('id' => '1','name' => 'Y'));
					break;
				case 'typeList':
					$i=0;			
					$output = array_build(IOType::getIOType(), function($key, $val) use(&$i) {return array($i++, array('id' => $key, 'name' => $val));});
				break;
				case 'statusList':
					$i=0;
					$output = array_build($this->service->getStatus(), function($key, $val) use(&$i) {return array($i++, array('id' => $val, 'name' => $val));});
					break;
				case 'detailTypesList':					
					$output = array(array('id'=>'in','name'=>'in'),array('id'=>'out','name'=>'out'));
				break;
				case 'new':
				  
				    $output = OtherIOMaster::GenerateInvoice();
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
  public function edit2($id) {
    return $this->show($id);
  }

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
  public function update2($id) {
    $masterGetData = Input::get('master', array());
    $childsGetData = Input::get('childs', array());

    $formMasterData = $this->formWarehouse->filterUpdateMasterOtherIO($masterGetData);
    $formChildsData = $this->formWarehouse->filterUpdateChildsOtherIO($childsGetData);

    $this->modelOtherIOMaster->updateOtherIO($formMasterData, $formChildsData);
  }

	public function update($id)
	{
		$returnCode=0;
		$returnMsg="";
		try{			
			$masterModel=array();
			$masterModel['warehouse_id']=Input::get("warehouse_id");			
			$masterModel['invoice']		=Input::get("invoice");
			$masterModel['status']		=Input::get("status");
			$masterModel['note']		=Input::get("note");
			$this->service->updateOtherMaster($id,$masterModel);
			$detailModels=array();
			$detailsInput=Input::get('details',array());
			if(count($detailsInput)>=1)
			{
				foreach($detailsInput as $key => $detail)
				{
					$detailModels[$key]['id']		=isset($detail['id'])?intval($detail['id']):false;
					
					$detailModels[$key]['item_id']	=isset($detail['item']['id'])?intval($detail['item']['id']):0;
					$detailModels[$key]['qty']		=$detail['qty'];
					$detailModels[$key]['type']		=$detail['type'];
					$detailModels[$key]['reason']	=isset($detail['reason'])?$detail['reason']:'';
				}
				$this->service->UpdateOtherDetails($id,$detailModels);
			}
			if(isset($_GET['type'])  && $_GET['type']=="confirmed")	
			{
			    $this->service->confirmMaster($id);
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
				$this->service->deleteOtherMaster($id);
			}
			else 
			{
				$this->service->deleteOtherDetail($id);
			}
		}
		catch(Exception $e)
		{
			$returnCode=1;
			$returnMsg=$e->getMessage();
		}
		return array('return'=>$returnCode,'errorMsg'=>$returnMsg);
	}
	
	public function generate($id)
	{
		$returnCode=0;
		$returnMsg="";
		try{
			$userid=Sentry::getUser()->id;
			$this->service->generateIOMaster(intval($id),$userid);
		}
		catch (Exception $e)
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
            case "returnPending":
                if(($msg=$this->returnPending($id,Sentry::getUser()->id))!==true)
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
    	        $detailModel=$this->service->findOtherDetailByPk($detail['id']);
    	        
    	        if($detailModel->other_id != $id)
    	        {
    	            return "参数不合法!";
    	        }
    	        else 
    	        {
    	            $attrs=array();
    	            if(isset($detail['type']))
    	            {
    	                $attrs['type']    = $detail['type'];
    	            }
    	             
    	            if(isset($detail['qty']))
    	            {
    	                $attrs['qty']    = $detail['qty'];
    	            }
    	            
    	            if(isset($detail['reason']))
    	            {
    	                $attrs['reason']    = $detail['reason'];
    	            }
    	            
    	            if(isset($detail['item_id']))
    	            {
    	                $attrs['item_id']    = $detail['item_id'];
    	            }
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
}