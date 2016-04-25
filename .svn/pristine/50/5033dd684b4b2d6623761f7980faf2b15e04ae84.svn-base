<?php

use Bluebanner\Core\Warehouse\WarehouseServiceInterface;

class APIWarehouseController extends \BaseController {

	public function __construct(WarehouseServiceInterface $service)
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
		
		  $warehouseList = $this->service->warehouseList();
	      return $warehouseList->get();
	
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
		$vendor = $this->service->warehouseCreate($array);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$warehouse = $this->service->warehouseFind($id);
		
		return $warehouse;
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
		$warehouse = $this->service->warehouseFind($id);
		$array = Input::get();
		$warehouse->update($array);
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$warehouse = $this->service->warehouseFind($id);
		$warehouse->delete();
	}

}
