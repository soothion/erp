<?php
/**
 * Short description for ServiceTest.php
 * Created on 2014-04-10
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage ServiceTest
 * @package ServiceTest
 * @category
 * @version
 */

use Mockery as m;

class RequestServiceTest extends MockeryGlobalTestCase {
    
  public $service;

  public $dir = __DIR__;
  public $class = __CLASS__;

  public function tearDown() {
    m::close();
  }

  public function setUp() {
    parent::setUp();

    $this->setModel('purchaseRequest');
    $this->setModel('purchaseRequestDetail');
    $this->setModel('warehouse');
    $this->setModel('purchaseCostParams');
    $this->setModel('vendorQuotation');

    $this->buildModels();
    $this->initService();
  }
  
  public function testConfirm() {
    $args = array('request_id' => 1, 'agent' => 2);
    
    $this->modelPurchaseRequest->shouldReceive('find')->with($args['request_id'])->once()->andReturn($this->modelPurchaseRequest);
    $this->modelPurchaseRequest->shouldReceive('getStatus')->once()->andReturn('pending');
    $this->modelPurchaseRequest->shouldReceive('getAgent')->once()->andReturn($args['agent']);
    $this->modelPurchaseRequest->shouldReceive('update')->once();

    $this->service->confirm($args['request_id'],  $args['agent']);
    // @todo No pending, it's confirmed, Test the precision of data;
    /* $this->modelPurchaseRequest->find($args['request_id']);
       $this->assertEquals($this->modelPurchaseRequest->getStatus(), 'pending'); */
    
  }

  // @todo No denpendency injection
  public function testLists() {
    /* $args = array('filter' => array('id', 'invoice'), 'fields' => array('id'), 'page_no' => 1, 'page_size' => 15); */


    /* $this->service->lists($args['filter'], $args['fields']); */

  }

    // @todo No denpendency injection
  public function testFindAllByCondition() {
    $args = array('filter' => array('invoice'));

    $this->service->findAllByCondition($args['filter']);
  }

  public function testWarehouseListWithFalse() {
    $this->modelWarehouse->shouldReceive('lists')->once()->andReturn($this->modelWarehouse);

    $result = $this->service->warehouseList(false);

    $this->assertTrue(is_object($result));
  }

  public function testWarehouseListWithTrue() {
    $this->modelWarehouse->shouldReceive('lists')->once()->andReturn($this->modelWarehouse);

    $result = $this->service->warehouseList(true);

    $this->assertTrue(is_array($result));
  }


  /**
   * @todo Exception?
   * @expectedException Exception
   */
  public function testCreateMasterHasNotAgent() {
    $args = array();

    $this->service->createMaster($args);
  }

  /**
   * @todo Exception?
   * @expectedException Exception
   */
  public function testCreateMasterHasNotType() {
    $args = array('agent' => 'agent');

    $this->service->createMaster($args);
  }

  /**
   * @todo Exception?
   * @expectedException Exception
   */
  public function testCreateMasterWithWrongType() {
    $args = array('agent' => 'agent', 'type' => 'type');

    $this->service->createMaster($args);
  }

  /**
   * @todo params can be '';
   * @todo Exception?
   * @expectedException Exception
   */
   public function testCreateMasterWithRightType() {
    $args = array('invoice' => '', 'agent' => '', 'type' => 'Order');

    $this->service->createMaster($args);
  }

   /**
    * static and exec ???
    */
   public function testGetDetails() {
     $args = 10;

     $this->modelPurchaseRequest->shouldReceive('findOrFail')->andReturn($this->modelPurchaseRequest);

     $result = $this->service->getDetails($args);
     $this->assertEquals($result->status, 'pending');
   }

  /**
   * @todo Exception?
   * @expectedException Exception
   */
   public function testApproveWithException() {
     $args = array('pr_id' => 1, 'agent' => 2, 'note' => '');

     $this->modelPurchaseRequest->shouldReceive('find')->once()->andReturn($this->modelPurchaseRequest);
     $this->modelPurchaseRequest->shouldReceive('getAttribute')->once()->andReturn(Bluebanner\Core\Model\Purchaserequest::STATUS_OF_ACCEPT);

     $this->service->approve($args['pr_id'], $args['agent'], $args['note']);
   }

   public function testReject() {
     $args = array('pr_id' => 1, 'agent' => 2, 'note' => '');

     $this->modelPurchaseRequest->shouldReceive('find')->once()->andReturn($this->modelPurchaseRequest);
     $this->modelPurchaseRequest->shouldReceive('getAttribute')->andReturn(Bluebanner\Core\Model\PurchaseRequest::STATUS_OF_CONFIRMED);
     $this->modelPurchaseRequest->shouldReceive('update')->once();

     $this->service->reject($args['pr_id'], $args['agent'], $args['note']);
   }
}

?>