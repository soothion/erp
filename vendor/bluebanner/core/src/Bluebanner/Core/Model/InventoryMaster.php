<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\InventoryException;
use Illuminate\Support\Facades\DB;

class InventoryMaster extends BaseModel
{
	
	protected $table = 'core_inventory_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
		
	public $rules = array();

	public function validate() 
	{
		
	}

	public function account()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Account');
	}

  public function platform() {
    return $this->belongsTo('Bluebanner\Core\Model\Platform');
  }
	
	public function item()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
	}

	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}

	public function restock()
	{
		return $this->belongsTo('Bluebanner\Core\Model\StockIOMaster');
	}

	//实际可用库存数据
	public static function withoutBookInventory(array $condition=null){
		$query = static::select(DB::raw('*,(qty - book_qty) as invalid_qty'))
				->where('status','=','1');

		if ($condition) {
			foreach ($condition as $field => $value) {
				($value['c'] == 'order') ? $query->orderBy('core_inventory_master.'.$field,$value['v']) : $query->where('core_inventory_master.'.$field,$value['c'],$value['v']);
			}
		}

		$query->having('invalid_qty','>',0);
		return $query;
	}


	//实际可用库存数据,返回得数据是实际记录，可用数量：qty-book_qty
	public static function withoutBookInventoryRecords($conditions=array()){
		$query = static::select(DB::raw('*,(qty - book_qty) as invalid_qty'))
				->where('status','=','1');

		if ($conditions) {
			foreach ($conditions as $f => $v) {
				$c = $v['c'];
				$value = $v['v'];

				if($c == 'order') {
					$query->orderBy($f,$value);
					continue;
				}
				if($f == 'limit'){
					$query->take($value);
					continue;
				}
				if($c == 'in'){
					$query->whereIn($f,$value);
					continue;
				}
				$query->where($f,$c,$value);
			}
		}


		if(!in_array('condition',array_keys($conditions))) {$query->where('condition','=','normal');}//默认normal
		
		$query->having('invalid_qty','>',0);
		return $query;
	}

	//实际可用库存按照item的总数
	public static function withoutBookQtySumByItem($warehouse_id,$account_id = '',$item_id,$condition = 'normal'){
		$query = static::select(DB::raw('sum(qty - book_qty) as sqty'))
				->where('warehouse_id','=',$warehouse_id)
				->where('item_id','=',$item_id)
				->where('condition','=',$condition)
				->where('status', '=', 1);
		if($account_id !=''){
			$query->where('account_id','=',$account_id);
		}

		$r = head($query->get()->toArray());

		return (isset($r['sqty']) && ($r['sqty'] >0)) ? $r['sqty'] : 0;
	}

	//实际可用库存按照item的总数--包含了book的数量
	public static function withBookQtySumByItem($warehouse_id,$account_id = '',$item_id,$condition = 'normal',$status = '1'){
		$query = static::select(DB::raw('sum(qty) as qty'))
				->where('warehouse_id','=',$warehouse_id)
				->where('item_id','=',$item_id)
				->where('condition','=',$condition)
				->where('status','=',$status);
		
		if($account_id !=''){
			$query->where('account_id','=',$account_id);
		}

		$r = head($query->get()->toArray());
		return (isset($r['qty']) && ($r['qty'] >0)) ? $r['qty'] : 0;
	}

  public function getInventoryByConds($conds, $pg = 1, $size = 16) {
    $result = $this->findByConds($conds, $pg, $size, 1)->select('*', DB::raw('sum(qty) as allQty, sum(book_qty) as allBookQty'))->groupBy('item_id', 'warehouse_id', 'status', 'condition')->get();

    foreach ($result as $inventory) {
      $inventory->item;
      $inventory->account;
    }

    return $result;
  }

  public function getLogsByOpts($conds, $pg, $size) {
    $result = $this->findByConds($conds, $pg, $size, 1)->select('*', DB::raw('sum(qty) as all_qty, sum(book_qty) as all_book_qty'))->groupBy('item_id', 'warehouse_id', 'platform_id', 'status')->get();

    foreach ($result as $log) {
      $log->item;
      $log->platform;
    }

    return $result;
  }


  public function logBuilderQuery() {
    return DB::table(InventoryChange::getTbl());
  }

  public function ioBuilderQuery() {
    return DB::table(StockIOMaster::getTbl());
  }

  public function makeStockToInventory($in) {
    DB::beginTransaction();

    try {
      foreach ($in['inventory'] as $key => $inventory) {
        $in['log'][$key]['inventory_id'] = $this->createGetId($inventory);
        $this->logBuilderQuery()->insert($in['log'][$key]);
      }

      $this->ioBuilderQuery()->where('id', $in['io']['id'])->update(array('status' => 1, 'exec_agent' => $in['io']['exec_agent'], 'exec_at' => $in['io']['exec_at']));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception($e);
    }
  }

  /**
   * @deprecated
   * @param $in
   * @throws \Exception
   */
  public function deprecated_makeStockToInventory($in) {
    DB::beginTransaction();

    try {
      foreach ($in['inventory'] as $key => $inventory) {
        $inventoryStockIn = $this->hasInventory($inventory['item_id'], $inventory['platform_id'], $inventory['warehouse_id']);
        if ($inventoryStockIn) {
          unset($inventory['book_qty']);

          $inventory['qty'] += $inventoryStockIn['qty'];
          $this->where('item_id', $inventory['item_id'])->where('platform_id', $inventory['platform_id'])->where('warehouse_id', $inventory['warehouse_id'])->update($inventory);
          $in['log'][$key]['inventory_id'] = $inventoryStockIn['id'];
        } else {
          $inventory['created_at'] = $in['inventory'][$key]['updated_at'];
          $in['log'][$key]['inventory_id'] = $this->createGetId($inventory);
        }

        $this->logBuilderQuery()->insert($in['log'][$key]);
      }

      $this->ioBuilderQuery()->where('id', $in['io']['id'])->update(array('status' => 1, 'exec_agent' => $in['io']['exec_agent'], 'exec_at' => $in['io']['exec_at']));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception($e);
    }
  }

  /**
   * @deprecated
   * @param $item_id
   * @param $platform_id
   * @param $warehouse_id
   * @return mixed
   */
  public function deprecated_hasInventory($item_id, $platform_id, $warehouse_id) {
    return $this->where('item_id', $item_id)->where('platform_id', $platform_id)->where('warehouse_id', $warehouse_id)->first();
  }
}
