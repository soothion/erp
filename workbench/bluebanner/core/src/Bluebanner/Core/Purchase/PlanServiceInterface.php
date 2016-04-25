<?php namespace Bluebanner\Core\Purchase;

interface PlanServiceInterface
{
	/**
	 * 创建一个新的计划
	 * 
	 * @param int $agent
	 * @return \Bluebanner\Core\Model\RequestPlan|null
	 */
	public function startNewPlanSession($agent);
}