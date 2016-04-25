<?php

use Bluebanner\Core\Model\PurchaseRequestDetail;

class APIRequestDetailController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return PurchaseRequestDetail::with('item.cost', 'item.spq', 'platform')->where('request_id', Input::get('rid'))->get();
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
		return PurchaseRequestDetail::create(array(
			'request_id' => Input::get('rid'),

		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return PurchaseRequestDetail::with('item.cost',  'item.spq', 'item.spq', 'platform')->find($id);
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
		$obj = PurchaseRequestDetail::with('item', 'platform')->find($id);
		$obj->update(array(
		  'item_id' => Input::get('item.id'),
		  // 因为客户端select自动匹配复杂对象时有问题，这里还是接受数字参数
		  'platform_id' => Input::get('platform_id'),
		  'qty' => Input::get('qty'),
		  'end_date' => Input::get('end_date'),
		  'transportation' => Input::get('transportation'),
		  'note' => Input::get('note'),
    ));

    return PurchaseRequestDetail::with('item.cost', 'item.spq', 'platform')->find($id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$obj = PurchaseRequestDetail::find($id);

		if ($obj) {
			$obj->delete();
		}
	}

}