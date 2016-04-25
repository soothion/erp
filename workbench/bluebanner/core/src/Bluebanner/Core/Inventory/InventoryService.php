<?php namespace Bluebanner\Core\Inventory;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\InventoryAllocate;
use Bluebanner\Core\Model\InventoryChange;
use Bluebanner\Core\Model\InventoryMaster;
use Bluebanner\Core\Model\InventoryBook;
use Bluebanner\Core\Inventory\bookStatus;
use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;

use Bluebanner\Core\Inventory\InventoryBookService;

use Bluebanner\Core\Inventory\InvType;
use Bluebanner\Core\InventoryException;

class InventoryService implements InventoryServiceInterface
{

	/**
	 * 实时库存查询
	 */
	public function query($warehouse_id = null, $item_id = null, array $status, array $condition)
	{
		$query = InventoryMaster::select(DB::raw('sum(`qty`) as `qty`, sum(`book_qty`) as `book_qty`, item_id, warehouse_id, account_id, status, `condition`'));

		$warehouse_id ? $query->where('warehouse_id', '=', $warehouse_id) : '';
		$item_id ? $query->where('item_id', '=', $item_id) : '';
		$status ? $query->whereIn('status', $status) : '';
		$condition ? $query->whereIn('condition', $condition) : '';

		$query->groupBy('item_id', 'warehouse_id', 'status', 'condition');
		return $query;
	}

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
	* array search_condition
	*			array(
	*				account_id => array('c' => '=','v' => 1),
	*				id         => array('c' => 'order','v'='asc')
	*			)
	*
	*/
	public function inventoryFindByCondition(array $search_condition = null)
	{
		return InventoryMaster::searching($search_condition)->orderBy('io_at', 'desc');
	}

	public function inventorySnapshotFindByCondition(array $change = null, array $master = null)
	{
		$builder = InventoryChange::searching($change)->with(array('inventory' => function($query) use ($master) {
			$query->searching($master);
		}))->groupBy('inventory_id')->orderBy('created_at', 'desc');

		return $builder;
	}

	public function logsByCondition(array $condition = null)
	{

		return InventoryChange::searching($condition)->orderBy('created_at', 'desc');
	}

	public function ioSearching(array $master = null, array $detail = null)
	{
		$builder = StockIOMaster::searching($master)->with(array('details' => function($query) use ($detail) {
			$query->searching($detail);
		}))->orderBy('created_at', 'desc');

		return $builder;
	}

	public function blanceSearching(array $condition)
	{
		return InventoryChange::searching($condition)->with('item','warehouse');
	}

	/*
	* @desc 获取balance的期初余额,条件里面的时间是balance的
	*
	*/
	public function balanceStart($warehouse_id,$item_id,$created_at)
	{
		return InventoryChange::where('warehouse_id','=',$warehouse_id)
		->where('item_id','=',$item_id)
		->where('created_at','<',$created_at)
		->orderBy('created_at', 'desc')
		->take(1);
	}

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
	*			array condition style
	*			array(
	*				account_id => array('c' => '=','v' => 1),
	*				id         => array('c' => 'order','v'='asc')
	*			)
	*/
	public function validInventory(array $condition = null)
	{
		return InventoryMaster::withoutBookInventory($condition);
	}

	public function validQtySumByItem($warehouse_id,$account_id = '',$item_id,$condition ='normal')
	{
		return InventoryMaster::withoutBookQtySumByItem($warehouse_id,$account_id,$item_id,$condition);
	}
	
	/*获取库存总数，包含book*/
	public function getQtySumByItem($warehouse_id,$account_id = '',$item_id,$condition ='normal',$status = '1')
	{
		return InventoryMaster::withBookQtySumByItem($warehouse_id,$account_id,$item_id,$condition,$status);
	}

	/*
	* 删除对应批次的onroad库存记录,只有onroad才可以删除
	*/
	public function deleteOroadInventoryByRestock($restock_id)
	{

		$onroad = InventoryMaster::where('status','=',0)->where('restock_id','=',$restock_id);
		$onroadValue = $onroad->get();

		if(count($onroadValue) >0){
			return $onroad->delete();
		}

		return true;
	}

