<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('core_order', function($table) {
	      $table->engine = 'InnoDB';

	      $table->increments('id');
	      $table->timestamps();
	      $table->softDeletes();
	      $table->integer('channel_id')->nullable();
	      $table->integer('warehouse_id')->nullable();
	      $table->string('third_party_order_id')->nullable();
	      $table->string('fulfillment_channel')->nullable();
	      $table->string('order_status')->nullable();
	      $table->string('payment_date')->nullable();
	      $table->string('payment_method')->nullable();
	      $table->integer('payment_status')->nullable();
	      $table->integer('shipping_status')->nullable();
	      $table->string('currency')->nullable();
	      $table->decimal('shipping_charge')->nullable();
	      $table->decimal('discount')->nullable();
	      $table->decimal('discount_type')->nullable();
	      $table->text('note')->nullable();
	      $table->string('acount')->nullable();
	      $table->integer('mailclass_id')->nullable();
	      $table->integer('customer_id')->nullable();
	      $table->string('shipping_level')->nullable();
	      $table->string('status')->nullable();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_order');
	}

}
