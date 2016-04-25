<?php
namespace Bluebanner\Core\Purchase;

use Illuminate\Support\Facades\DB;
use Bluebanner\Core\Model\Vendor;
use Bluebanner\Core\Model\VendorQuotation;
use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\PurchaseRequestPlanLog;
use Bluebanner\Core\Model\PurchasePlan;
use Bluebanner\Core\Model\PurchasePlanDetail;
use Bluebanner\Core\Model\PurchaseOrder;
use Bluebanner\Core\Model\PurchaseOrderDetail;
use Bluebanner\Core\Model\PurchasePlanOrderLog;
use Bluebanner\Core\Model\PurchasePlanShipLog;
use Bluebanner\Core\Model\PurchaseReturn;
use Bluebanner\Core\Model\PurchaseReturnDetail;

use Bluebanner\Core\Model\PurchaseSkuDefault;

use Bluebanner\Core\Model\User;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\Account;

use Bluebanner\Core\Purchase\POStatus;
use Bluebanner\Core\Purchase\PRStatus;
use Bluebanner\Core\Purchase\PRType;
use Bluebanner\Core\Warehouse\IOType;

use Bluebanner\Core\PurchaseRequestNotFoundException;
use Bluebanner\Core\PurchaseVendorNotFoundException;
use Bluebanner\Core\VendorQuotationNotFoundException;
use Bluebanner\Core\RequestAssignException;
use Bluebanner\Core\PurchasePlanExecException;

use Bluebanner\Core\Model\PurchaseCostParams;

use Bluebanner\Core\Warehouse\StockIOService;
use Bluebanner\Core\Facades\Purchase;
use Bluebanner\Core\Model\Platform;
class PurchaseArgumentsException extends \Exception {}
class PurchaseDuplicateException extends \Exception {}
class PlanAssignException		 extends \Exception {}
class PurchasePlanException		 extends \Exception {}

class PurchaseService implements PurchaseServiceInterface {
	
    
	   	public function __construct(PurchasePlan $PurchasePlan = null,
	   			PurchaseOrder $PurchaseOrder=null,
	   			PurchasePlan  $PurchasePlan=null,
	   			PurchasePlanDetail $PurchasePlanDetail=null,
	   			PurchasePlanOrderLog $PurchasePlanOrderLog=null,
	   			PurchasePlanShipLog $PurchasePlanShipLog=null,
	   			PurchaseRequest $PurchaseRequest=null,
	   			PurchaseRequestDetail $PurchaseRequestDeail=null,
	   			VendorQuotation $VendorQuotation=null,
                Vendor $Vendor=null,
	   			PurchaseSkuDefault $PurchaseSkuDefault=null,
	   			PurchaseReturn $PurchaseReturn=null,
	   			PurchaseReturnDetail $PurchaseReturnDetail=null,
	   			Item $Item=null,
	   			Platform $Platform=null,
	   			PurchaseCostParams $PurchaseCostParams=null,
	   			IOType $IOType=null,
	   			StockIOService $StockIOService=null
//serive 
 	   			
)
	{
				$this->PurchaseOrderModel = $PurchaseOrder;
				$this->PurchasePlanModel = $PurchasePlan;
				$this->purchasePlanDetailModel = $PurchasePlanDetail;
				$this->PurchasePlanOrderLogModel = $PurchasePlanOrderLog;
				$this->PurchasePlanShipLogModel = $PurchasePlanShipLog;
				$this->PurchaseRequestModel = $PurchaseRequest;
			    $this->PurchaseRequestDetailModel = $PurchaseRequestDeail;
			    $this->VendorModelQuotationModel = $VendorQuotation;
			    $this->VendorModel=$Vendor;
			    $this->VendorQuotationModel= $VendorQuotation;
			    $this->PurchaseSkuDefaulModel=$PurchaseSkuDefault;
			    $this->PurchaseReturnModel=$PurchaseReturn;
			    $this->PurchaseReturnDetailModel = $PurchaseReturnDetail;
			    $this->ItemModel=$Item;
			    $this->PlatformModel=$Platform;
			    $this->PurchaseCostParamsModel=$PurchaseCostParams;
			    $this->IOType =$IOType;
			    $this->StockIOService=$StockIOService;
			   
			    
//service			    
		
		 
	}
	public function planList() {                //計畫表的列表
		 return $this->PurchasePlanModel->with('user', 'details') -> orderBy('id', 'desc');
	}
	
	public function spePlanList($type)          
	{
	    if(is_array($type))
	    { 
	        return $this->PurchasePlanModel->with('user','details')->whereIn('status',$type)->orderBy('id','desc');
	    }
	    else if(is_string($type))
	    {
	        return $this->PurchasePlanModel->with('user','details')->where('status',$type)->orderBy('id','desc');
	    }
	    else 
	        return array();
	        
	}

	public function planFindByField($field, $condition, $value, $orderBy = 'asc') {
		return $this->PurchasePlanModel->where($field, $condition, $value) -> orderBy('id', $orderBy);
	}

	public function planCreate(array $array) {
		$month = date('ym');
		$invoice = $this->PurchasePlanModel->withTrashed() -> select('invoice') -> orderBy('id', 'desc') -> first();
		$count = $invoice ? ((int)(substr($invoice -> invoice, -2)) + 1) : '01';
		$count = str_pad($count, 2, "0", STR_PAD_LEFT);

		$new_invoice = 'PP' . $month . $count;

		$array = array_merge($array, array('invoice' => $new_invoice));

		return $this->PurchasePlanModel->create($array);
	}

	public function planFind($id) {
		
		if (!$plan = $this->PurchasePlanModel->find($id))
			throw new PurchasePlanException("Purchase Plan [$id] was not found.");

		return $plan;
	}

	/**
	 * Create vendor
	 */
	public function vendorCreate(array $vendor) {
		return $this->VendorModel->create($vendor);
	}

	public function vendorList() {
		return $this->VendorModel->where('id', '>', 0);
	}
  
	public function vendorFind($id) {
		if (!$vendor = $this->VendorModel->find($id))
			throw new PurchaseVendorNotFoundException("the vendor[$id] can not found.");

		return $vendor;
	}

