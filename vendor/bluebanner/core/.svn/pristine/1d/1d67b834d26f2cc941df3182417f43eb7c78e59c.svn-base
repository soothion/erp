<?php
/**
 * Short description for PurchaseOrderTableSeeder.php
 * Created on 2014-05-15
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage PurchaseOrderTableSeeder
 * @package PurchaseOrderTableSeeder
 * @category
 * @version 0.1
 */

namespace Bluebanner\Core;

use Illuminate\Database\Seeder;

use Bluebanner\Core\Model\PurchaseOrder;
use Bluebanner\Core\Model\PurchaseOrderDetail;
use Bluebanner\Core\Model\PurchasePlanOrderLog;

use Bluebanner\Core\Purchase\OrderService;

class PurchaseOrderTableSeeder extends Seeder {
  
  public function run() {
    $now = date('Y-m-d H:i:s');
    $orderService = new OrderService(new PurchaseOrder());

    PurchaseOrder::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'warehouse_id' => 2, 'agent' => 1, 'vendor_id' => 71, 'invoice' => $orderService->genInvoice(), 'status' => 'pending', 'currency' => 'CNY', 'currency_rate' => '6.6', 'tax_rate' => '3.5', 'invoice_rate' => '4.4', 'discount' => 1, 'total' => 8500, 'ship_to' => 'ship to where I might go', 'vendor_invoice' => '', 'note' => 'Something you will write', 'payment_method' => 'crash', 'payment_terms' => 0, 'payment_dates' => '1990', 'due_date' => '', 'delivery_date' => 0, 'plan_id' => 0, 'price_type' => 'normal'));

    PurchaseOrder::create(array('id' => 2, 'created_at' => $now, 'updated_at'=> $now, 'warehouse_id' => 2, 'agent' => 1, 'vendor_id' => 71, 'invoice' => $orderService->genInvoice(), 'status' => 'confirmed', 'currency' => 'CNY', 'currency_rate' => '5.7', 'tax_rate' => '3.3', 'invoice_rate' => '2.3', 'discount' => 1, 'total' => 3600, 'ship_to' => 'Can you guess it', 'vendor_invoice' => '', 'note' => '', 'payment_method' => 'crash', 'payment_terms' => '', 'payment_dates' => '2000', 'due_date' => '', 'delivery_date' => 0, 'plan_id' => 0, 'price_type' => 'tax'));


    PurchaseOrderDetail::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'order_id' => 1, 'item_id' => 2, 'platform_id' => 1, 'size' => '', 'qty' => 400, 'qty_confirmed' => 400, 'qty_free' => 0, 'um' => 'box', 'unit_price' => 10, 'tax_unit_price' => 0, 'usd_unit_price' => 0, 'discount' => 1, 'total' => 4000, 'specification' => 'Over & Over Again'));

    PurchaseOrderDetail::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'order_id' => 1, 'item_id' => 2, 'platform_id' => 2, 'size' => '', 'qty' => 900, 'qty_confirmed' => 900, 'qty_free' => 0, 'um' => 'box', 'unit_price' => 5, 'tax_unit_price' => 0, 'usd_unit_price' => 0, 'discount' => 1, 'total' => 4500, 'specification' => 'Over & Over Again'));

    PurchaseOrderDetail::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'order_id' => 2, 'item_id' => 2, 'platform_id' => 2, 'size' => '', 'qty' => 800, 'qty_confirmed' => 900, 'qty_free' => 100, 'um' => 'box', 'unit_price' => 6, 'tax_unit_price' => 0, 'usd_unit_price' => 0, 'discount' => 1, 'total' => 3600, 'specification' => 'Over & Over Again'));


    PurchasePlanOrderLog::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 2, 'plan_detail_id' => 3, 'order_id' => 1, 'order_detail_id' => 1, 'item_id' => 2, 'qty' => 400));

    PurchasePlanOrderLog::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 2, 'plan_detail_id' => 4, 'order_id' => 1, 'order_detail_id' => 2, 'item_id' => 2, 'qty' => 900));

    PurchasePlanOrderLog::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'plan_id' => 3, 'plan_detail_id' => 5, 'order_id' => 2, 'order_detail_id' => 3, 'item_id' => 2, 'qty' => 800));

  }
}

?>