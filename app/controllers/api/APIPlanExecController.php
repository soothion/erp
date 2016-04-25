<?php

use Bluebanner\Core\Purchase\ServiceInterface;
use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Bluebanner\Core\Purchase\OrderServiceInterface;
use Bluebanner\Core\Purchase\POStatus;
use Bluebanner\Core\Warehouse\WarehouseServiceInterface;
use Bluebanner\Core\Inventory\InventoryServiceInterface;
use Bluebanner\Core\PurchasePlanExecException;

use Bluebanner\Core\Model\PurchasePlan;
use Bluebanner\Core\Model\PurchasePlanDetail;
use Bluebanner\Core\Model\VendorQuotation;

class APIPlanExecController extends \BaseController {
 
	public function __construct(PurchaseServiceInterface $service,OrderServiceInterface $po,WarehouseServiceInterface $wh,InventoryServiceInterface $inventory, PurchasePlan $modelPurchasePlan, PurchasePlanDetail $modelPurchasePlanDetail, VendorQuotation $modelVendorQuotation, PlanExecForm $formPlanExec)
	{
		$this->purchaseService = $this->service = $service;
		$this->orderService = $this->po = $po;
		$this->warehouseService = $this->wh = $wh;
		$this->inventoryService = $this->inventory = $inventory;

    $this->modelPurchasePlan = $modelPurchasePlan;
    $this->modelPurchasePlanDetail = $modelPurchasePlanDetail;
    $this->modelVendorQuotation = $modelVendorQuotation;

    $this->formPlanExec = $formPlanExec;
	}

/*  public function index() {
//    $warehouse = array('name' => 'warehouseName');
//    $vendor = array('name' => 'vendorName');
//    $item = array('sku' => 'skuName');
//    $fkTbls = array('warehouse' => $warehouse,
//      'vendor' => $vendor,
//      'item' => $item);
//    $rmFields = array();
//    $fields = array('*', 'fkTbls' => $fkTbls, 'rmFields' => $rmFields);
    $fkTbls = array('warehouse', 'vendor', 'item');

    $pg = Input::get('pg', 1);
    $getData = Input::get();

    $formData = $this->formPlanExec->checkPlanExecSkusListOpt($getData);

//    $planExecSkusList = $this->modelPurchasePlanDetail->findFieldsByConds($fields, $formData, $pg, 16);
    $planExecSkusList = $this->modelPurchasePlanDetail->findPlanDetailByConds($fkTbls, $formData, $pg, 20);
    $this->modelVendorQuotation->appendSPQs($planExecSkusList);

    return $planExecSkusList;
  }*/

  public function index() {
    $planId = Input::get('plan_id', 0);
    $getData = Input::get();

    $planId = $this->modelPurchasePlan->getByIdOrLast($planId);
    $planExecOpt = $this->formPlanExec->checkPlanExecListsOpt($getData, $planId);
    return $this->modelPurchasePlanDetail->getByPlanAndConds($planExecOpt);
  }

