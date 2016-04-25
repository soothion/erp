<?php

use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\InventoryMaster;
use Bluebanner\Core\Model\InventoryChange;

use \Form\Stock\IOForm as StockIOForm;

class APIStockController extends \BaseController {
  public function __construct(StockIOMaster $modelStockIOMaster, StockIODetail $modelStockIODetail, InventoryMaster $modelInventoryMaster, InventoryChange $modelInventoryChange, StockIOForm $formStockIO) {
    $this->modelStockIOMaster = $modelStockIOMaster;
    $this->modelStockIODetail = $modelStockIODetail;
    $this->modelInventoryChange = $modelInventoryChange;
    $this->modelInventoryMaster = $modelInventoryMaster;

    $this->formStockIO = $formStockIO;
  }

  public function store($id) {
    $io = $this->modelStockIOMaster->where('id', (int)$id)->where('status', 0)->first();

    if ($io) {
      $io->relation;
      foreach ($io->details as $detail) {
        $detail->relation;
        $detail->item;
        $detail->item->category;
        $detail->qty_inventory = (int)$this->modelInventoryMaster->where('po_id', $io->relation->po_id)->where('item_id', $detail->item_id)->where('warehouse_id', $io->warehouse_id)->where('platform_id', $detail->relation->platform_id)->sum('qty');
      }

      $formData = $this->formStockIO->filterStockToInventory($io->toArray());

      $this->modelInventoryMaster->makeStockToInventory($formData);
    }
  }

  public function split($id) {
    
  }
}