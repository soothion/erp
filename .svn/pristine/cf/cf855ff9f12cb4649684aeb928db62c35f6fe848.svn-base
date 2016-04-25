<?php
use Bluebanner\Core\Warehouse\StockIOService;
use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Warehouse\IOStatus;
use Bluebanner\Core\Warehouse\StockIOServiceInterface;
use Illuminate\Support\Facades\Input;

use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\PurchaseOrder;
use Bluebanner\Core\Model\PurchaseOrderDetail;
use Bluebanner\Core\Model\PurchaseReturnDetail;
use Bluebanner\Core\Model\PurchaseReturn;

class APIIOListController extends \BaseController {

	public function __construct(StockIOService $stockIOService, StockIOMaster $modelStockIOMaster, WarehouseForm $formWarehouse) {
		$this -> service = $stockIOService;

    $this->modelStockIOMaster = $modelStockIOMaster;
    $this->formWarehouse = $formWarehouse;
	}

  public function lists() {
    $pg = Input::get('pg', 1);
    $getData = Input::get();

    $formData = $this->formWarehouse->filterIOListOpt($getData);
    $orders = $this->modelStockIOMaster->getIOLists($formData, $pg);

    return $orders;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$list = array();
		$types = IOType::getIOType();
		$status = IOStatus::getStatus();
		$condition = array();
		$i = 0;
		if (Input::get('type') == "out") {
			$condition[$i]['field'] = 'type';
			$condition[$i]['condition'] = '<';
			$condition[$i]['value'] = 0;
			$i++;
		} elseif (Input::get('type') == "in") {

			$condition[$i]['field'] = 'type';
			$condition[$i]['condition'] = '>';
			$condition[$i]['value'] = 0;
			$i++;
		}

		if (($invoice = Input::get("invoice", false)) !== false) {
			if (!empty($invoice) && $invoice != "undifined") {
				$condition[$i]['field'] = "invoice";
				$condition[$i]['condition'] = 'like';
				$condition[$i]['value'] = '%' . $invoice . '%';
				$i++;
			}
		}

		if (($relation_invoice = Input::get("relation_invoice", false)) !== false) {
			if (!empty($relation_invoice) && $relation_invoice != "undifined") {
				$condition[$i]['field'] = "relation_invoice";
				$condition[$i]['condition'] = 'like';
				$condition[$i]['value'] = '%' . $invoice . '%';
				$i++;
			}
		}

		if (($sku = Input::get("item_id", false)) !== false) {
			if (!empty($sku) && is_numeric($sku)) {
				$ids = $this -> service -> getMasterIdFromDetailByItemId($sku);
				if (!empty($ids) && $ids !== array() && count($ids) !== 0) {
					$condition[$i]['field'] = "id";
					$condition[$i]['condition'] = 'in';
					$condition[$i]['value'] = $ids;
					$i++;
				} else {
					$condition[$i]['field'] = 'id';
					$condition[$i]['condition'] = '=';
					$condition[$i]['value'] = 0;
					$i++;
				}
			}
		}
		if (($warehouse = Input::get("warehouse", false)) !== false) {
			if (!empty($warehouse) && is_numeric($warehouse)) {
				$condition[$i]['field'] = "warehouse_id";
				$condition[$i]['condition'] = '=';
				$condition[$i]['value'] = $warehouse;
				$i++;
			}
		}

		if (($leibie = Input::get("leibie", false)) !== false) {
			if (!empty($leibie) && is_numeric($leibie)) {
				$condition[$i]['field'] = "type";
				$condition[$i]['condition'] = '=';
				$condition[$i]['value'] = $leibie;
				$i++;
			}
		}
		if (($inputstatus = Input::get("status", false)) !== false) {

			if (!empty($inputstatus) && $inputstatus != "undifined") {
				$statusIds = array();
				$inputStatusArray = explode(',', $inputstatus);
				foreach ($inputStatusArray as $s) {
					if ($s == "Stocked")
						$statusIds[] = 1;
					if ($s == "Not_Stock")
						$statusIds[] = 0;
					if ($s == "Booked")
						$statusIds[] = 2;
				}

				if ($statusIds !== array() && !empty($statusIds) && count($statusIds) > 0) {
					$condition[$i]['field'] = "status";
					$condition[$i]['condition'] = 'in';
					$condition[$i]['value'] = $statusIds;
					unset($statusIds, $inputStatusArray);
					$i++;
				} else {
					$condition[$i]['field'] = 'status';
					$condition[$i]['opera'] = '=';
					$condition[$i]['value'] = '0';
					$i++;
				}
			}
		}
		if (($timeFrom = Input::get("created_at_from", false)) !== false) {
			if (!empty($timeFrom) && $timeFrom != "undefined") {
				$condition[$i]['field'] = "created_at";
				$condition[$i]['condition'] = '>=';
				$condition[$i]['value'] = date("Y-m-d H:i:s", strtotime($timeFrom));
				$i++;
			}
		}

		if (($timeTo = Input::get("created_at_to", false)) !== false) {
			if (!empty($timeTo) && $timeTo != "undefined") {
				$condition[$i]['field'] = "created_at";
				$condition[$i]['condition'] = '<=';
				$condition[$i]['value'] = date("Y-m-d H:i:s", strtotime($timeTo));
				$i++;
			}
		}

		if (($timeFrom = Input::get("exec_at_from", false)) !== false) {
			if (!empty($timeFrom) && $timeFrom != "undefined") {

				$condition[$i]['field'] = "exec_at";
				$condition[$i]['condition'] = '>=';
				$condition[$i]['value'] = date("Y-m-d H:i:s", strtotime($timeFrom));
				$i++;
			}
		}

		if (($timeTo = Input::get("exec_at_to", false)) !== false) {
			if (!empty($timeTo) && $timeTo != "undefined") {
				$condition[$i]['field'] = "exec_at";
				$condition[$i]['condition'] = '<=';
				$condition[$i]['value'] = date("Y-m-d H:i:s", strtotime($timeTo));
				$i++;
			}
		}

		$list = $this -> service -> StockFindByCondition($condition) -> get();
		foreach ($list as $stock) {
			$stock -> warehouse;
			$stock -> createUser;
			$stock -> execUser;
		}

		return $list;
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
		// callCreateMethod();
		return array('return' => 0);
	}

