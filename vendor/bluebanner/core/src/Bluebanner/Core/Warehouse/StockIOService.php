<?php namespace Bluebanner\Core\Warehouse;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Inventory\InventoryService;
use Bluebanner\Core\Inventory\InventoryBookService;
use Bluebanner\Core\Warehouse\IOType;
use Bluebanner\Core\Warehouse\IOStatus;
use Bluebanner\Core\Purchase\POStatus;



use Bluebanner\Core\StockIOException;

class StockIOService implements StockIOServiceInterface
{

	public function __construct()
	{
		$this->inventory=new InventoryService;
		$this->inventorybook=new InventoryBookService;
	}
	//------------------------------------------- 出入库单创建 -------------------------------------------//
	/**
	 * 创建入库单(默认都将onroad库存写入库存表，有特殊情况不用先插入库的再看)
	 *
	 * @param (array)$stockin 主表字段数组
	 * array(
	 *	relation_id => 关联的id,
	 *	relation_invoice => 关联的invoice,
	 *	warehouse_id => 出库单对应出库仓，入库单对应入库仓,
	 *  type => 类别,
	 *  creat_agent => 一定要是当前用户
	 *)
	 * @param (array)$details 明细字段数组
	 * array(
	 *	item_id => xx,
	 *	qty => 不同明细相同sku的数量不用加总,
	 *	relation_did => 对应的明细id,
	 *)
	 * @return int
	*/		
	public function createStockIN(array $stockin, array $details)
	{
		$stockin['invoice'] = isset($stockin['invoice']) ? $stockin['invoice'] : with(new StockIOMaster)->GenerateInvoice($stockin['type']);

		$self = $this;
		DB::transaction(function() use ($stockin, $details,$self) {
			$r = StockIOMaster::create($stockin);

			foreach ($details as $detail) {
				$detail['io_id'] = $r->id;
				StockIODetail::create($detail);
			}

			//插入库库存记录－onroad｛调度要在出库的时候插入[库存的价格要在取出的时候定]
			if(!$self->createInventoryByStockInId($r->id,$stockin['type'])) 
				throw new StockIOException("Generate Stock Failed -- Inventory Record Failed");
			
			return $r;
		});

		return true;
	}

	/*创建入库单，没有事务,也不主动插入库存记录，主要是拆分入库单使用*/
	public function createStockINWithoutTran(array $stockin, array $details)
	{
		$stockin['invoice'] = isset($stockin['invoice']) ? $stockin['invoice'] : with(new StockIOMaster)->GenerateInvoice($stockin['type']);
		if(!$r = StockIOMaster::create($stockin))
			throw new StockIOException("创建入库单表头失败");

		foreach ($details as $detail) {
			$detail['io_id'] = $r->id;
			if(!StockIODetail::create($detail))
				throw new StockIOException("创建入库单明细失败");
		}	

		return $r;
	}

	/**
	* 将入库单信息转化成库存信息
	* 
	* 
	*/
	public function createInventoryByStockInId($stockin_id,$stock_type)
	{	
		$stockin = $this->stockFindByID($stockin_id);

		foreach($stockin->details as $key => $detail){
			$inventoryArr = array(
				'warehouse_id' 	=> $stockin->warehouse_id,
				'item_id'		=> $detail->item_id,
				'qty'			=> $detail->qty + $detail->backup_qty,
				'account_id'	=> 0,
				'restock_id'	=> $stockin_id,
			);
			if(!$this->inventory->addInventoryRecord($inventoryArr)){
				return false;
			}
		}
		
		return true;
	}

	/**
	 * 创建出库单
	 * 
	 * @param (array)$stockin 主表字段数组
	 * array(
	 *	relation_id => 关联的id,
	 *	relation_invoice => 关联的invoice,
	 *	warehouse_id => 出库单对应出库仓，入库单对应入库仓,
	 *  type => 类别,
	 *  creat_agent => 一定要是当前用户
	 *)
	 * @param (array)$details 明细字段数组
	 * array(
	 *	item_id => xx,
	 *	qty => 不同明细相同sku的数量不用加总,
	 *	relation_did => 对应的明细id,
	 * )
	 * @return int
	*/		
	public function createStockOut(array $stockout, array $details)
	{	
		$stockout['invoice'] = isset($stockout['invoice']) ? $stockout['invoice'] : with(new StockIOMaster)->GenerateInvoice($stockout['type']);
		$self = $this;
		$stockoutId = 0;
		DB::transaction(function() use ($stockout, $details,$self) {
			$r = StockIOMaster::create($stockout);

			foreach ($details as $detail) {
				$detail['io_id'] = $r->id;
				StockIODetail::create($detail);
			}

			$stockoutId = $r->id;

			return $r;
		});

		/*if($stockoutId > 0){
			//自动book库存,初始建立的时候，可以和事务独立
			$self->bookInventoryByStock($r->id);
		}*/

		return true;
	}


	/*创建出库单，不使用事务*/
	public function createStockOutWithoutTran(array $stockout, array $details)
	{	
		$stockout['invoice'] = isset($stockout['invoice']) ? $stockout['invoice'] : with(new StockIOMaster)->GenerateInvoice($stockout['type']);

		if(!$r = StockIOMaster::create($stockout))
			throw new StockIOException("创建新出库单表头失败");

		foreach ($details as $detail) {
			$detail['io_id'] = $r->id;
			if(!StockIODetail::create($detail))
				throw new StockIOException("创建新出库单明细失败");
		}

		//$self->bookInventoryByStock($r->id);//自动book库存

		return true;
	}