	/**
	* 扣除库存--根据book的完成记录，减去库存数量，不删库存表记录
	* 
	* @param
	* 
	*/
	public function cutQuantityByBooked($relation_id,$booktype,$io_type,$agent)
	{
		//获取对应的book记录
		$doneBooks = with(new InventoryBookService)->getBookInfoByRelationId($booktype,$relation_id,bookStatus::DONE);
		if(!$doneBooks  || (count($doneBooks->toArray()) <=0))
			throw new InventoryException("找不到对应的booked记录！");

		foreach($doneBooks as $donebook){
			//减去库存数量
			$inventory = InventoryMaster::find($donebook->inventory_id);
			//这时候的库存
			$balance = $this->getQtySumByItem($inventory->warehouse_id,'',$inventory->item_id);

			$update_data = array('qty' => ((int)$inventory->qty - (int)$donebook->qty));
			if(!$inventory->update($update_data))
				throw new InventoryException("更新库存数量失败!");

			//追加库存日志
			$logArr = array(
				'warehouse_id' 	=> $inventory->warehouse_id,
				'inventory_id' 	=> $inventory->id,
				'item_id'		=> $inventory->item_id,
				'relation_id'	=> $relation_id,
				'agent'			=> $agent,
				'type'			=> $io_type,
				'qty'			=> (-$donebook->qty),
				'balance' 		=> ($balance - $donebook->qty),//这时候的库存减掉了
				);

			if(!$this->writeToLog($logArr))
				throw new InventoryException("更新日志失败!");
		}

		return true;
	}

	/**
	* 反出库，此时按照book的记录将库存加回去
	* @param $relation_id  对应book表得relation_id(io是出入库单id，order是包裹表id)
	* @param $booktype     book表类别(io是出入库单，order是包裹表)
	* @param $io_type      出入库类别
	* @param $agent        当前用户
	* @param $ioToStatus   反回去对应出库单得状态 0-not stock; 2- booked
	* 前提：只有已经完成得出库单或者订单才可以返回
	* 
	*/
	public function addQuantityByRevrese($relation_id,$booktype,$io_type,$agent,$ioToStatus = '0')
	{
		//获取对应的book记录
		$doneBooks = with(new InventoryBookService)->getBookInfoByRelationId($booktype,$relation_id,bookStatus::DONE);
		if(!$doneBooks  || (count($doneBooks->toArray()) <=0))
			throw new InventoryException("找不到对应的booked记录！");

		foreach($doneBooks as $donebook){
			//减去库存数量
			$inventory = InventoryMaster::find($donebook->inventory_id);
			//
			$balance = $this->getQtySumByItem($inventory->warehouse_id,'',$inventory->item_id);

			$update_data = array('qty' => ((int)$inventory->qty + (int)$donebook->qty));

			//如果是返回booked状态，则将库存表中得book数量也加上去
			if($ioToStatus == 2){
				$update_data['book_qty'] = (int)$inventory->book_qty + (int)$donebook->qty;
			}

			if(!$inventory->update($update_data))
				throw new InventoryException("更新库存数量失败!");

			//追加库存日志
			$logArr = array(
				'warehouse_id' 	=> $inventory->warehouse_id,
				'inventory_id' 	=> $inventory->id,
				'item_id'		=> $inventory->item_id,
				'relation_id'	=> $relation_id,
				'agent'			=> $agent,
				'type'			=> InvType::Inventory_Reverse_Out,
				'qty'			=> ($donebook->qty),
				'balance' 		=> ($balance + $donebook->qty),//这时候的库存已经减掉了
				'description'	=> '反出库，此时将库存加回去'
				);

			if(!$this->writeToLog($logArr))
				throw new InventoryException("更新日志失败!");

		}

		return true;
	}


