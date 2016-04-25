<?php

/**
 * Created by EMACS
 * Created at 2014-10-27
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Model
 * @copyright 2014
 */

namespace Bluebanner\Core\Model;

use Bluebanner\Core\Model\StockShipmentMaster;

use Bluebanner\Core\ShipInvoiceDuplicatedException;

class StockShipmentDetail extends BaseModel {
  protected $table = 'core_storage_shipment_detail';

  protected $guarded = array('id');

  protected $softDelete = true;

  public $rules = array();

  public function validate() {
    
  }

  public function item() {
    return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
  }

  public function master() {
    return $this->belongsTo('Bluebanner\Core\Model\ShipMaster','shipment_id');
  }

}