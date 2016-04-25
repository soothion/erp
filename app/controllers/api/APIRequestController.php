<?php

use Bluebanner\Core\Purchase\RequestServiceInterface;
use Bluebanner\Core\Item\RequestService;
use Bluebanner\Core\Model\RequestQueue;
use Bluebanner\Core\Model\RequestQueueError;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\PurchaseCostParams;
//use Bluebanner\Core\CoreService;

use Bluebanner\Core\Model\PurchaseRequest;

class APIRequestController extends \BaseController {

	public function __construct(RequestServiceInterface $service, PurchaseRequest $modelPurchaseRequest, RequestForm $formRequest) {
		$this -> service = $service;

    $this->modelPurchaseRequest = $modelPurchaseRequest;

    $this->formRequest = $formRequest;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
	   
 		$condition = array();

		if (($invoice = Input::get("invoice", false)) !== false) 
		{
			if (!empty($invoice) && $invoice != "undifined") 
			{
				$condition['invoice'] = array("like", '%' .$invoice. '%');
			}
		}

		if (($relation_id = Input::get("relation_id", false)) !== false) 
		{
			if (!empty($relation_id) && $relation_id != "undifined") 
			{
				$condition['relation_id'] = array("like",'%' . $relation_id . '%');
			}
		}

		if (($sku = Input::get("sku", false)) !== false) {
			if (!empty($sku) && is_numeric($sku)) {
				$ids = $this -> service -> getMasterIdFromDetailByItemId($sku);
				if (!empty($ids) && $ids !== array() && count($ids) !== 0) {
					$condition['id'] = array("in",$ids);
				} else {
					$condition['id'] = 0;
				}
			}
		}

		if (($skuLike = Input::get("skuLike", false)) !== false) 
		{
			if (!empty($skuLike)) 
			{
				$ids = $this -> service -> getMasterIdFromDetailByItemSku($skuLike);

				if (!empty($ids) && $ids !== array() && count($ids) !== 0) 
				{
					$condition['id'] = array("in",$ids);
				} else 
				{
					$condition['id'] = 0;
				}
			}
		}

		if (($fromwarehouse = Input::get("warehouse", false)) !== false) 
		{
			if (!empty($fromwarehouse) && is_numeric($fromwarehouse)) 
			{
				$condition['warehouse_id'] = $fromwarehouse;
			}
		}

		if (($status = Input::get("status", false)) !== false) 
		{
			if (!empty($status) && $status != "undifined") 
			{
				$condition['status'] = $status;
			}
		}

		if (($type = Input::get("type", false)) !== false)
		{

			if (!empty($type) && $type != "undifined") 
			{
				$condition['type'] = $type;
			}
		}

// 		$list = array();
// 		$listModel = $this -> service -> findByCondition($condition) -> get();
// 		foreach ($listModel as $request) {
// 			$request -> warehouse;
// 			$array = $request -> toArray();
// 			$array['agent'] = $request -> user -> email;
// 			$list[] = $array;
// 		}
        
		//页数
		$currentPage=1;
		//每页显示个数
		$pageSize=30;
		//return $this -> service->lists($condition,array('id', 'agent', 'agent_name', 'warehouse_id', 'warehouse_name', 'invoice', 'status',  'type', 'note', 'check_note','relation_id','created_at','updated_at','expired_time'),$currentPage,$pageSize);
		
		return $this -> service->lists($condition,array('id', 'agent', 'platform_id', 'agent_name', 'warehouse_id', 'warehouse_name', 'invoice', 'status',  'type', 'note', 'verified_note','relation_id','created_at','updated_at','expired_at'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() 
	{
	     //新建的申购单  默认的审核人为自己
	     $request = array('platform_id' => Input::get('platform', 0), 'agent' => Sentry::getUser() -> id,'verified_agent'=> Sentry::getUser() -> id, 'relation_id' => Input::get('relation_id'), 'warehouse_id' => Input::get('warehouse_id'), 'invoice' => Input::get('invoice'), 'status' => 'pending', 'note' => Input::get('note'), 'type' => Input::get('type'),'expired_at'=>Input::get('expired_at'));
	     return $this->service->createMaster($request);  
	    ///老方法
// 		$wh = Input::get('warehouse_id');
// 		$request = array('agent' => Sentry::getUser() -> id, 'relation_id' => Input::get('relation_id'), 'warehouse_id' => Input::get('warehouse_id'), 'invoice' => Input::get('invoice'), 'status' => 'pending', 'note' => Input::get('note'), 'type' => Input::get('type'),'expired_time'=>Input::get('expired_time'));

// 		$details = array();

// 		if (is_array(Input::get('details'))) {
// 			foreach (Input::get('details') as $key => $detail) {
// 				$details[] = array(
// 				// 'request_id' => $r->id,
// 				'platform_id' => $detail['platform']['id'], 'item_id' => $detail['item']['id'], 'qty' => $detail['qty'], 'end_date' => $detail['end_date'], 'transportation' => $detail['transportation'], 'note' => isset($detail['note']) ? $detail['note'] : '', );

// 			}
// 		}

// 		$r = $this -> service -> requestCreate($request, $details);

// 		return array('id' => $r -> id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) 
    {
	    if ($id == "new")
	        	return array('invoice' => $this -> service -> GenerateInvoice(Input::get('platform', 0)));
	    else 
	    	return PurchaseRequest::with('user')->find($id);
      // return  $this -> service -> getDetails($id);
	    
	    ////////////////////老方法
// 		if ($id == "new")
// 			return array('status' => 'pending', 'invoice' => $this -> service -> getNextInvoice(), 'type' => 'Shipment', 'relation_id' => '0');
// 		$request = $this -> service -> requestFind($id);
// 		$request -> warehouse;
// 		$request -> user;

// 		//如果订单是被拒绝状态 临时改为pending,修改后才允许真正改为pending 以及后续操作
//         // 		if($request->status=="rejected")
//         // 		{
//         // 		    $request->status="pending";
//         // 		}

// 		foreach ($request->details as $detail) {
// 			$detail -> item -> spq;
// 			$detail->platform;
// 			$detail -> channel;
// 			$detail['item']['fee']=PurchaseCostParams::getFeeByItemAndWarehose($detail -> item ->id, $request -> warehouse->id);
// 		}
	
// 		return $request;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
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

		$request = $this -> service -> requestFind($id);
		$wh = Input::get('warehouse_id');
		
		//订单状态允许的操作
		if($request->status!="pending")
		{
		    if(Input::get('status')=="confirmed")
		    {
		        $request -> update(array( 'status' => Input::get('status')));
		        return "";
		    }
		    else if($request->status=="confirmed" && Input::get('status')=="pending")
		    {
		        $request -> update(array( 'status' => Input::get('status')));
		        return "";
		    }
		}
		
    $this->service->updateMaster($id,array('relation_id' => Input::get('relation_id'), 'invoice' => Input::get('invoice'), 'warehouse_id' => $wh, 'status' => Input::get('status'), 'note' => Input::get('note'), 'type' => Input::get('type'),'expired_at'=>Input::get('expired_at')));
		
		if(Input::get('status')=="confirmed"&&$request->status=="pending")
		{
		    $this->service->confirm($id,Sentry::getUser()->id);
		}
		else if(Input::get('status')=="pending"&&$request->status=="confirmed")
		{
		    $this->service->unconfirm($id,Sentry::getUser()->id);
		}
		
         
		return "";
		//老方法
		
// 		$request -> update(array('relation_id' => Input::get('relation_id'), 'invoice' => Input::get('invoice'), 'warehouse_id' => $wh, 'status' => Input::get('status'), 'note' => Input::get('note'), 'type' => Input::get('type'),'expired_time'=>Input::get('expired_time')));

           
// 		$deleteIdList = array();
// 		$addDetailList = array();
// 		$input_details = Input::get('details');
// 		foreach ($request->details as $detail) {
// 			if (($index = self::getKeyIndex($detail -> id, $input_details)) !== false) {
// 			    $isChanged=false;
//                 if(isset($input_details[$index]['platform']['id'])  &&  $detail -> platform_id !=$input_details[$index]['platform']['id'] )
//                 {
//                     $isChanged==true;
// 				    $detail -> platform_id = $input_details[$index]['platform']['id'];
//                 }
//                 if(isset($input_details[$index]['item']['id'])  &&  $detail -> item_id !=$input_details[$index]['item']['id'] )
//                 {
//                     $isChanged==true;
//                     $detail -> item_id = $input_details[$index]['item']['id'];
//                 }
                
//                 if(isset($input_details[$index]['qty'])  &&  $detail -> qty !=$input_details[$index]['qty'] )
//                 {
//                     $isChanged==true;
//                    $detail -> qty = $input_details[$index]['qty'];
//                 }
				
//                 if(isset( $input_details[$index]['end_date'])  &&  $detail -> end_date !=$input_details[$index]['end_date'] )
//                 {
//                     $isChanged==true;
//                     $detail -> end_date =  $input_details[$index]['end_date'];
//                 }
                
//                 if(isset( $input_details[$index]['transportation'])  &&  $detail -> transportation !=$input_details[$index]['transportation'])
//                 {
//                     $isChanged==true;
//                     $detail -> transportation =  $input_details[$index]['transportation'];
//                 }
                
//                 if(isset( $input_details[$index]['note']) &&  $detail -> note !=$input_details[$index]['note'])
//                 {
//                     $isChanged==true;
//                     $detail -> note =  $input_details[$index]['note'];
//                 }
//                 if($isChanged)	
//                 {	
// 				    $detail -> save();
//                 }
// 			} else {
// 				$deleteIdList[] = $detail -> id;
// 			}
// 		}

// 		$i = 0;
// 		foreach ($input_details as $detail) {
// 			if (!isset($detail['id'])) {
// 				$addDetailList[$i]['platform_id'] = $detail['platform']['id'];
// 				$addDetailList[$i]['item_id'] = $detail['item']['id'];
// 				$addDetailList[$i]['qty'] = $detail['qty'];
// 				$addDetailList[$i]['transportation'] = $detail['transportation'];
// 				$addDetailList[$i]['end_date'] = date("Y-m-d H:i:s", strtotime($detail['end_date']));
// 				$addDetailList[$i]['note'] = isset($detail['note']) ? $detail['note'] : '';
// 				$i++;
// 			}
// 		}
// 		$this -> service -> addRequestDetail($request -> id, $addDetailList);
// 		$this -> service -> removeRequestDetail($request -> id, $deleteIdList);
// 		return "";
		// details update
		//		$input_details = array_build(Input::get('details'), function($k, $v) {return array(array_key_exists('id', $v) ? $v['id'] : -1, $v);});

		// 		foreach ($request->details as $detail) {
		// 			if (array_key_exists($detail->id, $input_details)) {
		// 				$detail->update(array(
		// 					'platform_id' => $input_details[$detail->id]['account']['id'],
		// 					'item_id' => $input_details[$detail->id]['item']['id'],
		// 					'qty' => $input_details[$detail->id]['qty'],
		// 					'end_date' => $input_details[$detail->id]['end_date'],
		// 					'transportation' => $input_details[$detail->id]['transportation'],
		// 					'note' => $input_details[$detail->id]['note'],
		// 				));
		// 			} else {
		// 				$detail->delete();
		// 			}

		// 			unset($input_details[$detail->id]);
		// 		}
		// 		// new details
		// 		foreach ($input_details as $detail) {
		// 			$this->service->requestDetailCreate(array(
		// 				'request_id' => $request->id,
		// 				//'warehouse_id' => $detail['warehouse']['id'],
		// 				'platform_id' => $detail['account']['id'],
		// 				'item_id' => $detail['item']['id'],
		// 				'qty' => $detail['qty'],
		// 				'end_date' => $detail['end_date'],
		// 				'transportation' => $detail['transportation'],
		// 				'note' => $detail['note'],
		// 			));
		// 		}

		// 		$input_details=Input::get('details');
		//         foreach ($request->details as $detail) {
		// 				$detail->delete();
		// 		}

		// 		foreach ($input_details as $detail) {
		// 			$this->service->requestDetailCreate(array(
		// 				'request_id' => $request->id,
		// 				'platform_id' => $detail['account']['id'],
		// 				'item_id' => $detail['item']['id'],
		// 				'qty' => $detail['qty'],
		// 				'end_date' => $detail['end_date'],
		// 				'transportation' => $detail['transportation'],
		// 				'note' => isset($detail['note'])?$detail['note']:"",
		// 			));
		// 		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		if (is_numeric($id)) {
			$id = intval($id);
			$this -> service -> requestRemove($id);
		}
	}

	private static function getKeyIndex($key, $info) {
		foreach ($info as $k => $in) {
			if (isset($in['id']) && $in['id'] == $key)
				return $k;
		}
		return false;
	}

    public function requestImport($id){
        
        $request_id=$id;
    	$file = Input::file('file');
		$path = storage_path() . '/upload/queues/uploadRequest/' . Sentry::getUser()->id . '/' . date('Ymdhis');
		$file->move($path, $file->getClientOriginalName());

		$service = new RequestService();
		$service->setUploadFilePath($path . '/' . $file->getClientOriginalName());
		$filefullPath=$path . '/' . $file->getClientOriginalName();
		//文件格式检验
		try {

			$service->validate();

		} catch (Exception $e) {

			return $e->getMessage();

		}
		$data = \Excel::excel2Array($filefullPath);
		$rows = array_splice($data[0], 2);
		$error_info='';
		$successCount=$errorCount=0;
		$this->service->importRequestDetailByExcelRows($rows,$request_id,$error_info,$successCount,$errorCount);
        
		if(empty($error_info)||$errorCount<=0)
		{
		    echo  "文件全部导入成功\n成功添加".$successCount."条记录!\n 点击刷新查看! ";
		}
		else 
		{
		    echo "文件导入成功\n成功添加".$successCount."条 记录!\n失败".$errorCount."条记录\n 失败原因:".$error_info." \n点击刷新查看!";
		}
    }
	public function uploadRequest(){
		  
		  return RequestQueue::with('errors') -> orderBy('created_at', 'desc') -> limit(Input::get('limit')) -> offset(Input::get('offset')) -> get();
		  
	}
	
	public function template()
	{
		return Response::download(storage_path() . '/templates/request.upload.template.xlsx');
	}


  public function confirm($id) {
    $request = $this->formRequest->validateRequestStatus($id);
    $this->modelPurchaseRequest->where('id', $id)->update($request);
  }

  public function unconfirmRequest($id) {
    $request = $this->formRequest->validateRequestStatus($id, 'pending');
    $this->modelPurchaseRequest->where('id', $id)->update($request);
  }

  public function confirmRequest($id) {
    $request = $this->formRequest->validateRequestStatus($id, 'confirmed');
    $this->modelPurchaseRequest->where('id', $id)->update($request);
  }

}
