<?php 

use Mockery as m;

class PurchasePlanServiceTest extends PHPUnit_Framework_TestCase
{
	
	function tearDown()
	{
		m::close();
	}

	public function testCanStartNewPlanSession()
	{
		$plan = $this->mockPlan();
		$request = $this->mockRequest();

		$p = m::mock('Bluebanner\Core\Model\PurchasePlan');
		$p->shouldReceive('hasGetMutator')->andReturn(false);

		$request->shouldReceive('pendingToPlan')->once()->andReturn(array($pr1 = m::mock('Bluebanner\Core\Model\PurchaseRequest'), $pr2 = m::mock('Bluebanner\Core\Model\PurchaseRequest')));
		$plan->shouldReceive('createPlan')->once()->with(1)->andReturn($p);
		$plan->shouldReceive('cloneFromRequestDetail')->twice();
		$plan->shouldReceive('hasGetMutator')->andReturn(false);

		$pr1->shouldReceive('getAttribute');
		$pr1->shouldReceive('hasGetMutator')->andReturn(false);

		$pr2->shouldReceive('getAttribute');
		$pr2->shouldReceive('hasGetMutator')->andReturn(false);


		$service = new Bluebanner\Core\Purchase\PlanService($plan, $request);
		$planed = $service->startNewPlanSession(1);

		$this->assertEquals($planed, $p);
	}

	/**
	 * @expectedException Bluebanner\Core\Purchase\NoRequestForPlanException
	 */
	public function testCanNotStartNewPlanSessionWithoutRequest()
	{
		$plan = $this->mockPlan();
		$request = $this->mockRequest();
		$request->shouldReceive('pendingToPlan')->once()->andReturn(null);


		$service = new Bluebanner\Core\Purchase\PlanService($plan, $request);
		$planed = $service->startNewPlanSession(1);
	}

	protected function mockPlan()
	{
		return m::mock('Bluebanner\Core\Repository\Purchase\PlanRepositoryInterface');
	}

	protected function mockRequest()
	{
		return m::mock('Bluebanner\Core\Repository\Purchase\RequestRepositoryInterface');
	}


}