	//------------------------------------------- 出入库单拆分 -------------------------------------------//

	/**
	 * 拆分入库单
	 *
	 * @param      (int)$id			
	 * @return     int
	*/		
	public function splitStockIn($id,$agent,array $newdetails)
	{
		$oldStockout = $this->stockFindByID($id);
		if($oldStockout->status != IOStatus::NOT_STOCK)
			throw new StockIOException("入库单的状态不是Not Stock");
		
		$newStockIn = array(
			'relation_id'	    => $oldStockout->relation_id,
			'relation_invoice'  => $oldStockout->relation_invoice,
			'warehouse_id' 		=> $oldStockout->warehouse_id,
			'invoice' 			=> with(new StockIOMaster)->generateSplitInvoice($oldStockout->type,$oldStockout->invoice),
			'type' 				=> $oldStockout->type,				
			'creat_agent'		=> $agent
		);

		$self = $this;

		/*---这里要改进事务功能--*/
		DB::transaction(function() use ($id,$newStockIn, $newdetails,$self) {
			//创建新单-会自动增加库存纪录
			if(!$new = $self->createStockINWithoutTran($newStockIn,$newdetails))
				throw new StockIOException("拆分失败－创建新入库单失败");
		
			//减去旧单数量
			if(!$self->reduceStockQty($id,$newdetails))
				throw new StockIOException("拆分失败 - 减去旧单数量失败");

			//减去对应库存记录数，方便渠道分配
			if(!$self->inventory->splitInventoryByStock($id,$new->id,$newdetails))
				throw new StockIOException("拆分失败 - 拆分库存记录失败");
			return true;
		});
	}

	/**
	 * 拆分出库单
	 *
	 * @param      (int)$id	 old stock out id 
	 * @param      (int)$agent	必须是当前用户
	 * @param      (array)$newDetails	array(id => array(item_id,qty,backup_qty,relation_did))
	 * @return     int
	*/		
	public function splitStockOut($id,$agent,array $newdetails)
	{
		$oldStockout = $this->stockFindByID($id);
		if($oldStockout->status != IOStatus::NOT_STOCK)
			throw new StockIOException("出库单的状态不是Not Stock,如果是Booked状态，请先解锁库存");
		
		$newStockout = array(
			'relation_id'	    => $oldStockout->relation_id,
			'relation_invoice'  => $oldStockout->relation_invoice,
			'warehouse_id' 		=> $oldStockout->warehouse_id,
			'invoice' 			=> with(new StockIOMaster)->generateSplitInvoice($oldStockout->type,$oldStockout->invoice),
			'type' 				=> $oldStockout->type,				
			'creat_agent'		=> $agent
		);

		$self = $this;
		DB::transaction(function() use ($id,$newStockout, $newdetails,$self) {
			//创建新单
			if(!$self->createStockOutWithoutTran($newStockout,$newdetails))
				throw new StockIOException("拆分失败－创建新出库单失败");
		
			//减去旧单数量
			if(!$self->reduceStockQty($id,$newdetails))
				throw new StockIOException("拆分失败 - 减去旧单数量失败");

			return true;
		});
	}


	//------------------------------------------- 出入库单查询 -------------------------------------------//
	/**
	 * 按照relation id查询
	 *
	 * @param      $relation_id 
	 * @param 	   $type
	 * @return     返回对应type＋relation_id的出入库单信息
	*/		
	public function stockFindByRelationID($relation_id,$type = array())
	{
		if ( ! $stock = StockIOMaster::with('details')->where('relation_id','=',$relation_id)->whereIn('type',$type))
			throw new StockIOException("Stock IO List With Relation ID[$relation_id] was not found.");
		return $stock;
	}
	
	/**
	 * 单个出入库单查询
	 *
	 * @param      id 
	 * @param 	   
	 * @return     
	*/		
	public function stockFindByID($id)
	{
		if ( ! $stock = StockIOMaster::with('details','warehouse','createUser')->find($id))
			throw new StockIOException("Stock IO[$id] was not found.");
		
		return $stock;
	}

	/*
	* @desc 按照查询条件查询
	*
	*/
	public function stockFindByCondition(array $search_condition)
	{
		$tmp = StockIOMaster::where('id','>',0)->select('*');
		foreach ($search_condition as $value)
		{
		    if(! isset($value['condition'])) $value['condition']='=';
			if($value['condition'] == "in")
			{
				$tmp->whereIn($value['field'],$value['value']);
			}
			else
			{
				$tmp->where($value['field'],$value['condition'],$value['value']);
			}
		}
		
		return $tmp;
	}

	//------------------------------------------- 出库单对应的库存book/unbook -------------------------------------------//
	/**
	* book 库存
	* 一个完整的单调用一次这个含税，方便判断是否缺库存
	* @param (int)$id
	* @action 整理的数据如下格式传入库存的book方法  
	*	array(
	*		relation_id => 1,
	*		invoice => 'O120303'
	*		type => 'io',
	*		warehouse_id => 1,
	*		details => array(
	*			relation_detail_id => 1,
	* 			item_id	=> 1,
	* 			qty	=> 1,//数量这里要将qty+backup_qty
	*		)
	*	)
	*/
	public function bookInventoryByStock($id)
	{
		$stockout = $this->stockFindByID($id);

		if($stockout->status == IOStatus::BOOKED)
			throw new StockIOException("该出库单已经是booked状态");

		if($stockout->status == IOStatus::STOCKED)
			throw new StockIOException("该出库单已经是被出库了");

		$self = $this;

		DB::transaction(function() use ($id,$self) {
			//book action
			if(!$self->inventorybook->bookInventory($self->prepareStockOut($id)))
				throw new StockIOException("库存book失败:book失败");

			//更改出库单状态为booked
			if(!$self->changeStatus($id,IOStatus::BOOKED))
				throw new StockIOException("库存book失败:更新出库单状态失败！");

			return true;
		});
	}

