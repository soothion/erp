<?php
namespace Bluebanner\Core\Warehouse;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\RMAMaster;
use Bluebanner\Core\Model\RMADetail;
use Bluebanner\Core\Warehouse\StockIOService;

class RMAService implements RMAServiceInterface {

	public function warehouseRMAList() {
		return RMAMaster::where('id', '>', 0);
	}

	public function warehouseFind($id) {
		return RMAMaster::find($id);
	}

	public function warehouseCreate($warehouseNew) {
		return RMAMaster::create($warehouseNew);
	}

	public function findRMAById($id) {
		return RMAMaster::with('details') -> find(intval($id));
	}

	public function deleteRMAMaster($id) {
		RMAMaster::find($id) -> delete();
	}

	public function deleteRMADetail($id) {
		RMADetail::find($id) -> delete();
	}

	public function updateRMAMaster($masterid, $masterinfo) {
		if (isset($masterinfo['status']))
			unset($masterinfo['status']);
		$master = RMAMaster::find($masterid);
		foreach ($masterinfo as $k => $v) {
			$master -> $k = $v;
		}
		$master -> save();
		return $master -> id;
	}

	public function UpdateRMADetails($masterId, $detailInfos) {
		foreach ($detailInfos as $detailInfo) {
			if (!isset($detailInfo['id'])) {
				throw new \Exception("update details you master set the detail id (false for empty)");
			}
			if ($detailInfo['id'] != false) {
				$this -> updateRMADetail($detailInfo['id'], $detailInfo);
				unset($detailInfo['id']);
			} else {
				unset($detailInfo['id']);
				$this -> createRMADetail($masterId, $detailInfo);
			}
		}
	}

	public function updateRMADetail($detailId, $detailInfo) {
		$detail = RMADetail::find($detailId);
		if ($detail != null) {
			foreach ($detailInfo as $k => $v) {
				$detail -> $k = $v;
			}
			$detail -> save();
		}

	}

	public function createRMADetails($masterid, array $details) {
		foreach ($details as $d) {
			$this -> createRMADetail($masterid, $d);
		}
	}

	public function createRMADetail($masterid, array $detail) {
		$detail['rma_id'] = intval($masterid);
		$d = RMADetail::create($detail);
		return $d -> id;
	}

	public function confirmMaster($masterid) {
		$master = RMAMaster::find($masterid);
		$master -> status = "confirmed";
		$master -> save();
	}

	/**
	 * @param integer $masterId
	 * @param integer $agent
	 * @return boolean
	 */

	public function returnPendingByMasterId($masterId, $agent = '1') {
		$masterId = intval($masterId);
		$masterModel = RMAMaster::find($masterId);
		if ($masterModel -> status == "pending" || $masterModel -> status == "confirmed") {
			$masterModel -> status = "pending";
			$masterModel -> save();

		}

		DB::transaction(function() use ($masterModel, $masterId, $agent) {
			$stockService = new StockIOService();
			$stockService -> reverseInByOrign($masterId, $agent, IOType::RMA_RESTOCK);
			$masterModel -> status = "pending";
			$masterModel -> save();

		});
	}

	public function generatermaMaster($mid, $agent) {
		$masterModel = rmaMaster::with('details') -> find($mid);
		if ($masterModel -> status != "confirmed") {
			throw new OtherIONotAllowGenerateException("this storage can not be generate , please check the status!");
		} else {
			$masterInModels = $detailInModels = array();
			$i = $o = 0;
			foreach ($masterModel->details as $detail) {

				$masterInModels['relation_id'] = $masterModel -> id;
				$masterInModels['relation_invoice'] = $masterModel -> invoice;
				$masterInModels['warehouse_id'] = $masterModel -> warehouse_id;
				$masterInModels['type'] = 8;
				$masterInModels['creat_agent'] = $agent;
				$masterInModels['status'] = 0;

				//附表
				$detailInModels[$i]['item_id'] = $detail -> item_id;
				$detailInModels[$i]['qty'] = $detail -> qty;
				$detailInModels[$i]['relation_did'] = $detail -> id;
				$i++;
			}
			$StockIOService = new StockIOService();
			if ($masterInModels !== array()) {
				$StockIOService -> createStockIN($masterInModels, $detailInModels);
			}
			$masterModel -> status = "stocking";
			$masterModel -> save();

		}

	}

}
