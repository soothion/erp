<?php

use Illuminate\Database\Migrations\Migration;

class CreateExchangeRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('core_exchange_rate_usd', function($table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->timestamps();
      $table->softDeletes();

      $table->string('fr_currency', 10);
      $table->string('fr_name', 100);
      $table->string('fr_um', 50);
      $table->string('to_currency', 10);
      $table->string('to_name', 100);
      $table->string('to_um', 50);
      $table->decimal('rate', 8, 2);
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::drop('core_exchange_rate_usd');
	}

}
