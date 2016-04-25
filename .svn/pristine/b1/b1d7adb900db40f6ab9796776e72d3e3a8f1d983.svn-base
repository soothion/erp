<?php

use Bluebanner\Core\Inventory\InventoryServiceInterface;

use Bluebanner\Core\Model\InventoryChange;

class APIInventoryBalanceController extends \BaseController {

	public function __construct(InventoryServiceInterface $service, InventoryChange $modelInventoryChange, InventoryForm $formInventory)
	{
		$this->service = $service;

    $this->InventoryService = $this->service;
    $this->modelInventoryChange = $modelInventoryChange;
    $this->formInventory = $formInventory;
	}

  public function balance() {
    $pg = Input::get('pg', 1);
    $getData = Input::get();

    $formData = $this->formInventory->filterBalanceOpt($getData);
    $inventories = $this->modelInventoryChange->findByConds($formData, $pg, 16, 1)->get();

    return $inventories;
  }

	/**
	 * Display a listing of the resource.
	 * @desc 期初余额：参数时间起点［之前］的最后一条记录的balance
	 * @desc 期末余额：参数时间末点的balance
	 * @return Response
	 */
	public function index()
	{
		$list  =array();
		$warehouse_id = Input::get('warehouse');
		$item_id = Input::get('sku');
		$created_at = with(new DateTime(Input::get('from')))->setTime(0,0,0);

		//期初
		if(Input::get('search_type') =='start'){
			$r = $this->service->balanceStart($warehouse_id,$item_id,$created_at)->get()->toArray();
			if($r) $list[0] = $r[0];
			else $list[0] = array('qty' => 0,'balance' => 0);
		}else{
			$condition = array(
				'warehouse_id' 	=> $warehouse_id,
				'item_id' 		=> $item_id,
				'created_at' 	=> (Input::get('from') || Input::get('to')) ? array(with(new DateTime(Input::get('from')))->setTime(0,0,0), with(new DateTime(Input::get('to')))->setTime(23,59,59)) : null,
			);

			$list = $this->service->blanceSearching($condition)->get()->toArray();
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