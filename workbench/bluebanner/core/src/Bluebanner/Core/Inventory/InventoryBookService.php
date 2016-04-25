<?php namespace Bluebanner\Core\Inventory;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\InventoryBook;
use Bluebanner\Core\Model\InventoryMaster;

use Bluebanner\Core\Inventory\bookStatus;

use Bluebanner\Core\InventoryBookException;

use Bluebanner\Core\Model\StockIOMaster;

class InventoryBookService implements InventoryBookServiceInterface
{

//	var bookItem = array();
//	var bookArray = array();

	/**
	* book 库存
	* 一个完整的单调用一次这个含税，方便判断是否缺库存
	* @param (object) $arr 
	*	array(
	*		relation_id => 1,  //order_id / oi_id
	*		type => 'io/order',
	*		warehouse_id => 1,
	*		a_id_arr => array(),//渠道id数组
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
	public function bookInventory(array $arr)
	{
		//类别不能为空
		if(!isset($arr['type'])) throw new InventoryBookException("Book 库存未传入类型[order / stock io]");
		
		//是否已经book过
		$book = $this->getBookInfoByRelationId($arr['type'],$arr['relation_id'],array(bookStatus::PENDING,bookStatus::DONE))->toArray();
		if(is_array($book) && (count($book) > 0))
			throw new InventoryBookException(" Book Info exist for[".$arr['invoice']."],pls check ");

		//是否有明细
		if(count($arr['details']) ==0)
			throw new InventoryBookException(" details not exists ");

		//第一次检测库存数否足够[合并sku，明细中有多个sku相同的记录合并判断，方便界面用户自己调拨]
		$result = $this->checkAllBookInventory($arr);
		if($result['f'] =='0')
			throw new InventoryBookException("库存不够\n".$result['m']);//有数组
		
		//插入库book记录到book表，更改book表数量
		if(!$this->bookAction($arr)) return false;
		
		return true;
	}

	/*查找对应相关id的book信息*/
	public function getBookInfoByRelationId($type,$relation_id,$status)
	{

		$r =  InventoryBook::where('type','=',$type)
		->where('relation_id','=',$relation_id);

		is_array($status) ? $r->whereIn('status',$status) : $r->where('status','=',$status);

		return $r->get();
	}

	/**
	*  判断库存是否足够
	*
	* @param
	* @desc 
	*/
	protected function checkAllBookInventory(array $arr){
		$return = array('f' =>'1','m' => '');
		$skus = array();
		foreach($arr['details'] as  $k => $detail){
			$i = $detail['item_id'];
			$skus[$i] = isset($skus[$i]) ? $skus[$i] + $detail['qty'] : $detail['qty'];
		}

		foreach($skus as $item_id => $qty){
			$qtyCount = InventoryMaster::withoutBookQtySumByItem($arr['warehouse_id'],'',$item_id);

			$qtyCount = $qtyCount ? $qtyCount :0;
			if(($qtyCount - $qty) <0){
				$return['f'] = 0;
				$item = Item::find($item_id);
				$return['m'] .= $item->sku.":".($qtyCount - $qty)."\n";
			}
		}

		return $return;
	}

	/* book one detail--不在统一判断库存，只要出现不够的就抛出异常
	*  array(
	*		relation_id => 1,  //order_id / oi_id
	*		type => 'io/order',
	*		warehouse_id => 1,
	*		a_id_arr => array(),//渠道id数组
	*		details => array(
	*			relation_detail_id => 1,  //order_detail_id / oi_detail_id
	* 			item_id	=> 1,
	* 			qty	=> 1,
	*		)
	*	)
	*/
	protected function bookAction(array $arr){
			//循环明细
			foreach($arr['details'] as  $key => $detail){
				$item_id 			= $detail['item_id'];
				$relation_detail_id = $detail['relation_detail_id'];
				$qty 				= $detail['qty'];

				$conditions = array(
					'warehouse_id' 	=> array('c' => '=',	'v' => $arr['warehouse_id']),
					'item_id' 		=> array('c' => '=',	'v' => $item_id),
					'io_at' 		=> array('c' => 'order','v' => 'asc'),//先进先出
					'limit'		 	=> array('c' => '=',	'v' => '1'),//一次取一条
					//渠道稍后考虑
				);

				//这里每次明细都查找一次库存，原先的prepare是先找出所有订单的所有sku，然后再进行prepare
				if($this->book($arr['relation_id'],$arr['type'],$relation_detail_id,$qty,$conditions) ===false)
				{				
					$item = Item::find($item_id);
					throw new InventoryBookException("库存book失败:".$item->sku."/".$item_id);
				}


			}

			return true;
	}

