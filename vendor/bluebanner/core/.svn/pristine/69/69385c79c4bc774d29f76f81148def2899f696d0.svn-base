<?php namespace Bluebanner\Core\Warehouse;

class IOType
{
	
	const PURCHASING = '1'; //采购入库

	const PURCHASING_RETUEN_VENDOR = '-1'; //采购退货单出库

	const CHECK_STOCK_IN = '2'; //盘盈入库

	const CHECK_STOCK_OUT = '-2'; //盘亏出库
	
	const MAKING_IN = '3'; //加工成品入库

	const MAKING_OUT = '-3'; //加工物料出库

	const SHIPMENT_IN = '4'; //shipment入库

	const SHIPMENT_OUT = '-4'; //shipment出库

	const SPLIT_IN = '5'; //拆分物料入库

	const SPLIT_OUT = '-5'; //拆分成品出库

	const OTHER_IN = '6'; //其他入库

	const OTHER_OUT = '-6'; //其他出库

	const ORDER_CLOSED_CANCEL = '7'; //订单取消库存回库

	const FBA_RETURN_IN = '8';

	const RMA_RESTOCK = '9'; //rma 检测回库


	/*
	* @desc 
	* 1.正负相对
	* 2.正数是入库
	* 3.负数是出库
	*/ 
	public static function getIOType(){
		return  array (
			'1'   => 'Purchasing', //采购入库
			'2'   => 'CheckStockIn', //盘盈入库
			'3'   => 'MakingIn', //加工成品入库
			'4'   => 'ShipmentIn', //shipment入库
			'5'   => 'SplitIn', //拆分物料入库
			'6'   => 'OtherIn', //其他入库
			'7'   => 'Order Closed Cancel', //订单取消库存回库
			'8'   => 'FBA Return In', //
			'9'   => 'RMA Restock', //rma 检测回库
			'-1'  => 'Purchasing Return Vendor', //采购退货单出库
			'-2'  => 'CheckStockOut', //盘亏出库
			'-3'  => 'MakingOut', //加工物料出库
			'-4'  => 'ShipmentOut', //shipment出库
			'-5'  => 'SplitOut', //拆分成品出库
			'-6'  => 'OtherOut', //其他出库
		);
	}
	
}
