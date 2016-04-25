<?php namespace Bluebanner\Core\Inventory;

class bookStatus
{
	
	const PENDING = 'pending'; //未入库

	const DONE = 'done'; //已入库

	const CANCEL = 'cancel'; //book


	/*
	* @desc 
	* 1.正负相对
	* 2.正数是入库
	* 3.负数是出库
	*/
	public static function getStatus(){
		return  array (
			'pending'   => 'pending', //未入库
			'done'   => 'done', //已入库
			'cancel'   => 'cancel', //book
		);
	}
	
}
