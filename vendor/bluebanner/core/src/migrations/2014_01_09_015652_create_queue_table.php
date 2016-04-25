<?php

use Illuminate\Database\Migrations\Migration;

class CreateQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_queue_item_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();

			$table->integer('agent')->unsigned();
			$table->string('filename');
			$table->smallInteger('total')->unsigned();
			$table->smallInteger('approved')->unsigned();
			$table->smallInteger('pending')->unsigned();
			$table->smallInteger('reject')->unsigned();
			$table->smallInteger('error')->unsigned();

			$table->foreign('agent')->references('id')->on('users');
		});

		Schema::create('core_queue_item_error', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('queue_id')->unsigned();
			$table->text('content');
			$table->string('desc');

			$table->foreign('queue_id')->references('id')->on('core_queue_item_master');
		});

		Schema::create('core_queue_image_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();

			$table->integer('agent')->unsigned();
			$table->string('filename');
			$table->smallInteger('total')->unsigned();
			$table->smallInteger('approved')->unsigned();
			$table->smallInteger('pending')->unsigned();
			$table->smallInteger('reject')->unsigned();
			$table->smallInteger('error')->unsigned();

			$table->foreign('agent')->references('id')->on('users');
		});

		Schema::create('core_queue_image_error', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('queue_id')->unsigned();
			$table->text('content');
			$table->string('desc');

			$table->foreign('queue_id')->references('id')->on('core_queue_image_master');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_queue_image_error');
		Schema::drop('core_queue_image_master');

		Schema::drop('core_queue_item_error');
		Schema::drop('core_queue_item_master');
	}

}