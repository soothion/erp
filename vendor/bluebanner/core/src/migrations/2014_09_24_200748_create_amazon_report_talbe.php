<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmazonReportTalbe extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('core_amazon_report', function($table) {
	      $table->engine = 'InnoDB';

	      $table->increments('id');
	      $table->timestamps();
	      $table->softDeletes();
	      $table->string('report_id');
	      $table->string('report_type');
	      $table->string('available_date');

	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_amazon_report');
	}

}
