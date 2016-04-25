<?php

use Bluebanner\Core\Item\ItemServiceInterface;

class APIMetaController extends \BaseController {

	public function __construct(ItemServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// 
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
		//
	}

	/**
	 * Display the specified resource.
	 * @todo fix the fake data
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($key)
	{
		$output = array();

		$select = Input::get('select') ? explode(',', Input::get('select')) : '*';

		switch ($key) {
			case 'stateList':
				$output = array_build($this->service->itemStatusList(), function($key, $val) {return array($key, array('data'=>$val));});
				break;
			
			case 'warehouseList':
				// $output = array(array('id' => 1, 'name' => 'US-CA'));
				$output = array_build(Bluebanner\Core\Model\Warehouse::all(), function($key, $val) {return array($key, array('id' => $val['id'], 'name' => $val['name']));});
				break;

			case 'requestStatus':
				$output = array_values(array_build(with(new Bluebanner\Core\Purchase\RequestService)->getStatusList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));}));
				break;
			case 'requestTypes':
				$output = array_values(array_build(with(new Bluebanner\Core\Purchase\RequestService)->getTypeList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));}));
				break;

			case 'chanelList':
				$output = Bluebanner\Core\Model\Account::select($select)->get();
				break;
				
			case 'platformList':
				  $output = Bluebanner\Core\Model\Platform::select($select)->get();
			break;
			
			case 'purchaseCostparams':
			     $output = Bluebanner\Core\Model\PurchaseCostParams::select($select)->get();
			break;
			
			case 'vendorQuotation':
			    $output = Bluebanner\Core\Model\VendorQuotation::select($select)->get();
			break;
			//skudefault
			case 'skudefaultvendor':
			    $output = Bluebanner\Core\Model\PurchaseSkuDefault::select($select)->get();
			    break;

			case 'transportList':
				$output = array(array('name' => 'air'), array('name' => 'sea'), array('name' => 'N/A'));
				break;
				
			case 'taxList': //'normal','tax','usd'
				$output = array(array('name' => 'normal'),array('name' => 'tax'),array('name' => 'usd'));
				break;

			case 'inventoryTypeList':
				$output = array_build(with(new Bluebanner\Core\Inventory\InvType)->InventoryChangeType(), function($k, $v) {return array($k, array('id' => "$k", 'name' => $v, 'dr' => ($k < 0) ? 'out' : 'in'));});
				break;
			case 'invTypeList':
				$output = array_build(with(new Bluebanner\Core\Inventory\InvType)->InventoryChangeType(), function($k, $v) {return array($k, array('id' => "$k", 'name' => $v));});
				break;
			case 'otherInventoryTypeList':
				$output = array(array('id'=>'in','name'=>'in'),array('id'=>'out','name'=>'out'));
			break;
			
			case 'otherInventoryStatusList':
			    $output =array(array('id'=>'pending','name'=>'pending'),array('id'=>'confirmed','name'=>'confirmed'),array('id'=>'stocking','name'=>'stocking'),array('id'=>'done','name'=>'done'));
			break;

			case 'ioTypeList':
				$output = array_build(with(new Bluebanner\Core\Warehouse\IOType)->getIOType(), function($k, $v) {return array($k, array('id' => $k, 'name' => $v, 'dr' => ($k < 0) ? 'out' : 'in'));});;
				break;
			
		    case 'ioStatusList':
				 $output = array_build(with(new Bluebanner\Core\Warehouse\IOStatus)->getStatus(), function($k, $v) {return array($k, array('id' => $k, 'name' => $v));});;
		    break;
		    
		    //采购退货单 状态
		    case 'purchaseReturnStatusList':
		         $output = array_build(with(new Bluebanner\Core\Purchase\PurchaseService)->getReturnStatusList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));});
				
		    break;
		    //仓库盘点状态
		    case 'warehouseCountStatusList':
		        $output = array_build(with(new Bluebanner\Core\Purchase\PurchaseService)->getReturnStatusList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));});
		     break;
		     //仓库调度状态
		     case 'warehouseShipStatusList':
		         $output = array_build(with(new Bluebanner\Core\Warehouse\ShipmentService)->getShipStatusList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));});
		     break;
		     //仓库运输方式
		     case 'warehouseShipTSStatusList':
		         $output = array_build(with(new Bluebanner\Core\Warehouse\ShipmentService)->getTransStatusList(), function($key, $val) {return array($key, array('id'=>$val,'name'=>$val));});
		     break;
		     
		     //仓库默认地址
		     case 'defaultWHShipAddr':
		         // $output = array(array('id' => 1, 'name' => 'US-CA','addr'=>''));
		         $output = array_build(Bluebanner\Core\Model\Warehouse::all(), function($key, $val) {return array($key, array('id' => $val['id'], 'name' => $val['name'], 'addr' => $val['address']));});
		     break;

			case 'userList':
				$output = array_build(Sentry::findAllUsers(), function($k, $v) { return array($k, array('id' => $v->id, 'name' => $v->email)); });
				break;
				
			case 'itemInfo':
					$output = Bluebanner\Core\Model\Item::select($select)->get();
			break;

			default:
				# code...
				break;
		}

		return $output;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

}