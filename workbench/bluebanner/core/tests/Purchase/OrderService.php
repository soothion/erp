<?php
/**
 * Short description for OrderService.php
 * Created on 2014-04-10
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage OrderService
 * @package OrderService
 * @category
 * @version
 */

<?php

use Mockery as m;

class OrderServiceTest extends TestCase {
  
  public $modelPurchasePlan;
  public $modelPurchaseOrder;
  public $modelPurchasePlanDetail;
  public $modelPurchaseRequestDetail;
  public $sysDB;
  
  public $service = null;
  
  public function tearDown() {
    m::close();
  }
  
  public function setUp() {
    parent::setUp();
    $this->getDepInj();
  }

  public function getPurchasePlan() {
    $this->modelPurchasePlan = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchasePlan');
    $this->modelPurchasePlan->shouldReceive('hasGetMutator');
    return $this->modelPurchasePlan;
  }
  
  public function getPurchaseOrder() {
    $this->modelPurchaseOrder = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchaseOrder');
    $this->modelPurchaseOrder->shouldReceive('hasGetMutator');
    return $this->modelPurchaseOrder;
  }
  
  public function getPurchasePlanDetail() {
    $this->modelPurchasePlanDetail = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchasePlanDetail');
    $this->modelPurchasePlanDetail->shouldReceive('hasGetMutator');
    return $this->modelPurchasePlanDetail;
  }
  
  public function getPurchaseRequestDetail() {
    $this->modelPurchaseRequestDetail = m::mock('Eloquent', 'Bluebanner\Core\Model\PurchaseRequestDetail');
    $this->modelPurchaseRequestDetail->shouldReceive('hasGetMutator');
    return $this->modelPurchaseRequestDetail;
  }

  public function getSysDB() {
    $this->sysDB = m::mock('Eloquent', 'Illuminate\Support\Facades\DB');
    $this->sysDB->shouldReceive('hasGetMutator');
    return $this->sysDB;
  }

  public function getDepInj() {
    $this->getPurchasePlan();
    $this->getPurchaseOrder();
    $this->getPurchasePlanDetail();
    $this->getPurchaseRequestDetail();
    
  }

  public function testGetObject() {
    $this->assertTrue(is_object($this->modelPurchasePlan));
    $this->assertTrue(is_object($this->modelPurchaseOrder));
    $this->assertTrue(is_object($this->modelPurchasePlanDetail));
    $this->assertTrue(is_object($this->modelPurchaseRequestDetail));
  }
  
  // @todo PurchaseRequestDetail  
  public function initService() {
    if (!$this->service) {
      unset($this->service);
    }
    //$this->service = new Bluebanner\Core\Purchase\OrderService($this->modelPurchasePlan, $this->modelPurchaseOrder, $this->modelPurchasePlanDetail, $this->modelPurchaseRequestDetail);

    $this->service = new Bluebanner\Core\Purchase\OrderService($this->modelPurchasePlan, $this->modelPurchaseOrder, $this->modelPurchasePlanDetail);
  }
  
  public function testOrderList() {
    $this->modelPurchaseOrder->shouldReceive('where')->once();

    $this->initService();
    
    $this->service->orderList();
  }
}
?>