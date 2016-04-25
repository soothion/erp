<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_customer', function($table) {
	      $table->engine = 'InnoDB';

	      $table->increments('id');
	      $table->timestamps();
	      $table->softDeletes();
	      $table->string('first_name');
	      $table->string('last_name')->nullable();
	      $table->string('customer_email')->nullable();
	      $table->string('paypal_email')->nullable();
	      $table->string('shipping_address1')->nullable();
	      $table->string('shipping_address2')->nullable();
	      $table->string('shipping_city')->nullable();
	      $table->string('shipping_state')->nullable();
	      $table->string('shipping_zip')->nullable();
	      $table->string('shipping_country')->nullable();
	      $table->string('shipping_province')->nullable();
	      $table->string('shipping_phone')->nullable();
	      $table->string('billing_address1')->nullable();
	      $table->string('billing_address2')->nullable();
	      $table->string('billing_city')->nullable();
	      $table->string('billing_state')->nullable();
	      $table->string('billing_zip')->nullable();
	      $table->string('billing_country')->nullable();
	      $table->string('billing_province')->nullable();
	      $table->string('billing_phone')->nullable();
	      $table->string('ebay_id')->nullable();
	      $table->string('ups_account')->nullable();
	      $table->integer('ups_third_party_id')->nullable();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_customer');
	}

}