	public function quotationCreate(array $quotation) {
		return $this->VendorQuotationModel->create($quotation);
	}

	public function quotationList() {
		return $this->VendorQuotationModel->where('id', '>', 0);
	}

	public function quotationFind($id) {
		if (!$quotation = $this->VendorQuotationModel->find($id))
			throw new VendorQuotationNotFoundException("the quotation[$id] can not found.");

		return $quotation;
	}

	public function requestParent($plan_id = 0) {
		$list = array();
		$res = $this->PurchaseRequestDetailModel->getParentStr() -> get();
		foreach ($res as $r) {
			$list[$r -> id] = $r -> parent_id;
		}

		return $list;
	}

	/**
	 *
	 * @param array $request_condition
	 * @param array $detail_condition
	 * @return \Illuminate\Database\Eloquent\Builder
	 * @desc
	 * 1.申购单在pending，cancelled状态下不能分配到计划表
	 * 2.申购明细有计划明细的也不能再次分配
	 * 以上2点在界面控制
	 */
	public function requestDetailList(array $request_condition = null, array $detail_condition = null) {
		$builder = $this->PurchaseRequestDetailModel->withJoin($request_condition, $detail_condition);

		return $builder;
	}
	
	
	public function requestDetailListOfVerified()
	{
	    $verifiedRequestIds=$this->PurchaseRequestModel->whereIn('status',array('verified','completed'))->lists('id');
	    
	    $builder = $this->PurchaseRequestDetailModel->with('request','account','platform')->whereIn('request_id',$verifiedRequestIds);//->where('status','pendingToPlan');
	    
	    return $builder;
	}
	

	/**
	 *
	 * @param int $plan_id
	 * @param string $request_ids
	 * @return boolean
	 * @throws PlanAssignException
	 *
	 */
	public function requestAssignAction($plan_id, $name = '', $request_ids = '', $agent, $purchase_wh) {
		if (($name != '') && ($plan_id == 'new')) {
			$p = $this -> planCreate(array('name' => $name, 'agent' => $agent));
			$plan_id = $p -> id;
		}

		//搜索出包含明细的明细产品，将结果集合写入计划明细和日志
		$request_filter = array( array('f' => 'status', 'o' => '<>', 'v' => 'cancelled'), array('f' => 'status', 'o' => '<>', 'v' => 'pending'), );

		$detail_filter = array( array('f' => 'plan_id', 'o' => '<=', 'v' => 0), array('f' => 'plan_detail_id', 'o' => '<=', 'v' => 0));

		if ($request_ids != 'all')
			$detail_filter[] = array('f' => 'id', 'o' => 'in', 'v' => explode(",", $request_ids));

		//整理需求明细，条件：item,wareh
		$planArr = $this -> getAssignList($request_filter, $detail_filter);

		if (count($planArr) == 0)
			throw new RequestAssignException("没有可添加进计划的数据!");

		$self = $this;

		 DB::transaction(function() use ($planArr, $self, $plan_id, $purchase_wh) {
			if ($planArr) {
				foreach ($planArr as $key => $val) {
					$planDetail = $val;
					$planDetail['status'] = 'pending';

					$req_detail_ids = $val['request_idd'];
					unset($planDetail['request_idd']);
					$childs = $val['childs'];
					unset($planDetail['childs']);

					if (!$id = $self -> planDetailCreate($planDetail, $plan_id, $val['childs'], $purchase_wh))
						throw new RequestAssignException("添加计划失败!");

					//插入日志,只做插入，暂时不用
					$tmp = explode(",", $req_detail_ids);

					foreach ($tmp as $k => $v) {
						$idd = explode("|", $v);

						//更新plan id到明细表
						$detail = $this->PurchaseRequestDetailModel->find($idd[1]);
						if (!$detail -> update(array('plan_id' => $plan_id, 'plan_detail_id' => $id)))
							throw new RequestAssignException("写申购－计划明细日志失败!");
					}

				}
			}
			return 1;
		});

		return 1;
	}

	protected function getAssignList($request_filter, $detail_filter) {
		$planArr = array();
		foreach ($this->requestDetailList(array_filter($request_filter),array_filter($detail_filter))->get() as $detail) {
			$key = $detail -> item_id . '-' . $detail -> warehouse_id . '-' . $detail -> relation_id . '-' . $detail -> transportation;

			if (in_array($key, array_keys($planArr))) {
				$planArr[$key]['request_qty'] += $detail -> qty;
				$planArr[$key]['request_idd'] .= "," . $detail -> request_id . "|" . $detail -> id . "|" . $detail -> qty;
			} else {
				$planArr[$key]['item_id'] = $detail -> item_id;
				$planArr[$key]['warehouse_id'] = $detail -> warehouse_id;
				$planArr[$key]['relation_id'] = $detail -> relation_id;
				$planArr[$key]['transportation'] = $detail -> transportation;
				$planArr[$key]['request_qty'] = $detail -> qty;
				$planArr[$key]['request_idd'] = $detail -> request_id . "|" . $detail -> id . "|" . $detail -> qty;
				$planArr[$key]['childs'] = $detail -> childs();
			}
		}

		return $planArr;
	}

	

