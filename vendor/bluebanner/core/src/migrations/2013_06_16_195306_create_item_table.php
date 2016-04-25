<?php

use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('core_item_category', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('name', 150)->unique();
			
		});
		
		Schema::create('core_item_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			// 基本参数
			$table->string('sku', 30)->unique();
			$table->text('description');
			$table->integer('category_id')->unsigned();
			$table->enum('status', array('新', '比较新', '正常', '夕阳', '停止'));

			$table->boolean('is_active')->default(0);
			$table->boolean('is_drop')->default(0);
			$table->boolean('is_virtual')->default(0);
			$table->boolean('is_hold_inv')->default(0);
			
			// 物流参数（产品）
			$table->smallInteger('product_length')->unsigned();
			$table->smallInteger('product_width')->unsigned();
			$table->smallInteger('product_height')->unsigned();
			$table->smallInteger('product_weight')->unsigned();

			// 物流参数（包装）
			$table->smallInteger('packing_length')->unsigned();
			$table->smallInteger('packing_width')->unsigned();
			$table->smallInteger('packing_height')->unsigned();
			$table->smallInteger('packing_weight')->unsigned();
			$table->smallInteger('packing_quantity')->unsigned();
			$table->smallInteger('pallet_quantity')->unsigned()->nullable();

			// 物流参数（外箱）
			$table->smallInteger('carton_length')->unsigned();
			$table->smallInteger('carton_width')->unsigned();
			$table->smallInteger('carton_height')->unsigned();
			$table->decimal('carton_weight', 7, 2)->unsigned();

			// 物流
			$table->string('hs_model');
			$table->string('hs_desc_cn');
			$table->string('hs_desc_en');

			$table->string('hs_code_cn');
			$table->string('hs_code_us');
			$table->string('hs_code_eu');
			$table->string('hs_code_uk');
			$table->string('hs_code_jp');
			
			$table->decimal('hs_drawback_cn', 5, 2);
			$table->decimal('hs_tariff_us', 5, 2);
			$table->decimal('hs_tariff_eu', 5, 2);
			$table->decimal('hs_tariff_uk', 5, 2);
			$table->decimal('hs_tariff_jp', 5, 2);

			// 品牌
			$table->string('brand');
			$table->boolean('packing_color_box')->default(0);
			$table->enum('instructions', array('千岸说明书', '供应商说明书'))->nullable();
			$table->boolean('silk_screen')->default(0);
			$table->text('certification')->nullable();
			$table->text('remark')->nullable();
			$table->boolean('warranty_card')->default(0);

			$table->integer('agent')->unsigned();
			
			$table->foreign('category_id')->references('id')->on('core_item_category');
			$table->foreign('agent')->references('id')->on('users');
		});

		Schema::create('core_item_language', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('name', 50);
	    });

		// 产品-语言 一对一
		Schema::create('core_item_instruction', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('item_id')->unsigned();
			$table->integer('lang_id')->unsigned();
			$table->string('original', 100);
			$table->string('mime', 100);
			$table->smallInteger('version')->unsigned()->default(0);
			$table->integer('agent')->unsigned();

			// 说明书对于产品的每个语言，都只有一个
			$table->unique(array('item_id', 'lang_id'));

			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('lang_id')->references('id')->on('core_item_language');
			$table->foreign('agent')->references('id')->on('users');
		});

		// 产品-语言 一对一
		Schema::create('core_item_attribute', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('item_id')->unsigned();
			$table->integer('lang_id')->unsigned();
			$table->string('title');
			$table->text('detail');
			$table->text('detail_html');
			$table->integer('agent')->unsigned();

			// 属性对于产品的每个语言，都只有一个
			$table->unique(array('item_id', 'lang_id'));

			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('lang_id')->references('id')->on('core_item_language');
			$table->foreign('agent')->references('id')->on('users');
		});

	    Schema::create('core_item_keyword', function($table) {
	    	$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('item_id')->unsigned();
			$table->integer('lang_id')->unsigned();
			$table->string('keyword');
			$table->integer('agent')->unsigned();

			$table->index('keyword');

			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('lang_id')->references('id')->on('core_item_language');
			$table->foreign('agent')->references('id')->on('users');
	    });

		Schema::create('core_item_feature', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('item_id')->unsigned();
			$table->integer('lang_id')->unsigned();
			$table->string('feature');
			$table->integer('agent')->unsigned();

			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('lang_id')->references('id')->on('core_item_language');
			$table->foreign('agent')->references('id')->on('users');
		});

		Schema::create('core_item_image', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('item_id')->unsigned();
			$table->string('desc', 50);
			$table->string('thumb', 100);
			$table->string('original', 100);
			$table->string('mime', 100);
			$table->smallInteger('version')->unsigned()->default(0);
			$table->integer('agent')->unsigned();

			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('agent')->references('id')->on('users');
		});

		Schema::create('core_item_bom', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('parent_id')->unsigned();
			$table->integer('child_id')->unsigned();
			$table->smallInteger('qty')->default(1);
			$table->integer('agent')->unsigned();
			$table->text('note')->nullable();

			$table->foreign('parent_id')->references('id')->on('core_item_master');
			$table->foreign('child_id')->references('id')->on('core_item_master');
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

		Schema::drop('core_item_bom');
		Schema::drop('core_item_image');
		Schema::drop('core_item_feature');
		Schema::drop('core_item_keyword');
		Schema::drop('core_item_attribute');
		Schema::drop('core_item_instruction');
		Schema::drop('core_item_language');

		Schema::drop('core_item_master');
		Schema::drop('core_item_category');
		
	}

}
