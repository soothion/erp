<?php namespace Bluebanner\Core\Purchase;

use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\Audit;

class PRAudit implements AuditInterface
{

	public static function getAutidType()
	{
		return 'PurchaseRequest';
	}

	public static function getOriginalEntity($pid)
	{
		return PurchaseRequest::find($pid);
	}
	
	public static function approve($pid, $agent, $message)
	{
		$pr = static::getOriginalEntity($pid);
		$pr->status = PRStatus::VERIFIED;
		$pr->save();

		Audit::create(array(
			'type_id' => $pid,
			'type_type' => static::getAutidType(),
			'agent'	=> $agent,
			'assessment' => true,
			'note' => $message
		));

		return;

	}

	public static function reject($pid, $agent, $message)
	{
		$pr = static::getOriginalEntity($pid);
		$pr->status = PRStatus::REJECTED;
		$pr->save();

		Audit::create(array(
			'type_id' => $pid,
			'type_type' => static::getAutidType(),
			'agent'	=> $agent,
			'assessment' => false,
			'note' => $message
		));

		return;
	}
}