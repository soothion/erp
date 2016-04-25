<?php namespace Bluebanner\Core\Purchase;

interface RequestServiceInterface {
	
	/**
	 * create a purchase request
	 * 
	 * @param array $request
	 * @param array $details
	 * @return Bluebanner\Core\Model\PurchaseRequest
	 */
	public function requestCreate(array $request, array $details);

	/**
	 * create a purchase request detail
	 *
	 * @param array $detail
	 * @return Bluebanner\Core\Model\PurchaseRequestDetail
	 */
	public function requestDetailCreate(array $detail);
	
	/**
	 * 
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function requestList();

	/**
	 * 
	 * 
	 * @param int $id
	 * @return Bluebanner\Core\Model\PurchaseRequest with details
	 * @throws Bluebanner\Core\PurchaseRequestNotFoundException
	 */
	public function requestFind($id);
}