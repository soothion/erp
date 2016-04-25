<?php

use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Illuminate\Support\Facades\Input;
use Bluebanner\Core\Item\ItemService;

class APIReturnController extends \BaseController {

	
	public function __construct(PurchaseServiceInterface $returnService)
	{
		
		$this->service=$returnService;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$list=$condition = array();
		
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
	
		if(($sku=Input::get("item_id",false))!==false)
		{
			if(!empty($sku) && is_numeric($sku))
			{
				$ids=$this->service->returnGetMasterIdFromDetailByItemId($sku);
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
		
		//eq status
		if(($inputstatus=Input::get("status",false))!==false)
		{		
			if(!empty($inputstatus) && $inputstatus!="undifined")
			{
				$condition[$i]['field'] ="status";
				$condition[$i]['opera']='=';
				$condition[$i]['value']=$inputstatus;
				$i++;
				
			}
		}
		
		if(($timeFrom=Input::get("timeStart",false))!==false)
		{
			if(!empty($timeFrom) && $timeFrom!="undefined")
			{
		
				$condition[$i]['field'] ="created_at";
				$condition[$i]['opera']='>=';
				$condition[$i]['value']=date("Y-m-d H:i:s",strtotime($timeFrom));
				$i++;
			}
		}
		
		if(($timeTo=Input::get("timeEnd",false))!==false)
		{
			if(!empty($timeTo) && $timeTo!="undefined")
			{
				$condition[$i]['field'] ="created_at";
				$condition[$i]['opera']='<=';
				$condition[$i]['value']=date("Y-m-d H:i:s",strtotime($timeTo));
				$i++;
			}
		}
				
		foreach ($this->service->returnFindByField($condition)->get() as $returns) {
			$array = $returns->toArray();
			$returns->warehouse;
			$array['agent_name'] = $returns->user->email;
			//$array['warehouse'] = $returns->warehouse;
			$array['vendor'] =empty($returns->vendor)?'不存在或者已删除':"[".$returns->vendor->code."]".$returns->vendor->name;
			$list[] = $array;
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
		$return=array(
				"agent"=>Sentry::getUser()->id, 
				"invoice"=>Input::get('invoice'),
				"address"=>Input::get('address'),
				"note"=>Input::get('note'),
				"return_at"=>Input::get('return_at'),
				"status"=>Input::get('status'),
				"vendor_id"=>Input::get('vendor_id'),
				"warehouse_id"=>Input::get('warehouse_id'),			
		);
		return $this->service->returnCreate($return);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $id
	 * @return Response
	 */
	public function show($key)
	{
		if(is_numeric($key))
		{
			$returnModel=$this->service->returnMoreFindByPK($key);
			foreach($returnModel->details  as $key => $detail)
			{
				$returnModel->details[$key]['sku'] = $detail->item->sku;
			}
			return $returnModel;
		}
		else
		{
			switch($key)
			{
				case "statusList":
					return array_build($this->service->getReturnStatusList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));});
				//add other here
				case "new":
				    return array('invoice'=>$this->service->getNextReturnInvoice(),'status'=>'pending');
				
			}
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$returnModel=$this->service->returnFindByPK($id);
		if($returnModel!==null)
		{
			$returnModel->update(
				array(
					"agent"=>Sentry::getUser()->id,
					"invoice"=>Input::get('invoice'),
					"address"=>Input::get('address'),
					"note"=>Input::get('note'),
					"return_at"=>Input::get('return_at'),
					"status"=>Input::get('status'),
					"vendor_id"=>Input::get('vendor_id'),
					"warehouse_id"=>Input::get('warehouse_id'),
				)
			);	
			return "";		
		}
		else
		{
			throw new \Exception("invailed arguments");
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$returnModel=$this->service->returnFindByPK($id);
		if($returnModel->details()->count() !==0)
		{
			throw new \Exception("please delete all the details first! ");
		}
		else 
		{
			return $this->service->returnDelete($id);
		}
	}
	
	/*
	 * 
	 * 生成出库单
	 * 
	 */
	public function generate($id)
	{
		
		if($this->service->returnGenerateOutStock($id,Sentry::getUser()->id))
		{
			return "0";
		}
		else 
			return "1";
		
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
	        throw new Exception("您传入的sku不合法!");
	    }
	    else
	    {
	        $itemModel=new ItemService();
	        $fromItemModel=$itemModel->itemFindBySKU($fromSku);
	        if(! isset($fromItemModel->id))
	        {
	            throw new Exception( "找不到该Item of '$fromSku'!");	          
	        }
	        else
	            $fromItemid=$fromItemModel->id;
	        $toItemModel=$itemModel->itemFindBySKU($toSku);
	        if(! isset($toItemModel->id))
	        {
	            throw new Exception( "找不到该Item of '$toSku'!");	
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