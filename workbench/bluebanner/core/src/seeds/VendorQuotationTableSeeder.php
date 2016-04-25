<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Bluebanner\Core\Model\VendorQuotation;

class VendorQuotationTableSeeder extends Seeder
{
	
	public function run()
	{
    $now = date('Y-m-d H:i:s');

    VendorQuotation::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 1, 'item_id' => 1, 'unit_price' => 12.00, 'tax_unit_price' => 32.00, 'usd_unit_price' => 334.00, 'moq' => 2150, 'spq' => 500, 'um' => '个', 'price_type' => 'normal', 'currency' => '1', 'tax_rate' => '12.01', 'invoice_rate' => 25.32, 'lead_time' => 21));
    VendorQuotation::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 2, 'item_id' => 1, 'unit_price' => 12.80, 'tax_unit_price' => 21.00, 'usd_unit_price' => 121.00, 'moq' => 11, 'spq' => 20, 'um' => '箱', 'price_type' => 'tax', 'currency' => '1', 'tax_rate' => '23.00', 'invoice_rate' => 221.00, 'lead_time' => 32));
    VendorQuotation::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 3, 'item_id' => 2, 'unit_price' => 7.20, 'tax_unit_price' => 2.60, 'usd_unit_price' => 212.00, 'moq' => 212, 'spq' => 2, 'um' => '23', 'price_type' => 'normal', 'currency' => '12', 'tax_rate' => '23.00', 'invoice_rate' => 213.00, 'lead_time' => 25));
    VendorQuotation::create(array('id' => 4, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 3, 'item_id' => 3, 'unit_price' => 11.00, 'tax_unit_price' => 1.00, 'usd_unit_price' => 1.00, 'moq' => 12, 'spq' => 10, 'um' => '个', 'price_type' => 'tax', 'currency' => '', 'tax_rate' => '1.00', 'invoice_rate' => 2.00, 'lead_time' => 18));
    VendorQuotation::create(array('id' => 5, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 2, 'item_id' => 2, 'unit_price' => 1.00, 'tax_unit_price' => 1.00, 'usd_unit_price' => 1.00, 'moq' => 1, 'spq' => 1, 'um' => '1', 'price_type' => 'normal', 'currency' => '', 'tax_rate' => '1.00', 'invoice_rate' => 1.00, 'lead_time' => 17));
    VendorQuotation::create(array('id' => 6, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 2, 'item_id' => 3, 'unit_price' => 1.00, 'tax_unit_price' => 1.00, 'usd_unit_price' => 1.00, 'moq' => 12, 'spq' => 12, 'um' => '12', 'price_type' => 'usd', 'currency' => '', 'tax_rate' => '1.00', 'invoice_rate' => 1.00, 'lead_time' => 20));
    VendorQuotation::create(array('id' => 7, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 1, 'item_id' => 2, 'unit_price' => 13.00, 'tax_unit_price' => 32.00, 'usd_unit_price' => 334.00, 'moq' => 2150, 'spq' => 500, 'um' => '个', 'price_type' => 'normal', 'currency' => '1', 'tax_rate' => '12.01', 'invoice_rate' => 25.32, 'lead_time' => 13));
    VendorQuotation::create(array('id' => 8, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 1, 'item_id' => 3, 'unit_price' => 24.00, 'tax_unit_price' => 30.00, 'usd_unit_price' => 334.00, 'moq' => 210, 'spq' => 50, 'um' => '个', 'price_type' => 'normal', 'currency' => '1', 'tax_rate' => '19.01', 'invoice_rate' => 29.32, 'lead_time' => 13));
    VendorQuotation::create(array('id' => 9, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 3, 'item_id' => 1, 'unit_price' => 104.00, 'tax_unit_price' => 3.00, 'usd_unit_price' => 334.00, 'moq' => 20, 'spq' => 20, 'um' => '个', 'price_type' => 'normal', 'currency' => '1', 'tax_rate' => '15.01', 'invoice_rate' => 25.32, 'lead_time' => 10));

    /* VendorQuotation::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 71, 'item_id' => 1, 'unit_price' => 4.44, 'tax_unit_price' => 5.55, 'usd_unit_price' => 6.66, 'moq' => 12, 'spq' => 12, 'um' => 'box', 'price_type' => 'usd', 'currency' => '6', 'tax_rate' => 1.21, 'invoice_rate' => 2.12, 'lead_time' => 100)); */
    /* VendorQuotation::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 71, 'item_id' => 2, 'unit_price' => 4.44, 'tax_unit_price' => 5.55, 'usd_unit_price' => 6.66, 'moq' => 12, 'spq' => 12, 'um' => 'bag', 'price_type' => 'usd', 'currency' => '6', 'tax_rate' => 1.21, 'invoice_rate' => 2.12, 'lead_time' => 100)); */
    /* VendorQuotation::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 71, 'item_id' => 3, 'unit_price' => 4.44, 'tax_unit_price' => 5.55, 'usd_unit_price' => 6.66, 'moq' => 12, 'spq' => 12, 'um' => 'box', 'price_type' => 'usd', 'currency' => '6', 'tax_rate' => 1.21, 'invoice_rate' => 2.12, 'lead_time' => 100)); */
    /* VendorQuotation::create(array('id' => 4, 'created_at' => $now, 'updated_at' => $now, 'vendor_id' => 73, 'item_id' => 1, 'unit_price' => 4.44, 'tax_unit_price' => 5.55, 'usd_unit_price' => 6.66, 'moq' => 12, 'spq' => 12, 'um' => 'box', 'price_type' => 'usd', 'currency' => '6', 'tax_rate' => 1.21, 'invoice_rate' => 2.12, 'lead_time' => 100)); */

	}
}





