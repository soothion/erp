<?php 

use Mockery as m;

/**
 * 测试类命名规则 NamespaceClassTest
 * 因为测试内部没有命名空间，所以类命名的时候包含包名
 */
class PurchaseRequestServiceTest extends PHPUnit_Framework_TestCase
{
	
	function tearDown()
	{
		m::close();
	}

	public function testConfirmFromPending()
	{
		// $this->markTestIncomplete();
		// 关于mocking Eloquent，参考 
		// http://stackoverflow.com/questions/17008637/mocking-eloquent-models-with-find
		// https://github.com/Codeception/AspectMock
		$model = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchaseRequest');

		// 这个一定要写出来 不然没法通过测试
		$model->shouldReceive('hasGetMutator');
		$model->shouldReceive('find')->with('a')->once()->andReturn($model);
		$model->shouldReceive('getStatus')->andReturn('pending');
		$model->shouldReceive('getAgent')->andReturn(2);
		$model->shouldReceive('update');
		$service = new Bluebanner\Core\Purchase\RequestService($model);
		$service->confirm('a', 2);
	}

	/**
	 * @expectedException1 Bluebanner\Core\Purchase\PurchaseOnlyConfirmedFromPendingException
	 */
	public function testConfirmNotFromPending()
	{
		$model = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchaseRequest');
		$model->shouldReceive('hasGetMutator');
		$model->shouldReceive('find')->with(1)->once()->andReturn($model);
		$model->shouldReceive('getStatus')->andReturn('notpending');
		$model->shouldReceive('getAgent')->andReturn(2);
		$model->shouldReceive('update');
		$service = new Bluebanner\Core\Purchase\RequestService($model);
		$service->confirm(1, 2);
	}

	/**
	 * @expectedException1 Bluebanner\Core\Purchase\PurchaseOnlyConfirmedByOwnerException
	 */
	public function testConfirmNotOwned()
	{
		$model = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchaseRequest');
		$model->shouldReceive('hasGetMutator');
		$model->shouldReceive('find')->with(1)->once()->andReturn($model);
		$model->shouldReceive('getStatus')->andReturn('pending');
		$model->shouldReceive('getAgent')->andReturn(2);
		$model->shouldReceive('update');
		$service = new Bluebanner\Core\Purchase\RequestService($model);
		$service->confirm(1, 3);
	}
}