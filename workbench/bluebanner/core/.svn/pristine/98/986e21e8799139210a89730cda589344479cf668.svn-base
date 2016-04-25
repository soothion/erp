<?php namespace Bluebanner\Core\Repository\Purchase;

use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\PurchaseRequestPlanLog;

class RequestRepository implements RequestRepositoryInterface
{

	protected $request;

	protected $detail;

	public function __construct(PurchaseRequest $request, PurchaseRequestDetail $detail, PurchaseRequestPlanLog $log)
	{
		$this->request = $request;
		$this->detail = $detail;

    $this->log = $log;
	}

	public function pendingToPlan()
	{
		return $this->request->verified();
	}

	/**
	 * 游离状态的PR明细
	 */
	public function pendingToPlanDetails($field = NULL)
	{
    $details = $this->detail
      ->with('request')
      ->whereHas('request', function($query) {
        $query->where('status', 'verified');
      })->has('plandetail', 0)
      ->get();

    if ($field) {
      return $details->lists($field);
    }

    return $details;
	}

	public function __call($method, $args)
	{
		return call_user_func_array(array($this->request, $method), $args);
	}
}