	public function planDetailCreate($detail, $plan_id, $childs, $purchase_wh) {
		//获取可用库存:实际库存-需求+发了(shipment)
		$detail['plan_id'] = $plan_id;

		$sku = $this->ItemModel->find($detail['item_id']) -> sku;
		$setting = $this -> skuDefaultSetByItemID($detail['item_id']);
		if (!$setting)
			throw new RequestAssignException($sku . "没有默认值[默认的供应商或装箱数]");

		$detail['vendor_id'] = $setting -> vendor_id;
		//原始需求
		$req = $detail['request_qty'];
		$detail['stock_qty'] = $this -> getLeaveStock($purchase_wh, $detail['item_id']);
		//装箱数调整后得需求
		$detail['real_qty'] = ($setting['spq'] > 0) ? round(($req / $setting['spq'])) * $setting['spq'] : $req;
		//采购量＝调整后需求量 － 库存量
		$detail['to_purchase_qty'] = $detail['real_qty'] - $detail['stock_qty'];
		//申请采购量 － 库存剩余数量..

		//获取报价
		$tmp = $this->VendorQuotationModel->where('item_id', '=', $detail['item_id']) -> where('vendor_id', '=', $setting['vendor_id']) -> first();

		//throw new RequestAssignException(count($childs));
		if (!$tmp && (count($childs) == 0)) {//parent sku可以没有信息
			throw new RequestAssignException("[$sku]没有报价信息，请及时填写!");
		}

		if ($tmp) {
			$detail['price_type'] = $tmp -> price_type;
			$detail['quotation_id'] = $tmp -> id;
			switch($tmp->price_type) {
				case 'normal' :
					$detail['unit_price'] = $tmp -> unit_price;
					break;
				case 'tax' :
					$detail['unit_price'] = $tmp -> tax_unit_price;
					break;
				case 'usd' :
					$detail['unit_price'] = $tmp -> usd_price;
					break;
			}
		}

		if (!$record = $this->purchasePlanDetailModel->create($detail))
			throw new RequestAssignException("汇总创建明细失败!");

		$parent_id = $record -> id;

		if (count($childs) > 0) {
			foreach ($childs as $item_id => $bom_qty) {
				//$record = $this->purchasePlanDetailModel->where('item_id','=',$item_id)->where('parent_id','=',$parent_id)->get()->toArray();
				$child_detail = $detail;
				$child_detail['plan_id'] = $plan_id;
				$child_detail['item_id'] = $item_id;
				$child_detail['parent_id'] = $parent_id;
				$child_detail['request_qty'] = $bom_qty * $req;
				//成品得装箱数量已经调整过，这里不用再调整
				$child_detail['real_qty'] = $detail['real_qty'] * $bom_qty;
				$child_detail['stock_qty'] = $this -> getLeaveStock($purchase_wh, $item_id);
				$child_detail['to_purchase_qty'] = $child_detail['real_qty'] - $child_detail['stock_qty'];

				$sku = $this->ItemModel->find($item_id) -> sku;
				$tmp = $this -> skuDefaultSetByItemID($item_id);
				if (!$tmp)
					throw new RequestAssignException($sku . "没有默认值[默认的供应商]");

				$child_detail['vendor_id'] = $tmp -> vendor_id;

				//获取报价
				$tmp = $this->VendorQuotationModel->where('item_id', '=', $item_id) -> where('vendor_id', '=', $tmp['vendor_id']) -> first();

				if (!$tmp) {
					throw new RequestAssignException("[$sku]没有报价信息，请及时填写!");
				}

				if ($tmp) {
					$child_detail['price_type'] = $tmp -> price_type;
					$child_detail['quotation_id'] = $tmp -> id;
					switch($tmp->price_type) {
						case 'normal' :
							$child_detail['unit_price'] = $tmp -> unit_price;
							break;
						case 'tax' :
							$child_detail['unit_price'] = $tmp -> tax_unit_price;
							break;
						case 'usd' :
							$child_detail['unit_price'] = $tmp -> usd_price;
							break;
					}
				}

				if (!$record = $this->purchasePlanDetailModel->create($child_detail))
					throw new RequestAssignException("分解明细失败!");
			}
		}

		return $parent_id;
	}

	public function splitPlanDetail(array $splitArr) {
		if (count($splitArr) == 0)
			throw new RequestAssignException("没有拆分数据!");

		$self = $this;
		 DB::transaction(function() use ($splitArr, $self) {
			$parent_id = 0;
			foreach ($splitArr as $k => $v) {
				$update = array();
				//修改旧单
				$orgin_detail = $self -> planDetaiFind($v['id']);
				//如果原单还在初始状态，则需要拆分初始得采购数量
				if ($orgin_detail -> status == 'pending') {//拆分采购量,
					$update['real_qty'] = $orgin_detail -> real_qty - $v['split_qty'];
					$update['to_purchase_qty'] = $orgin_detail -> to_purchase_qty - $v['split_qty'];
				} else {//只拆分
					$update['real_qty'] = $orgin_detail -> real_qty - $v['split_qty'];
				}
				if (!$orgin_detail -> update($update))
					throw new RequestAssignException("修改旧单失败!");

				$create = $v;
				unset($create['split_qty']);
				unset($create['id']);
				$create['warehouse_id'] = $v['warehouse_id'];
				$create['transportation'] = $v['transportation'];
				//如果原单还在初始状态，则需要拆分初始得采购数量
				if ($orgin_detail -> status == 'pending') {//拆分采购量,
					$create['real_qty'] = $v['split_qty'];
					$create['to_purchase_qty'] = $v['split_qty'];
					$create['price_type'] = $v['price_type'];
					//原来的含税与不含税不一致旧改价格
					if (($v['parent_id'] > 0) && $orgin_detail -> price_type != $v['price_type']) {
						//获取报价
						$tmp = $this->VendorQuotationModel->where('item_id', '=', $orgin_detail -> item_id) -> where('vendor_id', '=', $orgin_detail -> vendor_id) -> first();
						$create['quotation_id'] = $v['quotation_id'];
						switch($v['price_type']) {
							case 'normal' :
								$create['unit_price'] = $tmp -> unit_price;
								break;
							case 'tax' :
								$create['unit_price'] = $tmp -> tax_unit_price;
								break;
							case 'usd' :
								$create['unit_price'] = $tmp -> usd_price;
								break;
						}
					}
				} else {//只拆分
					$create['real_qty'] = $orgin_detail -> real_qty - $v['split_qty'];
				}

				//分组合得父sku必须先插入生成得id就是子sku得parent_id
				if ($v['parent_id'] == 0) {
					if (!$id = $parent_id = $this->purchasePlanDetailModel->create($create))
						throw new RequestAssignException("创建新单失败!");
				} else {
					$create['parent_id'] = $parent_id;
					if (!$id = $this->purchasePlanDetailModel->create($create))
						throw new RequestAssignException("创建新单失败!");
				}
			}
		});

		return true;
	}

