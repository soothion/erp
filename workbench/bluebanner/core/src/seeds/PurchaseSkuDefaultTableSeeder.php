<?php
/**
 * Short description for PurchaseSkuDefaultTableSeeder.php
 * Created on 2014-05-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage PurchaseSkuDefaultTableSeeder
 * @package PurchaseSkuDefaultTableSeeder
 * @category
 * @version 0.1
 */

namespace Bluebanner\Core;

use Illuminate\Database\Seeder;

use Bluebanner\Core\Model\PurchaseSkuDefault;

class PurchaseSkuDefaultTableSeeder extends Seeder {
  
  public function run() {
    $now = date('Y-m-d H:i:s');

    PurchaseSkuDefault::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'item_id' => 1, 'vendor_id' => 2));
    PurchaseSkuDefault::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'item_id' => 2, 'vendor_id' => 1));
    PurchaseSkuDefault::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'item_id' => 3, 'vendor_id' => 3));

  }
}

?>