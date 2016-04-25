<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Bluebanner\Core\Model\ItemBom;

class ItemBomTableSeeder extends Seeder
{
	
	public function run()
	{
    $now = date('Y-m-d H:i:s');

    ItemBom::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'parent_id' => 1, 'child_id' => 2, 'qty' => 7, 'agent' => 1, 'note' => 'Just Do it'));
    ItemBom::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'parent_id' => 2, 'child_id' => 3, 'qty' => 6, 'agent' => 1, 'note' => 'Tell me Why'));

	}
}