	/**
	* book 库存
	* 一个完整的单调用一次这个含税，方便判断是否缺库存
	* @param (int)$id
	* @action 主要流程：(1.取消book, 2.实际扣库存时候解除)
	* 1: 减掉库存表book数量 -> 将book关联数据改为cancel－> 出库单改初始状态
	* 2: 减掉库存表book数量 -> 减掉库存表实际数量 -> 库存日志 -> 将book关联数据改为closed -> 出库单改出库状态
	*/
	public function unbookInventoryByStock($id)
	{
		$stockout = $this->stockFindByID($id);

		if(($stockout->type >=0) || ($stockout->status != IOStatus::BOOKED))
			throw new StockIOException("出入库单得类别不属于出库，或者状态不是booked状态");
		$self = $this;
		DB::transaction(function() use ($stockout,$id,$self) {
			//解book--cancel
			if($self->inventorybook->offBookInventory($id,'io') != true)
				throw new StockIOException("unbook失败:解除库存失败!");
			
			//更改出库单状态为not_stock
			if(!$stockout->update(array('status' => IOStatus::NOT_STOCK,'exec_at' => date('Y-m-d H:i:s')))) 
				throw new StockIOException("unbook失败:更新出库单状态失败！");

			return true;
		});
	}

	//------------------------------------------- 出入库单实际出入库库 -------------------------------------------//
	/**
	 * 入库单入库
	 * 1.更改入库单状态
	 * 2.更改对应单据的状态
	 * 3.更新库存数据[状态，价格，po_id]
	 * @param     $stockin_id 入库单id
	 * @param 	  
	 * @return     
	 * 多态试了一下，似乎有问题，稍后再来研究
	*/		
	public function stockIn($stockin_id,$agent)
	{
		$stockin = $this->stockFindByID($stockin_id);
		if(($stockin->type <=0) || ($stockin->status != IOStatus::NOT_STOCK))
			throw new StockIOException("出入库单得类别不属于入库，或者状态不是pending状态");
		
		$self = $this;

		DB::transaction(function() use ($stockin,$self){
			//相关单的入库记录得价格处理
			switch ($stockin->type) {
				case IOType::PURCHASING:
					$self->updateInventoryByPurchasing($stockin);
					break;
				case IOType::CHECK_STOCK_IN:
				case IOType::OTHER_IN:
				case IOType::FBA_RETURN_IN:
					$self->updateInventoryByLastRecord($stockin);
					break;
				case IOType::SHIPMENT_IN:
					$self->updateInventoryByShipment($stockin);
					break;
				case IOType::ORDER_CLOSED_CANCEL:
				case IOType::RMA_RESTOCK:
				default:
					# code...
					break;
			}

			//更改本单状态
			if(!$self->changeStatus($stockin->id,IOStatus::STOCKED))
				throw new StockIOException("入库失败:更新入库单状态失败！");
			

			//更改原单状态－－每种原单有不同得情况
			if(!$self->changeOrginStatus($stockin,$stockin->type))
				throw new StockIOException("入库失败:更新相关单状态失败！");

			return true;
		});
	}

	/**
	* 入库得时候改变原单得状态
	*
	*
	*/
	public function changeOrginStatus($stockin,$type)
	{
		//更改关联单状态:若所有的出入库单为完成状态，则改关联单为done状态
		switch ($stockin->type) {
			case IOType::CHECK_STOCK_IN:
			case IOType::CHECK_STOCK_OUT:
				$type = array(IOType::CHECK_STOCK_IN,IOType::CHECK_STOCK_OUT);
				$orgin_status = array('status' => 'completely','status_part' => 'stocking');
				break;
			case IOType::OTHER_IN:
			case IOType::OTHER_OUT:
				$type = array(IOType::OTHER_IN,IOType::OTHER_OUT);
				$orgin_status = array('status' => 'done','status_part' => 'stocking');
				break;
			case IOType::FBA_RETURN_IN:
				$type = array(IOType::FBA_RETURN_IN);
				$orgin_status = array('status' => 'completely','status_part' => 'stocking');
				break;
			case IOType::PURCHASING:
				$type = array(IOType::PURCHASING);
				$orgin_status = array('status' => POStatus::COMPLETELY_RECEIVED,'status_part' => POStatus::PARTICALLY_RECEIVED,'status_0' => 'stocking');
				break;
			case IOType::PURCHASING_RETUEN_VENDOR:
				$type = array(IOType::PURCHASING_RETUEN_VENDOR);
				$orgin_status = array('status' => 'completely','status_part' => 'stocking');
			case IOType::SHIPMENT_IN:
			case IOType::SHIPMENT_OUT:
				$type = array(IOType::SHIPMENT_IN,IOType::SHIPMENT_OUT);
				$orgin_status = array('status' => 'completely received','status_part' => 'partially received','status_0' => 'on-road');
				break;
			default:
				break;
		}

		//更改关联单状态:所有的入库单入库则改为完成状态，部分入库的为PARTICALLY_RECEIVED状态
		$totalStocks = $this->stockFindByRelationID($stockin->relation_id,$type)->get();
		$count = 0;
		$shipmentin =0;
		foreach($totalStocks as $ts){
			($ts->status == IOStatus::STOCKED) ? $count++ : $count;
			(($ts->status == IOStatus::STOCKED) && ($ts->type == IOType::SHIPMENT_IN)) ? $shipmentin++ : $shipmentin;
		}

		if($count ==0){
			$Rstatus = isset($orgin_status['status_0']) ? $orgin_status['status_0'] : $orgin_status['status_part'];
		}else{
			$Rstatus = ($count == count($totalStocks)) ? $orgin_status['status'] : $orgin_status['status_part'];
		}

		if(in_array($stockin->type,array(IOType::SHIPMENT_OUT,IOType::SHIPMENT_IN)) && ($shipmentin ==0)){
			$Rstatus ='on-road';
		}

	//throw new StockIOException($stockin->type."/".$stockin->id);

		if(!$stockin->relation->update(array('status' => $Rstatus)))
			throw new StockIOException("入库失败:更新关联单状态失败");

		return true;
	}

