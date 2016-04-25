<?php namespace Bluebanner\Core\Repository\Purchase;

use Bluebanner\Core\Model\PurchaseSkuDefault;
use Bluebanner\Core\Model\Warehouse;
use Bluebanner\Core\Model\PurchasePlan;
use Bluebanner\Core\Model\PurchasePlanDetail;
use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\PurchaseRequestPlanLog;
use Bluebanner\Core\Model\VendorQuotation;
use Illuminate\Support\Facades\DB;

class PlanRepository implements PlanRepositoryInterface
{
    protected $plan;

    protected $detail;

    protected $wh;

	public function __construct(PurchasePlan $plan, PurchasePlanDetail $detail, Warehouse $wh, PurchaseSkuDefault $modelPurchaseSkuDefault, VendorQuotation $modelVendorQuotation)
	{
		$this->modelPurchasePlanMaster = $this->plan = $plan;
    $this->modelPurchasePlanDetail = $this->detail = $detail;
    $this->wh = $wh;

    $this->modelPurchaseSkuDefault = $modelPurchaseSkuDefault;
    $this->modelVendorQuotation = $modelVendorQuotation;
	}

    // 统计类
    /**
     * 分仓库、运输方式、SKU统计出需求数量
     * sku qty 美空 美海 英空 英海
     */
    public function getPlanSummary($plan_id)
    {

        $query = $this->detail->with('item.cost')->select();

        foreach ($this->warehouseTransportationList($plan_id) as $wt) {
            $query->addSelect(DB::raw("SUM(IF(`warehouse_id` = " . $wt['id'] . " AND `transportation` = '" . $wt['transportation'] . "', `request_qty`, 0)) as '" . $wt['name'] . "-" . $wt['transportation'] . "'"));
        }

        $query->addSelect(DB::raw('SUM(`request_qty`) as `request_qty`'));

        return $query->where('plan_id', $plan_id)
            ->groupBy('item_id');
    }

    public function warehouseTransportationList($plan_id)
    {
        $list = array();

        $query = $this->detail->with('warehouse')
            ->where('plan_id', $plan_id)
            ->groupBy('warehouse_id', 'transportation');

        foreach ($query->get() as $detail) {
            $list[] = array('id' => $detail->warehouse_id, 'name' => $detail->warehouse->name, 'transportation' => $detail->transportation);
        }

        return $list;
    }

    public function getDetailByDestination($plan_id, $item_id, $warehouse_id, $transportation)
    {
        return $this->detail->where('plan_id', $plan_id)
            ->where('item_id', $item_id)
            ->where('warehouse_id', $warehouse_id)
            ->where('transportation', $transportation);
    }

    public function getPlanChangeList($plan_id)
    {
        return $this->detail->where('plan_id', $plan_id)
            ->has('changes');
    }

    // 操作类

	public function createPlan($name, $agent)
	{
        $invoice = $this->plan->GenerateInvoice();
        return $this->plan->create(array(
                                   'name' => $name,
                                   'invoice' => $invoice,
                                   'agent' => $agent
                                   ));
	}

	public function cloneFromRequestDetail($request_id)
	{
		# code...
	}

    public function confirm($plan_id, $agent)
    {
        $plan = $this->find($plan_id);

        if ($plan->agent != $agent)
            throw new \Exception('只可以确认自己的采购计划表');

        $plan->status = 'confirmed';
        $plan->save();
    }

    /**
     * 申购明细汇总到采购计划明细
     * 按照 运输方式-目标仓库-SKU 进行汇总
     */
	public function cloneDetailToPlan($detail_ids, $plan_id)
	{
        if (! is_array($detail_ids) || ! $plan_id)
            throw new \Exception('目标计划和游离的收购单明细不可以为空');

        DB::transaction(function() use ($detail_ids, $plan_id) {

            foreach ($detail_ids as $detail_id) {
                $prd = PurchaseRequestDetail::find($detail_id);

                $ppd = PurchasePlanDetail::where('plan_id', $plan_id)
                    ->where('item_id', $prd->item_id)
                    ->where('warehouse_id', $prd->request->warehouse_id)
                    ->where('transportation', $prd->transportation)
                    ->first();
                if ($ppd) {
                    $ppd->request_qty = $ppd->request_qty + $prd->qty;
                } else {
                    $ppd = new PurchasePlanDetail;
                    $ppd->fill(array(
                        'plan_id'   =>  $plan_id,
                        'item_id'   =>  $prd->item_id,
                        'warehouse_id'=>    $prd->request->warehouse_id,
                        'transportation'=>  $prd->transportation,

                        'status'    =>  'pending',
                        'request_qty'=> $prd->qty,
                    ));
                }

                $ppd->save();

                // 存储关系
                $ppd->requestdetails()->attach($detail_id);

             }
            
            // 重新分配
            $this->resetRequestWeight($plan_id);

        });
        
        return true;
	}