	/**
	 *
	 * @param string $request_ids
	 * @param int $plan_id
	 * @return boolean
	 * @throws PlanAssignException
	 * @desc
	 * 1. 找出日志(plan_detail_id,request_detail_id,qty)
	 * 2. 找出对应的计划明细记录，如果日志数量小于计划，则减少数量；如果等于计划，则删除计划明细
	 * 3. 删除日志明细
	 * 4. 清空request_detail中的plan_id和plan_detail_id
	 */

	public function requestAssignReject($plan_id, $request_ids) {
		$self = $this;
		 DB::transaction(function() use ($request_ids, $plan_id, $self) {
			$rdetails = $this->PurchaseRequestDetailModel->where('plan_id', '=', $plan_id) -> whereIn('id', explode(",", $request_ids)) -> get();

			try {
				foreach ($rdetails as $rdetail) {
					//先更新child
					$childs = $rdetail -> childs();
					$planDetail = $this->purchasePlanDetailModel->find($rdetail -> plan_detail_id);

					if ($planDetail -> status != 'pending')
						throw new PlanAssignException('不能剔除，已经到了采购或者调度阶段');

					if (count($planDetail -> splits) > 0)
						throw new PlanAssignException('不能剔除，该明细被拆分过');

					//删除或者减少计划明细
					if ($planDetail -> request_qty == $rdetail -> qty) {
						if (count($childs) > 0) {
							if (!$this->purchasePlanDetailModel->where('parent_id', '=', $planDetail -> id) -> delete())
								throw new PlanAssignException('删除计划明细失败');
						}

						if (!$planDetail -> delete())//删除对应的child和parent
							throw new PlanAssignException('删除计划明细失败');
					} else if ($planDetail -> request_qty > $rdetail -> qty) {
						$setting = $self -> skuDefaultSetByItemID($rdetail -> item_id);
						$req = $planDetail -> request_qty - $rdetail -> qty;
						$real_qty = ($setting['spq'] > 0) ? round(($req / $setting['spq'])) * $setting['spq'] : $req;
						//
						//采购量＝调整后需求量 － 库存量
						$to_purchase_qty = $real_qty - $stock_qty;
						//申请采购量 － 库存剩余数量..

						if (count($childs) > 0) {
							foreach ($childs as $item_id => $bom_qty) {
								$stock_qty = $this -> getLeaveStock('7', $detail['item_id']);
								//仓库默认未7

								$childDetail = $this->purchasePlanDetailModel->where('item_id', '=', $item_id) -> where('parent_id', '=', $planDetail -> id) -> get() -> toArray();
								$childDetail = head($childDetail);

								if (!$this->purchasePlanDetailModel->where('item_id', '=', $item_id) -> where('parent_id', '=', $planDetail -> id) -> update(array('request_qty' => $req * $bom_qty, 'real_qty' => $real_qty * $bom_qty, 'to_purchase_qty' => $real_qty * $bom_qty - $childDetail['stock_qty'])))
									throw new PlanAssignException("分解明细失败");
							}
						}

						if (!$planDetail -> update(array('request_qty' => $req, 'real_qty' => $real_qty, 'to_purchase_qty' => $real_qty - $planDetail -> stock_qty)))//减少
							throw new PlanAssignException('更新计划明细失败');

					} else {//理论上，合并的计划明细数量不能少于原始申请数量
						throw new PlanAssignException("Reject Faild[request" . $rdetail -> qty . " qty and plan" . $planDetail -> request_qty . " qty do't match]");
					}
					//清空request_detail中的计划id和计划明细id
					if (!$this->PurchaseRequestDetailModel->find($rdetail -> id) -> update(array('plan_id' => 0, 'plan_detail_id' => 0)))
						throw new PlanAssignException('更新申购明细的计划关联失败');
				}

				return 1;

			} catch(Exception $e) {
				throw new PlanAssignException($e -> Message());
			}
		});
	}

	//获取可用库存:实际库存-需求+发了(shipment)---全局的，部分哪个渠道
	public function getLeaveStock($purchase_wh, $item_id) {
		return 0;
		//$sqty = 0;
		//$stock =;
		//获取库存
		//获取所有计划的未发货数--目前没有采购仓库这个条件，默认是purchase仓库，ID＝7
		/*$shipmenting = $this->purchasePlanDetailModel->where('item_id','=',$item_id)
		 ->where('shipment_qty','>',0)
		 ->select('item_id','real_qty','shipment_qty')->get();

		 if(isset($shipmenting) && (count($shipmenting) >0)){
		 foreach ($shipmenting as $v) {
		 $l = $this->PurchasePlanShipLogModel->where('plan_detail_id','=',$v->id);

		 $sqty = $v->real_qty - $v->shipment_qty;
		 }
		 }*/

	}

	//----------------------------------- plan exection ------------------------------//
	/**
	 *
	 * @param array $search_condition
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function planDetailList(array $search_condition, $other_condition = null) {

		$query = $this->purchasePlanDetailModel->with('item', 'warehouse', 'vendor', 'plan');
	
		if ($search_condition) {
		 foreach ($search_condition as $k => $v) {
		 if (($v == '') || ($v == 'null') || ($v == null))
		 continue;

		 $query -> where($k, '=', $v);
		 }
		 
		 }
	
			if ($other_condition) {
		 foreach ($other_condition as $k => $oc) {
		 switch ($oc['c']) {
		 case 'notin' :
		 $query -> whereNotIn($oc['f'], $oc['v']);
		 break;
		 case 'in' :
		 $query -> whereIn($oc['f'], $oc['v']);
		 break;
		 default :
		 $query -> where($oc['f'], $oc['c'], $oc['v']);
		 break;
		 }
		 }
		 }
		 
		return $query -> orderBy('plan_id', 'asc') -> orderBy('item_id', 'asc');
	}

	/**/
	public function getPurchasingSummary($plan_id) {
		return with(new PurchasePlanDetail) -> getPurchasingSummary($plan_id);
	}

	/**
	 *
	 * @param array $search_condition
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function planDetailListByVendorItem($plan_id) {
		$query = $this->purchasePlanDetailModel->getInfoByVendorItem($plan_id);

		return $query;
	}

	/**
	 *
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function planDetaiFind($id) {
		$detail = $this->purchasePlanDetailModel->find($id);

		if (!$detail)
			throw new PurchasePlanException("Detail Not Found!");

		return $detail;
	}

	/*获取plan纵向横向的数据*/
	public function getColumns($plan_id)//getColumns
	{
		return $this->purchasePlanDetailModel->getColumns($plan_id);
	}