	/**
	*
	* @param $stockin object
	* @desc 采购入库更改库存记录
	* 1.根据采购单的情况，获取每个sku的价格信息［默认按照不含税单价，美元这里自动转换一下价格］
	* 2.库存类里面根据这里的价格信息，修改价格
	* 3.渠道分配暂时不做，可以考虑在创建入库单－－插入库存记录的时候做渠道分配－－－
	* 
	*
	*/
	public function updateInventoryByPurchasing($stockin)
	{
		$item_price = array();
		//找出对应采购单的价格信息等，整理成对应item的信息, 将价格信息写入到库存表
		$exchange_rate = ($stockin->relation->currency_rate >0) ?  $stockin->relation->currency_rate : '6.3';//这里到时候要到汇率表中拿
		foreach($stockin->relation->details as $detail){
			switch ($stockin->relation->price_type) {
				case 'normal':
					if(!($detail->unit_price >0))
						throw new StockIOException($detail->item->sku."入库失败:含税单价和单价在采购单种缺失");
					$item_price[$detail->item_id]['rmbprice'] = $detail->unit_price;
					$item_price[$detail->item_id]['localprice'] = $this->getPriceByCNYExchangeRate($detail->unit_price,'USD',$exchange_rate);
					break;
				case 'tax':
					if(!($detail->tax_unit_price >0))
						throw new StockIOException($detail->item->sku."入库失败:含税单价和单价在采购单种缺失");
					$item_price[$detail->item_id]['rmbprice'] = $detail->tax_unit_price;
					$item_price[$detail->item_id]['localprice'] = $this->getPriceByCNYExchangeRate($detail->tax_unit_price,'USD',$exchange_rate);
					break;
				case 'usd':
					if(!($detail->usd_unit_price >0))
						throw new StockIOException($detail->item->sku."入库失败:美元单价在采购单种缺失");
					$item_price[$detail->item_id]['rmbprice'] = $detail->unit_price ? $detail->unit_price : $this->getPriceByCNYExchangeRate($detail->usd_unit_price,'CNY',$exchange_rate);
					$item_price[$detail->item_id]['localprice'] = $detail->usd_unit_price;
					break;
				default:
					throw new StockIOException("入库失败:对应的采购单未指定采购币种!");
					break;
			}
		}

		//入库的时候检测采购单价，含税单价和美元单价的情况［汇率为美元时是否转换为了人民比］
		if(!$this->inventory->updateInventoryByRestock($stockin->id,$stockin->type,1,$item_price,$stockin->relation->id,$stockin->invoice."入库操作"))
			throw new StockIOException("入库失败:更新库存失败！");

		return true;
	}

	/**
	* 其他入库更改库存记录
	* 统一取最后的价格来改
	* @action 
	* 1.取对应itemd在库存表里面最后一条库存记录的，价格，供应商id做为参考,没有库存记录出提示
	* 2.修改对应入库单
	*/
	public function updateInventoryByLastRecord($stockin)
	{
		//获取最后一条库存，并且更改价格和状态，入库时间
		if(!$this->inventory->updateInventoryByLastRecord($stockin->id,$stockin->type,1,$stockin->invoice."入库操作"))
			throw new StockIOException("入库失败:更新库存失败！");

		return true;
	}

	/**
	* 其他入库更改库存记录
	* 统一取最后的价格来改
	* @action 
	* 1.取对应itemd在库存表里面最后一条库存记录的，价格，供应商id做为参考,没有库存记录出提示
	* 2.修改对应入库单
	*/
	public function updateInventoryByShipment($stockin)
	{
		//判断是否能够入库，标准［该shipment下，出库数量和{{已入库数量＋本次入库数量}} 是否相等］－不相等则不能入库
		if(!$outID = $this->judyShipmentIn($stockin))
			throw new StockIOException("入库失败:shipment的调出仓和调入仓数据对不上！");

		//获取调出仓得出库库存记录，里面有对应得价格信息，以及
		if(!$this->inventory->updateInventoryByShipment($stockin->id,$stockin->type,1,$outID,$stockin->invoice."入库操作"))
			throw new StockIOException("入库失败:更新库存失败！");

		return true;
	}

