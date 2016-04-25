<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Bluebanner\Core\Model\Warehouse;

class WarehouseTableSeeder extends Seeder
{
	
	public function run()
	{
		
		Warehouse::create(array('id' => 1, 'name' => 'US-CA', 'status' => 1, 'address' => '700 Aldo Ave,Santa Clara, CA 95054', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 2, 'name' => 'CN-FUTIAN',  'status' => 1, 'address' => 'Shenzhen Futian', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 3, 'name' => 'CN-FUTIAN-TAX', 'status' => 1, 'address' => '深圳八封四路', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 4, 'name' => 'US-Amazon-FBA', 'status' => 1, 'address' => '深圳八封四路', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 5, 'name' => 'UK-FBA-Amazon', 'status' => 1, 'address' => 'UK FBA', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 6, 'name' => 'CN-FUTIAN-Sample', 'status' => 1,	'address' => '深圳八封四路', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 7, 'name' => 'Purchase', 'status' => 1, 'address' => '深圳八封四路', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 8, 'name' => 'DE', 'status' => 1, 'address' => '700 Aldo Ave', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 9, 'name' => 'FR-FBA-Amazon', 'status' => 1, 'address' => '深圳八封四路', 'telephone' => '', 'contact' => '', 'country' => 'US'));
		Warehouse::create(array('id' => 10, 'name' => 'SP-FBA-Amazon', 'status' => 1, 'address' => 'SPAN FBA', 'telephone' => '', 'contact' => '', 'country' => 'SP'));
		
		
	}
}

