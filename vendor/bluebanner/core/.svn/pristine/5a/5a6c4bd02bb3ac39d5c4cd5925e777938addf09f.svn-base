<?php namespace Bluebanner\Core\Warehouse;


interface ShipmentServiceInterface {
	
    /**
     * 创建主单
     * @param array $master
     */
    public function createShipMaster(array $master);
    
    /**
     * 根据主单id创建明细单 可一次创建多个
     * @param integer $masterid
     * @param array $details
     */
    public function createShipDetails($masterid,array $details);
    
    /**
     * 根据主单id创建明细单 一次一个
     * @param unknown $masterid
     * @param array $detail
     */
    public function createShipDetail($masterid,array $detail);
    

    /*
    * 创建shipment
    *
    */
    public function createShipment(array $master, array $details);

    /*
    *
    * 获取明细数量
    */
    //public function getPlanShipmentDetailQty($plan_detail_id);


    /**
     * 更新主单信息
     * @param integer $masterid
     * @param array $masterinfo
     */
    public function updateShipMaster($masterid,array $masterinfo);
    
    /**
     * 主单信息确认
     * @param integer $masterid
     */
    public function confirmMaster($masterid);
    
    /**
     * 根据主单id修改明细单 可一次修改多个
     * @param integer $masterId
     * @param array $detailInfos
     */
    public function updateShipDetails($masterId,array $detailInfos);
    
    /**
     * 根据主单id修改明细单 一次修改1个
     * @param integer $masterId
     * @param array $detailInfos
     */
    public function updateShipDetail($detailId,array $detailInfo);
    
    /**
     * find by pk
     * @param integer $id
     */
    public function findShipByID($id);
    
    /**
     * find by attributes info
     * @param array $search_condition
     */
    public function findShipByCondition(array $search_condition);
    
    /**
     * find details by $masterid
     * @param integer $masterId
     */
    public function findShipDetailsByMasterId($masterId);
    
    /**
     * find detail by pk
     * @param integer $detailId
     */
    public function findShipDetailByPk($detailId);
    
    /**
     * 删除主单(软删除)
     * @param integer $id
     */
    public function deleteShipMaster($id);
    
    /**
     * 删除明细单(软删除)
     * @param integer $id
     */
    public function deleteShipDetail($id);
    
    /**
     * @return array status list
     */
    public function getStatus();
    
    /**
     * @return array transportation list
     */
    public function getTransStatusList();
    
    /**
     * 根据item id 查找明细中含有此itemid的主单Id
     * @param integer $item_id
     * @return array $master_id
     */
    public function getMasterIdFromDetailByItemId($item_id);
    
    /**
     * 
     * @see getMasterIdFromDetailByItemId item_id 变为sku(可模糊查找)
     * @param string $sku
     */
    public function getMasterIdFromDetailByItemSku($sku);
    
    /**
     * 更新主单下明细单中itemid 为  $fromItemId 
     * @param integer $masterId
     * @param integer $fromItemId
     * @param integer $toItemId
     * @return integer the number has updated
     */
    public function updateShipDetailItemIdByMasterId($masterId,$fromItemId,$toItemId);
    
    /**
     * 整单返回
     * @param integer $masterId
     * @param integer $agent
     * @return boolean
     */
    public function returnPendingByMasterId($masterId,$agent = '1');
    
    /**
     * 调度单生成出入库单
     *
     * ps 只有其他出入库单状态为conformed时 才允许生成
     *
     * @param interge $mid master pk
     * @param interge $agent operar uid
     *
     * @return void
     *
     * @exception
     *
     */
    public function generateIOMaster($mid,$agent);
    
    /**
     * @see updateShipDetailItemIdByMasterId 只不过生成出入库单后也可修改
     * @param integer $masterId
     * @param integer $agent
     * @param integer $fromItemId
     * @param integer $toItemId
     *
     * @return void
     *
     */
    public function specailUpdateForSkus($masterId,$agent,$fromItemId,$toItemId);
    
    /**
     * 修改数量  生成出入库单后也可修改
     * @param integer $masterId
     * @param integer $detailId
     * @param integer $agent
     * @param array $detailInfo
     */
    public function specailUpdateForQty($masterId,$agent,$detailId,$detailInfo);
    
  
    /**
     * 修改box_id
     * @param integer $id
     * @param integer $agent
     * @param integer $detail_id
     * @param array $attrs
     */
    public function specailUpdateForBoxId($id,$agent,$detail_id,array $attrs);

    public function getShipQtyByDetails($detailIdArr);
}    
