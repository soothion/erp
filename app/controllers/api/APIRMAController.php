<?php

use Bluebanner\Core\Warehouse\RMAServiceInterface;
use Bluebanner\Core\Model\RMAMaster;

class APIRMAController extends \BaseController {

	public function __construct(RMAServiceInterface $service) {
		$this -> service = $service;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$warehouseRMAList = $this -> service -> warehouseRMAList();
		return $warehouseRMAList -> get();

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
		$array = Input::get();
		$vendor = $this -> service -> warehouseCreate($array);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($key) {

		$output = array();
		if (is_numeric($key)) {
			$model = $this -> service -> findRMAByID($key);
			foreach ($model->details as $detail) {
				$detail -> item;
			}
			return $model;
		} else {

			$output = RMAMaster::GenerateInvoice();
			$output = array('invoice' => $output, 'status' => 'pending', 'agent' => Sentry::getUser() -> id);

		}
		return $output;
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

		$returnCode = 0;
		$returnMsg = "";
		try {
			$masterModel = array();
			$masterModel['invoice'] = Input::get("invoice");
			$masterModel['status'] = Input::get("status");

			$this -> service -> updateRMAMaster($id, $masterModel);
			$detailModels = array();
			$detailsInput = Input::get('details', array());
			if (count($detailsInput) >= 1) {
				foreach ($detailsInput as $key => $detail) {
					$detailModels[$key]['id'] = isset($detail['id']) ? intval($detail['id']) : false;
					$detailModels[$key]['item_id'] = isset($detail['item']['id']) ? intval($detail['item']['id']) : 0;
					$detailModels[$key]['qty'] = $detail['qty'];
				}
				$this -> service -> UpdateRMADetails($id, $detailModels);
			}
			if (isset($_GET['type']) && $_GET['type'] == "confirmed") {
				$this -> service -> confirmMaster($id);
			}
		} catch(Exception $e) {
			$returnCode = 1;
			$returnMsg = $e -> getMessage();
		}
		return array('return' => $returnCode, 'errorMsg' => $returnMsg);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
		$returnCode = 0;
		$returnMsg = "";
		try {
			$type = Input::get('type', 'master');
			if ($type == "master") {
				$this -> service -> deleteRMAMaster($id);
			} else {
				$this -> service -> deleteRMADetail($id);
			}
		} catch(Exception $e) {
			$returnCode = 1;
			$returnMsg = $e -> getMessage();
		}
		return array('return' => $returnCode, 'errorMsg' => $returnMsg);

	}

	public function returnPending($id) {
		$returnCode = 0;
		$returnMsg = "";
		$id = intval($id);
		try {
			$this -> service -> returnPendingByMasterId($id, Sentry::getUser() -> id);
		} catch(Exception $e) {
			$returnCode = 1;
			$returnMsg = $e -> getMessage();
		}
		return array('return' => $returnCode, 'errorMsg' => $returnMsg);

	}

	public function rmaGenerate($id) {
		$returnCode = 0;
		$returnMsg = "";
		try {
			$userid = Sentry::getUser() -> id;
			$this -> service -> generatermaMaster(intval($id), $userid);
		} catch (Exception $e) {
			$returnCode = 1;
			$returnMsg = $e -> getMessage();
		}
		return array('return' => $returnCode, 'errorMsg' => $returnMsg);
	}

	public function rmaImport() {
		$returnCode = 0;
		$returnMsg = "";
		try{
			 $masterId = Input::get('id');
		if ($_FILES["file"]["error"] > 0) {
			echo "Error: " . $_FILES["file"]["error"] . "<br />";
		}  
		$documentExcel = $_FILES["file"]["tmp_name"];
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader -> setReadDataOnly(true);
		$objPHPExcel = $objReader -> load($documentExcel);
		$objWorksheet = $objPHPExcel -> setActiveSheetIndex(0);
		$allRow = $objWorksheet->getHighestRow(); 
		 $detailModels= array();
		 $key = 0;
		for ($i = 2; $i <= $allRow; $i++) {
			$item_id = $objWorksheet -> getCellByColumnAndRow(0, $i) -> getValue();
			$qty = $objWorksheet -> getCellByColumnAndRow(1, $i) -> getValue();
			$detailModels[$key]['item_id'] = $item_id;
			$detailModels[$key]['qty'] = $qty;
			$key++;
			}
			$this -> service -> createRMADetails($masterId, $detailModels);
			
		} catch (Exception $e) {
			$returnCode = 1;
			$returnMsg = $e -> getMessage();
		}{
			return array('return' => $returnCode, 'errorMsg' => $returnMsg); 
		} 
		}
        
	

}
