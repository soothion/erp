<?php

use Bluebanner\Core\Model\StockPurchaseMaster;
use Bluebanner\Core\Model\StockPurchaseDetail;
use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\PurchaseOrder;

use Form\Stock\PurchaseForm;

class APIStockPurchaseController extends \BaseController {
  public function __construct(StockPurchaseMaster $modelStockPurchaseMaster, StockPurchaseDetail $modelStockPurchaseDetail, StockIOMaster $modelStockIOMaster, Item $modelItem, PurchaseOrder $modelPurchaseOrder, PurchaseForm $formPurchase) {
    $this->modelStockPurchaseMaster = $modelStockPurchaseMaster;
    $this->modelStockPurchaseDetail = $modelStockPurchaseDetail;
    $this->modelStockIOMaster = $modelStockIOMaster;
    $this->modelItem = $modelItem;
    $this->modelPurchaseOrder = $modelPurchaseOrder;

    $this->formPurchase = $formPurchase;
  }

  public function index() {
    $pg = Input::get('pg', 1);
    $size = Input::get('size');
    $getData = Input::get();

    $size = ($size < 10 || $size > 50) ? 21 : $size + 1;

    $formData = $this->formPurchase->filterListOpts($getData);

    if (isset($formData['item'])) {
      $tempItemIds = $this->modelItem->conds($formData['item'])->lists('id');
      if (!$tempItemIds) {
        return array();
      }
      $formData['detail']['in']['item_id'] = $tempItemIds;
    }

    if (isset($formData['detail'])) {
      $temIds = $this->modelStockPurchaseDetail->conds($formData['detail'])->lists('master_id');
      if (!$temIds) {
        return array();
      }
      $formData['stock']['in']['id'] = $temIds;
    }

    if (isset($formData['purchase'])) {
      $tempPurchaseId = $this->modelPurchaseOrder->conds($formData['purchase'])->pluck('id');
      if (!$tempPurchaseId) {
        return array();
      }
      $formData['stock']['eq']['po_id'] = $tempPurchaseId;
    }

    $result = $this->modelStockPurchaseMaster->getListsByOpts($formData['stock'], $pg, $size);

    return $result;
  }

  public function create() {

  }

  public function store() {

  }

  public function show($id) {
    $result = $this->modelStockPurchaseMaster->where('id', (int)$id)->first();

    if ($result) {
      foreach ($result->details as $detail) {
        $detail->item;
      }
    }

    return $result;
  }

  public function edit($id) {
    return $this->show($id);
  }

  public function update($id) {
    $getData = Input::get('details', array());

    $formData = $this->formPurchase->filterUpdate($getData);

    $stock = $this->modelStockPurchaseMaster->getByIdAndDetailIds($id, $formData['ids']);

    $ioFormData = $this->formPurchase->genStockIO($stock, $formData['update']);

    $this->modelStockIOMaster->genStockPurchaseLog($ioFormData);
  }

  public function destroy($id) {

  }
}