	/**
	 * Display the specified resource.
	 * @todo fix the fake data
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($key) {

		$output = array();
		if (is_numeric($key)) {
			$returnModel = $this -> service -> stockFindByID(intval($key));
			$types = IOType::getIOType();
			$returnModel -> type = $types[strval($returnModel -> type)];
			foreach ($returnModel->details as $key => $detail) {
				$returnModel -> details[$key]['sku'] = $detail -> item -> sku;
			}

			//特殊情况的检查
			if (Input::get('type') == "ShipmentIn" && Input::get('relation_id')) {
				if ($returnModel -> type == "ShipmentIn" && $returnModel -> relation_id == Input::get('relation_id')) {
					$model = $this -> service -> stockFindByCondition(array( array('field' => 'relation_id', 'value' => Input::get('relation_id')), array('field' => 'type', 'value' => IOType::SHIPMENT_OUT), array('field' => 'status', 'value' => IOStatus::NOT_STOCK)));
					$data = $model -> get();
					if (count($data) < 1) {
						return array('err' => true, 'msg' => '出库单不存在!');
					} else {
						return array('err' => false, 'msg' => '出库状态正常!');
					}
				} else
					return array();
			} else
				return $returnModel;
		} else {
			switch ($key) {

				case 'stateList' :
					$output = array_build($this -> service -> itemStatusList(), function($key, $val) {
						return array($key, array('data' => $val));
					});
					break;

				case 'warehouseList' :
					// $output = array(array('id' => 1, 'name' => 'US-CA'));
					$output = array_build(Bluebanner\Core\Model\Warehouse::all(), function($key, $val) {
						return array($key, array('id' => $val['id'], 'name' => $val['name']));
					});
					break;

				case 'requestStatus' :
					$output = array( array('id' => 0, 'name' => 'pending'), array('id' => 1, 'name' => 'confirmed'), array('id' => 2, 'name' => 'purchasing'), array('id' => 3, 'name' => 'completely purchased'), array('id' => 4, 'name' => 'shipping'), array('id' => 5, 'name' => 'completely shipped'), array('id' => 6, 'name' => 'completed'), array('id' => 7, 'name' => 'cancelled'));
					break;
				case 'requestTypes' :
					$output = array( array('id' => 0, 'name' => 'Order Direct'), array('id' => 1, 'name' => 'Order'), array('id' => 2, 'name' => 'Shipment'), array('id' => 3, 'name' => 'Local'));
					break;

				case 'chanelList' :
					$output = Bluebanner\Core\Model\Account::all();
					break;

				case 'transportList' :
					$output = array( array('name' => 'surface'), array('name' => 'air'), array('name' => 'sea'), array('name' => 'N/A'));
					break;

				case 'taxList' :
					$output = array( array('id' => '0', 'name' => 'N'), array('id' => '1', 'name' => 'Y'));
					break;
				case 'typeList' :
					$i = 0;
					$output = array_build(IOType::getIOType(), function($key, $val) use (&$i) {
						return array($i++, array('id' => $key, 'name' => $val));
					});
					break;
				case 'statusList' :
					$i = 0;
					$output = array_build(IOStatus::getStatus(), function($key, $val) use (&$i) {
						return array($i++, array('id' => $key, 'name' => $val));
					});
					break;
				default :
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
	public function edit($id) {
		//return array('return'=>0);
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

			//book
			if (Input::get("type") == "book") {
				$this -> service -> bookInventoryByStock($id);
			}
			//unbook
			elseif (Input::get("type") == "unbook") {
				$this -> service -> unbookInventoryByStock($id);
			}
			//拆分入库单
			elseif (Input::get("type") == "chai-in") {
				$details = Input::get("data");
				$items = array();
				foreach ($details as $k => $v) {
					$qty = isset($v['newqty']) ? intval($v['newqty']) : 0;
					if ($qty == 0)
						continue;
					$items[$v['id']] = array('item_id' => $v['item_id'], 'qty' => $qty, 'relation_did' => $v['relation_did'], 'backup_qty' => 0, //备用数量先不考虑
					);
				}
				$this -> service -> splitStockIn($id, Sentry::getUser() -> id, $items);
			}
			//拆分出库单
			elseif (Input::get("type") == "chai-out") {
				$details = Input::get("data");
				$items = array();
				foreach ($details as $k => $v) {
					$qty = isset($v['newqty']) ? intval($v['newqty']) : 0;
					if ($qty == 0)
						continue;
					$items[$v['id']] = array('item_id' => $v['item_id'], 'qty' => $qty, 'relation_did' => $v['relation_did'], 'backup_qty' => 0, //备用数量先不考虑
					);
				}
				$this -> service -> splitStockOut($id, Sentry::getUser() -> id, $items);
			}
			//入库
			elseif (Input::get("type") == "in") {
				$this -> service -> stockIn($id, Sentry::getUser() -> id);
			}
			//反入库
			elseif (Input::get("type") == "unin") {
				$this -> service -> reverseIn($id, Sentry::getUser() -> id);
			}
			//出库
			elseif (Input::get("type") == "out") {
				$this -> service -> stockOut($id, Sentry::getUser() -> id);
			} elseif (Input::get("type") == "unout") {
				$status = Input::get("toStatus");
				if ($status == "book") {
					$status = IOStatus::BOOKED;
				} else {
					$status = IOStatus::NOT_STOCK;
				}
				$this -> service -> reverseOut($id, Sentry::getUser() -> id, $status);
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

	}

	/**
	 *
	 * print the page for
	 *
	 * @parm int $id
	 *
	 * @return Response
	 */
	public function showPrint($key) {
		$returnModel = $this -> service -> stockFindByID(intval($key));
		$purchaseOrderModel = PurchaseOrder::find($returnModel -> relation_id);
		$returnModel -> vendor_id = $purchaseOrderModel -> vendor_id;
		$types = IOType::getIOType();
		$returnModel -> type = $types[strval($returnModel -> type)];
		foreach ($returnModel->details as $key => $detail) {
			$returnModel -> details[$key]['sku'] = $detail -> item -> sku;
			$returnModel -> qty += $detail -> qty;
		}
		return $returnModel;

	}