	/**
	 *
	 * @param $arr
	 *
	 */
	public function planDetailBatchUpdate(array $arr) {
		$pd_arr = explode(",", $arr['plan_dids']);
		$self = $this;
		 DB::transaction(function() use ($self, $arr, $pd_arr) {
			//直接更改值
			if (!$this->purchasePlanDetailModel->whereIn('id', $pd_arr) -> update(array($arr['field'] => $arr['value'])))
				throw new PurchasePlanException("Detail Update Faild!sssssssss");

			//价格跟供应商和含税与否相关，更改参考价格
			if ($arr['field'] != 'transportation') {
				foreach ($pd_arr as $k => $id) {
					$update_data = array();
					$detail = $self -> planDetaiFind($id);

					//获取报价
					$tmp = $this->VendorQuotationModel->where('item_id', '=', $detail -> item_id) -> where('vendor_id', '=', $detail -> vendor_id) -> first();
					if (!$tmp) {
						$sku = $this->ItemModel->find($detail -> item_id) -> sku;
						throw new PurchasePlanException("[$sku]没有报价信息，请及时填写!");
					}

					$update_data['quotation_id'] = $tmp -> id;
					switch($detail->price_type) {
						case 'normal' :
							$update_data['unit_price'] = $tmp -> unit_price;
							break;
						case 'tax' :
							$update_data['unit_price'] = $tmp -> tax_unit_price;
							break;
						case 'usd' :
							$update_data['unit_price'] = $tmp -> usd_price;
							break;
					}

					if (!$detail -> update($update_data))
						throw new PurchasePlanException("Detail Update Faild!");
				}
			}
			return true;
		});

	}

	/**
	 *
	 * @param $arr
	 *
	 */
	public function planDetailUpdate(array $arr) {
		$id = $arr['detail_id'];
		unset($arr['detail_id']);
		$old = $this -> planDetaiFind($id);
		$self = $this;
		 DB::transaction(function() use ($self, $arr, $old, $id) {
			//直接更改值
			$detail = $self -> planDetaiFind($id);
			if (!$detail -> update($arr))
				throw new PurchasePlanException("Detail Update Faild!");

			//价格跟供应商和含税与否相关，更改参考价格
			if (($old -> vendor_id != $arr['vendor_id']) || ($old -> price_type != $arr['price_type'])) {
				$update_data = array();

				//获取报价
				$tmp = $this->VendorQuotationModel->where('item_id', '=', $detail -> item_id) -> where('vendor_id', '=', $detail -> vendor_id) -> first();
				if (!$tmp) {
					$sku = $this->ItemModel->find($detail -> item_id) -> sku;
					throw new PurchasePlanException("[$sku]没有报价信息，请及时填写!");
				}

				$update_data['quotation_id'] = $tmp -> id;
				switch($detail->price_type) {
					case 'normal' :
						$update_data['unit_price'] = $tmp -> unit_price;
						break;
					case 'tax' :
						$update_data['unit_price'] = $tmp -> tax_unit_price;
						break;
					case 'usd' :
						$update_data['unit_price'] = $tmp -> usd_price;
						break;
				}

				if (!$detail -> update($update_data))
					throw new PurchasePlanException("Detail Update Faild!");
			}
			return true;
		});

	}

	/**
	 *
	 * @param $arr
	 *
	 */
	public function planDetailBatchUpdateQty(array $arr) {
		$pd_arr = explode(",", $arr['plan_dids']);

		$self = $this;
		 DB::transaction(function() use ($self, $pd_arr, $arr) {
			foreach ($pd_arr as $k => $id) {
				$detail = $self -> planDetaiFind($id);
				$spq = $self -> skuDefaultSetByItemID($detail -> item_id);
				$spq = $spq -> spq ? $spq -> spq : 1;
				switch ($arr['type']) {
					case 'up' :
						$real_qty = ceil($detail -> request_qty / $spq) * $spq;
						break;
					case 'middle' :
						$real_qty = round($detail -> request_qty / $spq) * $spq;
						break;
					default :
						$real_qty = floor($detail -> request_qty / $spq) * $spq;
						break;
				}
				if (!$detail -> update(array('real_qty' => $real_qty, 'to_purchase_qty' => ($real_qty - $detail -> stock_qty))))
					throw new PurchasePlanException("Detail Update Faild!");
			}

			return true;
		});
	}

	//----------------------------------- plan ship ------------------------------//

	//----------------------------------- plan exection ------------------------------//
	/**
	 *
	 * @param array $search_condition
	 * @return \Illuminate\Database\Eloquent\Builder
	 *
	 */
	public function skuDefaultSetByItemID($item_id) {
		return $this->PurchaseSkuDefaulModel->where('item_id', '=', $item_id) -> first();
	}

	//将csv写入文件
	public function filePutCsv($file, $data, $header = 1, $arr = array()) {
		$fp = fopen($file, 'w');

		if ($header) {
			//用指定的做第一行title
			if (is_array($arr) && count($arr) > 0) {
				fputcsv($fp, $arr);
			} else {
				if (is_array($data) && count($data) > 0) {
					foreach ($data as $key => $val) {
						fputcsv($fp, array_keys($val));
						//写头部信息(即字段名)
						break;
					}
				}
			}
		}

		//写文件
		foreach ($data as $val) {
			fputcsv($fp, (array)$val);
		}

		fclose($fp);
	}

	//----------------------------------- return exection ------------------------------//

	/**
	 * return list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function returnList() {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		return $this->PurchaseReturnModel->with('user', 'vendor', 'warehouse');
	}

	/**
	 * return Detail list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function returnDetailList() {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		return $this->$PurchaseReturnDetailModel->with('item');
	}

	/**
	 * check if return exists
	 *
	 * @param string $id
	 * @return boolean
	 */
	public function returnExists($id) {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		return $this->PurchaseReturnModel->isExists($id);
	}