	/**
	* 扣除库存--减去数量，不删库存表记录
	* @param $do_type是指在入库单返回还是在原单返回
	* 入库单返回：将库存的状态变成0，反向增加日志
	* 原单返回：将库存的对应记录删除，反向增加日志
	* @param $restock_id 对应入库单id
	* 
	*/
	public function cutQuantityByRevrese($restock_id,$io_type,$agent,$do_type)
	{
		$flag =1;
		//找出对应入库单的数据
		$stock = StockIOMaster::with('details')->find($restock_id);//with('details')->where('id','=',$restock_id)->get();
		$item = array();
		$inv = array();

		foreach($stock->details as $detail)
		{
			$item[$detail->item_id] = isset($item[$detail->item_id]) ? ($item[$detail->item_id]+($detail->backup_qty+$detail->qty)) : ($detail->backup_qty+$detail->qty);

			if(!isset($inv[$detail->item_id]))
			{
				//找出对应库存的数据
				$i = InventoryMaster::where('restock_id','=',$restock_id)->where('item_id','=',$detail->item_id)->get();
				foreach($i as $_i)
				{
					if ($_i->book_qty > 0) return array('f' => '0','m' => "库存已经被book，请检查对应的SKU的订单和出库单[".$detail->item->sku."]");
					$valid_q = $_i->qty - $_i->book_qty;
					$inv[$detail->item_id] = isset($inv[$detail->item_id]) ? ($inv[$detail->item_id]+$valid_q) : $valid_q;
				}
			}
		}

		//对比库存和入库单的数据是否对应的上		
		foreach ($item as $item_id => $q) 
		{
			if($q != $inv[$item_id]) $flag = 0;
			break;
		}
		if(($flag ==0) || (count($item) != count($inv)) || (!$inv) || (!$item))
			return array('f' => '0','m' => '入库单和库存数量对不上');
		
		//删除前先找出库存
		$inventorys = InventoryMaster::where('restock_id','=',$restock_id)->get();

		foreach ($inventorys as $inventory) {
			$balance = $this->getQtySumByItem($inventory->warehouse_id,'',$inventory->item_id);
			

			if($do_type=='stock')//入库单返回未入库状态，只是更改库存状态，
			{
				$desc = $stock->invoice."反入库";
				if(!$inventory->update(array('status' => 0)))
					return array('f' => '0','m' => '将库存返回未入库状态失败');
			}
			else//原单要删除库存，//删除库存，删除库存日志--如果没有软删除则需要返回增加
			{
				$desc = $stock->relation_invoice."反入库";
				if(!$inventory->delete())
					return array('f' => '0','m' => '删除库存记录失败');
			}
							
			$logArr = array(
				'warehouse_id' 	=> $inventory->warehouse_id,
				'inventory_id' 	=> $inventory->id,
				'item_id'		=> $inventory->item_id,
				'relation_id'	=> $restock_id,
				'agent'			=> $agent,
				'type'			=> InvType::Inventory_Reverse_In,
				'qty'			=> (-$inventory->qty),
				'balance' 		=> ($balance - $inventory->qty),//这个balance是已经返回的数量
				'description'	=> $desc
				);

			if(!$this->writeToLog($logArr))
				return array('f' => '0','m' => '更新日志失败');
		}

		return array('f' =>'1','m' => 'success');
	}

	/**
	* 批次入库存
	* 
	* @param (int) $restock_id   批次号
	* @param (int) $status 	     更改以后的状态 //1是入库； 0是反入库
	* @param (arr) $item_price   参考的价格信息	
	* @param (int) $po_id   	 采购单id	
	* @param (str) $description  本次操作的描述
	*  
	*/
	public function updateInventoryByRestock($restock_id,$type,$status,$item_price = array(),$po_id ='',$description)
	{
		$rstatus = ($status ==1) ?  0 : 1;
		$io_at = ($status ==1) ? date('Y-m-d H:i:s') : '';
		//找出该批次的信息
		$info = InventoryMaster::where('restock_id','=',$restock_id)->where('status','=',$rstatus);
		if(!$inventory = $info->get())
			throw new InventoryException("库存信息不对!");

		foreach ($inventory as $inv) {
			//应该在未更改前查询数据
			$balance = $this->getQtySumByItem($inv->warehouse_id,'',$inv->item_id);

			//改价格
			if(!$inv->update(array(
				'rmbprice' 	 => isset($item_price[$inv->item_id]) ? $item_price[$inv->item_id]['rmbprice'] : '',
				'localprice' => isset($item_price[$inv->item_id]) ? $item_price[$inv->item_id]['localprice'] : '',
				'status' 	 => $status,
				'po_id' 	 => $po_id,
				'io_at'		 => $io_at
			)))
			throw new InventoryException("更新库存错误!");

			$qty = ($status ==1) ? $inv->qty : (-$inv->qty);
			$logArr = array(
					'warehouse_id' 	=> $inv->warehouse_id,
					'inventory_id' 	=> $inv->id,
					'item_id'		=> $inv->item_id,
					'relation_id'	=> $restock_id,
					'agent'			=> '1',//以后改当前用户
					'type'			=> $type,
					'qty'			=> $inv->qty,
					'balance' 		=> ($balance + $inv->qty),
					'description'	=> $description
				);
			if(!$this->writeToLog($logArr))
				throw new InventoryException("追加库存日志错误!");
		}

		//批量更新库存状态--去掉，之前已经在明晰中更新了
		//$xx = $info->update(array('status' => $status,'po_id' => $po_id,'io_at' => $io_at));
		
		return true;
	}
		