    /**
     * 对指定的采购计划，按照申购需求，计算每条申购明细的权重
     */
    public function resetRequestWeight($plan_id)
    {
        $plan = PurchasePlan::find($plan_id);

        foreach ($plan->details as $detail) {
            
            $sum = $detail->requestdetails()->sum('qty');

            foreach ($detail->requestdetails as $prd) {

                $detail->requestdetails()->updateExistingPivot($prd->id, array('percent' => $prd->qty / $sum), false);

            }
        }
    }

	public function __call($method, $args)
	{
		return call_user_func_array(array($this->plan, $method), $args);
	}


        /**
         * 生成一张新的计划表 并汇总已审核的明细
         * @param $name:计划表名 
         * @param $invoice:计划表编号
         * @param $agent:用户ID
         */
        public function planGenerate($name,$invoice,$agent)
        {
        	$plan=compact('name','invoice','agent');
        	try
        	{
        		$this->plan->create($plan);
//                $detail = PurchaseRequestDetail::where('')->all();
//                var_dump($detail);
        	}
        	catch(\Exception $e)
        	{
                throw new \Exception('Generate plan failed');//异常信息太长，显示统一消息。
            }
        }
        
        
        /**
         *  将申购明细追加到某个已有的明细里
         * @param $plan_id:主表ID 
         * @param $pr_detail_ids:一组申购单明细ID
         */
        public function planAddDetail($plan_id,$pr_detail_ids)
        {
        	$pr_details = PurchaseRequestDetail::find($pr_detail_ids);
        	$result=true;

        	DB::beginTransAction();
        	foreach($pr_details as $val)
        	{
        		$temp1['plan_id']=$plan_id;
        		$temp1['item_id']=$val->item_id;
        		$temp1['platform_id']=$val->platform_id;
        		$temp1['warehouse_id']=1;
        		$temp1['relation_id']=123;
        		$temp1['request_qty']=$val->qty;
                $temp1['status']='pending';//默认pending状态？
                $temp1['vendor_id']=123;
                $temp1['quotation_id']=123;
                $temp1['price_type']=1;
                $temp1['unit_price']=10;
                $temp1['transportation']=$val->transportation;
                $plan_detail_id=DB::table('core_purchase_plan_detail')->insertGetId($temp1);//插入并获取自增ID
                $temp2['request_id']=$val->request_id;
                $temp2['request_detail_id']=$val->id;
                $temp2['item_id']=$val->item_id;
                $temp2['qty']=$val->qty;
                $temp2['plan_id']=$plan_id;
                $temp2['plan_detail_id']=$plan_detail_id;
                DB::table('core_purchase_request_plan_log')->insert($temp2);
            }
            if(DB::commit())
            {
            	return true;
            }
            else 
            {
            	DB::rollBack();
            	return false;
            }    
        }
        
        /**
         * 审核通过
         * @param $plan_id:主表ID 
         * @param $pr_detail_ids:一组明细表ID
         */
        public function planAuditApprove($plan_id,$pr_detail_ids)
        {
        	$plan_detail_ids=DB::table('core_purchase_request_plan_log')
        	->where('plan_id','=',$plan_id)
        	->whereIn('request_detail_id',$pr_detail_ids)
        	->lists('plan_detail_id');
        	DB::beginTransAction();
        	foreach($plan_detail_ids as $plan_detail_id)
        	{
        		DB::table('core_purchase_request_plan')
        		-whereIn('id',$plan_detail_id)
        		-update(array('status'=>'purchasing'));
        	}
        	if(DB::commit())
        	{
        		return true;
        	}
        	else 
        	{
        		DB::rollBack();
        		return false;
        	}
        }
        