	/**
	 * find return by Field
	 *
	 * @param array $attributes
	 * @return return
	 * @throws PurchasePlanNotFound\Exception
	 */
	public function returnFindByField($attributes) {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		$temp = $this->PurchaseReturnModel->with('user', 'vendor', 'warehouse');
		foreach ($attributes as $condition) {
			if ($condition['opera'] == "in") {
				$temp -> whereIn($condition['field'], $condition['value']);
			} else {
				$temp -> where($condition['field'], $condition['opera'], $condition['value']);
			}
		}
		return $temp;
	}

	public function getNextReturnInvoice() {
		return $this->PurchaseReturnModel->GenerateInvoice();
	}

	/**
	 * 查找所有item_id为@item_id的列的return_id(主表主键)
	 * @param interge  $item_id
	 *
	 * @return array io_id的集合
	 *
	 */

	public function returnGetMasterIdFromDetailByItemId($item_id) {
		$models = $this->$PurchaseReturnDetailModel->where('item_id', '=', $item_id) -> select(array('return_id'));

		$ids = array();
		foreach ($models->get() as $detail) {
			$ids[] = $detail -> return_id;
		}
		return $ids;
	}

	/**
	 * find return by ID
	 *
	 * @param string $id
	 * @return return
	 * @throws returnNotFound\Exception
	 */
	public function returnFindByPK($id) {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		return $this->PurchaseReturnModel->find($id);
	}

	/**
	 * find return detail by ID
	 *
	 * @param string $id
	 * @return return
	 * @throws returnNotFound\Exception
	 */
	public function returnDetailFindByPK($id) {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		return $this->$PurchaseReturnDetailModel->find($id);
	}

	/**
	 * find return list
	 *
	 * @return returnList
	 * @throws returnNotFound\Exception
	 */
	public function returnFindAll($condition) {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		$where = array();

		foreach ($condition as $key => $value) {
			$where[] = array($key, $value);
		}

		return $this->PurchaseReturnModel->where($where) -> find();
	}

	public function returnCreate(array $returnModelInfo) {
		return $this->PurchaseReturnModel->create($returnModelInfo);
	}

	public function returnDetailCreate(array $returnDetailModelInfo) {
		return $this->$PurchaseReturnDetailModel->create($returnDetailModelInfo);
	}

	public function getReturnStatusList() {
		return $this->PurchaseReturnModel->getStatusList();
	}

	public function returnDelete($id) {
		return $this->PurchaseReturnModel->destroy($id);
	}

	public function returnDetailDelete($id) {
		return $this->$PurchaseReturnDetailModel->destroy($id);
	}

	public function returnMoreFindByPK($id) {
		//throw new \Exception("use this ".__FUNCTION__." of this ".get_class($this)." , you must overwrite this ".__FUNCTION__." first!");
		return $this->PurchaseReturnModel->with("details") -> find($id);
	}

	public function returnDetailUpdateSKU($oldItemId, $newItemId) {
		return $this->$PurchaseReturnDetailModel->where('item_id', '=', intval($oldItemId)) -> update(array('item_id' => intval($newItemId)));
	}

	public function returnGenerateOutStock($id, $userid) {
		try {
			$returnModel = $this->PurchaseReturnModel->with('details') -> find($id);

			$stockService = $this->StockIOService;

			list($stock, $stockDetails) = $this -> returnModelConvertToStockModel($returnModel);
			$stock['creat_agent'] = $userid;
			$stockService -> createStockOut($stock, $stockDetails);

			$returnModel -> status = 'stocking';

			$returnModel -> save();

			return true;
		} catch(Exception $e) {
			echo $e -> message;
			return false;
		}
	}

	/**
	 * 特殊修改 sku 替换
	 * 当otherIoMaster status 为 pending 或者 confirmed 状态时(即未添加到出入库单时) 直接修改
	 *                        其他情况 到 stockService中修改 成功后 再修改 otherIoMaster
	 *
	 * @param integer $masterId
	 * @param integer $agent
	 * @param integer $fromItemId
	 * @param integer $toItemId
	 *
	 * @return void
	 *
	 */
	public function specailUpdateForSkus($masterId, $agent, $fromItemId, $toItemId) {
		$masterId = intval($masterId);
		$fromItemId = intval($fromItemId);
		$toItemId = intval($toItemId);
		//主model
		$masterModel = $this->PurchaseReturnModel->with('details') -> find($masterId);

		//特殊情况
		if ($masterModel -> status != "pending" && $masterModel -> status != "confirmed") {
			$stockService = $this->StockIOService;
			$stockService -> updateStockOutIOItemId($masterId, $this->IOType->PURCHASING_RETUEN_VENDOR, $agent, $fromItemId, $toItemId);
		}

		foreach ($masterModel->details as $detail) {
			if ($detail -> item_id == $fromItemId) {
				$detail -> item_id = $toItemId;
				$detail -> save();
			}
		}

		return true;
	}

	/**
	 * 当otherIoMaster status 为 pending 或者 confirmed 状态时(即未添加到出入库单时) 直接修改
	 *                        其他情况 到 stockService中修改 成功后 再修改 otherIoMaster
	 *
	 * @param integer $masterId
	 * @param integer $detailId
	 * @param integer $agent
	 * @param array $detailInfo
	 */
	public function specailUpdateForQty($masterId, $agent, $detailId, $detailInfo) {
		$masterId = intval($masterId);
		$detailId = intval($detailId);
		$qty = isset($detailInfo['qty']) ? $detailInfo['qty'] : false;
		$hasChangedNum = false;
		//主model
		$masterModel = $this->PurchaseReturnModel->with('details') -> find($masterId);

		//未生成出入库单时  直接修改
		foreach ($masterModel->details as $detail) {
			if ($detail -> id == $detailId) {
				if ($detail -> qty != $qty)
					$hasChangedNum = (bool)($hasChangedNum || true);
				foreach ($detailInfo as $key => $v) {
					$detail -> $key = $v;
				}
				$detail -> save();
			}
		}

		if ($qty !== false && $hasChangedNum) {
			if ($masterModel -> status != "pending" && $masterModel -> status != "confirmed") {
				$stockService = $this->StockIOService;
				$stockService -> updateStockOutIOItemId($masterId, $detailId, $this->IOType->PURCHASING_RETUEN_VENDOR, $agent, $qty);
			}
		}

	}

