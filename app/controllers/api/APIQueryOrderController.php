<?php
use Bluebanner\Core\Model\OrderDetail;
use Bluebanner\Core\Model\Order;
use Bluebanner\Core\Model\Customer;
class APIQueryOrderController extends \BaseController {


	public function index(){
		$param = Input::get();
		@$from  = $param['from'];
		@$to  = $param['to'];
		@$sku  = $param['sku'];
		unset($param['from']);
		unset($param['to']);
		unset($param['sku']);

		$query = Order::findByAttributes($param);
		if(!empty($from)){
			$query = $query->where('created_at','>', $from);
		}		
		if(!empty($to)){
			$query = $query->where('created_at','<=', $to);
		}

		if(!empty($sku)){
			$query = $query->whereHas('Detail', function($q) use ($sku)
			{
			    $q->where('sku', '=', $sku);

			});
		}
		return $query->take(2000)->get();
	}

	public function show($id)
	{
		return Order::where('id', '=', $id)->get();
	}

	
	public function store()
    {
        $param = Input::get();
	   	return Order::create($param);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$model = Order::find($id);
		$model->update(Input::get());
		return $model;
	}


	public function destroy($id)
	{
		$order = Order::find($id);
		$customer = Customer::find($order->customer_id);
		$detail = OrderDetail::where('order_id', '=', $id);
		DB::beginTransaction();
		try {
			$order->forceDelete();
			$customer->forceDelete();
			foreach ($detail as $key => $value) {
				$value->forceDelete();
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
		}
	}

}
