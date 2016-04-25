<?php
/**
 * Short description for PurchaseRequestTableSeeder.php
 * Created on 2014-05-15
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage PurchaseRequestTableSeeder
 * @package PurchaseRequestTableSeeder
 * @category
 * @version 0.1
 */

namespace Bluebanner\Core;

use Illuminate\Database\Seeder;

use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;

class PurchaseRequestTableSeeder extends Seeder {
  
  public function run() {
    $now  = date('Y-m-d H:i:s');
    $expireTime = date('Y-m-d H:i:s', time() + 3600 * 24 * 7);

    PurchaseRequest::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'agent' => 1, 'warehouse_id' => 1, 'relation_id' => 0, 'invoice' => PurchaseRequest::GenerateInvoice(), 'status' => 'pending', 'note' => 'Very Cool', 'expired_at' => $expireTime, 'verified_at' => 0, 'verified_agent' => 1, 'verified_note' => 'Don\'t Tell me', 'type' => 'Shipment'));

    PurchaseRequest::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'agent' => 1, 'warehouse_id' => 3, 'relation_id' => 0, 'invoice' => PurchaseRequest::GenerateInvoice(), 'status' => 'pending', 'note' => 'Very Cool', 'expired_at' => $expireTime, 'verified_at' => 0, 'verified_agent' => 1, 'verified_note' => 'Don\'t Tell me', 'type' => 'Shipment'));

    PurchaseRequest::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'agent' => 1, 'warehouse_id' => 2, 'relation_id' => 0, 'invoice' => PurchaseRequest::GenerateInvoice(), 'status' => 'confirmed', 'note' => 'Very Cool', 'expired_at' => $expireTime, 'verified_at' => 0, 'verified_agent' => 1, 'verified_note' => 'Don\'t Tell me', 'type' => 'Shipment'));

    PurchaseRequest::create(array('id' => 4, 'created_at' => $now, 'updated_at' => $now, 'agent' => 1, 'warehouse_id' => 2, 'relation_id' => 0, 'invoice' => PurchaseRequest::GenerateInvoice(), 'status' => 'confirmed', 'note' => 'Very Cool', 'expired_at' => $expireTime, 'verified_at' => 0, 'verified_agent' => 1, 'verified_note' => 'Don\'t Tell me', 'type' => 'Shipment'));

    PurchaseRequest::create(array('id' => 5, 'created_at' => $now, 'updated_at' => $now, 'agent' => 1, 'warehouse_id' => 3, 'relation_id' => 0, 'invoice' => PurchaseRequest::GenerateInvoice(), 'status' => 'confirmed', 'note' => 'Very Cool', 'expired_at' => $expireTime, 'verified_at' => 0, 'verified_agent' => 1, 'verified_note' => 'Don\'t Tell me', 'type' => 'Shipment'));

    PurchaseRequest::create(array('id' => 6, 'created_at' => $now, 'updated_at' => $now, 'agent' => 1, 'warehouse_id' => 3, 'relation_id' => 0, 'invoice' => PurchaseRequest::GenerateInvoice(), 'status' => 'verified', 'note' => 'Very Cool', 'expired_at' => $expireTime, 'verified_at' => 0, 'verified_agent' => 1, 'verified_note' => 'Don\'t Tell me', 'type' => 'Shipment'));




    PurchaseRequestDetail::Create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 1, 'platform_id' => 1, 'item_id' => 1, 'qty' => 1000, 'end_date' => 0, 'transportation' => 'surface', 'note' => 'Hello World'));

    PurchaseRequestDetail::Create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 3, 'platform_id' => 2, 'item_id' => 1, 'qty' => 2000, 'end_date' => 0, 'transportation' => 'surface', 'note' => 'Hello World'));

    PurchaseRequestDetail::Create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 3, 'platform_id' => 1, 'item_id' => 2, 'qty' => 700, 'end_date' => 0, 'transportation' => 'air', 'note' => 'Hello World'));

    PurchaseRequestDetail::Create(array('id' => 4, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 4, 'platform_id' => 1, 'item_id' => 2, 'qty' => 800, 'end_date' => 0, 'transportation' => 'sea', 'note' => 'Hello World'));

    PurchaseRequestDetail::Create(array('id' => 5, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 4, 'platform_id' => 1, 'item_id' => 2, 'qty' => 900, 'end_date' => 0, 'transportation' => 'sea', 'note' => 'Hello World'));

    PurchaseRequestDetail::Create(array('id' => 6, 'created_at' => $now, 'updated_at' => $now, 'request_id' => 6, 'platform_id' => 1, 'item_id' => 2, 'qty' => 800, 'end_date' => 0, 'transportation' => 'sea', 'note' => 'Hello World'));

  }
}

?>