	/**
	 * @param integer $masterId
	 * @param integer $agent
	 * @return boolean
	 */

	public function returnPendingByMasterId($masterId, $agent = '1') {
		$masterId = intval($masterId);
		$masterModel = $this->PurchaseReturnModel->find($masterId);
		if ($masterModel -> status == "pending" || $masterModel -> status == "confirmed") {
			if ($masterModel -> status == "confirmed") {
				$masterModel -> status = "pending";
				$masterModel -> save();
			}
			return true;
		} else {
			 DB::transaction(function() use ($masterModel, $masterId, $agent) {
				$stockService = $this->StockIOService;
				$stockService -> reverseOutByOrign($masterId, $agent, $this->IOType->PURCHASING_RETUEN_VENDOR);
				$masterModel -> status = "pending";
				$masterModel -> save();
				return true;
			});
		}
	}

	protected function returnModelConvertToStockModel($return) {
		if ($return instanceof PurchaseReturn) {
			$stock = array();
			$details = array();
			$detailModel = $return -> details;
			$stock['relation_id'] = $return -> id;
			$stock['relation_invoice'] = $return -> invoice;
			$stock['warehouse_id'] = $return -> warehouse_id;

			$stock['type'] = $this->IOType->PURCHASING_RETUEN_VENDOR;
			foreach ($detailModel as $k => $detail) {
				$details[$k]['item_id'] = $detail -> item_id;
				$details[$k]['qty'] = $detail -> qty;
				$details[$k]['relation_did'] = $detail -> id;
			}

			return array($stock, $details);
		} else
			throw new \Exception("use this method the argument must instanceof PurchaseReturn");
	}

	//-----------------------------------  default setting exection ------------------------------//
	/**
	 * find packing by ID
	 *
	 * @param string $id
	 * @return packing
	 * @throws PurchasePackingException
	 */
	public function packingFind($id) {
		if (!$packing = $this->PurchaseSkuDefaulModel->with('item','vendor') -> find($id))
			throw new PurchasePlanException("Purchase SKU Default [$id] was not found.");

		return $packing;
	}

	/**
	 * packing list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function packingList() {
		return $this->PurchaseSkuDefaulModel->with('item', 'vendor') -> orderBy('id', 'desc');
	}

	/**
	 * Create a new packing
	 *
	 * @param array $array
	 * @return bool
	 */
	public function packingCreate(array $array) {
		return $this->PurchaseSkuDefaulModel->create($array);
	}

	public function getPurchaseOrder($plan_id) {
		return $this->PurchasePlanOrderLogModel->getPurchaseOrder($plan_id);
	}

	public function getPurchaseOrderStockin($plan_id) {
		return $this->PurchasePlanOrderLogModel->getPurchaseOrderStockin($plan_id);
	}

	public function getShipment($plan_id) {
		return $this->PurchasePlanShipLogModel->getShipment($plan_id);
	}

	/**
	 * 获取某仓库下的运费系数
	 * @param int $warehouse_id
	 * @param mix $item_id
	 */
	public function GetCostParamsByWarehouse($warehouse_id, $item_id = false) {
		$modelAr = $this->PurchaseCostParamsModel->where('warehouse_id', '=', intval($warehouse_id));
		if ($item_id !== false) {
			$modelAr -> where('item_id', '=', intval($item_id));
		}
		return $modelAr -> first();
	}

    /**
     * 返回运费系数list
     * @param array $condition
     */
	public function CostParamsList($condition=array())
	{
	    if($condition===array() || count($condition)<1)
	    {
	        return $this->PurchaseCostParamsModel->with('warehouse','item')->orderBy('id','desc');
	    }
	    else 
	    {
	        $modelAr=$this->PurchaseCostParamsModel->with('warehouse');
	        if(isset($condition['warehouse_id']))
	        {
	            $modelAr->where('warehouse_id','=',intval($condition['warehouse_id']));
	        }
	        
	        if(isset($condition['item_id']))
	        {
	            $modelAr->where('item_id','=',intval($condition['item_id']));
	        }	        
	        return $modelAr->orderBy('id','desc');	        
	    }
	}

	/**
	 * 添加一条运费系数
	 * @param array $attr
	 */
	public function addCostParams($attr) {
		if (isset($attr['id']))
			unset($attr['id']);
		return $this->PurchaseCostParamsModel->create($attr);
	}

	/**
	 * 修改一条运费系数
	 * @param int $id
	 * @param array $attr
	 */
	public function updateCostParams($id, $attr) {
		$costParams = $this->PurchaseCostParamsModel->find($id);
		if (empty($costParams))
			throw new \Exception("cost params with id '" . $id . "' is not found!");
		if (isset($attr['warehouse_id']))
			$costParams -> warehouse_id = intval($attr['warehouse_id']);
		if (isset($attr['item_id']))
			$costParams -> item_id = intval($attr['item_id']);
		if (isset($attr['air_cost']))
			$costParams -> air_cost = floatval($attr['air_cost']);
		if (isset($attr['sea_cost']))
			$costParams -> sea_cost = floatval($attr['sea_cost']);
		return $costParams -> save();
	}

	/**
	 * 修改多条记录
	 * @param array $attrs
	 * @param bool $addIfNotExists 不存在时时候添加(存在id时例外)
	 */
	public function updateAllCostParams($attrs, $addIfNotExists = true) {
		foreach ($attrs as $attr) {
			if (isset($attr['id'])) {
				$this -> updateCostParams($attr['id'], $attr);
			} else {
				if (isset($attr['warehouse_id'])) {
					$this -> updateCostParamsByWarehouse($attr['warehouse_id'], $attr, $addIfNotExists);
				} else {
					//无效数据直接过滤
					continue;
				}
			}
		}
	}

