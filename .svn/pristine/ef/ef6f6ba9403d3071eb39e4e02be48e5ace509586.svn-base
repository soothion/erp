<?php

use Bluebanner\Core\Purchase\ServiceInterface;
use Bluebanner\Core\Purchase\PurchaseServiceInterface;
use Bluebanner\Core\Purchase\OrderServiceInterface;
use Bluebanner\Core\Purchase\POStatus;
use Bluebanner\Core\Warehouse\WarehouseServiceInterface;
use Bluebanner\Core\Inventory\InventoryServiceInterface;
use Bluebanner\Core\PurchasePlanExecException;
use Bluebanner\Core\Warehouse\ShipmentServiceInterface;

class APIPlanShipController extends \BaseController {
 
 	var $pur_warehouse;

	public function __construct(PurchaseServiceInterface $service,OrderServiceInterface $order, ShipmentServiceInterface $ship, WarehouseServiceInterface $wh,InventoryServiceInterface $inventory)
	{
		$this->service = $service;
		$this->ship = $ship;
		$this->order = $order;
		$this->wh = $wh;
		$this->inventory = $inventory;
		$this->pur_warehouse = 7;//调度默认的发出仓库为buffer［在采购计划中也就是采购入库仓］－－稍后可考虑在计划中添加
	}
	/**
	 * Display a listing of the resource.
	 *
	 * 这里生成显示需要的数据只包含明细，当生成调度单的时候，将对应的成品sku写入到调度单里面，但是数量是0，当调度单生成入库单的时候，
	 * 为0的数量不要插入进去
	 * 
	 * @return Response
	 */
	public function index()
	{
		//获取searchform的参数，没有则通过model取一个，计划取最后一个
		$list = array();
		$i=0;
		$data = Input::get();
		$data['item_id'] = Input::get('sku');
		$data['parent_id'] = 0;//先只找出父sku
		$other = array(
				array('f' => 'parent_id','c' => '=','v' => 0),
				//array('f' => 'warehouse_id', 'c' => '!=','v' => $this->pur_warehouse),#1.((目的仓库 != 采购仓库))
				array('f' => 'status', 'c' => 'notin', 'v' => array('completely shipped','closed'))#2.明细状态 != closed || completely shipped
		);
		unset($data['sku']);
		
		foreach ( $this->service->planDetailList($data,$other)->get() as $plandetail) 
		{
			$plandetail->subitems;
			$tmp = $plandetail->toArray();
			$list[$i] = $tmp;
			$list[$i]['isParent'] = 0;

			//获取默认的供应商，装箱数
			$default  = $this->service->skuDefaultSetByItemID($plandetail->item_id);
			$list[$i]['default'] = ($default) ? $default->toArray() : null;
			$list[$i]['pur_warehouse'] = $this->pur_warehouse;

			$tmp = $this->order->getPurchaseQtyByDetails($plandetail->getOrderDetailArr());
			$list[$i]['purchase'] 	= $tmp['qty'];
			$list[$i]['purchased']  = $tmp['do_qty'];
			$list[$i]['purchaseing']  = $plandetail->real_qty - $tmp['do_qty'];
			
			//$tmp1 = $this->ship->getShipQtyByDetails($plandetail->getShipDetailArr());
			$list[$i]['shipment_qty'] 	= $plandetail->shipment_qty ? $plandetail->shipment_qty :0;//$tmp1['qty'];
			$list[$i]['shipmenting'] 	= $list[$i]['qty'] = $plandetail->real_qty - $plandetail->shipment_qty;
			$list[$i]['pi']		 	= 0;
			$list[$i]['box'] 		= '';
			$list[$i]['i']			= $i;
			$list[$i]['split_qty']	= 0;
			if(count($plandetail->subitems) >0) 
			{
				$list[$i]['isParent'] = 1;
				$tmp_key = $i;
			}
			$i++;

			if(count($plandetail->subitems) >0){
				$list[$tmp_key]['child_i'] = '';
				foreach ($plandetail->subitems as $subitem) {
					$list[$i]['isParent'] = 0;
					$list[$i] = $subitem->toArray();
					$list[$i]['default'] = ($default) ? $default->toArray() : null;//子sku用父sku的装箱数
					$tmp = $this->order->getPurchaseQtyByDetails($subitem->getOrderDetailArr());
					$list[$i]['purchase'] 	= $tmp['qty'];
					$list[$i]['purchased']  = $tmp['do_qty'];
					$list[$i]['purchaseing']  = $subitem->real_qty - $tmp['do_qty'];


				//	$tmp1 = $this->ship->getShipQtyByDetails($subitem->getShipDetailArr());
					$list[$i]['shipment_qty'] = $subitem->shipment_qty ? $subitem->shipment_qty :0;
					$list[$i]['shipmenting'] = $list[$i]['qty'] = $subitem->real_qty - $subitem->shipment_qty;;
					$list[$i]['pi']		 	= 0;
					$list[$i]['box'] 		= '';
					$list[$i]['i']			= $i;
					$list[$i]['split_qty']	= 0;
					//讲子sku得i写入父sku
					$list[$tmp_key]['child_i']	= ($list[$tmp_key]['child_i'] =='') ? $i : ($list[$tmp_key]['child_i'].",".$i);
					$i++;
				}
			}

		}

		return $list;
	}



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
	public function show()
	{
		//
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

	public function shipSplit()
	{
		$data = Input::get("splitObj");

		$self =$this;
		$detail = array();
		//$parent_id = 0;
		foreach($data as $d){
			$detail[] = array(
					'id' 			=> $d['id'],
					'plan_id' 		=> $d['plan_id'],
					'item_id'		=> $d['item_id'],
					'warehouse_id'	=> $d['warehouse_id'],
					'relation_id'	=> $d['relation_id'],
					'request_qty'	=> $d['request_qty'],
					'stock_qty'		=> $d['stock_qty'],
					'real_qty'		=> $d['real_qty'],
					'split_qty'		=> $d['split_qty'],
					'status'		=> 'pending',
					'vendor_id'		=> $d['vendor_id'],
					'quotation_id'	=> $d['quotation_id'],
					'price_type'	=> $d['price_type'],	
					'unit_price'	=> $d['unit_price'],
					'transportation'=> $d['transportation'],
					'parent_id'		=> $d['parent_id'],
					'to_purchase_qty'=> $d['to_purchase_qty'],
			);
		}

		//if(!
			$this->service->splitPlanDetail($detail);//)
			//return array('f' => 0,'m' => '拆分SHIPMENT失败');
		//else 	return array('f' => 1,'m' => '拆分SHIPMENT失败');
	}

	public function turnship(){
		//将传过来的数据转化成调度
			$data = Input::get("selectObj");
			$first = head($data);
			//$change_status_detail = array();

			$details 	= array();

			$head = array(
					'warehouse_from_id' => Input::get("pur_warehouse"),
					'warehouse_to_id'	=> Input::get("warehouse_id"),
					'agent'				=> Sentry::getUser()->id,
					'invoice' 			=> Input::get("invoice"),
					'date_eta'			=> '',
					'currency'			=> '',	
					'exchange_rate'		=> '',
					'status'			=> 'pending',
					'transportation'	=> Input::get("transportation"),
					'carrier'			=> '',
					'tracking'			=> '',
					'note'				=> '',
					'shipping_fee'		=> '',
					'price_type' 		=> Input::get("price_type")
			);

			//整理明细表
			foreach($data as $k => $v){
				$details[] = array(
					'item_id' 			=> $v['item']['id'],
					'plan_id'			=> $v['plan']['id'],
					'plan_detail_id'	=> $v['id'],
					'qty'	  			=> $v['qty'],
					'pi_price'	  		=> $v['pi'],
					'box_id'	 		=> $v['box']
				);
			}


			if(!$this->ship->createShipment($head, $details))
				return array('f' => 0,'m' => '创建SHIPMENT失败');

			/*
			$f = 1;
			foreach ($change_status_detail as $k => $did) {
				$detail = $this->service->planDetaiFind($did);
				if(!$detail->update(array('status' => 'purchasing')))
					$f =0;
			}
			if($f ==0)
				return array('f' => 0,'m' => '更改计划明细状态失败');
			*/

			return array('f' => 1);
	}	
	
}