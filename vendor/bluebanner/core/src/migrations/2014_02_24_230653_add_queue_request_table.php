<?php

use Illuminate\Database\Migrations\Migration;

class AddQueueRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		
		Schema::create('core_queue_request_master', function($table) {
			$table -> engine = 'InnoDB';
			$table -> increments('id');
			$table -> timestamps();

			$table -> integer('agent') -> unsigned();
			$table -> string('filename');
			$table -> smallInteger('total') -> unsigned();
			$table -> smallInteger('request_id') -> unsigned();
			$table -> smallInteger('approved') -> unsigned();
			$table -> smallInteger('pending') -> unsigned();
			$table -> smallInteger('reject') -> unsigned();
			$table -> smallInteger('error') -> unsigned();

			$table -> foreign('agent') -> references('id') -> on('users');
		});
			Schema::create('core_queue_request_error', function($table) {
			$table -> engine = 'InnoDB';
			$table -> increments('id');
			$table -> integer('queue_id') -> unsigned();
			$table -> text('content');
			$table -> string('desc');

			$table -> foreign('queue_id') -> references('id') -> on('core_queue_request_master');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('core_queue_request_error');
		Schema::drop('core_queue_request_master');

	}

}
