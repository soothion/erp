<?php

use Bluebanner\Core\Inventory\InventoryServiceInterface;

class APIInventoryOutputController extends \BaseController {

	public function __construct(InventoryServiceInterface $service)
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
		$condition = array(
			'warehouse_id' => intval(Input::get('warehouse')),
			'type' => intval(Input::get('type')),
			'exec_at' => (Input::get('from') || Input::get('to')) ? array(with(new DateTime(Input::get('from')))->setTime(0, 0), with(new DateTime(Input::get('to')))->add(new DateInterval('P1D'))->setTime(0, 0)) : null,
			'relation_id' => intval(Input::get('related')),
			'exec_agent' => intval(Input::get('agent')),
		);

		$detail = array(
			'item_id' => intval(Input::get('sku')),
			// 'vendor' => Input::get('vendor'),
		);

		$list = $this->service->ioSearching(array_filter($condition, function($v) {return $v != '';}), array_filter($detail, function($v) {return $v != '';}))->get();
		foreach ($list as $io) {
			$io->relation;
			foreach ($io->details as $detail) {
				$detail->relation;
			}
		}

		return $list;
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		//
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