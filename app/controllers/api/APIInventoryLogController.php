<?php

use Bluebanner\Core\Model\InventoryMaster;
use Bluebanner\Core\Model\InventoryChange;
use Bluebanner\Core\Model\InventoryDailyLog;
use Bluebanner\Core\Model\InventoryAllocate;
use Bluebanner\Core\Model\InventoryBook;

use \Form\Inventory\LogForm as InventoryLogForm;

class APIInventoryLogController extends \BaseController {
  public function __construct(InventoryMaster $modelInventory, InventoryChange $modelInventoryChange, InventoryDailyLog $modelInventoryDailyLog, InventoryAllocate $modelInventoryAllocate, InventoryBook $modelInventoryBook, InventoryLogForm $formInventoryLog) {
    $this->modelInventory = $modelInventory;
    $this->modelInventoryChange = $modelInventoryChange;
    $this->modelInventoryDailyLog = $modelInventoryDailyLog;
    $this->modelInventoryAllocate = $modelInventoryAllocate;
    $this->modelInventoryBook = $modelInventoryBook;

    $this->formInventoryLog = $formInventoryLog;
  }

  private function logs($filterFun, $tarModel, $tarFun) {
    $pg = Input::get('pg', 1);
    $size = Input::get('size');
    $getData = Input::get();

    $size = ($size < 10 || $size > 50) ? 21 : $size + 1;
    $formData = $this->formInventoryLog->$filterFun($getData);
    $logs = $this->$tarModel->$tarFun($formData, $pg, $size);

    return $logs;
  }

  private function log() {

  }

  public function nowday() {
    return $this->logs('filterNowdayListOpts', 'modelInventory', 'getLogsByOpts');
  }

  public function changes() {
    return $this->logs('filterChangesListOpts', 'modelInventoryChange', 'getLogsByOpts');
  }

  public function dailies() {
    return $this->logs('filterDailiesListOpts', 'modelInventoryDailyLog', 'getLogsByOpts');
  }

  public function books() {
    return $this->logs('filterBooksListOpts', 'modelInventoryBook', 'getLogsByOpts');
  }

  public function allocations() {
    return $this->logs('filterAllocationsListOpts', 'modelInventoryAllocate', 'getLogsByOpts');
  }
}