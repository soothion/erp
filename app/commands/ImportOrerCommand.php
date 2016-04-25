<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Bluebanner\Core\Order\ImportService;
use Bluebanner\Core\Model\Cron;

class ImportOrerCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'order:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '导入Amazon、Ebay订单';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$cronList = $this->getCronList();
		if(!count($cronList)){
			$this->info('no task to run!');
			die;
		}
		foreach ($cronList as $cron) {
			$config = $cron -> config;
			$config = (array)json_decode($config);
			$channel_id = $cron->channel_id;
			$platform = $cron -> platform;
			$service = new ImportService($platform,$channel_id,$config);
			try {
				$service->run();
			} catch (Exception $e) {
				$this->info($e->getMessage());
				die;
			}
			if(empty($service -> report)){
				$this->info('no order found!');
				die; 
			}
			foreach ($service -> report as $key => $value) {
				$this->info($value['action'].':'.$value['third_party_order_id'].':'.$value['status']);
			}
			$time = time();
			$cron->last = $time;
			$cron->next = $time+($cron->interval*60);
			$cron->save();
		}
	}

	public function getCronList()
	{
		$time = time();
		$cronList = Cron::where('next', '<', $time)->get();
		return $cronList;
	}
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	// protected function getArguments()
	// {
	// 	return array(
	// 		array('example', InputArgument::REQUIRED, 'An example argument.'),
	// 	);
	// }

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	// protected function getOptions()
	// {
	// 	return array(
	// 		array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
	// 	);
	// }

}
