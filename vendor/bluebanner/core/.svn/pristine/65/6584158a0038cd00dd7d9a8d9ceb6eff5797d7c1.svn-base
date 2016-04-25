<?php
namespace Bluebanner\Core\Inventory;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\InventoryBook;
use Bluebanner\Core\Model\InventoryMaster;
use Bluebanner\Core\Model\InventoryDailyLog;

use Bluebanner\Core\Inventory\bookStatus;

use Bluebanner\Core\InventoryBookException;

use Bluebanner\Core\Model\StockIOMaster;
use Symfony\Component\Finder\Comparator\DateComparator;
use Bluebanner\Core\Facades\Inventory;

class InventoryDailyLogService
{
    
    /**
     * 获取所有的日志
     * @param array $conditions
     * @return Ambigous <\Illuminate\Database\Eloquent\Builder, \Illuminate\Database\Eloquent\static, \Illuminate\Database\Eloquent\Builder>
     */
    public function findLogsByCondition(array $conditions=array())
    {
        $temp=InventoryDailyLog::where('id','>',0);
        foreach($conditions as $condition)
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
     * 获取日志明细
     * @param integer $itemId
     * @param array $conditions
     */    
    public function findLogsDetailFromItemIdByCondition($itemId,array $conditions=array())
    {
        $temp=InventoryMaster::where('item_id','=',$itemId);
        foreach($conditions as $condition)
        {
            if($condition['field']=="date") continue;
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
     * @param bool 是否覆盖原有数据 默认true
     * @return void 
     */
    public function makeLogsByDate($flush=true,$time=0)
    {
        $logTime=($time==0)?time():$time;
        
        //取为每天开始时间
        $logDateStart=(floor($logTime/86400)*86400);
        
        $saveTime=date("Y-m-d H:i:s",$logTime);
        //查询现有数据
        $logModels=InventoryDailyLog::where('date', '>=', $logDateStart)->get();
        $exists=array();
        foreach($logModels as $log)
        {
            $key=$m['warehouse_id']."--".$m['item_id']."--".$m['restock_id']."--".$m['condition']."--".$m['warehouse_id']."--".$m['status'];
            $exists[$key]=$logModels['qty'];
        }
        
        //归类并统计
        $masterModels=InventoryMaster::where('id', '>', 1)->get();        
        $stack=array();
        foreach($masterModels as $m)
        {
            $key=$m['warehouse_id']."--".$m['item_id']."--".$m['restock_id']."--".$m['condition']."--".$m['status'];
            if(!isset($stack[$key])) $stack[$key]=intval($m['qty']);
            else $stack[$key]+=intval($m['qty']);
        }
        
        $i=0;$logs=array();
        foreach ($stack as $key=>$qty)
        {
            //已存在
            if(isset($exists[$key]))
            {
                if(!$flush)
                {
                   continue;
                }
            }
            $logs[$i]['date']=$saveTime;
            $logs[$i]['qty']=intval($qty);
            $values=explode('--', $key);
            $logs[$i]['warehouse_id']=$values[0];
            $logs[$i]['item_id']=$values[1];
            $logs[$i]['restock_id']=$values[2];
            $logs[$i]['condition']=$values[3];
            $logs[$i]['status']=$values[4];
            $i++;
        }
        
        self::logRecord($logs);
    }
    
    
    /**
     * @param arrayList $logList
     */
    public static  function logRecord(array $logList)
    {
       DB::transaction(function() use ($logList) {
			foreach ($logList as $log) {
			    InventoryDailyLog::create($log);
			}
		});

		return true;
    }
}