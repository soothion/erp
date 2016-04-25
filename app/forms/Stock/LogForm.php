<?php

namespace Form\Stock;

class LogForm extends \BaseForm {
  public function filterOrdersListOpts($opts) {
    $result = array();

    $optIdsLabel = array('warehouse_id', 'status');
    foreach ($optIdsLabel as $optIdLabel) {
      $this->isNumeric($optIdLabel, $opts) && $result['eq'][$optIdLabel] = $opts[$optIdLabel];
    }

    isset($opts['invoice']) && $opts['invoice'] && $result['eq']['invoice'] = $opts['invoice'];
    isset($opts['relation_invoice']) && $opts['relation_invoice'] && $result['eq']['relation_invoice'] = $opts['relation_invoice'];

    isset($opts['created_at_from']) && $opts['created_at_from'] && $result['ge']['created_at'] = date('Y-m-d', strtotime($opts['created_at_from']));
    isset($opts['exec_at_to']) && $opts['exec_at_to'] && $result['le']['exec_at'] = date('Y-m-d', strtotime($opts['exec_at_to']));

    if ($this->isNumeric('type', $opts)) {
      $result['eq']['type'] = $opts['type'];
    } else if (isset($opts['type'])) {
      $opts['type'] == 'in' && $result['gt']['type'] = 0;
      $opts['type'] == 'out' && $result['lt']['type'] = 0;
    }

    return $result;
  }

}