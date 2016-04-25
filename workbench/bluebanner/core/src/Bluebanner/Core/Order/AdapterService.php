<?php
namespace Bluebanner\Core\Order;
use Bluebanner\Core\Model\Mapping;

class AdapterService implements AdapterServiceInterface{
	public $platform;

	public function __construct($platform){
		$this->platform = $platform;
	}

	/**
	 * 解析订单
	 * @param  array $orderList 待解析的订单
	 * @return array            解析后的订单
	 */
	public function parse($orderList){
        $orderList = $this->mapping($orderList);
        $result = array();
        foreach ($orderList as $value) {
            $order['info'] = $this->getOrderInfo($value);
            $order['customer'] = $this->getOrderCustomer($value);
            $order['detail'] = $this->getOrderDetail($value);
            $result[]=$order;
        }
        return $result;
	}

    /**
     * 根据mapping规则映射order
     * @param  array $orderList 待映射orderList
     * @return array            已映射orderList
     */
    public function mapping($orderList){
        $mapping = $this->getMapping();
        foreach ($orderList as $key => $order) {
            foreach ($order as $k => $v) {
                if(array_key_exists($k, $mapping)){
                    unset($orderList[$key][$k]);
                    $orderList[$key][$mapping[$k]] = $v;
                }
            }
        }
        return $orderList;
    }

	/**
	 * 根据platform从数据库取出对应mapping规则
	 * @return array           mapping表
	 */
	public function getMapping(){
        $result = array();
        $mapping = Mapping::findByAttributes(array('type'=>'order', 'platform'=>$this->platform))->get();
        foreach ($mapping as $value) {
            $result[$value['third_party']] = $value['erp'];
        }
        return $result;
	}


	
    /**
     * 从$order里提取order 主表信息
     * @param  array $order 
     * @return array
     */
    public function getOrderInfo($order){
    	$info=array(
    		'channel_id',
    		'warehouse_id',
    		'third_party_order_id',
            'fulfillment_channel',
    		'order_status',
    		'order_total',
    		'payment_date',
    		'payment_method',
    		'shipping_status',
    		'currency',
    		'shipping_charge',
    		'discount',
    		'discount_type',
    		'note',
    		'mailclass_id',
    		'shipping_level',
    		);
    	$result = array();
    	foreach ($info as $value) {
            if(!isset($order[$value]))
                continue;
    		$result[$value] = $order[$value];
    	}
    	return $result;
    }

    /**
     * 从$order里提取customer信息
     * @param  array $order 
     * @return array
     */
    public function getOrderCustomer($order){
    	$customer=array(
    		'first_name',
    		'last_name',
    		'customer_email',
    		'paypal_email',
    		'shipping_address1',
    		'shipping_address2',
    		'shipping_city',
    		'shipping_state',
    		'shipping_state',
    		'shipping_country',
    		'shipping_province',
    		'shipping_phone',
    		'billing_address1',
    		'billing_address2',
    		'billing_city',
    		'billing_state',
    		'billing_zip',
    		'billing_country',
    		'billing_province',
    		'billing_phone',
    		'ebay_id',
    		'ups_account',
    		'UPS_thirdparty_id'
    		);
    	$result = array();
    	foreach ($customer as $value) {
            if(!isset($order[$value]))
                continue;
    		$result[$value] = $order[$value];
    	}
    	return $result;
    }


    /**
     * 从$order里提取detail信息
     * @param  array $order 
     * @return array
     */
    public function getOrderDetail($order){
    	$detail=array(
    		'3rd_party_order_id',
    		'sku',
    		'market_item_id',
    		'quantity',
    		'sales_price',
    		'invd_id'
    		);
    	$result = array();
    	foreach ($detail as $value) {
            if(!isset($order[$value]))
                continue;
    		$result[$value] = $order[$value];
    	}
    	return $result;    	

    }

}