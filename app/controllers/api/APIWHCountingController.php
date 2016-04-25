<?php

use Bluebanner\Core\Warehouse\CountingService;
use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Model\CountingMaster;
use Illuminate\Support\Facades\Input;
use Bluebanner\Core\Item\ItemService;

class APIWHCountingController extends BaseController
{

  public function __construct (CountingService $countingService, CountingMaster $modelCountingMaster, WarehouseForm $formWarehouse)
    {
        $this->service=$countingService;

        $this->modelCountingMaster = $modelCountingMaster;
        $this->formWarehouse = $formWarehouse;
    }

    public function countings() {
      $pg = Input::get('pg', 1);
      $getData = Input::get();

      $formData = $this->formWarehouse->filterCountingOpt($getData);
      $countings = $this->modelCountingMaster->getCountings($formData, $pg);

      return $countings;
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
               
                if(!empty($ids) && $ids!==array() && is_array($ids) && count($ids)!==0)
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
        $list=$this->service->findCountByCondition($condition)->get();
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

    }

    public function store()
    {
        //
        $master=array();
        $master['warehouse_id']	=Input::get("warehouse_id");
        $master['agent']		=Sentry::getUser()->id;
        $master['invoice']		=Input::get("invoice");
        $master['status']		="pending";
        $master['created_at']	=time();
        return $this->service->createCountMaster($master);
       
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
            $model=$this->service->findCountByID($key);
            foreach ($model->details as $detail) {
                $detail->item;
            }
            return $model;
        }
        else
        {
            switch ($key) {
              
                case 'new':
                    $invoice = CountingMaster::GenerateInvoice();
                    $output = array('invoice'=>$invoice,'status'=>'pending','created_at'=>date("Y-m-d"));
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
        try{
            //修改或者确认
            if(!isset($_GET['type']) || $_GET['type']=="confirmed")
            {
                $masterModel=array();
                $masterModel['warehouse_id']=Input::get("warehouse_id");
                $masterModel['invoice']		=Input::get("invoice");
                $masterModel['status']		=Input::get("status");
                $this->service->updateCountMaster($id,$masterModel);
                $detailModels=array();
                $detailsInput=Input::get('details',array());
                if(count($detailsInput)>=1)
                {
                    foreach($detailsInput as $key => $detail)
                    {
                        $detailModels[$key]['id']		=isset($detail['id'])?intval($detail['id']):false;
                         
                        $detailModels[$key]['item_id']	=isset($detail['item']['id'])?intval($detail['item']['id']):0;
                        $detailModels[$key]['qty']		=$detail['qty'];
                    }
                    $this->service->UpdateCountDetails($id,$detailModels);
                }
                
                if(isset($_GET['type'])  && $_GET['type']=="confirmed")
                {
                    $this->service->confirmMaster($id);
                }
            }
            
            //其他类似特殊操作
            if(isset($_GET['type']))
            {
                switch ($_GET['type'])
                {
                    //检查数量
                    case "check":
                        $this->checkNum($id);
                    break;
                    //生成出入库单
                    case "generate":
                        $this->generateIO($id);
                    break;
                    //生成出入库单
                    case "returnPending":
                        $this->returnPending($id);
                        break;
                    default:
                        $returnCode=1;
                        $returnMsg="未知或者不允许的操作!";
                   break;
                }
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
    
    public function generateIO($id)
    {
        $this->service->generateIO($id,Sentry::getUser()->id);
    }
    
    public function checkNum($id)
    {
        $this->service->checkNum($id);
    }
    
    public function returnPending($id)
    {
        $this->service->returnPending($id,Sentry::getUser()->id);
    }
}