	protected function judyShipmentIn($stockin)
	{
		$outID = array();
		//获取所有出库得sku+qty
		$stocks = $this->stockFindByRelationID($stockin->relation_id,array(IOType::SHIPMENT_OUT))->get();
		$out = array();
		if($stocks){
			foreach($stocks as $ts){
				if($ts->status != IOStatus::STOCKED) continue;
				$outID[] = $ts->id;
				foreach($ts->details as $detail)
				{
					$tmp = $detail->qty + $detail->backup_qty;
					$out[$detail->item_id] = isset($out[$detail->item_id]) ? ($out[$detail->item_id] + $tmp) : $tmp;
				}
			}
		}

		//获取所有入库sku+qty + 本次得qty
		$stocks = $this->stockFindByRelationID($stockin->relation_id,array(IOType::SHIPMENT_IN))->get();
		$in = array();
		if($stocks){
			foreach($stocks as $ts){
				if($ts->status != IOStatus::STOCKED) continue;

				foreach($ts->details as $detail)
				{
					$tmp = $detail->qty + $detail->backup_qty;
					$in[$detail->item_id] = isset($in[$detail->item_id]) ? ($in[$detail->item_id] + $tmp) : $tmp ;
				}
			}
			foreach($stockin->details as $detail)
			{
					$tmp = $detail->qty + $detail->backup_qty;
					$in[$detail->item_id] = isset($in[$detail->item_id]) ? ($in[$detail->item_id] + $tmp) : $tmp ;
			}
		}

		$message  ='';
		//判断所有入库和需要入库的数据在出库单是否存在－－》出库单的数量可以大于等于入库单
		foreach($in as $item_id => $qty)
		{
			$sku = Item::find($item_id);
			if(!isset($out[$item_id]) || ($qty > $out[$item_id]))
				$message = ($message =='') ? $sku->sku."出库的数据不能小于入库数据" : $message."/r/n".$sku->sku."出库的数据不能小于入库数据";
		}

		if($message !='')	throw new StockIOException($message);

		return (count($outID) > 0) ? $outID : false;
	}

	/**
	 * 出库单出库
	 *
	 * @param      $stockout_id 出库单id
	 * @param 	   
	 * @action :  减掉库存表实际数量 -> 库存日志 -> 减掉库存表book数量 -> 将book关联数据改为closed -> 出库单改出库状态
	 * @return     
	*/		
	public function stockOut($stockout_id,$agent)
	{
		$stockout = $this->stockFindByID($stockout_id);

		if($stockout->type >=0)
			throw new StockIOException("出库单得类别不属于出库");

		if($stockout->status == IOStatus::STOCKED)
			throw new StockIOException("该出库单已经是被出库了");

		//没有book库存的先book库存
		if($stockout->status != IOStatus::BOOKED)
			throw new StockIOException("请先将出库单book库存");//自动book库存的到时候看看哪里加比较好

		$self = $this;

		DB::transaction(function() use ($stockout_id,$stockout,$agent,$self) {
			//解book--closed
			if($self->inventorybook->offBookInventory($stockout_id,'io','done') != true)
				throw new StockIOException("unbook失败:解除库存失败!");
			
			//根据book信息［状态为closed的记录］，减去库存数量
			if($self->inventory->cutQuantityByBooked($stockout_id,'io',$stockout->type,$agent) != true)
				throw new StockIOException("unbook失败:扣库存失败!");

			//更改出库单状态为not_stock--这里没有调用changestatus
			if(!$stockout->update(array('status' => IOStatus::STOCKED,'exec_at' => date('Y-m-d H:i:s'))))
				throw new StockIOException("unbook失败:更新出库单状态失败！");

			//更改相关单状态－－每种相关单有不同得情况
			if(!$self->changeOrginStatus($stockout,$stockout->type))
				throw new StockIOException("入库失败:更新相关单状态失败！");

			return true;
		});
	}

   //-------------------------------------出入库单得返回------------------------------------------//
	/*
	* 反入库－－只是返回入库前的一个状态
	*/
	public function reverseIn($orgin_id,$agent)
	{		
		$stockin = $this->stockFindByID($orgin_id);

		$self = $this;

		DB::transaction(function() use ($stockin,$agent,$self) {
			if($stockin->status == IOStatus::STOCKED){////返回库存				
				//将入库的库存减掉－如果库存已经被book或者占用则提示库存已经被占用，不能返回
				$res = $self->inventory->cutQuantityByRevrese($stockin->id,$stockin->type,$agent,'stock');
					
				if($res['f'] != 1) throw new StockIOException($res['m']);
			}

			//更改该入库单状态
			if (!$stockin->update(array('status' => IOStatus::NOT_STOCK,'exec_at' => ''))) 
				throw new StockIOException('入库单返回失败');	

			//更改相关单状态－－每种相关单有不同得情况
			if(!$self->changeOrginStatus($stockin,$stockin->type))
				throw new StockIOException("入库单返回失败:更新相关单状态失败！");

			return true;
		});
	}