	/*
	* 
	*/
	public function updateInventoryByShipment($restock_id,$type,$status,$outRestockArr = array(),$description)
	{
		$rstatus = ($status ==1) ?  0 : 1;
		$io_at = ($status ==1) ? date('Y-m-d H:i:s') : '';
		//找出该批次的信息
		$info = InventoryMaster::where('restock_id','=',$restock_id)->where('status','=',$rstatus);
		if(!$inventory = $info->get())
			throw new InventoryException("库存信息不对!");

		//获取出库批次的库存信息－－价格信息
		$outInventory = array();
		if(count($outRestockArr) >0)
		{
			$doneBooks = InventoryBook::with('inventory')
			->whereIn('relation_id',$outRestockArr)
			->where('type','=','io')
			->groupBy('inventory_id')
			->get();//一个出库库存只取一次

			foreach($doneBooks as $book)
			{
				$item = $book->inventory->item_id;
				if(!isset($outInventory[$item]))
				{
					$outInventory[$item]['rmbprice'] 	= $book->inventory->rmbprice;//没有计算成本因子
					$outInventory[$item]['localprice']  = $book->inventory->localprice;//没有成本因子和报关费。。。
					$outInventory[$item]['po_id'] 		= $book->inventory->po_id;
				}
			}
		}			

		foreach ($inventory as $inv) {
			//应该在未更改前查询数据
			$balance = $this->getQtySumByItem($inv->warehouse_id,'',$inv->item_id);
			$sku = Item::find($inv->item_id);

			if(!isset($outInventory[$inv->item_id]))
				throw new InventoryException($sku->sku."没有可参考的出库批次!");

			if(($outInventory[$inv->item_id]['rmbprice'] <=0) || ($outInventory[$inv->item_id]['localprice'] <=0))
				throw new InventoryException($sku->sku."没有库存价格!");

			//改价格
			if(!$inv->update(array(
				'rmbprice' 	 => isset($outInventory[$inv->item_id]) ? $outInventory[$inv->item_id]['rmbprice'] : '',
				'localprice' => isset($outInventory[$inv->item_id]) ? $outInventory[$inv->item_id]['localprice'] : '',
				'status' 	 => $status,
				'po_id' 	 => isset($outInventory[$inv->item_id]) ? $outInventory[$inv->item_id]['localprice'] : 0,
				'io_at'		 => $io_at
			)))
			throw new InventoryException("更新库存错误!");

			$qty = ($status ==1) ? $inv->qty : (-$inv->qty);
			$logArr = array(
					'warehouse_id' 	=> $inv->warehouse_id,
					'inventory_id' 	=> $inv->id,
					'item_id'		=> $inv->item_id,
					'relation_id'	=> $restock_id,
					'agent'			=> '1',//以后改当前用户
					'type'			=> $type,
					'qty'			=> $inv->qty,
					'balance' 		=> ($balance + $inv->qty),
					'description'	=> $description
				);
			if(!$this->writeToLog($logArr))
				throw new InventoryException("追加库存日志错误!");
		}

		return true;
	}


