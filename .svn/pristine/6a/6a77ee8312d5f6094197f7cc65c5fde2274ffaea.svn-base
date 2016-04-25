<?php

use Bluebanner\Core\Warehouse\WarehouseServiceInterface;

class APIContainerController extends \BaseController {

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
		//
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
		return $this->service->containerCreate(array(
			'warehouse_id' => Input::get('warehouse_id'),
			'parent_id' => Input::get('parent_id'),
			'barcode' => Input::get('barcode'),
			'desc' => Input::get('desc'),
			'has_child' => Input::get('has_child') ?: 0,
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
		$containers = $this->service->containerListByWarehouseId($id)->get();
		foreach ($containers as $container) {
			$container->png = DNS1D::getBarcodePNG($container->barcode, 'C39+', 2, 33);
		}
		return $containers;
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
		$container = $this->service->containerFind($id);
		$container->update(array(
			'warehouse_id' => Input::get('warehouse_id'),
			'parent_id' => Input::get('parent_id'),
			'barcode' => Input::get('barcode'),
			'desc' => Input::get('desc'),
			'has_child' => Input::get('has_child') ?: 0,
		));
		$container->png = DNS1D::getBarcodePNG($container->barcode, 'C39+', 2, 33);
		return $container;
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