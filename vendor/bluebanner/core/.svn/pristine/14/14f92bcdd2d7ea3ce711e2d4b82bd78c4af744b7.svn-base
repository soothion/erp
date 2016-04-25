<?php 
namespace Bluebanner\Core\Model;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\Item;

class PurchaseCostParams extends BaseModel
{
	
	protected $table = 'core_purchase_cost_params';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	private static $_allWarehouseItemFee=array();
		
	public $rules = array();

	public function validate() {
	    return true;
	}

	public function warehouse()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Warehouse','warehouse_id');
	}
  
    public function item()
    {
        return $this->belongsTo('Bluebanner\Core\Model\Item','item_id');
    }
    
    /**
     * 计算海运运费
     *
     * @param float $seaCostprama  海运运费系数
     * @param float $heavy     物品重量
     * @param float $length    物品长
     * @param float $width     物品宽
     * @param float $height    物品高
     * @return float 返回海运运费
     */
    public static function getSeaFee($seaCostprama,$heavy,$length,$width,$height)
    {
        //单位体积
        $molVol=$length*$width*$height/ 5000;
        if($molVol==0)
            $molHeavy=0;
        else
            $molHeavy=$heavy/$molVol;//$molHeavy 单位体积重
        return $molHeavy*$seaCostprama;
    }
    
    /**
     * 计算空运运费
     * 可以考虑放到Service里
     *
     * @param float $seaCostprama  海运运费系数
     * @param float $length    物品长
     * @param float $width     物品宽
     * @param float $height    物品高
     * @return float 返回海运运费
     */
    public static function getAirFee($airCostprama,$length,$width,$height)
    {
        //单位体积
        $molVol=$length*$width*$height/ 5000;
    
        return $molVol*$airCostprama;
    }
    
    /**
     * 查找 并计算 所有仓库下所用物品的运费
     * @return array
     */
    public static function GetAllWarehouseItemFee()
    {
        if(self::$_allWarehouseItemFee!==array())
            return self::$_allWarehouseItemFee;
        
        $return=array();
        $i=0;
        $items=Item::get();
        $costParams=PurchaseCostParams::get();
         
        foreach($costParams as $cost)
        {
            $wid=$cost->warehouse_id;
            $iid=$cost->item_id;
            $seaFee=$cost->sea_cost;
            $airFee=$cost->air_cost;
             
            if($iid!=0)
            {
                foreach($items as $item)
                {
                    if($item->id==$iid)
                    {
                        $return[$i]=array('item_id'=>$item->id,'warehouse_id'=>$wid,
                                'sea_cost'=>PurchaseCostParams::getSeaFee($seaFee, $item->packing_weight, $item->packing_length, $item->packing_width, $item->packing_height),
                                'air_cost'=>PurchaseCostParams::getAirFee($airFee, $item->packing_length, $item->packing_width, $item->packing_height));
                        $i++;
                    }
                }
            }
           
            foreach($items as $item)
            {
                if(self::findArrayPartInArray($return,array('item_id'=>$item->id,'warehouse_id'=>$wid))==-1)
                {
                    $return[$i]=array('item_id'=>$item->id,'warehouse_id'=>$wid,
                                'sea_cost'=>PurchaseCostParams::getSeaFee($seaFee, $item->packing_weight, $item->packing_length, $item->packing_width, $item->packing_height),
                                'air_cost'=>PurchaseCostParams::getAirFee($airFee, $item->packing_length, $item->packing_width, $item->packing_height));
                        $i++;
                 }
            }
        }
        //缓存结果
        self::$_allWarehouseItemFee=$return;
        
        return $return;
    }
    
    
    /**
     * 查找 $findArray里的键,值是否完全存在于 $resourceArray 中
     * @param array $resourceArray
     * @param array $findArray
     * @return number of $resourceArray index if found , else -1
     */
    public static function findArrayPartInArray($resourceArray,$findArray)
    {
        foreach($resourceArray as $key=>$res)
        {
            $isFound=true;
            foreach($findArray as $k=>$value)
            {
                if(isset($res[$k])&&$res[$k]==$value)
                {
                    continue;
                }
                else
                {
                    $isFound=false;
                    break;
                }
            }
            if($isFound) return $key;
        }
        return -1;
    }
    
    /**
     * 获取特定item warehouse 下的 运费
     * ps:如果返回数组为双-1 可能是此运费不存在 或者没有进行维护
     * @param int $item_id
     * @param int $warehouse_id
     * @return array
     */
    public static function getFeeByItemAndWarehose($item_id,$warehouse_id)
    {
        $allFee=self::GetAllWarehouseItemFee();
        $return=array('sea_cost'=>-1,'air_cost'=>-1);
        if(($k=self::findArrayPartInArray($allFee,array('item_id'=>$item_id,'warehouse_id'=>$warehouse_id)))!==-1)
        {
            $return['sea_cost']=$allFee[$k]['sea_cost'];
            $return['air_cost']=$allFee[$k]['air_cost'];
        }        
        return $return;
    }
	
}