	/**
	* 更新其入库，库存价格，及状态
	*/
	public function updateInventoryByLastRecord($restock_id,$type,$status,$description)
	{
		$rstatus = ($status ==1) ?  0 : 1;
		$io_at = ($status ==1) ? date('Y-m-d H:i:s') : '';
		//找出该批次的信息
		$info = InventoryMaster::where('restock_id','=',$restock_id)->where('status','=',$rstatus);
		if(!$inventory = $info->get())
			throw new InventoryException("库存信息不对!");
		
		foreach ($inventory as $inv)
		{
			//应该在未更改前查询数据
			$balance = $this->getQtySumByItem($inv->warehouse_id,'',$inv->item_id);

			//获取最后一条记录的价格
			$info = $this->getLastRecord($inv->item_id,$inv->warehouse_id,$inv->condition)->get()->toArray();
			if(!$info)
				throw new InventoryException("没有最后一条记录!");
			$info = $info[0];

			$data = array( 
				'rmbprice'		=> $info['rmbprice'],
				'localprice'	=> $info['localprice'],
				'pi_price'		=> $info['pi_price'],
				'status'		=> 1,
				'po_id'			=> $info['po_id'],
				'status' 		=> $status,
				'io_at' 		=> $io_at
				);

			//改价格
			if(!$inv->update($data))
			throw new InventoryException("更新库存错误!");

			
			$qty = ($status ==1) ? $inv->qty : (-$inv->qty);
			$logArr = array(
					'warehouse_id' 	=> $inv->warehouse_id,
					'inventory_id' 	=> $inv->id,
					'item_id'		=> $inv->item_id,
					'relation_id'	=> $restock_id,
					'agent'			=> '1',
					'type'			=> $type,
					'qty'			=> $inv->qty,
					'balance' 		=> ($balance + $inv->qty),
					'description'	=> $description
				);
			if(!$this->writeToLog($logArr))
				throw new InventoryException("追加库存日志错误!");
		}

		return true;
	}


	/**
	* 
	* 获取仓库最后出库批次SKU的记录,一般
	* @param $item_id
	* @param $condition
	* @param $whid
	* @return array
	*/
	public function getLastRecord($item_id, $whid,$condition = 'normal')
	{
		//找出该批次的信息
		$info = InventoryMaster::where('item_id','=',$item_id)
		->where('status','=',1)
		->where('condition','=',$condition)
		->where('warehouse_id','=',$whid)
		->orderBy('io_at','desc')
		->take(1)->withTrashed();

		return $info;
	}
	

	/**
	* 创建库存记录
	*
	* @param $id 被复制的库存id
	* @return array
	*/
	public function copyInventoryRecord($id)
	{
		return InventoryMaster::find($id);
	}

	/**
	* 创建库存记录
	*
	* @param array $detail
 	* array(
 	*	'warehouse_id' 	=> $stockin->warehouse_id,
	*	'item_id'		=> $detail->item_id,
	*	'qty'			=> $detail->qty + $detail->backup_qty,
	*	'account_id'	=> 0,
	*	'restock_id'	=> $stockin_id / package_id
	* )
	*  
	* array(
 	*		'warehouse_id' 	=> $inventory->warehouse_id,
	*		'inventory_id' 	=> $inventory->id,
	*		'item_id'		=> $inventory->item_id,
	*		'relation_id'	=> $relation_id,
	*		'agent'			=> $agent,
	*		'type'			=> $io_type,//invType里面找对应的类别
	*		'qty'			=> (-$donebook->qty),//大于的数量不管，小于的数量带0
	*		'balance' 		=> 本次更新后的实际库存
	*	);
	*/
	public function addInventoryRecord(array $detail,$logArr= array())
	{
		$i = InventoryMaster::create($detail);

		if(is_array($logArr) && (count($logArr) >0)){
			$logArr['inventory_id'] = $i->id;
			$this->writeToLog($logArr);
		}

		return $i;
	}

	/**
	* 写库存日志
	* 
	* @param array $logArr
 	* 	array(
 	*		'warehouse_id' 	=> $inventory->warehouse_id,
	*		'inventory_id' 	=> $inventory->id,
	*		'item_id'		=> $inventory->item_id,
	*		'relation_id'	=> $relation_id,
	*		'agent'			=> $agent,
	*		'type'			=> $io_type,//invType里面找对应的类别
	*		'qty'			=> (-$donebook->qty),//大于的数量不管，小于的数量带0
	*		'balance' 		=> 本次更新后的实际库存
	*	);
	*  
	*/
	public function writeToLog(array $logArr)
	{
		if(!InventoryChange::create($logArr)) return false;
		return true;
	}