	/*
	* 反出库－－只是返回出库前的一个状态 －－默认是已经出库得返回
	* 反出库可以返回到两种状态(pending / booked,默认是pending)
	*/
	public function reverseOut($stockout_id,$agent,$toStatus = IOStatus::NOT_STOCK)
	{
		$stockout = $this->stockFindByID($stockout_id);

		$self = $this;

		DB::transaction(function() use ($stockout,$agent,$self,$toStatus) {
			if(($stockout->status == IOStatus::NOT_STOCK) || ($stockout->status == IOStatus::BOOKED))
				throw new StockIOException("该单不需要返回,如果是book状态请解book");
			
			if($stockout->status == IOStatus::STOCKED){////返回库存	
				//返回库存
				if($self->inventory->addQuantityByRevrese($stockout->id,'io',$stockout->type,$agent,$toStatus) != true)
					throw new StockIOException("返出库失败:回加库存失败!");

				if(!$self->inventorybook->changeStatus($stockout->id,'done','pending','io'))
					throw new StockIOException("返出库失败:改变book状态失败!");

				if($toStatus == IOStatus::NOT_STOCK){//解book
					if($self->inventorybook->offBookInventory($stockout->id,'io') != true)
						throw new StockIOException("返出库失败:解除库存失败!");
				}
			}

			//更改该入库单状态
			if (!$stockout->update(array('status' => $toStatus,'exec_at' => ''))) 
				throw new StockIOException('返出库失败');	

			//更改相关单状态－－每种相关单有不同得情况
			if(!$self->changeOrginStatus($stockout,$stockout->type))
				throw new StockIOException("入库单返回失败:更新相关单状态失败！");

			return true;
		});
	}

	/**
	 * 原单关联的出库单出库
	 *
	 * @param  $orgin_id 原始单的id
	 * @param  $agent 	 当前用户
	 * @param  $type 	 对应出库单的类别
	 * 整单返回时的调用
	 * 1.判断出库单的状态
	 * 2.如果是pending状态－－直接删除
	 *		 booked状态 －－解book－－删除
	 *		 stocked状态－－返回库存－－解book－删除 
	 */
	public function reverseOutByOrign($orgin_id,$agent = '1',$type)
	{
		$outStocks = $this->stockFindByRelationID($orgin_id,array($type))->get();

		if($outStocks)
		{
			foreach($outStocks as $stockout)
			{
				switch($stockout->status){
					case IOStatus::NOT_STOCK:
						break;
					case IOStatus::BOOKED:	//解book--cancel
						if($this->inventorybook->offBookInventory($stockout->id,'io') != true)
							throw new StockIOException("unbook失败:解除库存失败!");
						
						if(!$stockout->update(array('status' => IOStatus::NOT_STOCK,'exec_at' => date('Y-m-d H:i:s')))) 
							throw new StockIOException("返出库失败:更新出库单状态失败！");
						break;
					case IOStatus::STOCKED://返回库存－－解book
						//返回库存
						if($this->inventory->addQuantityByRevrese($stockout->id,'io',$stockout->type,$agent) != true)
							throw new StockIOException("返出库失败:回加库存失败!");

						if(!$this->inventorybook->changeStatus($stockout->id,'done','pending','io'))
							throw new StockIOException("返出库失败:改变book状态失败!");

						//解book
						if($this->inventorybook->offBookInventory($stockout->id,'io') != true)
							throw new StockIOException("返出库失败:解除库存失败!");
						
						if(!$stockout->update(array('status' => IOStatus::NOT_STOCK,'exec_at' => date('')))) 
							throw new StockIOException("返出库失败:更新出库单状态失败！");

						break;
				}

				//删除该出库单
				if (!$stockout->delete()) 
					throw new StockIOException("返出库失败:删除出库单失败！");
			}
		}

		return true;
	}

	/*
	* * @param   $id 入库单id
	*
	* @param  $orgin_id 原始单的id
	* @param  $agent 	 当前用户
	* @param  $type 	 对应出库单的类别
	* 整单返回时的调用
	* 1.判断入库单的状态
	* 2.如果是pending状态－－直接删除
	*		 stocked状态－－判断库存是否已经被使用(库存实际可用数量是否等于入库单的数量)
	* 
	*/
	public function reverseInByOrign($orgin_id,$agent = '1',$type)
	{
		$inStocks = $this->stockFindByRelationID($orgin_id,array($type))->get();
		if($inStocks){
			foreach($inStocks as $stockin)
			{
				if($stockin->status == IOStatus::STOCKED){////返回库存				
					//将入库的库存减掉－如果库存已经被book或者占用则提示库存已经被占用，不能返回
					$res = $this->inventory->cutQuantityByRevrese($stockin->id,$type,$agent,'orign');
					if($res['f'] != 1) throw new StockIOException($res['m']);
				}else{
					if(!$this->inventory->deleteOroadInventoryByRestock($stockin->id))
						throw new StockIOException('删除对应批次在途库存失败'.$stockin->id);
				}

				//删除该出库单
				if (!$stockin->delete()) 
					throw new StockIOException('入库单删除失败');				
			}
		}

		return true;
	}

	/**
	* 改变sku
	* 
	*/
	public function changeSKU()
	{

	}

	/**
	* 改变sku 数量
	*
	*/
	public function changeQty()
	{

	}

	//------------------------------------------- 出入库单辅助项 -------------------------------------------//
	/**
	* 更改出入库单的状态
	*
	*/
	public function changeStatus($id,$status)
	{
		$stock = $this->stockFindByID($id);
		
		if(!$stock->update(array('status' => $status,'exec_at' => date('Y-m-d H:i:s')))) return false;

		return true;
	}

