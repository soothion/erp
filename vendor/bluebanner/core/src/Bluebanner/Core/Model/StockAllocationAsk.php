<?php
/**
 * Created by VIM
 * Created at 2014-10-10
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Model
 * @copyright 2014 
 */

namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;

class StockAllocationAsk extends BaseModel {
  protected $table = 'core_storage_allocation_ask';

  protected $guarded = array('id');

  protected $softDelete = true;

  // @todo
  public function validate() {
    
  }

  public function warehouse() {
    return $this->belongsTo('Bluebanner\Core\Model\Warehouse', 'warehouse_id');
  }
  
  public function from_platform() {
    return $this->belongsTo('Bluebanner\Core\Model\Platform', 'from_platform_id');
  }

  public function to_platform() {
    return $this->belongsTo('Bluebanner\Core\Model\Platform', 'to_platform_id');
  }

  public function item() {
    return $this->belongsTo('Bluebanner\Core\Model\Item', 'item_id');
  }
}
