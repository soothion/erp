<?php

use Bluebanner\Core\Item\ItemServiceInterface;
use Bluebanner\Core\Purchase\AuditInterface;
use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\PurchaseCostParams;
use Bluebanner\Core\Model\Audit;
use Bluebanner\Core\Purchase\RequestService;

class APIAuditController extends \BaseController {

	public function __construct(ItemServiceInterface $itemService, AuditInterface $auditService,RequestService $request) {
		$this -> itemService = $itemService;
		$this -> auditService = $auditService;
		$this -> requestService = $request;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return PurchaseRequest::whereIn('status', array('verified', 'confirmed', 'rejected')) -> get();
	}

	public function pr() {
		return PurchaseRequest::confirmed() -> get();
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
	public function store() {

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
	
		$model = PurchaseRequest::with('details.item.cost', 'details.account', 'details.platform') -> find($id);
		foreach ($model->details as $detail) {

			$detail['item']['fee'] = PurchaseCostParams::getFeeByItemAndWarehose($detail -> item -> id, $model -> warehouse_id);
		}

		return $model;
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
	public function update($id) {
		
		switch (Input::get('action')) {
			case 'approve' :
				$this -> requestService -> approve($id, Sentry::getUser() -> id, Input::get('note'));
			break;
			case 'reject':
			    $this -> requestService -> reject($id, Sentry::getUser() -> id, Input::get('note'));
			 break;
			default :
				throw new Exception('Illegal Action!');
		}
		return array();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

	public function batchUpdate() {
		$returnCode = 'successful';
		$returnMsg = "";
		$value = Input::get();
		if (isset($value)) {
			try {
				$model = PurchaseRequest::find($value['index']);
				$model -> status = $value['action'];
				$model -> check_note = $value['check_note'];
				$model -> check_user = Sentry::getUser() -> id;
				$model -> update();
				$detailModel = PurchaseRequestDetail::where('request_id', '=', $value['index']) -> get();

				// 因主表和明细的表的状态枚举类型不同而造成的
				if ($value['action'] == 'verified') {
					$status = "approved";
				} elseif ($value['action'] == 'rejected') {
					$status = 'rejected';
				}
				//这里把申购单明细一次性拒绝或通;
				foreach ($detailModel as $key => $detailsModel) {

					$detailsModel -> status = $status;

					$detailsModel -> update();
				}
				//创建记录日志
                if($value['action']=='verified'){
                	$action=true;
				}else{
					$action=false;
				}
				Audit::create(array('type_id' =>$value['index'], 'type_type' => 'PurchaseRequest', 'agent' =>Sentry::getUser() -> id , 'assessment' => $action, 'note' => $value['check_note']));
		
			} catch(Exception $e) {
				$returnCode = 'error';
				$returnMsg = $e -> getMessage();

			}
			return array('returnData' => $returnCode, 'errorMsg' => $returnMsg);
		}

	}

}
