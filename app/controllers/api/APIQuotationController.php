<?php

use Bluebanner\Core\Purchase\PurchaseServiceInterface;

class APIQuotationController extends \BaseController {

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
		$quotations = array();
		foreach ($this->service->quotationList()->get() as $quotation) {
			$quotation->vendor && $quotation->item;
			$quotations[] = $quotation->toArray();
		}

		return $quotations;
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
		$quotation = Input::get();
		$quotation['vendor_id'] = $quotation['vendor']['id'];
		$quotation['item_id'] = $quotation['item']['id'];

		unset($quotation['vendor'], $quotation['item']);

		return $this->service->quotationCreate($quotation);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$quotation = $this->service->quotationFind($id);

		// 比较蠢 一定得显式的调用一下 看看以后有没有别的办法
		$quotation->vendor && $quotation->item;

		return $quotation;
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
		$quotation = $this->service->quotationFind($id);

		$update = Input::get();
		$update['vendor_id'] = $update['vendor']['id'];
		$update['item_id'] = $update['item']['id'];

		unset($update['vendor'], $update['item']);

		$quotation->update($update);
		return "";
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$quotation = $this->service->quotationFind($id);
		$quotation->delete();
		return ;
	}

}