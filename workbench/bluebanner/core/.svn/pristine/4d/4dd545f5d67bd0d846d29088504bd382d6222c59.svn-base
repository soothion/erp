<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\VendorQuotationVendorRequiredException;
use Bluebanner\Core\PurchaseVendorNotFoundException;
use Bluebanner\Core\VendorQuotationItemRequiredException;
use Bluebanner\Core\ItemNotFoundException;
use Bluebanner\Core\VendorQuotationDuplicatedException;

class VendorQuotation extends BaseModel
{
	
	protected $table = 'core_purchase_vendor_quotation';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'vendor_id' => 'required|integer',
		'item_id' => 'required|integer'
	);
	
	public function validate() {
		if ( ! $vendor_id = $this->vendor_id)
			throw new VendorQuotationVendorRequiredException('A vendor is required for a Quotation, none given.');

		if ( ! $vendor = Vendor::find($vendor_id))
			throw new PurchaseVendorNotFoundException("A Vendor is required for a Quotation, the given [$vendor_id] can not found.");

		if ( ! $item_id = $this->item_id)
			throw new VendorQuotationItemRequiredException('An item is required for a Quotation, none given.');

		if ( ! $item = Item::find($item_id))
			throw new ItemNotFoundException("An Item is required for a Quotation, the given [$item_id] can not found.");

		$query = $this->newQuery();
		$persisted = $query->where('vendor_id', '=', $vendor_id)->where('item_id', '=', $item_id)->first();
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new VendorQuotationDuplicatedException("A Quotation already exists with vendor [$vendor_id] and item [$item_id], (vendor, item) must be unique for Quotation.");

		return true;
	}
	
	public function vendor()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Vendor');
	}
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

  public function appendSPQ(&$row) {
    if (is_object($row)) {
      $row->spq = $this->where('item_id', $row->item_id)->where('vendor_id', $row->vendor_id)->pluck('spq');
      return $row->spq;
    }

    return $this->where('item_id', $row['item_id'])->where('vendor_id', $row['item_id'])->pluck('spq');      
  }

  public function appendSPQs(&$rows) {
    foreach ($rows as $row) {
      $this->appendSPQ($row);
    }
    return $rows;
  }

}