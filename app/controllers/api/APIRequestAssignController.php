<?php
use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Bluebanner\Core\PurchasePlanExecException;


class APIRequestAssignController extends \BaseController {
 	
 	var $pur_warehouse;

	public function __construct(PurchaseServiceInterface $service)
	{
		$this->service = $service;
		$this->pur_warehouse = 7;//调度默认的发出仓库为buffer［在采购计划中也就是采购入库仓］－－稍后可考虑在计划中添加
	}
	
	/**
	 * 只显示已经是confirmed状态，并且只是明细的
	 * @return Response
	 */
	public function index()
	{
	  
	    
	    $list = array();
	    $r =   $this->service->requestDetailListOfVerified()->get();
	
	    if(count($r) >0){
	        foreach ($r as $detail) {
	            $detail->request->warehouse;
	            $detail->plan;
	            $detail->item;
	            $detail->account;
	            $detail->request->user;
	            $detail->plandetail;
	            $detail->childs();
	            $dArr = $detail->toArray();
	            $dArr['childs'] = $detail->childs();
	            $list[] = $dArr;
	        }
	    }
	    return $list;
	  
// 		$parentArr = array();
		
// 		$item_id = Input::get("item_id") ? Input::get("item_id") : '';
// 		//$parentArr = $this->service->requestParent();
		
// 		//这里  中文有时候会出问题 (DateTime 构造问题) 我改了下  

// // 		$request_filter =array(
// // 			array('f' => 'created_at', 'o' => 'between','v' => array(with(new DateTime(Input::get('from_date')))->format('Y-m-d'), with(new DateTime(Input::get('to_date')))->format('Y-m-d'))),
// // 			array('f' => 'status',     'o' => '=',		'v' => Input::get('status')),
// // 			array('f' => 'type',	   'o' => '=',		'v' => (Input::get('req_type',false) !=false) ? Input::get('req_type') : ''),
// // 			array('f' => 'warehouse_id', 	'o' => '=',	'v' => (Input::get('req_wh_id',false) !=false) ? Input::get('req_wh_id') : '')
// // 		);
// 		$startTime=date("Y-m-d",strtotime(Input::get('from_date')));
// 		$endTime=date("Y-m-d",strtotime(Input::get('to_date')));
// 		$request_filter =array(
// 		        array('f' => 'created_at', 'o' => 'between','v' => array($startTime, $endTime)),
// 		        array('f' => 'status',     'o' => '=',		'v' => Input::get('status')),
// 		        array('f' => 'type',	   'o' => '=',		'v' => (Input::get('req_type',false) !=false) ? Input::get('req_type') : ''),
// 		        array('f' => 'warehouse_id', 	'o' => '=',	'v' => (Input::get('req_wh_id',false) !=false) ? Input::get('req_wh_id') : '')
// 		);
	
// 		$detail_filter = array(
// 			array('f' => 'item_id',		   'o' => '=',		'v' => $item_id ? $item_id : ''),
// 			array('f' => 'account_id',	   'o' => '=',		'v' => (Input::get('account',false) !=false) ? Input::get('account') : ''),
// 			array('f' => 'parent_id',	   'o' => '=',		'v' => 0),
// 			array('f' => 'transportation', 'o' => '=',		'v' => (Input::get('transportation',false) !=false) ? Input::get('transportation') : '')
// 		);
		
// 		$list = array();
// 		$r = $this->service->requestDetailList(array_filter($request_filter),array_filter($detail_filter))->get();
// 		if(count($r) >0){
// 			foreach ($r as $detail) {
// 				$detail->request->warehouse;
// 				$detail->plan;
// 				$detail->item;
// 				$detail->account;
// 				$detail->request->user;
// 				$detail->plandetail;
// 				$detail->childs();
// 				$dArr = $detail->toArray();
// 				$dArr['childs'] = $detail->childs();
// 				$list[] = $dArr;
// 			}
// 		}
// 		return $list;
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
	    
// 		switch(Input::get('type')){
// 			case 'add':
// 				return $this->service->requestAssignAction(Input::get('plan_id'),Input::get('invoice'),Input::get('request_ids'),Sentry::getUser()->id,$this->pur_warehouse);
// 				break;
// 			case 'reject':
// 				return $this->service->requestAssignReject(Input::get('plan_id'),Input::get('request_ids'));
// 				break;
// 			default:	
// 			break;
// 		}
        $plan_id=intval(Input::get('plan_id'));
        $requestIds=Input::get('requestIds');
        if(!is_array($requestIds))
        {
            throw new Exception("invaild arguments of request id!");
        }
        $this->service->requestToPlanDetail($plan_id,$requestIds);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
	 * @param  int  $plan_id
	 * @param  string $request_ids
	 * @return Response $plan_id,$request_ids =''
	 */
	public function update()
	{
		
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
	
	/**
	 * 分配到计划表的项取消
	 */
	public function revertAssign()
	{
	    $ids=Input::get("detailId");
	    if(is_numeric($ids))
	    {
	        $ids=array(intval($ids));
	    }
	    
	    if(is_array($ids))
	    {
	        $this->service->revertAssignedPlanDetail($ids);
	    }
	    else 
	        throw new Exception("非法的参数!");
	}

}