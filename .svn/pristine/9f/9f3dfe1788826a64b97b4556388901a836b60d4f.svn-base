<?php
/**
 * Short description for APIPurchaseOrderController.php
 * Created on 2014-04-21
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage APIPurchaseOrderController
 * @package APIPurchaseOrderController
 * @category
 * @version 0.1
 */

use Bluebanner\Core\Model\PurchaseOrder;
use Bluebanner\Core\Model\PurchaseOrderDetail;
use Bluebanner\Core\Model\StockPurchaseMaster;
use Bluebanner\Core\Purchase\OrderServiceInterface;

class APIPurchaseOrderController extends \BaseController {

  public function __construct(PurchaseOrder $modelPurchaseOrder, PurchaseOrderDetail $modelPurchaseOrderDetail, StockPurchaseMaster $modelStockPurchaseMaster, OrderForm $formOrder, OrderServiceInterface $orderService) {
    $this->modelPurchaseOrder = $modelPurchaseOrder;
    $this->modelPurchaseOrderDetail = $modelPurchaseOrderDetail;
    $this->modelStockPurchaseMaster = $modelStockPurchaseMaster;
    $this->formOrder = $formOrder;
    $this->orderService = $orderService;
  }

  public function index() {
    $warehouse = array('name' => 'warehouseName');
    $vendor = array('name' => 'vendorName');
    $fkTbls = array('warehouse' => $warehouse,
                    'vendor' => $vendor);
    $rmFields = array('warehouse_id', 'vendor_id');
    //$rmFields = array();
    $fields = array('*', 'fkTbls' => $fkTbls, 'rmFields' => $rmFields);

    $pg = Input::get('pg', 1);
    $size = Input::get('size', 20);
    $getData = Input::get();

    $formData = $this->formOrder->checkOrderListOpt($getData);

    $orderLists = $this->modelPurchaseOrder->findFieldsByConds($fields, $formData, $pg, $size);

    return $orderLists;
  }

  public function create() {

  }

  public function store() {
    $order = Input::get('master', array());
    $orderDetails = Input::get('childs', array());

    $master = $this->formOrder->validateOrder($order);
    $childs = $this->formOrder->validateOrderDetail($orderDetails);
    $relation = $this->getRelation();

    $this->modelPurchaseOrder->createMasterAndChilds($master, $childs, $relation);
  }

  public function show($id) {
    if (!is_numeric($id)) {
      // redirect other page
      return Redirect::to('api/purchase/po/create');
    }

    $order = $this->modelPurchaseOrder->getOrderById($id);

    if (!$order) {
      // redirect other page
      return Redirect::to('api/purchase/po/create');
    }

    return $order;
  }

  public function edit($id) {
    return $this->show($id);
  }

  public function update($id) {
    if (!is_numeric($id)) {
      // redirect to other page
      return Redirect::to('api/purchase/po/create');
    }

    $order = Input::get('master', array());
    $orderDetails = Input::get('childs', array());

    $master = $this->formOrder->validateUpdateOrder($id, $order);
    $childs = $this->formOrder->validateUpdateOrderDetail($id, $orderDetails);

    $this->modelPurchaseOrder->updateMasterAndChilds($id, $master, $childs);
  }

  public function destroy($id) {
    
  }

  /**
   * @todo incomplete
   */
  public function merge() {
    $orderIds = Input::get('orders');

    $order = $this->formOrder->validateMergeOrder($orderIds);
    $relation = $this->getRelation();

    $masterId = $this->modelPurchaseOrder->mergeMasterAndChilds($order, $orderIds, $relation);
    $this->modelPurchaseOrder->where('id', $masterId)->update(array('invoice' => $this->orderService->genInvoice()));

    // redirect to other page
  }

  /**
   * master => invoice, vendor_id, delivery_date, ship_to, note
   * child => plan_detail_id, qty, transportation
   * one plan
   */
  /*public function generate() {
    $master = Input::get('master');
    $details = Input::get('childs');

    $masterOpt = $this->formOrder->filterGenOrderMasterOpt($master);
    $detailsOpt = $this->formOrder->filterGenOrderDetailsOpt($details);
    $detailsId = $this->formOrder->filterOneField('plan_detail_id');

    $quotations = $this->modelVendorQuotation->where('vendor_id', $master['vendor_id'])->get();
    $detailsDb = $this->modelPurchasePlanDetail->whereIn('id', $detailsId)->get();

    $masterId = $this->formOrder->filterGenOrderMasterId($detailsDb);

    $masterDb = $this->modelPuchasePlan->where('id', $masterId)->first();

    $masterField = $this->formOrder->filterGenOrderMasterField($masterId, $masterOpt, $masterDb);
    $detailsField = $this->formOrder->filterGenOrderDetailsField($detailsOpt, $detailsDb, $quotations);
    $logsField = $this->formOrder->filterGenOrderLogField($masterField, $detailsField);

    $this->modelPurchaseOrder->genOrderByPlan($masterField, $detailsField, $logsField);
  }*/

  public function generate() {
    $order = Input::get('master');
    $orderDetails = Input::get('childs');

    if (!$this->formOrder->isNumeric('plan_id', $order) || $order['plan_id'] < 1) {
      // @redirect
      return Redirect::to();
    }

    $planId = $order['plan_id'];

    $master = $this->formOrder->validateOrder($order);
    $childs = $this->formOrder->validateOrderDetailByPlan($orderDetails);

    $this->modelPurchaseOrder->genOrderByPlan($master, $childs, $planId);

    // redirect to other page
  }

  public function confirmToStock($id) {
    $formData = $this->formOrder->filterPurchaseToStock((int)$id);
    $this->modelStockPurchaseMaster->makePurchaseToStock($formData);
  }

  public function unconfirm($id) {
    $this->formOrder->filterRollbackFromStock((int)$id);
    $this->modelStockPurchaseMaster->rollbackFromPurchase((int)$id);
  }

  public function genInvoice() {
    return json_encode(array('invoice' => $this->orderService->genInvoice()));
  }

  public function assignInventory() {
    // order_id item_id qty
    $getData = Input::get();

    $formData = $this->formOrder->validateAssignInventory($getData);

    $this->modelPurchaseOrderDetail->updateByIdOneTime($formData);
  }

  public function getRelation() {
    return array('masterId' => 'order_id', 'childId' => 'order_detail_id');
  }

}
?>