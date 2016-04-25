<?php
/**
 * Short description for PurchasePlanTableSeeder.php
 * Created on 2014-05-15
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage PurchasePlanTableSeeder
 * @package PurchasePlanTableSeeder
 * @category
 * @version 0.1
 */

namespace Bluebanner\Core;

use Illuminate\Database\Seeder;

use Bluebanner\Core\Model\PurchasePlan;
use Bluebanner\Core\Model\PurchasePlanDetail;
use Bluebanner\Core\Model\PurchaseRequestPlanLog;

class PurchasePlanTableSeeder extends Seeder {
  

  public function run() {
    $now = date('Y-m-d H:i:s');

    PurchasePlan::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'invoice' => 'Plan 1 Invoice', 'name' => 'Plan 1', 'status' => 'open', 'agent' => 1));

    PurchasePlan::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'invoice' => 'Plan Two Invoice', 'name' => 'Plan Two', 'status' => 'confirmed', 'agent' => 1));

    PurchasePlan::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'invoice' => 'The Third Plan Invoice', 'name' => 'The Third Plan', 'status' => 'confirmed', 'agent' => 1));


    PurchasePlanDetail::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 1, 'item_id' => 1, 'platform_id' => 2, 'warehouse_id' => 2, 'relation_id' => 0, 'request_qty' => 2000, 'stock_qty' => 200, 'real_qty' => 0, 'to_purchase_qty' => 0, 'shipment_qty' => 0, 'status' => 'pending', 'vendor_id' => 73, 'quotation_id' => 0, 'price_type' => 'normal', 'unit_price' => 4.44, 'transportation' => 'surface'));

    PurchasePlanDetail::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 1, 'item_id' => 1, 'platform_id' => 2, 'warehouse_id' => 2, 'relation_id' => 0, 'request_qty' => 700, 'stock_qty' => 400, 'real_qty' => 800, 'to_purchase_qty' => 400, 'shipment_qty' => 0, 'status' => 'pending', 'vendor_id' => 73, 'quotation_id' => 0, 'price_type' => 'normal', 'unit_price' => 4.44, 'transportation' => 'surface'));

    PurchasePlanDetail::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 2, 'item_id' => 1, 'platform_id' => 2, 'warehouse_id' => 2, 'relation_id' => 0, 'request_qty' => 800, 'stock_qty' => 200, 'real_qty' => 600, 'to_purchase_qty' => 400, 'shipment_qty' => 0, 'status' => 'pending', 'vendor_id' => 71, 'quotation_id' => 0, 'price_type' => 'normal', 'unit_price' => 4.44, 'transportation' => 'surface'));

    PurchasePlanDetail::create(array('id' => 4, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 2, 'item_id' => 1, 'platform_id' => 2, 'warehouse_id' => 2, 'relation_id' => 0, 'request_qty' => 900, 'stock_qty' => 300, 'real_qty' => 1200, 'to_purchase_qty' => 900, 'shipment_qty' => 0, 'status' => 'purchasing', 'vendor_id' => 71, 'quotation_id' => 0, 'price_type' => 'normal', 'unit_price' => 4.44, 'transportation' => 'surface'));

    PurchasePlanDetail::create(array('id' => 5, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 3, 'item_id' => 1, 'platform_id' => 2, 'warehouse_id' => 2, 'relation_id' => 0, 'request_qty' => 800, 'stock_qty' => 400, 'real_qty' => 800, 'to_purchase_qty' => 400, 'shipment_qty' => 0, 'status' => 'purchasing', 'vendor_id' => 71, 'quotation_id' => 0, 'price_type' => 'normal', 'unit_price' => 4.44, 'transportation' => 'surface'));



    PurchaseRequestPlanLog::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 3, 'request_detail_id' => 2, 'item_id' => 1, 'qty' => 2000, 'plan_id' => 1, 'plan_detail_id' => 1));

    PurchaseRequestPlanLog::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 3, 'request_detail_id' => 3, 'item_id' => 2, 'qty' => 700, 'plan_id' => 1, 'plan_detail_id' => 2));

    PurchaseRequestPlanLog::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 4, 'request_detail_id' => 4, 'item_id' => 2, 'qty' => 800, 'plan_id' => 2, 'plan_detail_id' => 3));

    PurchaseRequestPlanLog::create(array('id' => 4, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 4, 'request_detail_id' => 5, 'item_id' => 2, 'qty' => 900, 'plan_id' => 2, 'plan_detail_id' => 4));

    PurchaseRequestPlanLog::Create(array('id' => 5, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 6, 'request_detail_id' => 6, 'item_id' => 2, 'qty' => 800, 'plan_id' => 3, 'plan_detail_id' => 5));

  }
}

?>

