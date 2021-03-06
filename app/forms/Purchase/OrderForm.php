<?php
/**
 * Short description for OrderForm.php
 * Created on 2014-04-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage OrderForm
 * @package OrderForm
 * @category
 * @version 0.1
 */
use Bluebanner\Core\Purchase\OrderServiceInterface;

use Bluebanner\Core\Model\PurchaseOrder;
use Bluebanner\Core\Model\PurchaseOrderDetail;
use Bluebanner\Core\Model\StockPurchaseMaster;

class OrderForm extends \BaseForm {

  public function __construct(OrderServiceInterface $orderService, PurchaseOrder $modelPurchaseOrder, PurchaseOrderDetail $modelPurchaseOrderDetail, StockPurchaseMaster $modelStockPurchaseMaster) {
    $this->orderService = $orderService;

    $this->modelPurchaseOrder = $modelPurchaseOrder;
    $this->modelPurchaseOrderDetail = $modelPurchaseOrderDetail;
    $this->modelStockPurchaseMaster = $modelStockPurchaseMaster;
  }

  /**
   * attribute is alias of field in the database
   * @param array &$attrs
   */
  public function transAttrs(array &$attrs) {
    $keys = array('agent_id' => 'agent',
                  'start_time' => 'created_at',
                  'begin_time' => 'created_at',
                  'end_time' => 'updated_at',
                  'to_purchase_qty' => 'qty',
                  'planDetailId' => 'plan_detail_id');

    foreach ($attrs as $attr => $value) {
      if (array_key_exists($attr, $keys)) {
        $attrs[$keys[$attr]] = $value;
        unset($attrs[$attr]);
      }
    }
  }

  /**
   * @param array $getData with [invoice, item_id, agent, warehouse_id, status, created_at, updated_at]
   * @return array with [invoice, item_id, agent, warehouse_id, status, created_at, updated_at]
   */
  public function checkOrderListOpt($options) {
    $this->transAttrs($options);

    $result = array();

    if (isset($options['invoice']) && $options['invoice'] && $options['invoice'] != "undifined") {
      $result['like']['invoice'] = $options['invoice'];
    }

    if (isset($options['item_id']) && $options['item_id'] && is_numeric($options['item_id'])) {
      $orderIds = $this->modelPurchaseOrderDetail->distinct()->whereIn('item_id', array($options['item_id']))->lists('order_id');

      if ($orderIds) {
        $result['in']['id'] = $orderIds;
      } else {
        // Needn't search other else

        unset($result);
        $result['eq']['id'] = '0';
      }
    }

    if (isset($options['agent']) && $options['agent'] && is_numeric($options['agent'])) {
      $result['eq']['agent'] = $options['agent'];
    }

    if (isset($options['warehouse_id']) && $options['warehouse_id'] && is_numeric($options['warehouse_id'])) {
      $result['eq']['warehouse_id'] = $options['warehouse_id'];
    }

    if (isset($options['status']) && $options['status'] && $options['status'] != "undifined") {
      $result['eq']['status'] = $options['status'];
    }

    if (isset($options['created_at']) && $options['created_at']) {
      $result['gt']['created_at'] = date('Y-m-d H:i:s', strtotime($options['created_at']));
    }

    if (isset($options['updated_at']) && $options['updated_at']) {
      $result['lt']['updated_at'] = date('Y-m-d H:i:s', strtotime($options['updated_at']));
    }

    return $result;
  }

