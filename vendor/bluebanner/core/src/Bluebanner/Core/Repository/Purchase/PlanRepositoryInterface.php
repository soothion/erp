<?php namespace Bluebanner\Core\Repository\Purchase;

interface PlanRepositoryInterface
{

	/**
	 * 新建一个计划表
	 *
	 * @param int $agent
	 * @return \Bluebanner\Core\Model\PurchasePlan
	 */
	public function createPlan($name, $agent);

	/**
	 * 根据申购单ID 复制申购单明细到计划表
	 *
	 * @param int $request_id
	 * @return void
	 */
	public function cloneFromRequestDetail($request_id);

}