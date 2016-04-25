<?php namespace Bluebanner\Core\Inventory;

interface InventoryServiceInterface {

	/**
	 * 实时库存查询
	 */
	public function query($warehouse_id, $item_id, array $status, array $condition);

	/**
	* 按条件查询库存
	*
	* @param (array)$condition (field as follow)
 	* 		  array(item_id				//item的id
	* 				account_id			//没有此条件，查询的是所有渠道库存
	* 				warehouse_id		//0:指所有仓库的库存，其它具体仓库库库存
	*				status             	//0:在途库存 1:实际库存
	* 				condition       	//对应的库存状态(Normal,New... )
	* 				inventory_id		//库存id号	
	*			)
	*
	*/
	public function inventoryFindByCondition(array $search_condition = null);
	

	/**
	* 查询可用库存库存(指出实际库存－book) 并且 是实际的库存的库存记录
	* @param (array)$condition (field as follow)
 	* 		  array(item_id				//item的id
	* 				account_id			//(-1)要查询所有渠道;(0)查询公共库存
	* 				warehouse_id		//0:指所有仓库的库存，其它具体仓库库库存
	* 				condition       	//对应的库存状态(Normal,New... )
	* 				inventory_id		//库存id号	
	*			)
	* 
	*/
	public function validInventory(array $condition = null);
	
	public function validQtySumByItem($warehouse_id,$account_id = '',$item_id);

	public function getQtySumByItem($warehouse_id,$account_id = '',$item_id,$condition ='normal',$status = '1');

	public function deleteOroadInventoryByRestock($restock_id);

	/**
	* 扣除库存--根据book的完成记录，减去库存数量，不删库存表记录
	* 
	* @param
	* 
	*/
	public function cutQuantityByBooked($relation_id,$booktype,$io_type,$agent);
	
	/**
	* 反出库，此时按照book的记录将库存加回去
	* 
	* @param
	* 
	*/
	public function addQuantityByRevrese($relation_id,$booktype,$io_type,$agent);

	/**
	* 扣除库存--减去数量，不删库存表记录
	* 
	* @param $restock_id 对应入库单id
	* 
	*/
	public function cutQuantityByRevrese($restock_id,$io_type,$agent,$do_type);


	/**
	* 更新库存
	* 
	* @param
	*  
	*/
	public function updateInventoryByRestock($restock_id,$type,$status,$item_price = array(),$po_id ='',$description);
	

	/**
	* 更新其入库，库存价格，及状态
	*/
	public function updateInventoryByLastRecord($restock_id,$type,$status,$description);

	/**
	* 
	* 获取仓库最后出库批次SKU的记录,一般
	* @param $item_id
	* @param $condition
	* @param $whid
	* @return array
	*/
	public function getLastRecord($item_id, $whid,$condition = 'normal');

	/**
	* 创建库存记录
	*
	* @param $id 被复制的库存id
	* @return array
	*/
	public function copyInventoryRecord($id);

	/**
	* 创建库存记录
	*
	* @param
	*  
	*/
	public function addInventoryRecord(array $detail,$log = 0);

	/**
	* 写库存日志
	* 
	* @param
	*  
	*/
	public function writeToLog(array $log);

	/**
	*
	* 检测库存，如果出现负数的，立刻写入最高级别的System Notice
	*/
	public function checkInventory();

	/**
	*
	*
	* @param array $or_id     原的出入库单id = restock_id
	* @param array $nr_id     新的出入库单id = restock_id
	* @param array $s_details 待拆分出来的明细
	* $s_details = array($id => array(
	*						'item_id' 		=> '',
	*						'qty'	  		=> '',
	*						'relation_did' 	=> '',
	*						'backup_qty'	=> '')
	*				);
	* 拆分入库单对应得库存
	*/
	public function splitInventoryByStock($or_id,$nr_id,$s_details);
}