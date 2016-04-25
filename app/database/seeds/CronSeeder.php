<?php use Bluebanner\Core\Model\Cron;
class CronSeeder extends Seeder {

	/**
	 * Run the cron seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('core_cron')->delete();
		$config = array(
			'access_key_id' => 'AKIAJZI5EXGOZV22NQJQ',
			'secret_access_key' => '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',
			'application_name' => 'BetterStuff LowerPrice',
			'application_version' => '2010-10-01',
			'merchant_id' => 'A2KV19AYUKS3X0',
			'service_url' => 'https://mws.amazonservices.com');
		$config = json_encode($config);

        Cron::create(array(
        	'channel_id' => 1,
        	'platform' => 'amazon',
        	'config' => $config,
        	'interval' => 60,
        	'last' => time(),
        	'next' => time()+(60*60)));
	}

}