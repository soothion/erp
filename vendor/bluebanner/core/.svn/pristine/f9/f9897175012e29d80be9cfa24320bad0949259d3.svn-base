<?php

use Illuminate\Database\Migrations\Migration;

class CreateCostParams extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    // 运费系数
	    
	    Schema::create('core_purchase_cost_params',
	    
	    function  ($table)
	    
	    {
	    
	        $table->engine = 'InnoDB';
	    
	        $table->increments('id');
	    
	        $table->timestamps();
	    
	        $table->softDeletes();
	    
	    
	    
	        $table->integer('warehouse_id')->unsigned();
	    
	        $table->integer('item_id')->unsigned();
	    
	        $table->float('air_cost');
	        $table->float('sea_cost');
	    
	         
	    
	        $table->foreign('warehouse_id')
	    
	        ->references('id')
	    
	        ->on('core_storage_warehouse');
	    
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	    Schema::drop('core_purchase_cost_params');
	}

}