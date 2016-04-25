<?php
namespace Bluebanner\Core\Order;
use Bluebanner\Core\Model\Order;
use Bluebanner\Core\Model\Customer;
use Bluebanner\Core\Model\OrderDetail;
use Illuminate\Support\Facades\DB;

class ImportService implements ImportServiceInterface{
	public $platform;//平台（Amazon,Ebay）
    public $channel_id;
	public $config;//配置参数
    public $report;//执行结果报告

    public function __construct($platform = null, $channel_id = null, $config = null) {
    	$this->platform = strtolower($platform);//全部小写方便判断
    	$this->config = $config;
        $this->channel_id = $channel_id;
    }

    public function run(){
        $orderList = $this->getOrderList();
        if(empty($orderList))
            throw new \Exception("Empty Order List");
        else{
            $orderList = $this->parseOrder($orderList);
            $orderList = $this->filter($orderList);//新订单与老订单分离
            if(!empty($orderList['import']))
               $import = $this->import($orderList['import']);
            if(!empty($orderList['update']))
               $update = $this->update($orderList['update']);
        }

    }

    /**
     * 导入订单
     * @param  array $orderList 
     * @return array 导入处理报告
     */
    public function import($orderList){
        $result = array();
    	foreach ($orderList as $order) {
            DB::beginTransaction();
            $flag = 1;
            $orderInfo = $order['info'];
            $result = array(
                'action'=>'import',
                'third_party_order_id'=>$orderInfo['third_party_order_id'],
                'status'=>$flag);
            try
            {
                $orderCustomer = $order['customer'];
                $orderCustomer = Customer::create($orderCustomer);

                
                $orderInfo['customer_id'] = $orderCustomer->id;
                $orderInfo['channel_id'] = $this->channel_id;
                $orderInfo['account'] = $this->config->account;
                $orderInfo['status'] = 'pending';
                $orderInfo = Order::create($orderInfo);
                $result['order_id'] = $orderInfo->id;

                $orderDetail = $order['detail'];
                $orderDetail['order_id'] = $orderInfo->id;
                OrderDetail::create($orderDetail);
                DB::commit();
            }
            catch (\Exception $e)
            {
                $result['status'] = 0;
                DB::rollBack();
            }
            $this->report[] = $result;

    	}
        return $this->report; 
    }

    /**
     * 更新订单
     * @param  array $orderList 
     * @return array 更新处理报告
     */
    public function update($orderList){
        foreach ($orderList as $order) {
            DB::beginTransaction();
            $flag = 1;
            try
            {   
                Order::find($order['info']['id'])->update($order['info']);
                OrderDetail::firstOrNew($order['detail']);
                DB::commit();
            }
            catch ( \Exception $e)
            {
                $flag = 0;
                DB::rollBack();
            }
            $this->report[] = array(
                'action'=>'update',
                'order_id'=>$order['info']['id'],
                'third_party_order_id'=>$order['info']['third_party_order_id'],
                'status'=>$flag);
        }
        return $this->report;
    }

    /**
     * 获取订单列表
     * @return array 
     */
    public function getOrderList(){
    	switch ($this->platform) {
            case 'amazon':
                $service = new AmazonService($this->config);
                break;
            case 'ebay':
                $service = new EbayService($this->config);
                break; 
            case 'buy':
                $service = new BuyService($this->config);   
                break;            
            case 'newegg':
                $service = new NewEggService($this->config);   
                break;
            default:
                throw new \Exception('Unknown platform:'.$this->platform);
                break;
        }
    	$orderList = $service->getOrderList();
    	return $orderList;
    }

    /**
     * 分离新订单与老订单
     * @param  array $orderList  待分离订单
     * @return array             分离后订单
     */
    public function filter($orderList){
    	$result=array();
    	foreach ($orderList as $key => $order) {
    		$filter=array('third_party_order_id','=',$order['info']['third_party_order_id']);
    		if($id = $this->checkOrder($filter)){
                $order['info']['id']= $id;
    			$result['update'][]=$order;//添加到更新列表
    			array_slice($orderList, $key, 1);//删除已存在的订单
    		}
    	}
    	$result['import'] = $orderList;
    	return $result;
    }

    /**
     * 检测订单是否存在
     * @param  array $filter 筛选条件
     * @return int           返回已存在的订单ID         
     */
    public function checkOrder($filter){
        return Order::where($filter[0], $filter[1], $filter[2])->pluck('id');
    }

    /**
     * 调用adapter解析订单
     * @param  array $orderList 待解析的订单
     * @return array            解析后的订单
     */
    public function parseOrder($orderList){
    	$adapter =  new AdapterService($this->platform);
    	return $adapter->parse($orderList);
    }

    /**
     * 配置函数
     * @param  mixed $option 参数名，如果是数组，直接赋值给$this->config
     * @param  mixed $value  参数值
     * @return mixed         返回$this->config 或者null
     */
    public function config($option = null, $value = null){
    	if($option !== null){
    		if(!is_array($option)){
    			if($value !== null){
    				$this->config[$option] = $value;
    			}
    			return array_key_exists($option, $this->config) ? $this->config[$option] : null;
    		}
    		$this->config = $option;
    	}
    	return $this->config;
    }


}