	public function batchPurchasePrint($id) {//采购单及退货单所有的记录

		$returnData = array();
		$id = Input::get('type');
		$returnArray = array();
		try {
			if ($id) {
				$purchaseArr = PurchaseOrder::where('vendor_id', '=', $id) -> lists("id");
				$returnData = StockIOMaster::with('details') -> whereIn('relation_id', $purchaseArr) -> where('type', IOType::PURCHASING) -> where('status', '=', 1) -> orWhere(function($query) {
					$id = Input::get('type');
					if ($id) {
						$purchaseReturnArr = PurchaseReturn::where('vendor_id', '=', $id) -> lists("id");
						if (count($purchaseReturnArr) > 0) {

							$query -> whereIn('relation_id', $purchaseReturnArr) -> where('type', IOType::PURCHASING_RETUEN_VENDOR) -> where('status', '=', 1);
						}
					}
				}) -> orderBy('exec_at', 'asc') -> get();
				$n = 0;
				foreach ($returnData as $key => $value) {
					foreach ($returnData[$key]->details as $key2 => $value2) {
						$returnArray[$n] = $value2;
						$returnArray[$n]['sku'] = $value2 -> item -> description;
						$n++;
					}
				}
				return $returnData;
			}

		} catch(Exception $e) {
                  	$returnCode = 1;
			        $returnMsg = $e -> getMessage();
		};
       return array('return' => $returnCode, 'errorMsg' => $returnMsg);
	}

}
