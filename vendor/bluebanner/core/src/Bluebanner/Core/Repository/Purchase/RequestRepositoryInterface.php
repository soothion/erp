<?php namespace Bluebanner\Core\Repository\Purchase;

interface RequestRepositoryInterface
{
	/**
	 * 获取所有的已经审核通过的申购单
	 */
	public function pendingToPlan();
}