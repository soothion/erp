<?php namespace Bluebanner\Core\Warehouse;

interface StockIOServiceInterface {
	/**
	 * 创建入库单
	 *
	 * @param      (array)$stockin			主表字段数组
	 * @param 	   (array)$detail		    明细表字段数组
	 * @return     int
	*/		
	public function createStockIN(array $stockin, array $detail);

	/**
	 * 创建出库单
	 * @param      (array)$stockin			主表字段数组
	 * @param 	   (array)$detail		    明细表字段数组
	 * @return     int
	 * @return     int
	*/		
	public function createStockOut(array $stockout, array $detail);

	/**
	 * 拆分入库单
	 *
	 * @param      (int)$id			
	 * @return     int
	*/		
	public function splitStockIn($id,$agent,array $details);

	/**
	 * 拆分出库单
	 *
	 * @param      (int)$item_id			item的id
	 * @return     int
	*/		
	public function splitStockOut($id,$agent,array $details);

	/**
	 * 按照relation id查询
	 *
	 * @param      $relation_id 
	 * @param 	   $type
	 * @return     返回对应type＋relation_id的出入库单信息
	*/		
	public function stockFindByRelationID($relation_id,$type);

	/**
	 * 单个出入库单查询
	 *
	 * @param      
	 * @param 	   
	 * @return     
	*/		
	public function stockFindByID($id);

	/**
	 * 按照查询条件查询
	 *
	 * @param       (arrary)$search_condition 
	 * @param 	   
	 * @return     
	*/		
	public function stockFindByCondition(array $search_condition);

	/**
	 * 入库单入库
	 * 1.更改入库单状态
	 * 2.更改对应单据的状态
	 * 3.更新库存数据[状态，价格，po_id]
	 * @param     $stockin_id 入库单id
	 * @param 	  
	 * @return     
	*/		
	public function stockIn($stockin_id,$agent);

	/**
	 * 出库单出库
	 *
	 * @param      $stockout_id 出库单id
	 * @param 	   
	 * @return     
	*/		
	public function stockOut($stockout_id,$agent);
	
	/**
	 * 查找所有item_id为@item_id的列的io_id(主表主键)
	 * @param interge  $item_id
	 *
	 * @return array io_id的集合
	 *
	 */
	
	public function getMasterIdFromDetailByItemId($item_id);
}