	/**
	* 减去出入库单明细的数量
	* 1.如果该明细全部被减完，则删除该明细
	* 2.如果该单中所有明细都没了，则删除该单
	*
	*/
	public function reduceStockQty($id,$splitdetail)
	{
		$updateData = array();
		foreach($splitdetail as $did => $detail){
			$olddetail = StockIODetail::find($did);

			//减去出入库单的数量
			$qty = $olddetail->qty - $detail['qty'];
			$qty = ($qty >= 0) ? $qty : 0;

			$res = (($qty > 0)) ? $olddetail->update(array('qty' => $qty)) : $olddetail->delete();
			if(!$res)
				throw new StockIOException("拆分旧单明细失败");
		}

		$olddetails = StockIODetail::where('io_id','=',$id)->get();
		$flag = 0;
		foreach ($olddetails as $detail) {
		 	if(($detail->qty > 0) || ($detail->backup_qty >0)) {
		 		$flag =1 ;
		 		break;
		 	}

		 	if(!StockIODetail::find($detail->id)->delete())
		 		throw new StockIOException("拆分时，删除原单失败");
		}

		//没有明细或者明细数量都是0，删除整个原出入库单
		if($flag == 0){
			if(!StockIOMaster::find($id)->delete())
				throw new StockIOException("拆分时，删除原单失败");
		}

		return true;
	}

	/**
	* 整理需要book的出库单信息
	*
	* @action 整理的数据如下格式传入库存的book方法  
	*	array(
	*		relation_id => 1,
	*		type => 'io',
	*		warehouse_id => 1,
	*		a_id_arr => array(),//渠道id数组
	*		details => array(
	*			relation_detail_id => 1,
	* 			item_id	=> 1,
	* 			qty	=> 1,//数量这里要将qty+backup_qty
	*		)
	*	)
	* return object(对象成员如上)
	*/
	public function prepareStockOut($id){
		$stock = array();
		$stockout = $this->stockFindByID($id);

		$stock['relation_id'] = $id;
		$stock['invoice'] = $stockout->invoice;
		$stock['type'] 	= 'io';
		$stock['warehouse_id'] = $stockout->warehouse_id;

		$detials = array();
		$i = 0;
		foreach($stockout['details'] as $d){
			$stock['details'][$i]['relation_detail_id'] = $d->id;
			$stock['details'][$i]['item_id'] = $d->item_id;
			$stock['details'][$i]['qty'] = $d->qty + $d->backup_qty;
			$i++;
		}

		return $stock;
	}
	
	
	/**
	 * 查找所有item_id为@item_id的列的io_id(主表主键)
	 * @param interge  $item_id
	 *
	 * @return array io_id的集合
	 *
	 */
	
	public function getMasterIdFromDetailByItemId($item_id)
	{
		$models=StockIODetail::where('item_id','=',$item_id)->select(array('io_id'));
	
		$ids=array();
		foreach($models->get() as $detail)
		{
			$ids[]=$detail->io_id;
		}
		return $ids;
	}

	/////////////////////////public function[将来转到公共的函数里去]///////////////////////
	/*
	* $price 原币种价格(如果to是人民币，则原价格就是原币价格；如果to是美元则，原价格就是人民币价格)
	* $to  	 转换后价格类型
	* $exchange_rate 对于人民币的价格
	*/
	public function getPriceByCNYExchangeRate($price,$to,$exchange_rate)
	{
		if($exchange_rate <=0)
			throw new StockIOException("汇率不存在");

		if($to == 'CNY')
			$price = $price*$exchange_rate;
		else 
			$price = rand($price/$exchange_rate,2);

		return $price;
	}
	
