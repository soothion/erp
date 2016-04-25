<?php use Bluebanner\Core\Model\Mapping;
class MappingSeeder extends Seeder {

	/**
	 * Run the cron seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('core_mapping')->delete();
        Mapping::create(array(
        	'platform' => 'amazon',
        	'type' => 'order',
        	'third_party' => 'itemId',
        	'erp' => 'orderId',
        	'sort' => 99,));

        Mapping::create(array(
        	'platform' => 'amazon',
        	'type' => 'sku',
        	'third_party' => '111-222-333',
        	'erp' => '444-555-666',
        	'sort' => 99,));
	}

}