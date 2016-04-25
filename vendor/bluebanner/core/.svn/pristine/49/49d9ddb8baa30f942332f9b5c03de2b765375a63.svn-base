<?php

use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('core_inventory_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
			$table->smallInteger('book_qty')->unsigned()->default(0);
                        $table->smallInteger('extra_qty')->unsigned()->default(0);
			$table->integer('platform_id')->unsigned();
			$table->decimal('rmbprice', 8, 2)->nullable();
			$table->decimal('localprice', 8, 2)->nullable();
			$table->decimal('pi_price', 8, 2)->nullable();
			$table->integer('restock_id')->nullable();
			$table->boolean('status')->default(0);
			$table->timestamp('io_at')->nullable();
			$table->integer('po_id')->nullable();
			
			$table->enum('condition', array('normal', 'like new', 'used', 'defective'))->default('normal');
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('platform_id')->references('id')->on('core_platform_master');
			
			// TODO: add when IO is OK
			// $table->foreign('restock_id')->references('id')->on();
		});
		
		Schema::create('core_inventory_book', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('inventory_id')->unsigned();
			$table->integer('relation_id')->unsigned();
			$table->integer('relation_detail_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
      $table->smallInteger('extra_qty')->unsigned();
			$table->enum('type', array('order', 'io'));
			$table->enum('status', array('pending', 'done', 'cancel'))->default('pending');
			
			$table->foreign('inventory_id')->references('id')->on('core_inventory_master');
		});
		
		Schema::create('core_inventory_change', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('inventory_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('relation_id')->unsigned();
			$table->integer('agent')->unsigned();
			// TODO change to enum type
			$table->smallInteger('type')->nullable();
			
			$table->text('description')->nullable();
			$table->smallInteger('qty');
			$table->smallInteger('balance')->unsigned();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('inventory_id')->references('id')->on('core_inventory_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('agent')->references('id')->on('users');
		});
		
		Schema::create('core_inventory_allocate', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('from_platform_id')->unsigned();
			$table->integer('to_platform_id')->unsigned();
			$table->integer('from_inventory_id')->unsigned();
			$table->integer('to_inventory_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
			$table->integer('sender')->unsigned();
			$table->integer('receiver')->unsigned();
			$table->enum('status', array('completed', 'requested', 'received', 'rejected', 'cancelled'))->default('requested');
			$table->enum('type', array('channel', 'prepare', 'cron'))->default('channel');
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('from_platform_id')->references('id')->on('core_platform_master');
			$table->foreign('to_platform_id')->references('id')->on('core_platform_master');
			$table->foreign('from_inventory_id')->references('id')->on('core_inventory_master');
			$table->foreign('to_inventory_id')->references('id')->on('core_inventory_master');
			$table->foreign('sender')->references('id')->on('users');
			$table->foreign('receiver')->references('id')->on('users');
		});


		Schema::create('core_inventory_daily_log', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
			$table->integer('restock_id');
			$table->enum('condition', array('normal', 'like new', 'used', 'defective'))->default('normal');
			$table->boolean('status')->default(0);
			$table->timestamp('date')->nullable();
						
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
		Schema::drop('core_inventory_allocate');
		Schema::drop('core_inventory_change');
		Schema::drop('core_inventory_book');		
		Schema::drop('core_inventory_master');
		Schema::drop('core_inventory_daily_log');
	}

}