    /**
     * 更改stock detail 的 item_id
     * status 为  NOT_STOCK 时 直接改
     * status 为  STOCKED 时 直接改 到 inventoryService 中改
     * status 为  BOOKED 时 直接改 到 inventoryBookService 中改
     * @param integer $relation_id
     * @param string $type
     * @param integer $agent
     * @param integer $from_item_id
     * @param integer $to_item_id
     * 
     * @return bool
     */
	public function updateStockOutIOItemId($relation_id,$type,$agent,$from_item_id,$to_item_id)
	{
	    
	    $outStocks = $this->stockFindByRelationID($relation_id,array($type))->get();
	    
	    foreach($outStocks as $stockout)
	    {
	        $stockout = $this->stockFindByID($stockout->id);
	    
	        switch($stockout->status){
	            case IOStatus::NOT_STOCK:
	                break;
	            case IOStatus::BOOKED:	//解book--cancel
	                throw new StockIOException("未完成! 暂时不允许修改");
	                break;
	            case IOStatus::STOCKED://返回库存－－解book
	                   //
	                throw new StockIOException("未完成! 暂时不允许修改");
	             break;
	        }
	    
	        //删除该出库单
	        if (!$stockout->delete())
	            throw new StockIOException("返出库失败:删除出库单失败！");
	    
	    }
	    
	    return true;
	    
	    $stockModel=$this->stockFindByRelationID($relation_id,array($type));
	    
	    foreach($inStocks as $stockin)
	    {
	        $stockin = $this->stockFindByID($stockin->id);
	    
	        if($stockin->status == IOStatus::STOCKED){////返回库存
	            //将入库的库存减掉－如果库存已经被book或者占用则提示库存已经被占用，不能返回
	            $res = with(new InventoryService)->cutQuantityByRevrese($stockin->id,$type,$agent);
	            	
	            if($res['f'] != 1) throw new StockIOException($res['m']);
	        }
	    
	        //删除该出库单
	        //更改该入库单
			foreach($stockin->details as $detail)
			{
			    if($detail->item_id == $from_item_id)
			    {
			        $detail->item_id = $to_item_id;
			        $detail->save();
			    }
			}	
	    }
	    
	    return true;
	    
// 	    foreach($stockModel as $stock)
// 	    {
// 	        $stockMore=$this->stockFindByID($stock->id);
// 	        if($stockMore->status == IOStatus::NOT_STOCK)
// 	        {
// 	            foreach($stockMore->details as $detail)
// 	            {
// 	                if($detail->item_id == $from_item_id)
// 	                {
// 	                    $detail->item_id =$to_item_id;
	                    
// 	                    $detail->save();
// 	                }
// 	            }
// 	        }
// 	        else 
// 	        {
// 	            $IsOutStock=true;
	            
// 	            if($stockMore->type > 0)
// 	            {
// 	                $IsOutStock=false;
// 	            }
	            
// 	            $qty=$this->getSumQtyByPk($stockMore->id);
	            
// 	            if($stockMore ->status == IOStatus::STOCKED)
// 	            {
// // 	                 if($IsOutStock)
// // 	                 {
// // 	                     $InventoryService=new InventoryService();
	                     
// // 	                 }
// // 	                 else 
// // 	                 {
// 	                     $InventoryService=new InventoryService();
// 	                     if($InventoryService->checkInventoryNum($stockMore->id, $from_item_id, $qty))
// 	                     {
// 	                         $InventoryService->changeItemIdByRelationId($stockMore->id,$from_item_id,$to_item_id);
// 	                     }
// 	                     else 
// 	                         throw new StockIOException("can not update sku bacause some has been used OR QTY is NOT equal!");
// // 	                 }
// 	            }
// 	            //BOOK
// 	            else
// 	            {
// 	                 if($IsOutStock)
// 	                 {
// 	                     $InventoryService=new InventoryService();
// 	                     $InventoryBookService=new InventoryBookService();
// 	                     $InventoryBookService->changeItemIdByRelationId($stockMore->id,'io',$from_item_id,$to_item_id);
	                     
// 	                 }
// 	                 else 
// 	                 {
	                     
// 	                 }
// 	            }
// 	        }
	       
// 	    }
// 	    return true;
	}
	
	
	/**
	 * 更改stock detail 的 item_id
	 * status 为  NOT_STOCK 时 直接改
	 * status 为  STOCKED 时 直接改 到 inventoryService 中改
	 * status 为  BOOKED 时 直接改 到 inventoryBookService 中改
	 * @param integer $relation_id
	 * @param string $type
	 * @param integer $agent
	 * @param integer $from_item_id
	 * @param integer $to_item_id
	 *
	 * @return bool
	 */
	public function updateStockInIOItemId($relation_id,$type,$agent,$from_item_id,$to_item_id)
	{
	   $inStocks = $this->stockFindByRelationID($relation_id,array($type))->get();

		foreach($inStocks as $stockin)
		{
			$stockin = $this->stockFindByID($stockin->id);

			if($stockin->status == IOStatus::STOCKED){////已入库不让修改		
				throw new StockIOException("has been inventoryed !");
			}

			//更改该入库单
			foreach($stockin->details as $detail)
			{
			    if($detail->item_id == $from_item_id)
			    {
			        $detail->item_id = $to_item_id;
			        $detail->save();
			    }
			}				
		}

		return true;
	}
	
	/**
	 * @param integer $relation_id
	 * @param integer $detail_id
	 * @param string $type
	 * @param integer $agent
	 * @param integer $to_qty
	 */
	public function updateStockIOOutQty($relation_id,$detail_id,$type,$agent,$to_qty)
	{
	    $stocksModel = $this->stockFindByRelationID($relation_id,array($type));
	    foreach($stocksModel as $m)
	    {
	        if($m->status == IOStatus::STOCKED)
	        {	
				throw new StockIOException("do not how to change ! has been inventoryed !");
			}
			if($m->status == IOStatus::BOOKED)
			{
			    throw new StockIOException("do not how to change ! has been booked !");
			}
			
			foreach($m->details as $detail)
			{
			    if($detail->id == $detail_id)
			    {
			        $detail->qty=$to_qty;
			        $detail->save();
			    }
			}
	    }
	    
	    return true;
	}
	
	/**
	 * @param integer $relation_id
	 * @param integer $detail_id
	 * @param string $type
	 * @param integer $agent
	 * @param integer $to_qty
	 */
	public function updateStockIOInQty($relation_id,$detail_id,$type,$agent,$to_qty)
	{
	    $stocksModel = $this->stockFindByRelationID($relation_id,array($type));
	    foreach($stocksModel as $m)
	    {
	        if($m->status == IOStatus::STOCKED)
	        {
	            throw new StockIOException("do not how to change ! has been inventoryed !");
	        }
	        if($m->status == IOStatus::BOOKED)
	        {
	            throw new StockIOException("do not how to change ! has been booked !");
	        }
	        	
	        foreach($m->details as $detail)
	        {
	            if($detail->id == $detail_id)
	            {
	                $detail->qty=$to_qty;
	                $detail->save();
	            }
	        }
	    }
	     
	    return true;
	}
    
	/**
	 * @param integer $pk
	 * @return integer
	 */
	public function getSumQtyByPk($pk)
	{
	   $model= $this->stockFindByID($pk);
	   $qty =0;
	   foreach($model->details as $detail)
	   {
	       $qty += $detail->qty;
	   }
	   return $qty;
	}
}