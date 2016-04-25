<?php
use Bluebanner\Core\Model\OrderDetail;
use Bluebanner\Core\Model\Order;
use Bluebanner\Core\Model\Customer;
class APIQueryCustomerController extends \BaseController {


	public function index(){
		return Input::get();
	}

	public function show($id)
	{
		return Customer::find($id);
	}
	
	public function store()
    {
        $param = Input::get();
	   	return Customer::create($param);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$model = Customer::find($id);
		$model->update(Input::get());
		return $model;
	}


	public function destroy($id)
	{
		$model = Customer::find($id);
		$model->forceDelete();
	}

}
