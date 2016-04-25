<?php

use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_purchase_vendor', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('code', 100)->unique();
			$table->string('name', 30);
			$table->string('abbreviation', 30);
			$table->text('categorys_id');//类别可以多个，以","形式分隔开,可以为空
			$table->text('location')->nullable();
			$table->text('note')->nullable();
			$table->string('contact', 15)->nullable();
			$table->string('tel', 20)->nullable();
			$table->string('fax', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->text('contact_addr')->nullable();
			$table->text('delivery_addr')->nullable();
			$table->text('delivery_addr_ext')->nullable();
			$table->text('tax_registration_card')->nullable();//税务登记证号
			$table->text('business_license')->nullable();//营业执照
			$table->decimal('registered_capital', 7, 2);//注册资金
			//$table->enum('payment_method', array('cash', 'terms'));
			//付款方式--变成账期1，自己填写
			$table->string('payment_method',50);

			$table->decimal('discount_rate', 7, 1);
			//$table->smallinteger('payment_period', 7)->unsigned();
			//帐期 -> 变成账期2，自己填写
			$table->string('payment_period',50);
			
			$table->enum('status', array('normal', 'expired'));
			$table->string('qq', 15);
			$table->text('home_page')->nullable();//网站，采购部要求加的
			$table->decimal('payment_credit_limit', 7, 1);//信用额度
			$table->string('developer',50);
		});
		
		//供应商报价
		Schema::create('core_purchase_vendor_quotation', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('vendor_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->boolean('if_primary');
			$table->decimal('unit_price', 7, 2);
			$table->decimal('tax_unit_price', 7, 2);
			$table->decimal('usd_unit_price', 7, 2);
			$table->smallinteger('moq')->unsigned();
			$table->smallinteger('spq')->unsigned();
			$table->string('um', 20)->nullable();
			$table->enum('price_type', array('normal', 'tax', 'usd'));
			$table->string('currency', 5);
			$table->decimal('tax_rate', 7, 2);
			$table->decimal('invoice_rate', 7, 2);
			$table->smallinteger('lead_time')->unsigned();//交货期
			$table->integer('agent')->unsigned()->nullable();
			$table->integer('audit')->unsigned()->nullable();

			
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->unique(array('vendor_id','item_id'));//报价是按照供应商＋sku，这2个增加唯一索引
		});

		//报价日志,可用来查看历史报价（当更改新的价格信息插入此表）
		// 先不管
		Schema::create('core_purchase_vendor_quotation_log', function($table) {
			$table->engine = 'InnoDB';
			$table->integer('id');//不要主键
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('vendor_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->decimal('unit_price', 7, 2);
			$table->decimal('tax_unit_price', 7, 2);
			$table->decimal('usd_unit_price', 7, 2);
			$table->smallinteger('moq')->unsigned();
			$table->smallinteger('spq')->unsigned();
			$table->enum('price_type', array('normal', 'tax', 'usd'));
			$table->string('currency', 5);
			$table->decimal('tax_rate', 7, 2);
			$table->decimal('invoice_rate', 7, 2);
			$table->integer('lead_time',2);//交货期
			
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->unique(array('vendor_id','item_id'));//报价是按照供应商＋sku，这2个增加唯一索引
		});

		//每个sku默认的供应商和最小包装数量
		Schema::create('core_purchase_sku_default', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('item_id')->unsigned()->unique();
			$table->integer('vendor_id')->unsigned();

			$table->smallinteger('spq')->unsigned();//最小包装数，如果默认供应商选定了，可以从报价表中代出，可改
			$table->enum('price_type', array('normal', 'tax', 'usd'));

			
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		//PR
		Schema::create('core_purchase_request', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('agent')->unsigned();
			$table->integer('platform_id')->unsigned();
			// 目的仓
			$table->integer('warehouse_id')->unsigned();//指定的采购仓
			$table->integer('relation_id')->unsigned();//关联的订单号
			$table->string('invoice', 50)->unique();
			$table->enum('status', array('pending' ,'confirmed', 'verified', 'rejected', 'deleted', 'expired', 'completed'));
			$table->text('note')->nullable();

			$table->timestamp('expired_at');
			$table->timestamp('verified_at');
			$table->integer('verified_agent')->unsigned();
			$table->text('verified_note')->nullable();

			/*
			----------------type description---------------------
			1.Order Direct  －－》(direct request)指定后不需要入库，直接告知供应商发货地址发货
			2.Order  －－》(order local request)指定后入库直接改变订单为打印状态
			3.Shipment   －－》(shipment reqeust)指定后需要转仓(非本地仓库申请)
			4.Local   －－》(local request)指定后直接入库(本地仓库申请)－默认
			----------------type description---------------------
			*/
			$table->enum('type', array('Order Direct', 'Order','Shipment','Local'));
			$table->foreign('agent')->references('id')->on('users');
			$table->foreign('platform_id')->references('id')->on('core_platform_master');
			$table->foreign('verified_agent')->references('id')->on('users');
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
		});
		
		//PRD
		Schema::create('core_purchase_request_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('request_id')->unsigned();
			$table->integer('platform_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();//只能销售人员改
			$table->timestamp('end_date')->nullable();//期望的交货日期
			$table->enum('transportation', array('surface', 'air', 'sea','N/A'));//用户没有指定默认海运，否则根据期望时间判断，10天以内是空运
			$table->text('note')->nullable();

			$table->foreign('request_id')->references('id')->on('core_purchase_request');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});

		// 待定 针对所有仓库创建一个只用于备货的子集
		Schema::create('core_purchase_warehouse', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();

			$table->integer('warehouse_id')->unsigned();
			$table->string('alias');

			$table->foreign('warehouse_id')->references('id')->on('core_purchase_warehouse');
		});
		
		//采购计划主表
		Schema::create('core_purchase_plan', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->string('invoice', 50)->unique();	
			$table->string('name', 50)->text()->nullable();	
			$table->enum('status', array('open', 'confirmed'))->default('open');
			$table->integer('agent')->unsigned();		

			$table->foreign('agent')->references('id')->on('users');
		});

		//采购计划明细表，计划表需要合并，可以暂时不考虑
		Schema::create('core_purchase_plan_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('plan_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('warehouse_id')->unsigned();
			
			$table->smallinteger('request_qty')->unsigned()->default(0);

			$table->smallinteger('stock_qty')->unsigned()->default(0);//仓库可用库存－－当时或者实时
			$table->smallinteger('real_qty')->unsigned()->default(0);//
			$table->smallinteger('to_purchase_qty')->unsigned()->default(0);//
			$table->smallinteger('shipment_qty')->unsigned()->default(0);//记录已经创建了shipment的数量，类似库存的操作


			$table->enum('status', array('pending' ,'purchasing','completely purchased','shipping' ,'completely shipped','closed'))->default('pending');
			$table->enum('transportation', array('air', 'sea','N/A'));

			$table->foreign('plan_id')->references('id')->on('core_purchase_plan');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});

		Schema::create('core_purchase_plan_detail_adjustment', function ($table) {
			$table->engine = "InnoDB";
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('plan_detail_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->smallinteger('qty_from')->unsigned();
			$table->smallinteger('qty_to')->unsigned();
			$table->text('note');

			$table->foreign('plan_detail_id')->references('id')->on('core_purchase_plan_detail');
			$table->foreign('agent')->references('id')->on('users');
		});

		Schema::create('core_purchase_request_plan_log', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('request_detail_id')->unsigned();
			$table->integer('plan_detail_id')->unsigned();
			$table->decimal('percent', 5, 4)->unsigned();
			
			$table->foreign('request_detail_id')->references('id')->on('core_purchase_request_detail');
			$table->foreign('plan_detail_id')->references('id')->on('core_purchase_plan_detail');
		});

		// PO
		Schema::create('core_purchase_order', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->integer('vendor_id')->unsigned();
			$table->string('invoice', 50)->unique();
			$table->enum('status', array('pending', 'confirmed', 'stocking','partially received', 'completely received', 'cancelled'));
			$table->string('currency', 5);
			$table->decimal('currency_rate', 7, 2);
			$table->decimal('tax_rate', 7, 2);
			$table->decimal('invoice_rate', 7, 4);
			$table->decimal('discount', 7, 2);
			$table->decimal('total', 7, 2);
			
			$table->string('ship_to', 50)->nullable();
			$table->string('vendor_invoice', 50)->nullable();
			$table->string('vendor_invoice_note', 30)->nullable();
			$table->text('note')->nullable();
			
			$table->string('payment_method', 50);
			$table->string('payment_terms', 10)->nullable();
			$table->string('payment_dates', 50);
			$table->timestamp('due_date')->nullable();
			$table->timestamp('delivery_date')->nullable();
			$table->integer('plan_id')->unsigned()->nullable();
			$table->enum('price_type', array('normal', 'tax', 'usd'));//加一个含税与否的选项

			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
		});
		
		Schema::create('core_purchase_order_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('order_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->string('size', 30)->nullable();
			$table->smallinteger('qty')->unsigned();
			$table->smallinteger('qty_confirmed')->unsigned();
			$table->smallinteger('qty_free')->unsigned();
			$table->string('um', 50)->nullable();
			$table->decimal('tax_unit_price', 7, 2);
			$table->decimal('usd_unit_price', 7, 2);
			$table->decimal('unit_price', 7, 2);
			$table->decimal('discount', 7, 2);
			$table->decimal('total', 7, 2);
			$table->string('specification', 255)->nullable();
			
			$table->foreign('order_id')->references('id')->on('core_purchase_order');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});

		//申购单明细，采购单明细，采购计划明细对应表(日志表)
		Schema::create('core_purchase_plan_order_log', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('plan_detail_id')->unsigned();
			$table->integer('order_detail_id')->unsigned();

			$table->foreign('plan_detail_id')->references('id')->on('core_purchase_plan_detail');
			$table->foreign('order_detail_id')->references('id')->on('core_purchase_order_detail');
		});

		//采购计划中变成shipment的日志记录，再调度计划中生成
		Schema::create('core_purchase_plan_ship_log', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('plan_id')->unsigned();
			$table->integer('shipment_id')->unsigned();

			$table->integer('plan_detail_id')->unsigned();
			$table->integer('shipment_detail_id')->unsigned();

			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();//生成采购单得数量

			$table->foreign('plan_id')->references('id')->on('core_purchase_plan');
			$table->foreign('shipment_id')->references('id')->on('core_storage_shipment_master');
			$table->foreign('plan_detail_id')->references('id')->on('core_purchase_plan_detail');
			$table->foreign('shipment_detail_id')->references('id')->on('core_storage_shipment_detail');
		});


		// Return
		Schema::create('core_purchase_return', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('invoice', 50)->unique();
			$table->enum('status', array('pending', 'confirmed', 'stocking', 'completely'));
			$table->integer('vendor_id')->unsigned();
			$table->integer('warehouse_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->timestamp('return_at')->nullable();
			$table->text('address')->nullable();
			$table->text('note')->nullable();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
			$table->foreign('agent')->references('id')->on('users');
		});
		
		Schema::create('core_purchase_return_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('return_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->text('description')->nullabel();//类别可以多个，以","形式分隔开
			$table->string('um', 20);
			$table->smallinteger('qty')->unsigned();
			$table->text('reason')->nullable();
			$table->text('note')->nullabel();//类别可以多个，以","形式分隔开
		
			
			$table->foreign('return_id')->references('id')->on('core_purchase_return');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_purchase_request_plan_log');
		Schema::drop('core_purchase_plan_order_log');
		Schema::drop('core_purchase_plan_ship_log');
		Schema::drop('core_purchase_vendor_quotation_log');

		Schema::drop('core_purchase_order_detail');		
		Schema::drop('core_purchase_order');
		
		Schema::drop('core_purchase_return_detail');
		Schema::drop('core_purchase_return');
		
		//Schema::drop('core_purchase_request_split');
		Schema::drop('core_purchase_request_detail');
		Schema::drop('core_purchase_request');
		
		Schema::drop('core_purchase_vendor_quotation');

		Schema::drop('core_purchase_sku_default');
		Schema::drop('core_puchase_plan_adjustment');
		Schema::drop('core_purchase_plan_detail');
		Schema::drop('core_purchase_plan');
		Schema::drop('core_purchase_vendor');
	}

}
