<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('core_order_detail', function($table) {
	      $table->engine = 'InnoDB';

	      $table->increments('id');
	      $table->timestamps();
	      $table->softDeletes();
	      $table->integer('order_id')->nullable();
	      $table->string('third_party_order_id')->nullable();
	      $table->string('sku')->nullable();
	      $table->string('market_item_id')->nullable();
	      $table->integer('quantity')->nullable();
	      $table->decimal('sales_price')->nullable();
	      $table->integer('invd_id')->nullable();

	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_order_detail');
	}

}
