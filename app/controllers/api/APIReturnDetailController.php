<?php

use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Illuminate\Support\Facades\Input;
use Bluebanner\Core\ItemService;

class APIReturnDetailController extends \BaseController {
	public function __construct(PurchaseServiceInterface $returnDetailService) {
		$this->service=$returnDetailService;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->service->returnDetailList()->get();
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::get('changeSku',false) === false)
		{
			return $this->createReturnDetail();		
		}
		else
		{
			return $this->changeReturnDetailSKU();
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  string  $id
	 * @return Response
	 */
	public function show($key)
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
		
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$returnModel=$this->service->returnDetailFindByPK($id);		
		
		$itemService=new Bluebanner\Core\Item\ItemService();
		$itemModel=$itemService->itemFindBySku(Input::get('sku'));
		$item_id=$itemModel->id;
		
		
		if($returnModel!==null)
		{
			$returnModel->update(
				array(
					"description"	=>Input::get('description'),
					"item_id"		=>$item_id,
					"note"			=>Input::get('note'),
					"qty"			=>Input::get('qty'),
					"reason"		=>Input::get('reason'),
					"um"			=>Input::get('um'),
					"return_id"		=>Input::get('return_id'),
				)
			);	
			return "";		
		}
		else
		{
			throw new \Exception("invailed arguments");
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->service->returnDetailDelete($id);
	}
	
	
	public function createReturnDetail()
	{
		$itemService=new Bluebanner\Core\Item\ItemService();
	
		$itemModel=$itemService->itemFindBySku(Input::get('sku'));
		$item_id=$itemModel->id;
		$return=array(				
				"description"	=>Input::get('description'),
				"item_id"		=>$item_id,
				"note"			=>Input::get('note'),
				"qty"			=>Input::get('qty'),
				"reason"		=>Input::get('reason'),
				"um"			=>Input::get('um'),
				"return_id"		=>Input::get('return_id'),
		);
		return $this->service->returnDetailCreate($return);
	}
	
	public function changeReturnDetailSKU()
	{
		$itemService=new Bluebanner\Core\Item\ItemService();
		$itemNewModel=$itemService->itemFindBySku(Input::get('newsku'));
		$itemOldModel=$itemService->itemFindBySku(Input::get('oldsku'));
		return $this->service->returnDetailUpdateSKU($itemOldModel->id,$itemNewModel->id);
	}
}

?>