	/**
	*
	* 检测库存，如果出现负数的，立刻写入最高级别的System Notice
	*/
	public function checkInventory()
	{

	}

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
	public function splitInventoryByStock($or_id,$nr_id,$s_details)//这个含税稍后需要考虑不同状态
	{
		//整理拆出来的detail
		$split_item = array();
		foreach ($s_details as $id => $d) {
			$item_id = $d['item_id'];
			$split_item[$item_id] = isset($split_item[$item_id]) ? ($split_item[$item_id] + $d['qty'] + $d['backup_qty']) : ($d['qty'] + $d['backup_qty']);
		}

		try{
			foreach ($split_item as $item_id => $qty) {
				$invs = InventoryMaster::where('restock_id','=',$or_id)
				->where('item_id','=',$item_id)
				->where('status','=',0)->get()->toArray();

				//被拆的sku于库存的比较和判断
				foreach ($invs as $k => $i) {
					$newRecord = array();
					$newRecord = $i;
					unset($newRecord['id']);
					$newRecord['created_at'] = $newRecord['updated_at'] = date('Y-m-d');
				
					if($i['qty'] >= $qty){
						//新单的插入
						$newRecord['qty'] = $qty;
						$newRecord['restock_id'] = $nr_id;
						$this->addInventoryRecord($newRecord);

						//原库存记录减少该数量
						$releave_qty = ($i['qty'] - $qty);
						$invs[$k]['qty'] = $releave_qty;
						if(!InventoryMaster::find($i['id'])->update(array('qty' => $releave_qty)))
							throw new InventoryException('拆分库存记录失败');

						break;
					}else{
						//新单的插入
						$newRecord['qty'] = $i['qty'];
						$newRecord['restock_id'] = $nr_id;
						$this->addInventoryRecord($newRecord);

						//原库存记录减少该数量，
						$invs[$k]['qty'] = $releave_qty = 0;
						if(!InventoryMaster::find($i['id'])->update(array('qty' => $releave_qty)))
							throw new InventoryException('拆分库存记录失败');
						continue;//接着找下一跳记录
					}
				}
			}

		}catch(Exception $e){
			throw new InventoryException($e->Message);
		}

		
		return true;
	}
	
	/**
	 * 检查数量是否相同
	 * 
	 * @param integer $restock_id
	 * @param integer $item_id
	 * @param integer $compare_qty
	 * @return boolean
	 */
	public function checkInventoryNum($restock_id,$item_id,$compare_qty)
	{
	    $qty=$this->getInventoryNumByRestockIdAndItemId($restock_id,$item_id);
	    return $qty==$compare_qty;
	}
	
