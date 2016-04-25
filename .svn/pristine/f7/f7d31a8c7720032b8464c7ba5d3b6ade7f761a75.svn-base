<?php

use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Bluebanner\Core\Model\PurchaseSkuDefault;
use Bluebanner\Core\Model\Item;

class APIPackingController extends \BaseController {

	public function __construct(PurchaseServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//取整个列表
		return $this->service->packingList()->get();
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
        $param = Input::get();
	   
		$sku = $param['item']['sku'];
		$Itemmodel = Item::where('sku', '=', $sku)->first();
		$arr = array(
			'item_id' => $Itemmodel->id,
			'vendor_id' => $param['vendor']['id'],
			'spq'	=> $param['spq'],
			'price_type'=>$param['price_type'],
			);
		$model = $this->service->packingCreate($arr);

		return PurchaseSkuDefault::with('item', 'vendor')->find($model->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->service->packingFind($id);
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
		$packing = PurchaseSkuDefault::with('item', 'vendor')->find($id);
		$packing->update(array('vendor_id' => Input::get('vendor.id'), 'spq' => Input::get('spq'), 'price_type' => Input::get('price_type')));

		return PurchaseSkuDefault::with('item', 'vendor')->find($id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$packing = $this->service->packingFind($id);
		$packing->forceDelete();
	}

}
