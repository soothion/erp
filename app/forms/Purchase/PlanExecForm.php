<?php
/**
 * Short description for PlanExecForm.php
 * Created on 2014-05-09
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage PlanExecForm
 * @package PlanExecForm
 * @category
 * @version 0.1
 */

use Bluebanner\Core\Model\PurchasePlan;
use Bluebanner\Core\Model\PurchasePlanDetail;
use Bluebanner\Core\Model\Item;

class PlanExecForm extends \BaseForm {

  public function __construct(PurchasePlan $modelPurchasePlan, PurchasePlanDetail $modelPurchasePlanDetail, Item $modelItem) {
    $this->modelPurchasePlan = $modelPurchasePlan;
    $this->modelPurchasePlanDetail = $modelPurchasePlanDetail;
    $this->modelItem = $modelItem;
  }

  public function transAttrs(array &$attrs) {
    $keys = array();

    foreach ($attrs as $attr => $value) {
      if (array_key_exists($attr, $keys)) {
        $attrs[$keys[$attr]] = $value;
        unset($attrs[$attr]);
      }
    }
  }


  public function checkPlanExecListsOpt($opts, $planId) {
    $result = array();

    $filteredIds = array('warehouse_id', 'vendor_id', 'item_id');
    foreach ($filteredIds as $filteredId) {
      if (isset($opts[$filteredId]) && $opts[$filteredId]) {
        if (!is_numeric($opts[$filteredId])) {
          throw new \Exception($filteredId . ' must be numeric');
        }
        $result['eq'][$filteredId] = $opts[$filteredId];
      }
    }

    $filteredFields = array('transportation', 'price_type');
    foreach ($filteredFields as $filteredField) {
      if (isset($opts[$filteredField])) {
        $result['eq'][$filteredField] = $opts[$filteredField];
      }
    }

    $result['eq']['plan_id'] = $planId;

    return $result;
  }

  /**
   * plan_id, warehouse_id, transportation, price_type, vendor_id, item_id, pg
   */
  public function checkPlanExecSkusListOpt($options) {

    $result = array();

    $keys = array('warehouse_id', 'vendor_id', 'price_type', 'transportation');

    foreach ($keys as $key) {
      if (isset($options[$key]) && $options[$key]) {
        $result['eq'][$key] = $options[$key];
      }
    }

    if (isset($options['item']) && $options['item']) {
      if (is_int($options['item'])) {
        $result['eq']['item_id'] = $options['item'];
      } else {
        $itemIds = $this->modelItem->single('sku', $options['item'], 'like')->lists('id');
        if ($itemIds) {
          $result['in']['item_id'] = $itemIds;
        } else {
          $result['eq']['item_id'] = 0;
        }

      }
    }

    if (isset($options['plan_id']) && $options['plan_id']) {
      $childs = $this->modelPurchasePlanDetail->where('plan_id', $options['plan_id'])->lists('id');
      if ($childs) {
        $result['in']['id'] = $childs;
      } else {
        unset($result);
        $result['eq']['id'] = 0;
      }
    } else {
      $planIds = $this->modelPurchasePlan->confirmed()->lists('id');

      if (!$planIds) {
        return array('eq' => array('id' => 0));
      }

      $childs = $this->modelPurchasePlanDetail->whereIn('plan_id', $planIds)->lists('id');
      if ($childs) {
        $result['in']['id'] = $childs;
      } else {
        unset($result);
        $result['eq']['id'] = 0;
      }
    }

    $result['eq']['status'] = 'pending';

    return $result;
  }

  /* public function checkPlanExecListOpt($options) { */

  /*   $result = array(); */

  /* } */

}

?>