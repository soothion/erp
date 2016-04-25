<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('core_cron', function($table) {
	      $table->engine = 'InnoDB';

	      $table->increments('id');
	      $table->timestamps();
	      $table->softDeletes();
	      $table->integer('channel_id');
	      $table->string('platform');
	      $table->text('config');
	      $table->integer('interval');
	      $table->string('account');
	      $table->integer('last');
	      $table->integer('next');

	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_cron');
	}

}