  /**
   * @todo exception
   */
  public function validateOrder(array $order, $exp = array()) {
    $this->transAttrs($order);

    $result = array();

    $exp['status'] = isset($exp['status']) ? $exp['status'] : 'pending';
    $exp['currency'] = array('CNY', 'USD');
    $exp['price_type'] = array('normal', 'tax', 'usd');

    $keysNotNull = array('invoice', 'status', 'price_type', 'currency');
    if (!($valNotNull = $this->filterInput($keysNotNull, $order))) {
      throw new Exception('Not NULL');
    }

    $keysBeNum = array('warehouse_id', 'vendor_id', 'total', 'discount', 'tax_rate', 'invoice_rate', 'payment_method', 'payment_dates');
    if (!($valBeNum = $this->filterInput($keysBeNum, $order, parent::SET_NUM_CANNOT_NULL))) {
      throw new Exception('Num && Not NULL');
    }

    $keysCanNull = array('payment_terms', 'delivery_date', 'ship_to', 'note');
    if (!($valCanNull = $this->filterInput($keysCanNull, $order, parent::SET_CAN_NULL))) {
      throw new Exception('Can Null');
    }

    /* $keysNumOrNull = array(); */
    /* if (!($valNumOrNull = $this->filterInput($keysNumOrNull, $order, parent::SET_NUM_CAN_NULL))) { */
    /*   throw new Exception('Num && Can NULL'); */
    /* } */

    $result = array_merge($valNotNull, $valBeNum, $valCanNull);

    if ($result['status'] != $exp['status'] || !in_array($result['currency'], $exp['currency']) || !in_array($result['price_type'], $exp['price_type'])) {
      throw new Exception('Expectation');
    }

    $result['created_at'] = $result['updated_at'] = date('Y-m-d H:i:s');
    $result['delivery_date'] = $result['delivery_date'] ? date('Y-m-d H:i:s', strtotime($result['delivery_date'])) : '';
    $result['agent'] = Sentry::getUser()->id;
    // @todo
    $result['currency_rate'] = 6.2;

    return $result;
  }

  /**
   * @todo exception
   */
  public function validateOrderDetail(array $orderDetails, $exp = array()) {
    $result['main'] = array();
    $nowDate = date('Y-m-d H:i:s');

    $keysBeNum = array('item_id', 'qty', 'tax_unit_price', 'usd_unit_price', 'unit_price', 'discount', 'total', 'platform_id');
    $keysCanNull = array('um');

    foreach ($orderDetails as $key => $detail) {
      // $detail maybe has something wrong
      $this->transAttrs($orderDetails[$key]);

      if (!($valBeNum = $this->filterInput($keysBeNum, $detail, parent::SET_NUM_CANNOT_NULL))) {
        throw new Exception('Detail Num');
      }

      if (!($valCanNull = $this->filterInput($keysCanNull, $detail, parent::SET_CAN_NULL))) {
        throw new Exception('Detail Can Null');
      }

      $result['main'][$key] = array_merge($valBeNum, $valCanNull);
      $result['main'][$key]['created_at'] = $result['main'][$key]['updated_at'] = $nowDate;
    }

    return $result;
  }


