<?php
use Bluebanner\Core\Model\Order;
use Bluebanner\Core\Model\OrderDetail;
use Bluebanner\Core\Model\Account;
class APIAnalyzingController extends \BaseController {

	public function index(){
		$param = Input::get();
		if(empty($param['from'])||empty($param['to']))
			throw new Exception('没有设置时间段');
		
		//一次最多只能查询90的数据
		if(strtotime($param['to'])-strtotime($param['from']) > 90*24*60*60)	
			throw new Exception("一次最多只能查询90天记录");
			
		$orderList = Order::where('created_at','<=', $param['to'])
			->where('created_at','>', $param['from'])
			->whereIn('status', array('pending','printed'))
			->lists('id');
		if(empty($orderList))
			return null;
		$query = OrderDetail::whereIn('order_id', $orderList);
		if(!empty($param['sku'])){
			$query = $query->where('sku', '=', $param['sku']);
		}
		
		$query = $query->select(
			'sku',
			DB::raw('count(DISTINCT order_id) as orderTotal'),
			DB::raw('count(sku) as skuTotal'),
			DB::raw('sum(sales_price) as priceTotal')
			);
		if($param['group'] == 'day' || $param['group'] == 'sku')
			$query = $query->addSelect(
				DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')
			);			
		elseif($param['group'] == 'month')
			$query = $query->addSelect(
				DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date')
			);

		if($param['group'] == 'sku'){
			$query = $query->groupBy('sku','date');
		}
		else{
			$query = $query->groupBy('date');
		}
		
		return $query->get();
	}
  
	public function store()
    {
        $param = Input::get();
        $param['last'] = time();
        $param['next'] = $param['last'] + $param['interval']*60;
	   	return Cron::create($param);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$model = $this->model->find($id);
		$model->update(Input::get());
		return $model;
	}

	public function show($platform)
	{
		$model = Cron::firstByAttributes(array('platform'=>$platform));
		if($result = $model['config'])
			return $result;
		else return null;
	}

	public function destroy($id)
	{
		$mapping = Cron::find($id);
		$mapping->forceDelete();
	}

}
