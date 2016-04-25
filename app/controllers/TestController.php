<?php

class TestController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| 
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function test()
	{

		$service = new Bluebanner\Core\Order\NeweggService('/Users/vincent/Downloads/订单导入模板/newegg.csv');
		
		$orderList = $service->getOrderList();
		echo '<pre>';
		print_r($orderList);
	}

	public function amazon(){
		$time = time();
		$cronList = Bluebanner\Core\Model\Cron::where('next', '<', $time)->get();
		if(!count($cronList)){
			echo 'no task to run!';
			die;
		}
		foreach ($cronList as $cron) {
			$config = $cron -> config;
			$config = (array)json_decode($config);
			$channel_id = $cron->channel_id;
			$platform = $cron -> platform;
			$service = new Bluebanner\Core\Order\ImportService($platform,$channel_id,$config);
		
				$service->run();
				
	
			if(empty($service -> report)){
				echo 'no order found!';
				die; 
			}
			foreach ($service -> report as $key => $value) {
				echo $value['action'].':'.$value['third_party_order_id'].':'.$value['status'];
			}
			$time = time();
			$cron->last = $time;
			$cron->next = $time+($cron->interval*60);
			$cron->save();
		}
	}

}