  /**
   * @todo exception
   */
  public function validateOrderDetailByPlan($orderDetails, $exp = array()) {
    /* $details = $this->validateOrderDetail($orderDetails, $exp); */
    /* $logs = array(); */
    /* $nowDate = date('Y-m-d H:i:s'); */

    /* $keysBeNum = array('plan_id', 'plan_detail_id'); */

    /* foreach ($details['main'] as $key => $detail) { */
    /*   if (!$this->filterInput($keysBeNum, $orderDetails[$key], parent::SET_NUM_CANNOT_NULL)) { */
    /*     throw new Exception('Log Detail Can Null'); */
    /*   } */

    /*   $logs[$key]['plan_id'] = $orderDetails[$key]['plan_id']; */
    /*   $logs[$key]['plan_detail_id'] = $orderDetails[$key]['plan_detail_id']; */
    /*   $logs[$key]['item_id'] = $detail['item_id']; */
    /*   $logs[$key]['qty'] = $detail['qty']; */
    /*   $logs[$key]['created_at'] = $logs[$key]['updated_at'] = $nowDate; */
    /* } */

    /* $details['logs'] = $logs; */
    /* return $details; */

    $result = array();
    $main = array();
    $logs = array();
    $plans = array();
    $now = date('Y-m-d H:i:s');
    $keys = array('plan_id', 'plan_detail_id', 'item_id', 'platform_id');

    if (!is_array($orderDetails) || count($orderDetails) < 1) {
      throw new Exception('Must be more than 1 item');
    }

    foreach ($orderDetails as $detailId => $details) {
      $this->transAttrs($details);

      foreach ($keys as $key) {
        if (!$this->isNumeric($key, $details)) {
          throw new Exception('id must be numeric and can not be 0');
        }
        $main[$detailId][$key] = $details[$key];
      }
      unset($main[$detailId]['plan_id']);
      unset($main[$detailId]['plan_detail_id']);
      $logs[$detailId]['plan_id'] = $details['plan_id'];
      $logs[$detailId]['plan_detail_id'] = $details['plan_detail_id'];
      $logs[$detailId]['item_id'] = $details['item_id'];

      if (!$this->isNumeric('qty', $details) || $details['qty'] < 1) {
        throw new Exception('qty must be larger than 1');
      }
      $plans[$details['plan_detail_id']]['to_purchase_qty'] = $main[$detailId]['qty_confirmed'] = $main[$detailId]['qty'] = $logs[$detailId]['qty'] = $details['qty'];
      $main[$detailId]['qty_free'] = 0;

      if (!$this->isNumeric('real_qty', $details) || $details['real_qty'] < $details['qty']) {
        throw new Exception('real qty must be bigger than to purchase qty');
      }
      $plans[$details['plan_detail_id']]['real_qty'] = $details['real_qty'];

      // @todo default discount
      if ($this->isNumeric('discount', $details) && $details['discount'] > 0) {
        $main[$detailId]['discount'] = $details['discount'];
      } else {
        $main[$detailId]['discount'] = 1;
      }

      switch ($details['price_type']) {
        case 'normal':
          if (!isset($details['unit_price']) || !($details['unit_price'] && $details['unit_price'] > 0)) {
            throw new Exception('unit price can not be null or zero or less than zero');
          }
          $main[$detailId]['unit_price'] = $details['unit_price'];
          $main[$detailId]['tax_unit_price'] = 0;
          $main[$detailId]['usd_unit_price'] = 0;
          $main[$detailId]['total'] = $main[$detailId]['unit_price'] * $main[$detailId]['discount'] * $main[$detailId]['qty'];
          break;
        case 'tax':
          if (!isset($details['tax_unit_price']) || !($details['tax_unit_price'] && $details['tax_unit_price'] > 0)) {
            throw new Exception('tax unit price can not be null or zero or less than zero');
          }
          $main[$detailId]['unit_price'] = 0;
          $main[$detailId]['tax_unit_price'] = $details['tax_unit_price'];
          $main[$detailId]['usd_unit_price'] = 0;
          $main[$detailId]['total'] = $main[$detailId]['tax_unit_price'] * $main[$detailId]['discount'] * $main[$detailId]['qty'];
          break;
        case 'usd':
          if (!isset($details['usd_unit_price']) || !($details['usd_unit_price'] && $details['usd_unit_price'] > 0)) {
            throw new Exception('usd unit price can not be null or zero or less than zero');
          }
          $main[$detailId]['unit_price'] = 0;
          $main[$detailId]['tax_unit_price'] = 0;
          $main[$detailId]['usd_unit_price'] = $details['usd_unit_price'];
          $main[$detailId]['total'] = $main[$detailId]['usd_unit_price'] * $main[$detailId]['discount'] * $main[$detailId]['qty'];
          break;
        default:
          throw new Exception('price type must be normal or tax or usd');
      }

      $plans[$details['plan_detail_id']]['updated_at'] = $plans[$details['plan_detail_id']]['deleted_at'] = $logs[$detailId]['created_at'] = $logs[$detailId]['updated_at'] = $main[$detailId]['created_at'] = $main[$detailId]['updated_at'] = $now;
      $plans[$details['plan_detail_id']]['status'] = 'purchasing';
    }

    $result = array('main' => $main, 'logs' => $logs, 'plans' => $plans);
    return $result;
  }

  public function validateUpdateOrder($id, array $order) {
    if ('pending' != $this->modelPurchaseOrder->getStatus($id)) {
      throw new Exception('update pending');
    }

    if (!isset($order['vendor_id']) || !$order['vendor_id'] || !is_numeric($order['vendor_id'])) {
      throw new Exception('update order null');
    }
    $result['vendor_id'] = $order['vendor_id'];

    $result['updated_at'] = date('Y-m-d H:i:s');

    return $result;
  }

