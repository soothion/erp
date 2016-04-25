<?php

use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_audit_master', function ($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();

			$table->morphs('type');
			$table->integer('agent')->unsigned();
			$table->boolean('assessment');
			$table->string('note')->nullable();

			$table->foreign('agent')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_audit_master');
	}

}