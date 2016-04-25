<?php

class RpcSeeder extends Seeder
{
	
	public function run()
	{
		DB::table('rpc_auth_user')->truncate();
		DB::table('rpc_item')->truncate();
		DB::table('rpc_company')->truncate();
		
		Bluebanner\Rpc\Company::create(array(
			'name' => 'Sample Company',
			'desc' => 'desc for sample compay',
		));
		
		Bluebanner\Rpc\User::create(array(
			'username' => 'admin',
			'password' => Hash::make('admin'),
			'role' => 1,
			'company_id' => 1,
		));
		
		Bluebanner\Rpc\Item::create(array(
   		'sku' => '111-11101-01',
   		'desc' => 'sample sku',
   		'company_id' => 1,
   		'consuming' => 5,
   		'amount' => 50,
   		'train' => true,
   	));
		

	}
}