  public function validateUpdateOrderDetail($masterId, array $orderDetails) {
    $result = array();
    $now = date('Y-m-d H:i:s');

    foreach ($orderDetails as $detail) {
      if (!$this->isNumeric('qty', $detail)) {
        throw new \Exception('qty must be a number');
      }

      if (!$this->isNumeric('item_id', $detail)) {
        throw new \Exception('item_id must be exist');
      }

      $qtys = $this->modelPurchaseOrderDetail->where('order_id', $masterId)->where('item_id', $detail['item_id'])->lists('qty', 'id');
      $price_type = $this->modelPurchaseOrder->where('id', $masterId)->pluck('price_type');
      switch ($price_type) {
        case 'usd':
        case 'USD':
          $price = $this->modelPurchaseOrderDetail->where('order_id', $masterId)->where('item_id', $detail['item_id'])->lists('usd_unit_price', 'id');
          break;
        case 'tax':
        case 'TAX':
          $price = $this->modelPurchaseOrderDetail->where('order_id', $masterId)->where('item_id', $detail['item_id'])->lists('tax_unit_price', 'id');
          break;
        default:
          $price = $this->modelPurchaseOrderDetail->where('order_id', $masterId)->where('item_id', $detail['item_id'])->lists('unit_price', 'id');
      }
      $discount = $this->modelPurchaseOrderDetail->where('order_id', $masterId)->where('item_id', $detail['item_id'])->lists('discount', 'id');
      $qtysAssigned = $this->orderService->assignInventory($qtys, $detail['qty']);

      foreach ($qtysAssigned as $detailId => $qtyAssigned) {
        if (!isset($qtyAssigned['qty_confirmed'])) {
          $result[$detailId]['qty_confirmed'] = $qtys[$detailId];
        } else {
          $result[$detailId]['qty_confirmed'] = $qtyAssigned['qty_confirmed'];
        }
        $result[$detailId]['qty_free'] = $qtyAssigned['qty_free'];
        $result[$detailId]['total'] = $result[$detailId]['qty_confirmed'] * $price[$detailId] - $discount[$detailId];
        $result[$detailId]['updated_at'] = $now;
      }
    }

    return $result;
  }
  /*public function validateUpdateOrderDetail($masterId, array $orderDetails) {
    $result = array();
    $nowDate = date('Y-m-d H:i:s');

    foreach ($orderDetails as $detail) {
      if (!$this->isNumeric('qty', $detail) || !$this->isNumeric('total', $detail) || !$this->isNumeric('id', $detail)) {
        throw new Exception('id & qty & total null');
      }
      $result[$detail['id']] = array('qty' => $detail['qty'], 'total' => $detail['total'], 'updated_at' => $nowDate);
    }

    $childIds = $this->modelPurchaseOrder->childQueryBuilder()->where('order_id', $masterId)->lists('id');

    // make sure all child belongs master
    foreach ($result as $key => $value) {
      if (!in_array($key, $childIds)) {
        throw new Exception('No exsit');
      }
    }

    return $result;
  }*/

  /**
   * @param array $orderIds
   * @return array
   */
  public function validateMergeOrder(array $orderIds) {
    if (count($orderIds) == 0 || count($orderIds) == 1) {
      throw new Exception('can\'t be null');
    }

    foreach ($orderIds as $orderId) {
      if (!is_numeric($orderId)) {
        throw new Exception('merge num');
      }
    }

    $orders = $this->modelPurchaseOrder->whereIn('id', $orderIds)->where('status', 'pending')->get();

    if (count($orders->toArray()) != count($orderIds)) {
      throw new Exception('Unmatch');
    }

    // only need to match the first row
    $uniqKeys = array('warehouse_id', 'vendor_id', 'currency', 'currency_rate', 'tax_rate', 'invoice_rate', 'discount', 'ship_to', 'price_type');
    foreach ($uniqKeys as $uniqKey) {
      $firstOrder[$uniqKey] = $orders[0][$uniqKey];
    }

    $firstOrder['payment_dates'] = '';
    $firstOrder['total'] = 0.0;
    $firstOrder['note'] = '';
    $firstOrder['created_at'] = $firstOrder['updated_at'] = date('Y-m-d H:i:s');
    foreach ($orders->toArray() as $order) {
      foreach ($uniqKeys as $uniqKey) {
        if ($order[$uniqKey] != $firstOrder[$uniqKey]) {
          throw new Exception('no unique');
        }
      }

      $firstOrder['payment_dates'] .= $order['payment_dates'] . ' ';
      $firstOrder['total'] += (double)$order['total'];
      $firstOrder['note'] .= $order['note'] ? $order['note'] . ' ' : '';
      $firstOrder['agent'] = Sentry::getUser()->id;
    }

    return $firstOrder;
  }