  public function getConfirmed() {
    return $this->modelPurchasePlan->where('status', 'confirmed')->get(array('id', 'name'));
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	/*public function index()
	{
		//获取searchform的参数，没有则通过model取一个，计划取最后一个
		$list = array();
		$i=0;
		$data = Input::get();
		$data['item_id'] = Input::get('sku');//isset($data['sku']) ? $data['sku'] : '';
		$data['vendor_id'] = Input::get('vendor');//isset($data['vendor']) ? $data['vendor'] : '';
		$data['parent_id'] = 0;//先只找出父sku
		$other = array(
				array('f' => 'parent_id','c' => '=','v' => 0)
			);
		unset($data['sku']);
		unset($data['vendor']);

		foreach ( $this->service->planDetailList($data,$other)->get() as $plandetail) {
			$plandetail->subitems;
			$tmp = $plandetail->toArray();
			$list[$i] = $tmp;
			$list[$i]['isParent'] = 0;
			//获取默认的供应商，装箱数
			$default  = $this->service->skuDefaultSetByItemID($plandetail->item_id);
			$list[$i]['default'] = ($default) ? $default->toArray() : null;
			//unit price可以按照含税和不含税的价格取出来
			$list[$i]['total'] = $plandetail->unit_price * $plandetail->to_purchase_qty;
			if(count($plandetail->subitems) >0) $list[$i]['isParent'] = 1;
			$i++;

			//子sku
			if(count($plandetail->subitems) >0)
			{
				foreach ($plandetail->subitems as $subitem) {
					$list[$i]['isParent'] = 0;
					$list[$i] = $subitem->toArray();
					$list[$i]['default'] = ($default) ? $default->toArray() : null;//子sku用父sku的装箱数
					//unit price可以按照含税和不含税的价格取出来
					$list[$i]['total'] = $subitem->unit_price * $subitem->to_purchase_qty;
					$i++;
				}
			}
		}

		return $list;
    }*/

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	   $plan=$this->service->planFind($id);
	   return $plan->details;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $plan_id
	 * @param  string $request_ids
	 * @return Response $plan_id,$request_ids =''
	 */
	public function update()
	{

		//return $this->service->planDetailUpdate($id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function turnorder(){
		//将传过来的数据转化成采购单
		//try{
			$data = Input::get("selectObj");
			$plan_id = Input::get("plan_id");
			$pur_warehouse = Input::get("pur_warehouse");
			$first = head($data);
			$change_status_detail = array();

			//获取供应商的信息
			$vendor = $this->service->vendorFind($first['vendor']['id']);

			//获取报价信息
			$quotation 	= $this->service->quotationFind($first['quotation_id']);

			$ship_to  	= $this->wh->warehouseFind($pur_warehouse);
			if(!$ship_to) 
				throw new PurchasePlanExecException("入库仓没找到!");
			$ship_to 	= $ship_to->address;

			$details 	= array();
			//整理明细表
			$sum = 0;
			foreach($data as $k => $v){
				$quotation = $this->service->quotationFind($v['quotation_id']);

				switch ($first['price_type']) {
					case 'usd':
						$total = round($quotation->usd_unit_price * $v['to_purchase_qty'],2);
						break;
					case 'tax':
						$total = round($quotation->tax_unit_price * $v['to_purchase_qty'],2);
						break;
					default:
						$total = round($quotation->unit_price * $v['to_purchase_qty'],2);
						break;
				}
				$sum +=$total;

				$details[] = array(
					'item_id' 		=> $v['item']['id'],
					'plan_id'		=> $plan_id,
					'plan_detail_id'=> $v['id'],
					'qty'	  		=> $v['to_purchase_qty'],
					'um'	  		=> $quotation->um,//报价里面取
					'tax_unit_price' =>  $quotation->tax_unit_price,	
					'usd_unit_price' =>	 $quotation->usd_unit_price,		
					'unit_price'	 =>	 $quotation->unit_price,
					'total'			 =>  $total,
				);

				//更改明细状态
				$detail = $this->service->planDetaiFind($v['id']);

				if($v['real_qty'] == $detail->real_qty)
				{
					$change_status_detail[] = $detail->id; 
				}
			}

			//交期--根据报价里面得交期限，自动计算一个日期
			if($delivery_date = $quotation->lead_time){
				$delivery_date = date('Y-m-d',strtotime("+$delivery_date days"));
			}

			//整理主表
			$order = array(
					'vendor_id'		=> $vendor->id,
					'warehouse_id' 	=> $pur_warehouse,
					'invoice'		=> $this->po->generateInvoice(),
					'status'		=> POStatus::PENDING,
					'currency'		=> ($first['price_type'] =='usd') ? 'USD' : 'CNY',
					'currency_rate' => '6.20',//这里默认，到时候需要用汇率表取及时汇率
					'tax_rate'		=> $quotation['tax_rate'],//考虑拿到明细里面
					'invoice_rate'	=> $vendor->discount_rate,//票点取供应商的
					'total'			=> $sum,//这个到时候需要昨个主动计算的
					'ship_to'		=> $ship_to,//我们仓库的地址
					'vendor_invoice'=> '',//发票号没有默认
					'vendor_invoice_note'	=> '',
					'note'			=> $vendor->note,
					'payment_method'=> $vendor->payment_method,
					'payment_terms'	=>	'',
					'payment_dates'	=> $vendor->payment_period,
					'due_date'		=> '',
					'delivery_date'	=> $delivery_date,
					'price_type'	=> $first['price_type']
			);

			if(!$this->po->orderCreate($order, $details))
				return array('f' => 0,'m' => '创建订单失败');

			$f = 1;
			foreach ($change_status_detail as $k => $did) {
				$detail = $this->service->planDetaiFind($did);
				if(!$detail->update(array('status' => 'purchasing')))
					$f =0;

				if($detail->parent_id >0){
					//修改相应父sku的状态
					$parent = $this->service->planDetaiFind($detail->parent_id);
					$count = 0;
					foreach ($parent->subitems as $child) {
						if($child->status !='pending') $count++;
					}

					if($count == count($parent->subitems)) 
					{
						if(!$parent->update(array('status' => 'purchasing')))  $f =0;
					}
				}

			}
			if($f ==0)
				return array('f' => 0,'m' => '更改计划明细状态失败');

			return array('f' => 1);
			//model里面判断plan下面所有都完成则变问closed
	//	}catch(Exception $e){
			
		//}
	}

	public function batchUpdate()
	{
		try{
			$data = Input::get();
			if(isset($data['detail_id']) && ($data['detail_id'] >0))
			{
				$r = $this->service->planDetailUpdate($data);
			}else{
				$r = $this->service->planDetailBatchUpdate($data);
			}

			return array('f' => 1);
		}catch(Exception $e){
			return array('f' => 0,'m' => $e->getMessage());
		}
	}

	public function batchUpdateQty()
	{
		try{
			$arr = array(
				'type' => Input::get('type'),
				'plan_dids' => Input::get('plan_dids')
			);	
			$r =  $this->service->planDetailBatchUpdateQty($arr);

			return array('f' => 1);
		}catch(Exception $e){
			return array('f' => 0,'m' => $e->getMessage());
		}
	}

	public function exports()
	{
		$list = array();
		$title = '';

		//基于item的剩余库存数量
		//算法：找出在库的库存并且排除属于plan_order_log这里面采购订单的入库批次
		$path = $_SERVER["DOCUMENT_ROOT"]."/logs";
		if(!is_dir($path)) mkdir($path);

		$path = $path."/purchase_plan/";
		if(!is_dir($path)) mkdir($path);		
		
		switch(Input::get('type'))
		{
			case '1':
				$list = $this->getDownData1(Input::get('plan_id'));
				break;
			case '2':
				$list = $this->getDownData2(Input::get('plan_id'));
				break;
			case '3':
				$list = $this->getDownData3(Input::get('plan_id'));
				break;
		}
		
		if(count($list) <=0)
			return array('f' => 0,'m' => '没有要导出的数据');

		$title = $list['title'];
		unset($list['title']);
		$filename = $path.$title.".csv";
		

		$this->service->filePutCsv($filename,$list);
		$name = file_exists($filename) ? $title.".csv" : '';
		$url  = file_exists($filename) ? "/logs/purchase_plan/".$title.".csv" : '';

		return array('f' => '1','url' => $url,'name' => $title.".csv");
	}

	/*采购计划明细*/
	protected function getDownData1($plan_id)
	{
		$list = array();
		$r = $this->getBaseData(Input::get('plan_id'));

		if(!isset($r['title'])) 
		{
			throw new PurchasePlanExecException("没有计划明细");
		}
		$list['title'] = $r['title'];
		unset($r['title']);
		$keys = $this->turnKeyToCN();

		//转成中文键值
		foreach($r as $k => $v){
			foreach ($v as $kk => $vv) {
				$key = isset($keys[$kk]) ? $keys[$kk] : $kk;
				$list[$k][$key] = $vv;	
			}
		}
		return $list;
	}

	/*采购计划预算*/
	protected function getDownData2($plan_id)
	{
		$list = array();
		$r = $this->getBaseData(Input::get('plan_id'),'1');

		if(!isset($r['title'])) 
		{
			throw new PurchasePlanExecException("没有计划明细");
		}
		$list['title'] = $r['title'];
		unset($r['title']);
		$keys = $this->turnKeyToCN();

		//转成中文键值
		foreach($r as $k => $v){
			foreach ($v as $kk => $vv) {
				$key = isset($keys[$kk]) ? $keys[$kk] : $kk;
				$list[$k][$key] = $vv;	
			}
		}
		return $list;
	}

	/*获取预算和明细的基础数据*/
	public function getBaseData($plan_id,$flag =0){
		$r = array();

		$columns = $this->service->getColumns($plan_id);
		//整理数据
		foreach ($this->service->planDetailList(array('plan_id' => $plan_id))->get() as $d) {
			if(count($d->subitems) >0) continue;//成品排除
			$key = $d->vendor->id.'-'.$d->item->id;
			$key2 = $d->warehouse->name.'-'.$d->transportation;
			$key3 = 'Order-'.$d->relation_id;
				
			if(in_array($key,array_keys($r))){

				if($flag ==0) $r[$key]['request'] += $d->request_qty;
				
				$r[$key]['real_qty']	+=$d->real_qty;
				
				if($flag ==1){
					$r[$key]['stock_qty']		+=$d->stock_qty;
					$r[$key]['to_purchase_qty']	+=$d->to_purchase_qty;
				}
				
				$r[$key]['total_price']	+=$d->real_qty * $d->unit_price;//
				$tmp = ($d->real_qty) ? $d->real_qty : 0;
		
				foreach($columns as $k => $v){
					if(($key2 == $v) && ($d->relation_id <=0)) 	$r[$key][$v] +=$tmp;
					if(($key3 == $v) && ($d->relation_id >0)) 	$r[$key][$v] +=$tmp;
				}
			}else{
				$quotation = $this->service->quotationFind($d->quotation_id);
				$r['title'] = (isset($r['title'])) ? $r['title'] : $d->plan->name."预算" ;

				$r[$key]['vendor'] 		=$this->charsetToGBK($d->vendor->name);
				$r[$key]['sku']			=$d->item->sku;
				$r[$key]['desc']		=$this->charsetToGBK($d->item->description);
				
				if($flag ==0) $r[$key]['request'] = $d->request_qty;
				
				$r[$key]['real_qty']	=$d->real_qty;
				
				if($flag ==1){
					$r[$key]['stock_qty']		=$d->stock_qty;
					$r[$key]['to_purchase_qty']	=$d->to_purchase_qty;
				}
				
				$r[$key]['unit_price']	=$d->unit_price;//
				$r[$key]['total_price']	=$d->real_qty * $d->unit_price;//
				foreach($columns as $k => $v){
					$r[$key][$v] = 0;

					if(($key2 == $v) && ($d->relation_id <=0)) 	$r[$key][$v] +=$d->real_qty;
					if(($key3 == $v) && ($d->relation_id >0)) 	$r[$key][$v] +=$d->real_qty;
				}			
				//获取采购订单数量，和采购到货数量
				$r[$key]['paypment_period1']	=$this->charsetToGBK($d->vendor->payment_method);
				$r[$key]['paypment_period2']	=$this->charsetToGBK($d->vendor->payment_period);
				switch ($d->price_type) {
					case 'tax':
						$r[$key]['price_type']	= 'Y';
						break;
					case 'usd':
						$r[$key]['price_type']	= 'M';
						break;
					default:
						$r[$key]['price_type']	= 'N';
						break;
				}
			}
		}

		return $r;
	}


	/*获取预算和明细的基础数据*/
	public function getDownData3($plan_id){
		$r = array();

		//该plan下所有item的采购订单数量
		$purchase  = $this->service->getPurchaseOrder(Input::get('plan_id'));

		//该plan下所有item的采购到货数量
		$purchaseReceive  = $this->service->getPurchaseOrderStockin(Input::get('plan_id'));

		//该plan下所有item的采购订单数量
		$ship  = $this->service->getShipment($plan_id);
		if($ship) {$sk = $ship['invoice']; unset($ship['invoice']);}
		//获取剩余库存。。。。
		$columns = array_merge($this->service->getColumns($plan_id));

		//整理数据
		foreach ($this->service->planDetailList(array('plan_id' => $plan_id))->get() as $d) {
			$key = $d->vendor->id.'-'.$d->item->id;
			$key2 = $d->warehouse->name.'-'.$d->transportation;
			$key3 = 'Order-'.$d->relation_id;
				
			if(in_array($key,array_keys($r))){
				$r[$key]['real_qty']	+=$d->real_qty;
				$tmp = ($d->real_qty) ? $d->real_qty : 0;
		
				foreach($columns as $k => $v){
					if(($key2 == $v) && ($d->relation_id <=0)) 	$r[$key][$v] +=$tmp;
					if(($key3 == $v) && ($d->relation_id >0)) 	$r[$key][$v] +=$tmp;
				}
			}else
			{
//quotation = $this->service->quotationFind($d->quotation_id);
				$r['title'] = (isset($r['title'])) ? $r['title'] : $d->plan->name."收发货明细表";

				$r[$key]['vendor'] 		=$this->charsetToGBK($d->vendor->name);
				$r[$key]['sku']			=$d->item->sku;
				$r[$key]['desc']		=$this->charsetToGBK($d->item->description);
				$r[$key]['real_qty']	=$d->real_qty;//是应采购的订单数量
				$r[$key]['stock_qty']	=0;
				foreach($columns as $k => $v){
					$r[$key][$v] = 0;

					if(($key2 == $v) && ($d->relation_id <=0)) 	$r[$key][$v] +=$d->real_qty;
					if(($key3 == $v) && ($d->relation_id >0)) 	$r[$key][$v] +=$d->real_qty;
				}
				//获取采购订单数量，和采购到货数量
				$r[$key]['order']			=isset($purchase[$d->item_id]) ? $purchase[$d->item_id] : 0 ;
				$r[$key]['order_receive']	=isset($purchaseReceive[$d->item_id]) ? $purchaseReceive[$d->item_id] :0;
				$r[$key]['order_waiting']	=0;

				if($ship)
				{
					foreach ($sk as $k => $v)
					{
						$r[$key][$v] = 0;
						foreach ($ship as $kk => $vv) 
						{
							if($d->item_id == $kk) $r[$key][$v] = $vv[$v];
						}
					}
				}
			}
		}

		$list = array();

		if(!isset($r['title'])) 
		{
			throw new PurchasePlanExecException("没有计划明细");
		}

		$list['title'] = $r['title'];
		unset($r['title']);
		$keys = $this->turnKeyToCN();

		//转成中文键值
		foreach($r as $k => $v){
			foreach ($v as $kk => $vv) {
				$key = isset($keys[$kk]) ? $keys[$kk] : $kk;
				$list[$k][$key] = ($kk == 'order_waiting') ? ($v['real_qty'] - $v['order_receive']) : $vv;	
			}
		}

		return $list;	
	}

	//主键中英文转换
	protected function turnKeyToCN(){
		return $array = array(
			'vendor' 			=> $this->charsetToGBK("供应商"),
			'sku'				=> $this->charsetToGBK("SKU"),
			'desc'				=> $this->charsetToGBK("描述"),
			'request'			=> $this->charsetToGBK("原始申请量"),
			'real_qty'			=> $this->charsetToGBK("调整后总需求"),
			'stock_qty'			=> $this->charsetToGBK("期初库存"),
			'to_purchase_qty'	=> $this->charsetToGBK("最终采购量"),
			'spq'				=> $this->charsetToGBK("最小包装数"),
			'purchase_qty'		=> $this->charsetToGBK("最终采购量"),
			'unit_price'		=> $this->charsetToGBK("单价"),
			'total_price'		=> $this->charsetToGBK("金额"),
			'paypment_period1'	=> $this->charsetToGBK("账期1"),
			'paypment_period2'	=> $this->charsetToGBK("账期2"),
			'price_type'		=> $this->charsetToGBK("含税与否"),
			'stock_qty'			=> $this->charsetToGBK("库存数量"),
			'order'				=> $this->charsetToGBK("订单数量"),
			'order_receive'		=> $this->charsetToGBK("实际到货数"),
			'order_waiting'		=> $this->charsetToGBK("缺货数"),
			'paypment_period1'		=> $this->charsetToGBK("账期1"),
			'paypment_period2'		=> $this->charsetToGBK("账期2")
		);
	}

	/**/
	protected function titleToGBK(array $arr)
	{
		$r = array();
		foreach ($arr as $key => $value) {
			$r[$key] = $this->charsetToGBK($value);
		}

		return $r; 
	}

	/**/
	protected function charsetToGBK($str)
	{
		return iconv("UTF-8", "GBK",$str);
	}

}