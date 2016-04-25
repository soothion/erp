<?php

use Bluebanner\Core\Inventory\InventoryServiceInterface;

use Bluebanner\Core\Model\InventoryChange;

class APIInventoryLog2Controller extends \BaseController {

	public function __construct(InventoryServiceInterface $service, InventoryChange $modelInventoryChange, InventoryForm $formInventory)
	{
		$this->service = $service;

    $this->inventoryService = $this->service;
    $this->modelInventoryChange = $modelInventoryChange;
    $this->formInventory = $formInventory;
	}

  public function log() {
    $pg = Input::get('pg', 1);
    $getData = Input::get();

    $formData = $this->formInventory->filterLogOpt($getData);
    $logs = $this->modelInventoryChange->getInventoryByConds($formData, $pg, 16);

    return $logs;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$condition = array(
			'warehouse_id' => Input::get('warehouse'),
			'type' => Input::get('type'),
			'created_at' => (Input::get('from') || Input::get('to')) ? array(with(new DateTime(Input::get('from')))->setTime(0,0,0), with(new DateTime(Input::get('to')))->setTime(23,59,59)) : null,
			'item_id' => Input::get('sku'),
			'vendor' => Input::get('vendor'),
			'relation_id' => Input::get('related'),
			'description' => Input::get('desc'),
			'agent' => Input::get('agent')
		);

		$list = $this->service->logsByCondition(array_filter($condition, function($v) {return $v != '';}))->get();
		foreach ($list as $log) {
			$log->item;
			$log->warehouse;
			$log->inventory;
			$log->relation;
			$log->agent;
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