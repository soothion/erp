<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as Eloquent;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('Bluebanner\Core\WarehouseTableSeeder');
		
		$this->call('Bluebanner\Core\PlatformTableSeeder');
		
		$this->call('Bluebanner\Core\ItemTableSeeder');

		$this->call('Bluebanner\Core\ItemBomTableSeeder');

		$this->call('Bluebanner\Core\VendorTableSeeder');

		$this->call('Bluebanner\Core\VendorQuotationTableSeeder');
	}

}