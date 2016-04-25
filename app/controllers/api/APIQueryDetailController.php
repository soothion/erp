<?php
use Bluebanner\Core\Model\OrderDetail;
use Bluebanner\Core\Model\Order;
use Bluebanner\Core\Model\Customer;
class APIQueryDetailController extends \BaseController {


	public function index()
	{
		$param = Input::get();
		return OrderDetail::findByAttributes($param)->get();
	}

	public function show($id)
	{
		return OrderDetail::find($id);
	}
	
	public function store()
    {
        $param = Input::get();
	   	return OrderDetail::create($param);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$model = OrderDetail::find($id);
		$model->update(Input::get());
		return $model;
	}


	public function destroy($id)
	{
		$model = OrderDetail::find($id);
		$model->forceDelete();
	}

}
