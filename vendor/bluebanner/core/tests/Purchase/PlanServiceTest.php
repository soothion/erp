<?php
/**
 * Short description for PlanServiceTest.php
 * Created on 2014-04-11
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage PlanServiceTest
 * @package PlanServiceTest
 * @category
 * @version
 */

use Mockery as m;

class PlanServiceTest extends GlobalTestCase {
  public $service;

  public $dir = __DIR__;
  public $class = __CLASS__;

  public function tearDown() {
    m::close();
  }

  public function setUp() {
    parent::setUp();

    $this->setRepos('Plan');
    $this->setRepos('Request');

    $this->getDepInj();
    $this->initServiceByRepo();

  }

  public function testStartNewPlan() {
    $args = array('agent' => 1);

    $this->repoRequest->shouldReceive('pendingToPlan')->once()->andReturn(array($this->getPurchaseRequest(), $this->modelPurchaseRequest));
    $agent = $this->repoPlan->shouldReceive('createPlan')->once()->andReturn($this->getPurchasePlan());
    $this->repoPlan->shouldReceive('cloneFromRequestDetail')->twice();
    $this->modelPurchaseRequest->shouldReceive('getAttribute')->twice();

    $plan = $this->service->startNewPlan($args['agent']);

    $this->assertEquals($plan, $this->modelPurchasePlan);
  }

	/**
	 * @expectedException Bluebanner\Core\Purchase\NoRequestForPlanException
	 */
  public function testCanNotStartNewPlanWithoutRequest() {
    $args = array('agent' => 1);

    $this->repoRequest->shouldReceive('pendingToPlan')->once()->andReturn(array());

    $this->service->startNewPlan($args['agent']);
  }
}

?>