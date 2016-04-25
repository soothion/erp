<?php namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\ItemCustomsNotFoundException;
use Bluebanner\Core\ItemCustomsCodeRequiredException;
use Bluebanner\Core\ItemCustomsItemRequiredException;
use Bluebanner\Core\ItemCustomsWarehouseRequiredException;

class ItemCustoms extends BaseModel
{
    protected $table = 'core_item_customs';
    
    protected $guarded = array('id');
    
    protected $softDelete = true;
    
    public $rules = array(
		'customs_code' => 'required',
		'item_id' => 'required|integer',
    );
    
    public function validate() {
        if ( ! $sku = $this->item_id)
            throw new ItemCustomsItemRequiredException('A SKU is required for an Customs, none given.');
        	
        $query = $this->newQuery();
        return true;
    }
    
    public function item()
    {
        return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
    }
    
    public function user()
    {
        return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'agent');
    }
    
}