	/**
	 * 获取相关id的某个Itemid的数量
	 * 
	 * @param integer $restock_id
	 * @param integer $item_id
	 * @return number
	 */
	public function getInventoryNumByRestockIdAndItemId($restock_id,$item_id)
	{
	    $IMs=InventoryMaster::where("restock_id",'=',$restock_id)->where('item_id','=',$item_id);
	    $qty=0;
	    foreach($IMs as $im)
	    {
	        $qty +=$im->qty;
	    }
	    return $qty;
	}
	
	
	/**
	 * 
	 * @param integer $relation_id
	 * @param unknown $type
	 * @param integer $agent
	 * @param integer $from_item_id
	 * @param integer $to_item_id
	 * 
	 * @return array
	 */
	public function updateItemIdByRevrese($relation_id,$type,$agent,$from_item_id,$to_item_id)
	{
	    $flag =1;
	    //找出对应入库单的数据
	    $stock_details = StockIODetail::where('io_id','=',$relation_id)->get();
	    $item = array();
	    $inv = array();
	    
	    foreach($stock_details as $detail)
	    {
	        if($detail->item_id == $from_item_id)
	        {
    	        $item[$detail->item_id] = isset($item[$detail->item_id]) ? ($item[$detail->item_id]+($detail->backup_qty+$detail->qty)) : ($detail->backup_qty+$detail->qty);
    	        	
    	        if(!isset($inv[$detail->item_id]))
    	        {
    	            //找出对应库存的数据
    	            $i = InventoryMaster::where('restock_id','=',$relation_id)->where('item_id','=',$detail->item_id)->get();
    	            foreach($i as $_i){
    	                if ($_i->book_qty > 0) throw new InventoryException("库存已经被book，请检查对应的SKU的订单和出库单[$detail->item_id]");
    	                	
    	                $valid_q = $_i->qty - $_i->book_qty;
    	                $inv[$detail->item_id] = isset($inv[$detail->item_id]) ? ($inv[$detail->item_id]+$valid_q) : $valid_q;
    	            }
    	        }
	        }
	    }
	    
	    //对比库存和入库单的数据是否对应的上
	    if((count($item) != count($inv)) || (!$inv) || (!$item)) return array('f' => '0','m' => '入库单和库存数量对不上');
	    
	    foreach ($item as $item_id => $q)
	    {
	        if($q != $inv[$item_id]) $flag = 0;
	        break;
	    }
	    
	    if($flag ==0){return array('f' => '0','m' => '入库单和库存数量对不上');}
	    
	    //删除库存，删除库存日志--如果没有软删除则需要返回增加
	    
	    InventoryMaster::where('restock_id','=',$relation_id)
	    ->where('item_id','=',$from_item_id)
	    ->update(
	        array(
	            'item_id'=>$to_item_id,
	        )
	    );
	    
	    InventoryChange::where('type','=',$type)
	    ->where('relation_id','=',$relation_id)
	    ->update(
	        
	    );
	    
	    if(!InventoryMaster::where('restock_id','=',$restock_id)->delete() || !(InventoryChange::where('type','=',$io_type)->where('relation_id','=',$restock_id)->delete()))
	        return array('f' => '0','m' => '删除库存记录和库存日志失败');
	    
	    return array('f' =>'1','m' => 'success');
	}
	
	
	/**
	 * 修改某个item_id
	 * 
	 * @param integer $relation_id
	 * @param integer $agent
	 * @param integer $from_item_id
	 * @param integer $to_item_id
	 * @return bool
	 */
	public function changeItemIdByRelationId($relation_id,$agent,$from_item_id,$to_item_id)
	{
	   $master =  InventoryMaster::where("restock_id",'=',$restock_id)->where('item_id','=',$from_item_id)->all();
	   foreach($master as $m)
	   {
	       //未入库
	       if($m->status == 0)
	       {
	           $m->item_id=$to_item_id;
	           $m->save();
	       }
	       else
	       {
	          InventoryChange::where("inventory_id",'=',$m->id)
	          ->where("relation_id",'=',$relation_id)
	          ->where('item_id','=',$from_item_id)
	          ->update(array(
	              'item_id'  => $to_item_id,
	              'agent'    => $agent,
	          ));
	          
	       }
	   }
	   return true;
	}
	
	
	/**
	 * inventoryChange 查询
	 * @param array $conditions
	 * @return model
	 */	
	public function findAllChangesByConditions(array $conditions)
	{
	    $tmp = InventoryChange::where('id','>',0)->select('*');
	    foreach ($conditions as $value)
	    {
	        if(! isset($value['opera'])) $value['opera']='=';
	        if($value['opera'] == "in")
	        {
	            $tmp->whereIn($value['field'],$value['value']);
	        }
	        else
	        {
	            $tmp->where($value['field'],$value['opera'],$value['value']);
	        }
	    }
	    return $tmp->orderBy('created_at','DESC');
	}
	
	/**
	 * inventoryChange 查询
	 * @param array $conditions
	 * @return model
	 */
	public function findAllMasterByConditions(array $conditions)
	{
	    $tmp = InventoryChange::where('id','>',0)->select('*');
	    foreach ($conditions as $value)
	    {
	        if(! isset($value['opera'])) $value['opera']='=';
	        if($value['opera'] == "in")
	        {
	            if($value['value']!==false)
	            {
	                if(count($value['value'])<1)
	                {
	                    $tmp->where('id','=',-1);
	                }
	                else
	                    $tmp->whereIn($value['field'],$value['value']);
	            }   
	               
	        }
	        else
	        {
	            if($value['value']!==false)
	                $tmp->where($value['field'],$value['opera'],$value['value']);
	        }
	    }
	    return $tmp;
	}
	
	/**
	 * @param array $status
	 * @return array 
	 */
	public function findMasterIdsByStatus(array $status)
	{
	    $return=InventoryMaster::whereIn('status',$status)->lists('id');
	    if(empty($return)) return array();
	    else return $return;
	}
	
	/**
	 * @param array $condition
	 * @return array
	 */
	public function findMasterIdsByCondition(array $conditions)
	{
	    
	    $tmp = InventoryMaster::where('id','>',0);
	    foreach ($conditions as $value)
	    {
	        if(! isset($value['opera'])) $value['opera']='=';
	        if($value['opera'] == "in")
	        {
	            if($value['value']!==false)
	                $tmp->whereIn($value['field'],$value['value']);
	        }
	        else
	        {
	            if($value['value']!==false)
	                $tmp->where($value['field'],$value['opera'],$value['value']);
	        }
	    }
	    return $tmp->lists('id');
	}

}