<?php
/**
 * Created by VIM
 * Created at 2014-10-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package API
 * @copyright 2014 
 */

use Bluebanner\Core\Repo\Inventory as RepoInventory;

use Bluebanner\Core\Form\Inventory\Inventory as FormInventory;

class APIInventoryController extends \BaseController {
  private $_logs = array();
  private $_args = array();
  private $_page = 1;
  private $_size = 21;
  private $_instance = null;

  public function __construct(RepoInventory $repoInventory, FormInventory $formInventory) {
    $this->repoInventory = $repoInventory;

    $this->formInventory = $formInventory;
  }

  public function nowday() {
    return $this->logs()->filterBy('nowday')->fetchBy('nowday')->get();
  }

  public function allocations() {
    return $this->logs()->filterBy('allocations')->fetchFrom('allocation')->getInstance()->findByConds($this->_args, $this->_page, $this->_size)->get();
  }

  public function books() {
    return $this->logs()->filterBy('books')->fetchFrom('book')->getInstance()->findByConds($this->_args, $this->_page, $this->_size)->get();
  }

  public function changes() {
    return $this->logs()->filterBy('changes')->fetchFrom('change')->getInstance()->findByConds($this->_args, $this->_page, $this->_size)->get();
  }

  private function filterBy($invoker) {
    $this->_instance = $this->formInventory;
    $invoker = 'filter' . ucfirst($invoker);
    $this->_args = $this->_instance->$invoker($this->_args);
    return $this;
  }
  
  private function fetchFrom($type) { 
    $this->_instance = $this->repoInventory->$type();
    return $this;
  }
  
  private function fetchBy($invoker) {
    $this->_instance = $this->repoInventory;
    $invoker = 'get' . ucfirst($invoker) . 'Logs';
    $this->_logs = $this->_args = $this->_instance->$invoker($this->_args, $this->_page, $this->_size);
    return $this;
  }

  private function get() {
    return $this->_logs;
  }

  private function getInstance() {
    return $this->_instance;
  }

  private function logs() {
    $this->_args = Input::get();
    $this->_page = $this->formInventory->page($this->_args);
    $this->_size = $this->formInventory->size($this->_args) + 1;
    $this->_instance = $this;
    return $this;
  }
}
