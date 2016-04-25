<?php

/**
 * Created by EMACS
 * Created at 2014-10-27
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Model
 * @copyright 2014
 */

namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;

use Bluebanner\Core\ShipInvoiceRequiredException;
use Bluebanner\Core\ShipWarehouseSameException;
use Bluebanner\Core\ShipInvoiceDuplicatedException;

class StockShipmentMaster extends BaseModel {
  protected $table = 'core_storage_shipment_master';

  protected $guarded = array('id');

  protected $softDelete = true;

  public $rules = array();

  public function validate() {
    
  }

  public function from_warehouse() {
    return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_from_id');
  }    

  public function to_warehouse() {
    return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_to_id');
  }

  public function user() {
    return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'agent');
  }

  public function details() {
    return $this->hasMany("Bluebanner\Core\Model\ShipDetail",'shipment_id');
  }

}