        /**
         * 审核拒绝
         * @param $plan_id:主表ID 
         * @param $pr_detail_ids:一组明细表ID
         */
        public function planAuditReject($plan_id,$pr_detail_ids)
        {
        	$plan_detail_ids=DB::table('core_purchase_request_plan_log')
        	->where('plan_id','=',$plan_id)
        	->whereIn('request_detail_id',$pr_detail_ids)
        	->lists('plan_detail_id');
        	DB::beginTransAction();
        	foreach($plan_detail_ids as $plan_detail_id)
        	{
        		DB::table('core_purchase_request_plan')
        		-whereIn('id',$plan_detail_id)
        		-update(array('status'=>'closed'));
        	}
        	if(DB::commit())
        	{
        		return true;
        	}
        	else 
        	{
        		DB::rollBack();
        		return false;
        	}            
        }
        
        
        /**
         * 将计划表的明细换到另一个计划表
         * @param $plan_id:主表ID 
         * @param $pr_detail_ids:一组明细表的id
         */
        public function planDetailChangeMaster($plan_id,$pr_detail_ids)
        {
        	$plan_detail_ids=DB::table('core_purchase_request_plan_log')
        	->whereIn('request_detail_id',$pr_detail_ids)
        	->lists('plan_detail_id');
        	DB::beginTransAction();
        	foreach($plan_detail_ids as $plan_detail_id)
        	{
        		DB::table('core_purchase_request_plan')
        		-whereIn('id',$plan_detail_id)
        		-update(array('plan_id'=>$plan_id));
        	}
        	if(DB::commit())
        	{
        		return true;
        	}
        	else 
        	{
        		DB::rollBack();
        		return false;
        	}                  
        }
        
        
        /**
         * 返回最新一个计划表中的所有数据
         * @param $filter:过滤条件 
         * @param $fields:需要返回的字段 
         * @param $page_no:页数 
         * @param $page:分页大小
         */
        public function getLastApprovedPlan($filter,$fields,$page_no,$page)
        {
        	$plan_id=DB::table('core_purchase_plan')
        	->select('id')
        	->orderBy('created_at','desc')
        	->first()->id;
        	$filter[]=array('plan_id',$plan_id);
        	$table='core_purchase_plan_detail';
        	return findAllByCondition($table,$filter,$fields,$page_no,$page);
        }  


         /**
          * 返回某个计划表中的所有数据
          * @param $plan_id:主表ID 
          * @param $filter:过滤条件 
          * @param $fields:需要返回的字段 
          * @param $page_no:页数 
          * @param $page:分页大小
          */
         public function getApprovedPlan($plan_id,$filter,$fields,$page_no,$page)
         {
         	$filter[]=array('plan_id',$plan_id);
         	$table='core_purchase_plan_detail';
         	return findAllByCondition($table,$filter,$fields,$page_no,$page);             
         }
         
         /**
          * 将审核后的计划表的明细 数量,供应商进行调整
          * @param $plan_id:主表ID 
          * @param $details:明细表中要修改的相关内容
          */
         public function adjustmentPlans($plan_id,$details)
         {
         	return DB::table('core_purchase_plan_detail')
         	->where('status','=','purchasing')
         	->where('plan_id','=',$plan_id)
         	->update($details);
         }
         
         /**
          * 拆分明细
          * @param $detail_id:明细表Id
          */
         public function splitPlanDetails()
         {

         }
         
         /**
          * 生成采购单
          * @param $plan_id:主表ID
          */
         public function GenaratePurchaseOrder()
         {

         }

         public function getRequestDetails($value = '')
         {
         	return 1;
         }
         
         /**
          * 通用查找方法,改写自念哥的方法
          * @param  $table 表名
          * @param  $filter 过滤条件 
          * @param  $fields 返回字段
          * @param  $page_no 页数
          * @param  $page 分页大小
          */
         public function findAllByCondition($table,$fields,$filter,$page_no=1,$page=10)
         {
         	$temp=DB::table($table);
         	if(!is_array($filter))
         	{
         		throw new \Exception('filter must be a array');
         	}
         	else 
         	{
         		foreach($filter as $field => $value)
         		{
         			if(is_string($value)||is_int($value))
         			{
         				$temp -> where($field, "=", $value);
         			}
         			else if(is_array($value))
         			{
         				if(isset($value[0]))
         				{
         					$opera=strtolower($value[0]);
         					if($opera=="in")
         					{
         						if(isset($value[1])&&is_array($value[1]))
         						{
         							$temp ->whereIn($field,$value[1]);
         						}
         					}
         					else if($opera=="between")
         					{
         						if(isset($value[1])&&is_int($value[1]))
         						{
         							$temp ->where($field,">",intval($value[1]));
         						}

         						if(isset($value[2])&&is_int($value[2]))
         						{
         							$temp ->where($field,"<",intval($value[2]));
         						}
         					}
         				}
         			}
         			else 
         			{
         				throw new \Exception("filter's format is error !");
         			}  
         		}
         	}
         	$skip=($page_no-1)*$page;
         	if($skip<1)
         	{
         		throw new \Exception('page_no and page must be a  positive integer');
         	}
         	else
         	{
         		return $temp->select($fields)->skip($skip)->take($page)->get();
         	}
         }
         
     }         