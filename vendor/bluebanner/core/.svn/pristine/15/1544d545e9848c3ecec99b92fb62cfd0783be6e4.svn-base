<?php namespace Bluebanner\Core\Purchase;

interface PurchaseServiceInterface {

	/**
	 * create a vendor
	 *
	 * @param array $array
	 */
	public function vendorCreate(array $vendor);

	public function vendorList();

	public function vendorFind($id);

	public function quotationCreate(array $quotation);

	public function quotationList();

	public function quotationFind($id);

	//-----------------------------------      plan      ------------------------------//
	/**
	 * find plan by Field
	 * 
	 * @param  $field
	 * @param  $condition
	 * @param  $value
	 * @return Plan
	 * @throws PurchasePlanException
	 */
	public function planFindByField($field,$condition,$value,$orderBy= 'asc');

	/**
	 * find plan by ID
	 *
	 * @param string $id
	 * @return plan
	 * @throws PurchasePlanException
	 */
	public function planFind($id);

	/**
	 * plan list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function planList();

	/**
	 * Create a new plan
	 *
	 * @param array $array
	 * @return bool
	 */
	public function planCreate(array $array);

	/**
	 * Remove a plan
	 *
	 * @param string $field	 
	 * @param string $value
	 * @return bool
	 */
	//public function planRemove($id);

	public function requestParent($plan_id = 0);
	//----------------------------------- request assgin ------------------------------//
	/**
	 * 
	 * 将申购单联合申购单的明细搜索出列表［注意这里只能出现child记录］ －－ confirmed状态的
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function requestDetailList(array $array);

	/**
	 * 
	 * @param int $plan_id
	 * @param string $request_ids
	 * @return boolean
	 * @throws PlanAssignException
	 *
	 */
	public function requestAssignAction($plan_id,$name = '',$request_ids = '',$agent,$purchase_wh);
	

	/**
	 * 
	 * @param string $request_ids
	 * @param int $plan_id
	 * @return boolean
	 * @throws PlanAssignException
	 *
	 */
	public function requestAssignReject($plan_id,$request_ids);
	

	//----------------------------------- plan exection ------------------------------//
	/**
	 * 
	 * @param array $search_condition
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function planDetailList(array $search_condition);
	public function getPurchasingSummary($plan_id);

	/**
	 * 
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function planDetaiFind($id);
	
	public function getColumns($plan_id); //getColumns

	/**
	 * 
	 * @param $arr 
	 *
	 */
	public function planDetailBatchUpdate(array $arr);

	/**
	 * 
	 * @param $arr 
	 *
	 */
	public function planDetailBatchUpdateQty(array $arr);

	/**
	*
	* @param $type 1-导出明细， 2－导出收发货明细表
	*/
	public function filePutCsv($file, $data, $header = 1, $arr = array());

	/**
	 * 
	 * @param array 
	 * @return 
	 *
	 */
	//public function planBatchOperation();	

	/**
	 * 
	 * @param array 
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	//public function planTurntoOrderView();

	/**
	 * 
	 * @param array 
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	//public function planTurntoOrderAction();

	//----------------------------------- purchase order ------------------------------//

	//----------------------------------- return exection ------------------------------//

	/**
	 * return list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function returnList();
	
	/**
	 * return Detail list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function returnDetailList();


	/**
	 * check if return exists
	 *
	 * @param string $id
	 * @return boolean 
	 */
	public function returnExists($id);

	/**
	 * find return by Field
	 * 
	 * @param  $field
	 * @return return
	 * @throws PurchasePlanNotFoundException
	 */
	public function returnFindByField($field);	
	
	/**
	 * find return by ID
	 *
	 * @param string $id
	 * @return return
	 * @throws returnNotFoundException
	 */
	public function returnFindByPK($id);
	
	/**
	 * find return detail by ID
	 *
	 * @param string $id
	 * @return return
	 * @throws returnNotFound\Exception
	 */
	public function returnDetailFindByPK($id);
	

	/**
	 * find return list
	 *
	 * @return returnList
	 * @throws returnNotFoundException
	 */
	public function returnFindAll($condition);

	/***
	*
	*  create return
	*
	**/
	public function returnCreate(array $returnModelInfo);
	
	/***
	*
	*  create return detail
	*
	**/
	public function returnDetailCreate(array $returnDetailModelInfo);
	
	/***
	*
	*   return  status list
	*
	**/
	public function getReturnStatusList();
	
	/*
	 * 
	 * delete return by pk($id)
	 * 
	 */
	public function returnDelete($id);
	
	
	/*
	 *
	* delete return detail by pk($id)
	*
	*/
	public function returnDetailDelete($id);
	
	/*
	*
	* find return more info 
	*
	*/
	public function returnMoreFindByPK($id);
	
	/*
	 *
	* update return detail item_id
	* ps: 此处为批量操作
	*
	*/
	public function returnDetailUpdateSKU($oldItemId,$newItemId);
	
	//退货单生成出库单
	//return bool
	public function returnGenerateOutStock($returnid,$userid);

	//-----------------------------------  Default Setting ------------------------------//
	/**
	 * find packing by ID
	 *
	 * @param string $id
	 * @return packing
	 * @throws PurchasePackingException
	 */
	public function packingFind($id);

	/**
	 * packing list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function packingList();

	/**
	 * Create a new packing
	 *
	 * @param array $array
	 * @return bool
	 */
	public function packingCreate(array $array);

	/**
	 * 对应计划的采购订单量
	 *
	 * @param int  $plan_id
	 * @return array  以计划明细为键值的数组
	 */
	public function getPurchaseOrder($plan_id);

	/**
	 * 对应计划的采购订单收货量 － 入库单的数量
	 *
	 * @param nt  $plan_id
	 * @return array  以计划明细为键值的数组
	 */
	public function getPurchaseOrderStockin($plan_id);

	public function getShipment($plan_id);

}