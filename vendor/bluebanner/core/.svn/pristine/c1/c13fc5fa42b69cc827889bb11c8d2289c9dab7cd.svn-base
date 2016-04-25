<?php namespace Bluebanner\Core\Inventory;

interface InventoryBookServiceInterface {
	/**
	* book 库存
	* 一个完整的单调用一次这个含税，方便判断是否缺库存
	* @param (array) $arr 
	*	array(
	*		relation_id => 1,  //order_id / oi_id
	*		type => 'io/order',
	*		warehouse_id => 1,
	*		details => array(
	*			relation_detail_id => 1,  //order_detail_id / oi_detail_id
	* 			item_id	=> 1,
	* 			qty	=> 1,
	*		)
	*	)
	* 
	* @method 
	* 1.库存加hold，数量
	* 2.插入数据到book表
	* //以前是先搜索所有sku,
	*/
	public function bookInventory(array $arr);

	/*查找对应相关id的book信息*/
	public function getBookInfoByRelationId($type,$relation_id,$status);

	/**
	* 解除book 库存
	*
	* @param
	* @desc 
	*/
	public function offBookInventory($relation_id,$type,$tostatus);

	/*
	* 更改book记录状态
	*/
	public function changeStatus($relation_id,$fStatus,$tStatus,$type);
}