<?php

namespace Form\Inventory;

class LogForm extends \BaseForm {
  public function filterNowdayListOpts($opts) {
    $result = array();

    $this->isNumeric('warehouse_id', $opts) && $result['eq']['warehouse_id'] = $opts['warehouse_id'];
    $this->isNumeric('item_id', $opts) && $result['eq']['item_id'] = $opts['item_id'];

    isset($opts['status']) && $opts['status'] && is_array($opts['status']) && $result['in']['status'] = $opts['status'];

    return $result;
  }

  public function filterChangesListOpts($opts) {
    $result = array();

    $optIdsLabel = array('warehouse_id', 'item_id', 'relation_id', 'agent', 'type');
    foreach ($optIdsLabel as $optIdLabel) {
      $this->isNumeric($optIdLabel, $opts) && $result['eq'][$optIdLabel] = $opts[$optIdLabel];
    }

    isset($opts['updated_from']) && $opts['updated_from'] && $result['ge']['updated_at'] = date('Y-m-d', strtotime($opts['updated_from']));
    isset($opts['updated_to']) && $opts['updated_to'] && $result['le']['updated_at'] = date('Y-m-d', strtotime($opts['updated_to']));

    isset($opts['description']) && $opts['description'] && $result['like']['description'] = $opts['description'];

    return $result;
  }

  public function filterDailiesListOpts($opts) {
    $result = array();

    $this->isNumeric('item_id', $opts) && $result['eq']['item_id'] = $opts['item_id'];
    isset($opts['date']) && $opts['date'] && $result['eq']['date'] = date('Y-m-d', strtotime($opts['date']));
    isset($opts['warehouse_id']) && $opts['warehouse_id'] && is_array($opts['warehouse_id']) && $result['in']['warehouse_id'] = $opts['warehouse_id'];

    return $result;
  }

  public function filterBookListOpts($opts) {
    $result = array();

    $fieldTypes = array('order', 'io');
    $fieldStatus = array('pending', 'done', 'cancel');

    isset($opts['status']) && $opts['status'] && in_array($opts['status'], $fieldStatus) && $result['eq']['status'] = $opts['status'];
    isset($opts['type']) && $opts['type'] && in_array($opts['type'], $fieldTypes) && $result['eq']['type'] = $opts['type'];

    isset($opts['created_from']) && $opts['created_from'] && $result['ge']['created_at'] = date('Y-m-d', strtotime($opts['created_from']));
    isset($opts['updated_to']) && $opts['updated_to'] && $result['le']['updated_at'] = date('Y-m-d', strtotime($opts['updated_to']));

    return $result;
  }

  public function filterAllocationsListOpts($opts) {
    $result = array();

    $optIdsLabel = array('item_id', 'warehouse_id', 'from_account_id', 'to_account_id', 'sender', 'receiver');
    foreach ($optIdsLabel as $optIdLabel) {
      $this->isNumeric($optIdLabel, $opts) && $result['eq'][$optIdLabel] = $opts[$optIdLabel];
    }

    isset($opts['created_from']) && $opts['created_from'] && $result['ge']['created_at'] = date('Y-m-d', strtotime($opts['created_from']));
    isset($opts['updated_to']) && $opts['updated_to'] && $result['le']['updated_at'] = date('Y-m-d', strtotime($opts['updated_to']));

    return $result;
  }
}