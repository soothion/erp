<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StorageTransfer extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('core_storage_transfer_ask', function($table) {
      $table->engine = 'InnoDB';

      $table->increments('id');
      $table->timestamps();
      $table->softDeletes();
      $table->integer('from_platform_id')->unsigned();
      $table->integer('to_platform_id')->unsigned();
      $table->enum('status', array('pending', 'confirmed', 'rejective', 'finish'));
      $table->integer('warehouse_id')->unsigned();
      $table->integer('item_id')->unsigned();
      $table->integer('qty');

      $table->foreign('from_platform_id')->references('id')->on('core_platform_master');
      $table->foreign('to_platform_id')->references('id')->on('core_platform_master');
      $table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
      $table->foreign('item_id')->references('id')->on('core_item_master');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('core_storage_transfer_ask');
  }

}
