<?php namespace Bluebanner\Core\Warehouse;

class IOStatus
{
	
	const NOT_STOCK = '0'; //未入库

	const STOCKED = '1'; //已入库

	const BOOKED = '2'; //book

	/*
	* @desc 
	* 1.正负相对
	* 2.正数是入库
	* 3.负数是出库
	*/
	public static function getStatus(){
		return  array (
			'0'   => 'Not Stock',
			'1'   => 'Stocked',
			'2'   => 'Booked',
		);
	}
	
}
