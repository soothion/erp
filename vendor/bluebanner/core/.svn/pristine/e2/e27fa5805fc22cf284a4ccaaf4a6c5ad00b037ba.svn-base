<?php namespace Bluebanner\Core\Warehouse;


interface OtherStorageServiceInterface {
	
	/*
	 * 
	 * 一次性建 master 与  details
	 * 
	 */
	public function createOther($master,$details);
	
	
	/**
	 * 创建其他出入库单
	 *
	 * @param      (array)storage_other_master		主表字段数组	
	 * @return     int  
	*/		
	public function createOtherMaster(array $master);
	
	/**
	 * 创建其他出入库单 明显
	 *
	 * @param      array((array))storage_other_master		明细表表字段数组
	 * @return    
	 */
	
	public function createOtherDetails($masterId,array $details);
	
	public function createOtherDetail($masterId,array $detail);
	
	//更新主表
	public function updateOtherMaster($id,$masterInfo);
	
	//更新明细表
	public function updateOtherDetail($id,$detailInfo);

	/**
	 * 单个出入库单查询
	 *
	 * @param      
	 * @param 	   
	 * @return     
	*/		
	public function findOtherByID($id);

	/**
	 * 按照查询条件查询
	 *
	 * @param       (arrary)$search_condition 
	 * @param 	   
	 * @return     
	*/		
	public function findOtherByCondition(array $search_condition);

	//删除master by id
	public function deleteOtherMaster($id);
	
	//删除DETAIL by id
	public function deleteOtherDetail($id);
	
	//获取状态list
	public function getStatus();
	
	//根据masterid 改 sku
	public function updateOtherDetailItemIdByMasterId($masterId,$fromItemId,$toItemId);

	//查找所有item_id为@sku的列的other_id(主表主键)
	public function getMasterIdFromDetailByItemSku($sku);

	//查找所有item_id为@item_id的列的other_id(主表主键)
	public function getMasterIdFromDetailByItemId($item_id);
	

}