	/**
	 * 根据warehouse 更新运费系数
	 * @param int $warehouse_id
	 * @param array $attrs
	 * @param bool $addIfNotExists 不存在时时候添加(存在id时例外)
	 */
	public function updateCostParamsByWarehouse($warehouse_id, $attr, $addIfNotExists) {
		$modelAr = $this->PurchaseCostParamsModel->where('warehouse_id', '=', intval($warehouse_id));
		if (isset($attr['item_id'])) {
			$modelAr -> where('item_id', '=', intval($attr['item_id']));
		}
		$model = $modelAr -> first();
		if (empty($model)) {
			if ($addIfNotExists) {
				$attr['warehouse_id'] = $warehouse_id;
				return $this -> addCostParams($attr);
			}
		} else {
			if (isset($attr['item_id']))
				$model -> item_id = intval($attr['item_id']);
			if (isset($attr['air_cost']))
				$model -> air_cost = floatval($attr['air_cost']);
			if (isset($attr['sea_cost']))
				$model -> sea_cost = floatval($attr['sea_cost']);
			return $model -> save();
		}
	}

	/**
	 * 返回一条运费系数model
	 * @param int $id
	 */
	public function getCostParams($id) {
		return $this->PurchaseCostParamsModel->with('warehouse', 'item') -> find($id);
	}
	
	/**
	 * @param int $planId
	 * @param array $requestIds
	 * @throws RequestAssignException
	 * @return boolean
	 */
	
	public function requestToPlanDetail($planId,$requestDetailIds)
	{
	    
	   //状态检测
	   $planModel=$this->PurchasePlanModel->findOrFail($planId);
	   if($planModel->status!="open")
	   {
	       throw new RequestAssignException("当前计划表状态异常或者已经被关闭!");
	   }
	   
	   $requestIds=$this->PurchaseRequestDetailModel->with("request")->whereIn('id',$requestDetailIds)->lists('request_id');
	   
	   if(count($requestIds)<=0)
	   {
	       throw new RequestAssignException("当前所选申购单异常或者已被删除!");
	   }
	   
	   $requestStatusList=$this->PurchaseRequestModel->whereIn('id',$requestIds)->lists('status');
	   
	   $allowRequestStatusList=array('verified','completed');
	   
	   $disAllowReuestStatus=array_diff($requestStatusList, $allowRequestStatusList);
	   
	   if(count($disAllowReuestStatus)>0)
	   {
	       throw new RequestAssignException("当前所选申购单异常,存在 '".implode("','", $disAllowReuestStatus)."' 状态的订单!");
	   }
	    
	   //存储明细
	     DB::transaction(function() use ($requestDetailIds,$planId,$requestIds) {
	      $requestDetails=$this->PurchaseRequestDetailModel->with("request")->whereIn('id',$requestDetailIds)->get();
	      $requests=$this->PurchaseRequestModel->whereIn('id',$requestIds)->get();
	     
	      foreach($requestDetails as $detail){
	        
	           $planAttrs=array();
	           $planAttrs['plan_id']=$planId;
	           $planAttrs['request_detail_id']=$detail->id;
	           $planAttrs['item_id']=$detail->item_id;
	           $planAttrs['warehouse_id']=$detail->request->warehouse->id;
	           $planAttrs['request_qty']=$detail->qty;
	           $planAttrs['transportation']=$detail->transportation;
	           $planAttrs['end_date']=$detail->end_date;
	           $planAttrs['platform_id']=$detail->platform_id;
	           $this->purchasePlanDetailModel->create($planAttrs);
	           $detail->status="planed";
	           $detail->save();
	      }
	      
	      foreach($requests as $request)
	      {
	          if($request->status=="verified")
	          {
	              $request->status="completed";
	              $request->save();
	          }
	      }
	      return true;
	      	        
	    });
	    
	}
	
	public function getPendToCheck()
	{
	    return $this->purchasePlanDetailModel->with('plan','warehouse','item','vendor','platform')->where('status','pending')->orderBy('id','desc');
	}
	
	public function getCheckedDetail()
	{
	    return $this->purchasePlanDetailModel->with('plan','warehouse','item','vendor','platform')->whereIn('status',array('approve','reject'))->orderBy('id','desc');
	}
	
	public function checkPlanDetail($ids,$opera)
	{
	    if($opera=="allow")
	    {
	        //审核通过
	        $status="approve";
	    }
	    else 
	    {
	        //审核拒绝
	        $status="reject";
	    }
	    
	    $planDetailModel=$this->purchasePlanDetailModel->whereIn('id',$ids)->get();
	    
	    foreach($planDetailModel as $detail)
	    {
	        $detail->status=$status;
	        $detail->save();
	    }
	}
	
	public function revertAssignedPlanDetail($detailIds)
	{
	    DB::transaction(function() use ($detailIds) {
	        $requestDetailIds=array();
	        $planDetailModel=$this->purchasePlanDetailModel->whereIn('id',$detailIds)->get();
	        foreach($planDetailModel as $planDetail)
	        {
	            if(in_array($planDetail->status,array('approve','reject','pending')))
	            {
	                $requestDetailIds[]=$planDetail->request_detail_id;
	            }
	            else 
	                throw new Exception("非法的操作,试图修改审核后已使用的计划明细");
	        }
	        
	        $requestDetails=$this->PurchaseRequestDetailModel->whereIn('id',$requestDetailIds)->get();
	        foreach($requestDetails as $rq_detail)
	        {
	            if($rq_detail->status=="planed")
	            {
	                $rq_detail->status="pendingToPlan";
	                $rq_detail->save();
	            }
	        }
	        
	        $this->purchasePlanDetailModel->whereIn('id',$detailIds)->forceDelete();	        
		});
	}
	
	/**
	 * 获取所有仓库,所有item的运费
	 * 
	 */
	public function GetAllWarehouseItemFee()
	{
	    return $this->PurchaseCostParamsModel->GetAllWarehouseItemFee();
	}
	
	
	public function getConfirmPlanMasterIds()
	{
	    return $this->PurchasePlanModel->where('status','confirmed')->lists('id');
	}
	
	public function getConfirmedPlanDetails()
	{
	    $masterIdList=$this->getConfirmPlanMasterIds();
	    return $this->PurchasePlanDetail->with('item','warehouse','plan','platform','vendor')->whereIn('plan_id',$masterIdList)->get();
	}
	
}
