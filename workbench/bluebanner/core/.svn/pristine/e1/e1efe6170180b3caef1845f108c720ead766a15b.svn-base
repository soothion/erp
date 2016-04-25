<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonQueueAndLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_queue_master', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();

      $table->string('action');
      $table->string('params');
      $table->integer('agent')->unsigned();
      $table->string('filename');
      $table->smallInteger('total')->unsigned()->default(0);
      $table->smallInteger('approved')->unsigned()->default(0);
      $table->smallInteger('pending')->unsigned()->default(0);
      $table->smallInteger('reject')->unsigned()->default(0);
      $table->smallInteger('error')->unsigned()->default(0);

      $table->foreign('agent')->references('id')->on('users');
      $table->index('action');
    });

    Schema::create('core_queue_error', function ($table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->timestamps();

      $table->integer('queue_id')->unsigned();
      $table->smallInteger('line')->unsigned();
      $table->text('content');
      $table->string('desc');

      $table->foreign('queue_id')->references('id')->on('core_queue_master');
    });
  }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::drop('core_queue_error');
		Schema::drop('core_queue_master');
	}

}