  // @todo exception
  public function validateOrderStatus($id, $expStatus = null) {
    if (!$expStatus) {
      if ('pending' == $this->modelPurchaseOrder->getStatus($id)) {
        $result['status'] = 'confirmed';
      } else if ('confirmed' == $this->modelPurchaseOrder->getStatus($id)) {
        $result['status'] = 'pending';
      } else {
        throw new \Exception('only confirmed & pending & cancel');
      }
    } else {
      $result['status'] = $expStatus;
    }

    $result['updated_at'] = date('Y-m-d H:i:s');
    return $result;
  }

  public function filterRollbackFromStock($id) {
    if ('confirmed' != $this->modelPurchaseOrder->getStatus($id)) {
      throw new \Exception('only the confirmed status can unconfirm');
    }

    if ('todo' != $this->modelStockPurchaseMaster->getStatusByPOId($id)) {
      throw new \Exception('Can not rollback');
    }
  }

  public function filterPurchaseToStock($id) {
    $result = array();
    $now = date('Y-m-d H:i:s');
    $uid = \Sentry::getUser()->id;
    $purchase = $this->modelPurchaseOrder->where('id', $id)->where('status', 'pending')->first();

    if (!$purchase) {
      throw new \Exception('No such order or the order had confirmed');
    }

    $result['purchase'] = array('status' => 'confirmed', 'updated_at' => $now);
    $result['stockMaster'] = array('created_at' => $now,
      'updated_at' => $now,
      'agent' => $uid,
      'po_id' => $id,
      'status' => 'todo',
      'warehouse_id' => $purchase['warehouse_id'],
      'vendor_id' => $purchase['vendor_id'],
      'discount' => $purchase['discount'],
      'rate' => $purchase['currency_rate'],
      'relation_invoice' => $purchase['invoice']);

    foreach ($purchase->details as $detail) {
      $result['stockDetails'][] = array('item_id' => $detail['item_id'],
        'agent' => $uid,
        'po_detail_id' => $detail['id'],
        //'platform_id' => $detail['platform_id'],
        'qty' => $detail['qty_confirmed'],
        'qty_rest' => $detail['qty_confirmed'],
        'qty_free' => $detail['qty_free'],
        'rmbprice' => $this->getRMBPrice($purchase['price_type'], $detail),
        'discount' => $detail['discount'],
        'updated_at' => $now,
        'created_at' => $now);
    }

    if (!isset($result['stockDetails']) || !$result['stockDetails']) {
      throw new \Exception('No details');
    }

    return $result;
  }

  public function getRMBPrice($type, $price) {
    switch ($type) {
      case 'tax':
        return $price['tax_unit_price'];
      case 'usd':
        return $price['usd_unit_price'];
      default:
        return $price['unit_price'];
    }
  }

  public function validateAssignInventory(array $item) {
    $this->transAttrs($item);

    $result = array();
    $keys = array('order_id', 'item_id', 'qty');
    foreach ($keys as $key) {
      if (!$this->isNumeric($key, $item)) {
        throw new Exception('id or qty can not be null or less than 1');
      }
    }

    $qtys = $this->modelPurchaseOrderDetail->where('order_id', $item['order_id'])->where('item_id', $item['item_id'])->lists('qty', 'id');
    $discounts = $this->modelPurchaseOrderDetail->where('order_id', $item['order_id'])->where('item_id', $item['item_id'])->lists('discount', 'id');
    $price_type = $this->modelPurchaseOrder->where('id', $item['order_id'])->pluck('price_type');
    switch ($price_type) {
      case 'normal':
        $prices = $this->modelPurchaseOrderDetail->where('order_id', $item['order_id'])->where('item_id', $item['item_id'])->lists('unit_price', 'id');
        break;
      case 'usd':
        $prices = $this->modelPurchaseOrderDetail->where('order_id', $item['order_id'])->where('item_id', $item['item_id'])->lists('usd_unit_price', 'id');
        break;
      case 'tax':
        $prices = $this->modelPurchaseOrderDetail->where('order_id', $item['order_id'])->where('item_id', $item['item_id'])->lists('tax_unit_price', 'id');
    }
    
    if (!count($qtys)) {
      throw new Exception('No such item');
    }

    $result = $this->orderService->assignInventory($qtys, $item['qty']);

    // @todo discount
    foreach ($result as $detailId => $detail) {
      if (isset($detail['qty_confirmed'])) {
        $result[$detailId]['total'] = $discounts[$detailId] * $detail['qty_confirmed'] * $prices[$detailId];        
      }
    }

    return $result;
  }

}

?>