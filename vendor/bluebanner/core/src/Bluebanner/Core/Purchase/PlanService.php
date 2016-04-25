<?php namespace Bluebanner\Core\Purchase;

use Bluebanner\Core\Model\PurchasePlan;
use Bluebanner\Core\Model\PurchasePlanDetailAdjustment;
use Bluebanner\Core\Repository\Purchase\PlanRepositoryInterface;
use Bluebanner\Core\Repository\Purchase\RequestRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NoRequestForPlanException extends \Exception {}

/**
* Purchase Plan (PP)
* 采购计划处理类
*/
class PlanService implements PlanServiceInterface
{

	/**
	 * Repository类
	 *
	 * @var \Bluebanner\Core\Repository\Purchase\RequestRepositoryInterface
	 */
	protected $request;

	/**
	 * Repository类
	 *
	 * @var \Bluebanner\Core\Repository\Purchase\PlanRepositoryInterface
	 */
	protected $plan;
	
	function __construct(PlanRepositoryInterface $plan, RequestRepositoryInterface $request)
	{
		$this->plan = $plan;
		$this->request = $request;
	}

	/**
	 * 发起产生一个新计划会话
	 */
	public function startNewPlanSession($agent)
	{
		$pr_list = $this->request->pendingToPlan();

		if ( ! $pr_list)
			throw new NoRequestForPlanException('没有需要加入计划的申购单');

		$new_plan = $this->plan->createPlan($agent);

		foreach ($pr_list as $request) {
			$this->plan->cloneFromRequestDetail($request->id);
		}

		return $new_plan;
	}

	public function latestPlanList($filter, $fields)
	{
		return $this->plan->all();
	}

	public function planChangeList($plan_id)
	{
		return $this->plan->getPlanChangeList($plan_id);
	}

	public function activePlan()
	{
		$plan = $this->plan->open()->first();
		return $plan;
	}

	/**
	 * 计划明细添加到采购计划
	 * 
	 * @param int $agents
	 */
	public function addToPlan($agent)
	{
		$active_plan = $this->activePlan();
		if ( ! $active_plan) {
			throw new \Exception('当前没有进行中的计划表，请先创建一个计划表');
		}

    $free_details = $this->request->pendingToPlanDetails('id');

		return $this->plan->cloneDetailToPlan($free_details, $active_plan->id);
	}

	public function createPlan($name, $agent)
	{
		$active_plan = $this->activePlan();
		if ($active_plan) {
			throw new \Exception("只允许一个OPEN的申购计划", 1);
			
		}
		return $this->plan->createPlan($name, $agent);
	}

	/**
	 * 获取游离状态的PR明细列表
	 */
	public function avaliableRequestList()
	{
		return $this->request->pendingToPlanDetails();
	}

	/**
	 * 获取计划表内容
	 * 结构 
	 */
	public function retrievePlan($plan_id)
	{
		return $this->plan->with('user')->find($plan_id);
	}

	/**
	 * 计划表统计详情
	 * 按照SKU、目标仓库、运输方式三个维度进行统计
	 */
	public function planSummaryByWareHouseAndTransaction($plan_id)
	{
		return $this->plan->getPlanSummary($plan_id)->get();
	}

	/**
	 * 修改汇总的数量，遍历所有符合条件的明细，按比例调配
	 *
	 *
	 * @todo 这里考虑，以后修改的值和原始值分开来 这样在多次修改的时候，能够保留原始的分配关系
	 * @param int $plan_id
	 * @param int $item_id
	 * @param int $wh_id
	 * @param string $transportation
	 * @param int $qty
	 */
	public function planAdjustmentByWarehouseAndTransaction($plan_id, $item_id, $wh_id, $transportation, $delta, $agent)
	{

		$detail = $this->plan->getDetailByDestination($plan_id, $item_id, $wh_id, $transportation)->first();

		DB::transaction(function () use ($detail, $delta, $agent) {

			if ($delta != 0) {
				$adjusting = new PurchasePlanDetailAdjustment(array('qty_from' => $detail->request_qty, 'qty_to' => $detail->request_qty + $delta, 'agent' => $agent, 'note' => ''));
				$detail->request_qty += $delta;
				$detail->save();
				$detail->changes()->save($adjusting);
			}

		});

		return;
	}

	public function planWarehouseAndTransactionList($plan_id)
	{
		return $this->plan->warehouseTransportationList($plan_id);
	}

	public function planConfirm($plan_id, $agent)
	{
		return $this->plan->confirm($plan_id, $agent);
	}

}