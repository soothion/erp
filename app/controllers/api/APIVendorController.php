<?php

use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Bluebanner\Core\Model\VendorQuotation;

class APIVendorController extends \BaseController {

	public function __construct(PurchaseServiceInterface $service, VendorQuotation $modelVendorQuotation)
	{
		$this->service = $service;
    $this->modelVendorQuotation = $modelVendorQuotation;
	}

  public function getLtFromQuotation($itemId) {
    return $this->modelVendorQuotation->select(array('lead_time', 'vendor_id'))->where('item_id', (int)$itemId)->get();
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$builder = $this->service->vendorList();
		if (Input::get('select')) {
			call_user_func_array(array($builder, 'select'), explode(',', Input::get('select')));
		}		
		return $builder->get();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$array = Input::get();
		$array['categorys_id'] = implode(',', array_fetch($array['categorys_id'], 'id'));
		$vendor = $this->service->vendorCreate($array);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$vendor = $this->service->vendorFind($id);
		$vendor->categorys_id = array_build(explode(',', $vendor->categorys_id), function($k, $v){return array($k, array('id' => $v, 'name' => Bluebanner\Core\Model\Category::find($v)->name));});
		return $vendor;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$vendor = $this->service->vendorFind($id);

		$array = Input::get();
		// $array['categorys_id'] = implode(',', array_fetch($array['categorys_id'], 'id'));
		$vendor->update($array);
		return '';
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}