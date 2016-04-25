<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoragePurchase extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('core_storage_purchase_master', function ($table) {
      $table->engine = 'InnoDB';

      $table->increments('id');
      $table->timestamps();
      $table->softDeletes();
      $table->integer('agent')->unsigned();
      $table->integer('po_id')->unsigned();
      $table->integer('vendor_id')->unsigned();
      $table->decimal('rate', 5, 2);
      $table->decimal('discount', 5, 2);
      $table->string('relation_invoice', 50);
      $table->enum('status', array('todo', 'doing', 'done'))->default('todo');
      $table->integer('warehouse_id')->unsigned();
      $table->mediumText('note');

      $table->foreign('agent')->references('id')->on('users');
      $table->foreign('po_id')->references('id')->on('core_purchase_order');
      $table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
      $table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
    });

    Schema::create('core_storage_purchase_detail', function ($table) {
      $table->engine = 'InnoDB';

      $table->increments('id');
      $table->timestamps();
      $table->softDeletes();
      $table->integer('master_id')->unsigned();
      $table->integer('item_id')->unsigned();
      $table->integer('platform_id')->unsigned();
      $table->integer('po_detail_id')->unsigned();
      $table->integer('agent')->unsigned();
      $table->integer('qty')->unsigned();
      $table->integer('qty_rest')->unsigned();
      $table->integer('qty_free')->unsigned()->default(0);
      $table->decimal('rmbprice', 5, 2);
      $table->decimal('discount', 5, 2);

      $table->foreign('agent')->references('id')->on('users');
      $table->foreign('platform_id')->references('id')->on('core_platform_master');
      $table->foreign('master_id')->references('id')->on('core_storage_purchase_master');
      $table->foreign('po_detail_id')->references('id')->on('core_purchase_order_detail');
      $table->foreign('item_id')->references('id')->on('core_item_master');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('core_storage_purchase_master');
    Schema::drop('core_storage_purchase_detail');
  }

}
