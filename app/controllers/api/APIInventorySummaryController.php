<?php
use Bluebanner\Core\Inventory\InventoryDailyLogService;
use Illuminate\Support\Facades\Input;

use Bluebanner\Core\Model\InventoryDailyLog;

class APIInventorySummaryController extends \BaseController {

  public function __construct(InventoryDailyLogService $service, InventoryDailyLog $modelInventoryDailyLog, InventoryForm $formInventory)
    {
        $this->service = $service;

        $this->InventoryDailyLogService = $this->service;
        $this->modelInventoryDailyLog = $modelInventoryDailyLog;
        $this->formInventory = $formInventory;
    }

    public function statement() {
      $pg = Input::get('pg', 1);
      $getData = Input::get();

      $formData = $this->formInventory->filterStatementOpt($getData);
      $inventories = $this->modelInventoryDailyLog->getInventoryByConds($formData, $pg, 16, 1);

      return $inventories;
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
        $isset_item=false;
        if(($sku=Input::get("sku",false))!==false)
        {
            if(!empty($sku) && is_numeric($sku))
            {
                $condition[$i]['field'] ="item_id";
                $condition[$i]['opera']='=';
                $condition[$i]['value']=$sku;
                $isset_item=true;
                $i++;
            }
        }
         
        if(($warehouse=Input::get("warehouse",false))!==false)
        {
            if(!empty($towarehouse) && is_numeric($towarehouse))
            {
                $condition[$i]['field'] ="warehouse_id";
                $condition[$i]['opera']='=';
                $condition[$i]['value']=$warehouse;
                $i++;
            }
        }
         
        if(($status=Input::get("status",false))!==false)
        {
            $testStatus=trim($status," \t\n\r\0,");
            if(!empty($status) && $status!="undifined" && !empty($testStatus))
            {
                // $inventory_ids_status=$this->service->findMasterIdsByStatus(explode(',',$testStatus));
                $whereIn=explode(',',$testStatus);
                if(count($whereIn)<1) return array();
                $condition[$i]['field'] ="status";
                $condition[$i]['opera']='in';
                $condition[$i]['value']=$whereIn;
                $i++;

            }
        }

        if(($type=Input::get("condition",false))!==false)
        {
            $testType=trim($type," \t\n\r\0,");
            if(!empty($type) && $type!="undifined" && !empty($testType))
            {
                $whereIn=explode(',',$testType);
                if(count($whereIn)<1) return array();
                $condition[$i]['field'] ="condition";
                $condition[$i]['opera']='in';
                $condition[$i]['value']=$whereIn;
                $i++;
            }
        }
         
        if(($date=Input::get('date',false))!==false)
        {
            if(!empty($date) && $date!=='undifined')
            {
                $time=strtotime($date);
                $timeStart=(floor($time/86400))*86400;
                $timeEnd=$timeStart+86400;
                $condition[$i]['field'] ="date";
                $condition[$i]['opera']='>=';
                $condition[$i]['value']=$timeStart;
                $i++;
                $condition[$i]['field'] ="date";
                $condition[$i]['opera']='<';
                $condition[$i]['value']=$timeEnd;
                $i++;
            }
        }
        
        $listModel=$this->service->findLogsByCondition($condition)->get();
        foreach($listModel as $k => $m)
        {
            $model=$m->inventory();
            if(!empty($model))
            {
               $listModel[$k]['inventory']= $model->toArray();
            }
            else 
                $listModel[$k]['inventory']=array();
        }
        return $listModel;
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
     public function show($id)
    {
        $i=0;$condition=array();
        if(($warehouse=Input::get("warehouse",false))!==false)
        {
            if(!empty($towarehouse) && is_numeric($towarehouse))
            {
                $condition[$i]['field'] ="warehouse_id";
                $condition[$i]['opera']='=';
                $condition[$i]['value']=$warehouse;
                $i++;
            }
        }

        if(($status=Input::get("status",false))!==false)
        {
            $testStatus=trim($status," \t\n\r\0,");
            if(!empty($status) && $status!="undifined" && !empty($testStatus))
            {
                // $inventory_ids_status=$this->service->findMasterIdsByStatus(explode(',',$testStatus));
                $whereIn=explode(',',$testStatus);
                if(count($whereIn)<1) return array();
                $condition[$i]['field'] ="status";
                $condition[$i]['opera']='in';
                $condition[$i]['value']=$whereIn;
                $i++;
                 
            }
        }
         
        if(($type=Input::get("condition",false))!==false)
        {
            $testType=trim($type," \t\n\r\0,");
            if(!empty($type) && $type!="undifined" && !empty($testType))
            {
                $whereIn=explode(',',$testType);
                if(count($whereIn)<1) return array();
                $condition[$i]['field'] ="condition";
                $condition[$i]['opera']='in';
                $condition[$i]['value']=$whereIn;
                $i++;
            }
        }
        return $this->service->findLogsDetailFromItemIdByCondition($id,$condition)->get();
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
	}

}