	//不够库存的递归调用下一条
	protected function book($relation_id,$type,$relation_detail_id,$qty,$conditions = array())
	{
		if($qty <=0) return true;

		$inv =  head(InventoryMaster::withoutBookInventoryRecords($conditions)->get()->toArray());
		if(!$inv)  throw new InventoryBookException("不好意思，没有可用库存了...");


		$invalid_qty = $inv['invalid_qty'];
		if($invalid_qty <=0) {
		 	throw new InventoryBookException("不好意思，没有可用库存了...");
		}
		
		$book_qty = $inv['book_qty'];

		//初始化插入到book表的数组插入记录到book表
		$book = array(
					'inventory_id' => $inv['id'],
					'relation_id'  => $relation_id,
					'relation_detail_id' => $relation_detail_id,
					'qty'			=> $qty,
					'type'			=> $type,
					'status'		=> 'pending'//default
				);

		if($invalid_qty >= $qty)
		{
			$update_data = array('book_qty' => ($book_qty + $qty));
			if(!InventoryMaster::find($inv['id'])->update($update_data)) {return false;}//保存book数量到库存主表

			if(!InventoryBook::create($book)) {return false;}//插入book记录

			return true;
		}else{
			//保存book数量到库存主表
			$update_data = array('book_qty' => ($book_qty + $invalid_qty));
			if(!InventoryMaster::find($inv['id'])->update($update_data)) return false;

			//插入记录到book表
			$book['qty'] = $invalid_qty;
			if(!InventoryBook::create($book)) return false;

			$next_qty = $qty - $invalid_qty;
			$this->book($relation_id,$type,$relation_detail_id,$next_qty,$conditions);
		}

	}

	/**
	* 解除book 库存
	*
	* @param
	* @desc 
	*/
	public function offBookInventory($relation_id,$type,$tostatus = bookStatus::CANCEL)
	{
		//找出book表中的pending记录
		$books = $this->getBookInfoByRelationId($type,$relation_id,bookStatus::PENDING);
		if(!$books) 	throw new InventoryBookException("unbook失败:找不到pending的book记录");
		foreach($books as $book){
			//减去库存book数量
			$inventory = InventoryMaster::find($book->inventory_id);
			$update_data = array('book_qty' => ((int)$inventory->book_qty - (int)$book->qty));
			
			if(!$inventory->update($update_data)) 
				throw new InventoryBookException("unbook失败:更新库存book数量失败!");
		}

		//批量更新book的状态
		if(!InventoryBook::where('relation_id', '=', $relation_id)
		->where('status','=',bookStatus::PENDING)
		->where('type','=',$type)
		->update(array('status' => $tostatus)))
			throw new InventoryBookException("unbook失败:更新book失败!");

		return true;
	}

	/*
	* 更改book记录状态
	*/
	public function changeStatus($relation_id,$fStatus,$tStatus,$type)
	{
		//批量更新book的状态
		if(!InventoryBook::where('relation_id', '=', $relation_id)
		->where('status','=',$fStatus)
		->where('type','=',$type)
		->update(array('status' => $tStatus)))
			throw new InventoryBookException("更新book状态失败!");

		return true;
	}
	
	/**
	 * 
	 * @param integer $relation_id
	 * @param string $type (enum 'io' , 'order')
	 * @param integer $from_item_id
	 * @param integer $to_item_id
	 * @return boolean
	 */
	public function changeItemIdByRelationId($relation_id,$type,$from_item_id,$to_item_id)
	{
	    $book=InventoryBook::where('relation_id', '=', $relation_id)
	    ->where('status','=','pending')
	    ->where('type','=',$type)
	    ->all();
	    if(count($book)<1)
	    {
	        throw new InventoryBookException("没有可以修改的book库存");
	    }
	    else 
	    {
	        InventoryBook::where('relation_id', '=', $relation_id)
	        ->where('status','=','pending')
	        ->where('type','=',$type)
	        ->update(array(
	            
	        ));
	    }
	    return true;
	}
	
	/**
	 * @param array $search_condition
	 * @return Ambigous <\Illuminate\Database\Eloquent\Builder, \Illuminate\Database\Eloquent\static, \Illuminate\Database\Eloquent\Builder>
	 */
    public function findBookByCondition(array $search_condition)
    {
        //OrderRelations  OrderDetailRelations 未完成所以这里暂时注释
       // $temp=InventoryBook::with('inventory','IORelations','IOdetailRelations','OrderRelations','OrderDetailRelations');
        $temp=InventoryBook::with('inventory','IORelations','IODetailRelations');
        foreach($search_condition as $condition)
        {
            if($condition['opera'] == "in")
            {
                $temp->whereIn($condition['field'],$condition['value']);
            }
            else
            {
                $temp->where($condition['field'],$condition['opera'],$condition['value']);
            }
        }
        return $temp;
    }
    
    /**
     * 
     * @param string $invoice
     * @return array 
     */
    public function getRelationIdByInvoice($invoice)
    {
        
        $IOModel=new StockIOMaster();
        $io_ids=DB::table($IOModel->getTable())->where('invoice','like','%'.$invoice.'%')->lists('id');
        if(!is_array($io_ids)) $io_ids=array();
        
        // order 表未建立所以此处留空   order表获取ids的方式同上
        //
        //
        $order_ids=array();
        
        return array_merge($io_ids,$order_ids);
    }
}