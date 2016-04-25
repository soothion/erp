<?php

/**
 * Created by EMACS
 * Created at 2014-10-27
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package API
 * @copyright 2014
 */

use Bluebanner\Core\Repo\StockShipment as RepoStockShipment;
use Bluebanner\Core\Repo\StockIo as RepoStockIo;

use Bluebanner\Core\Form\Stock\Shipment as FormShipment;
use Bluebanner\Core\Form\Inventory\Inventory as FormInventory;

class APIStockShipmentController extends \BaseController {
  public function __construct(RepoStockShipment $repoShipment, RepoStockIo $repoStockIo, FormShipment $formShipment, FormInventory $formInventory) {
    $this->repoShipment = $repoShipment;
    $this->repoStockIo = $repoStockIo;

    $this->formShipment = $formShipment;
    $this->formInventory = $formInventory;
  }

  public function invoice() {
    return 'Shipment1234';
  }

  public function index() {
    $inputGet = Input::get();

    $inputGen = $this->formShipment->filterIndex($inputGet);
    $page = $this->formShipment->page($inputGet);
    $size = $this->formShipment->size($inputGet) + 1;

    return $this->repoShipment->master()->findByConds($inputGen, $page, $size)->get();
  }

  public function create() {
    
  }

  public function store() {
    // @notice only store master
    /* $masterGet = Input::get('master'); */
    /* $detailsGet = Input::get('details'); */

    /* $masterGen = $this->formShipment->genStoreMaster($masterGet); */
    /* $detailsGen = $this->formShipment->genStoreDetails($detailsGet); */

    /* $this->repoShipment->genShipment($masterGen, $detailsGen); */

    $masterGet = Input::get();

    $masterGen = $this->formShipment->genStoreMaster($masterGet);
    $masterGen['agent'] = Sentry::getUser()->id;
    $masterGen['status'] = 'pending';

    $this->repoShipment->master()->create($masterGen);
  }

  public function storeDetail() {
    $inputGet = Input::get();

    $inputGen = $this->formShipment->genStoreDetail($inputGet);

    $this->repoShipment->detail()->create($inputGen);
  }

  public function show($id) {
    return $this->repoShipment->master()->where('id', (int)$id)->first();
  }

  public function showDetails($id) {
    return $this->repoShipment->detail()->where('shipment_id', (int)$id)->get();
  }

  public function update($id) {
    $masterGet = Input::get('master');
    $detailsDeleteGet = Input::get('detailsDelete');
    $detailsModifyGet = Input::get('detailsModify');
    $detailsAppendGet = Input::get('detailsAppend');

    $masterGen = $this->formShipment->filterUpdateMaster($masterGet);
    $detailsDeleteGen = $this->formShipment->filterUpdateDetailsDelete($detailsDeleteGet);
    $detailsModifyGen = $this->formShipment->filterUpdateDetailsModify($detailsModifyGet);
    $detailsAppendGen = $this->formShipment->filterUpdateDetailsAppend($detailsAppendGet);

    $this->repoShipment->updateShipment($id, $masterGen, $detailsAppendGen, $detailsModifyGen, $detailsDeleteGen);
  }

  public function updateDetail($id) {
    $inputGet = Input::get();
    $inputFiltered = $this->formShipment->filterUpdateDetail($inputGet);

    $this->repoShipment->detail()->where('id', (int)$id)->where('status', 'pending')->update($inputFiltered);
  }

  public function destroy($id) {
    $this->repoShipment->deleteShipment($id);
  }

  public function destroyDetail($id) {
    $this->repoShipment->detail()->where('id', (int)$id)->where('status', 'pending')->delete();
  }

  public function confirm($id) {
    //$this->repoShipment->confirmShipment($id);
    $master = $this->repoShipment->master()->where('id', (int)$id)->where('status', 'pending')->first();
    $details = $this->repoShipment->detail()->where('shipment_id', (int)$id)->get()->toArray();

    $inventories = array();
    $inventoriesShip = array();

    if ($master && $details) {
      foreach ($details as $detailId => $detail) {
        $inventories = $this->formInventory->filterItemCanBeOpera($this->repoShipment->inventory()->where('item_id', $detail['item_id'])->where('platform_id', $detail['platform_id'])->where('warehouse_id', $master['warehouse_from_id'])->get()->toArray());

        $inventoriesShip = $this->fifoShip($inventories, $detail['qty']);

        $inventoriesGen[$detailId] = $this->formShipment->confirmShipment($inventories, $inventoriesShip, $master['warehouse_to_id']);
        $logsGen[$detailId] = $this->formShipment->genConfirmBook($inventories, $inventoriesShip, $master['warehouse_to_id'], $master['id'], $detail['id']);
      }

      $this->repoShipment->confirmShipment($id, $inventoriesGen, $logsGen);
    }
  }

  public function unconfirm($id) {
    $books = $this->repoShipment->book()->where('relation_id', (int)$id)->get();
    foreach ($books as $book) {
      $book->inventory;
    }
    $books = $books->toArray();

    $inventoriesGen = $this->formShipment->unconfirmShipment($books);
    $this->repoShipment->unconfirmShipment($id, $inventoriesGen);
  }

  public function generate($id) {
    // @notice book before generate io order
    /* $master = $this->repoShipment->master()->where('id', (int)$id)->where('status', 'confirmed')->first(); */
    /* $details = $this->repoShipment->detail()->where('shipment_id', (int)$id)->get()->toArray(); */

    /* $inventories = array(); */
    /* $inventoriesShip = array(); */

    /* if ($master && $details) { */
    /*   foreach ($details as $detailId => $detail) { */
    /*     $inventories = $this->formInventory->filterItemCanBeOpera($this->repoShipment->inventory()->where('item_id', $detail['item_id'])->where('platform_id', $detail['platform_id'])->where('warehouse_id', $master['warehouse_from_id'])->get()->toArray()); */

    /*     $inventoriesShip = $this->fifoShip($inventories, $detail['qty']); */

    /*     $inventoriesGen[$detailId] = $this->formShipment->genInventoryShip($inventories, $inventoriesShip, $master['warehouse_to_id']); */
    /*     $logsGen[$detailId] = $this->formShipment->genLogShip($inventories, $inventoriesShip, $master['warehouse_to_id'], $master['id'], $detail['id']); */
    /*     $ioDetailsGen[$detailId] = $this->formShipment->genIoDetailShip($detail); */
    /*   } */
    /*   $ioMasterGen = $this->formShipment->genIoMasterShip($master, $this->repoStockIo->genInvoice(), \Sentry::getUser()->id); */

    /*   $this->repoShipment->shipIo($id, $inventoriesGen, $logsGen, $ioMasterGen, $ioDetailsGen); */
    /* } */

    $master = $this->repoShipment->master()->where('id', (int)$id)->first();
    $details = $this->repoShipment->detail()->where('shipment_id', (int)$id)->get()->toArray();

    $ioMasterGen = $this->formShipment->genIoMasterShip($master, $this->repoStockIo->genInvoice(), \Sentry::getUser()->id);
    $ioDetailsGen = $this->formShipment->genIoDetailsShip($details);

    $this->repoShipment->genIo($id, $ioMasterGen, $ioDetailsGen);
  }

  public function sailing($id) {
    $master = $this->repoShipment->master()->where('id', $id)->where('status', 'confirmed')->first();
    $details = $this->repoShipment->detail()->where('shipment_id', $id)->get()->toArray();
    $inventories = array();
    $inventoriesShip = array();

    if ($master && $details) {
      foreach ($details as $detailId => $detail) {
        $inventories = $this->formInventory->filterItemCanBeOpera($this->repoShipment->inventory()->where('item_id', $detail['item_id'])->where('platform_id', $detail['platform_id'])->where('warehouse_id', $master['warehouse_from_id'])->get()->toArray());

        $inventoriesShip = $this->fifoShip($inventories, $detail['qty']);
        $inventoriesGen[$detailId] = $this->formShipment->genInventoryShip($inventories, $inventoriesShip, $master['warehouse_to_id']);
        $logsGen[$detailId] = $this->formShipment->genLogShip($inventories, $inventoriesShip, $master['warehouse_to_id'], $master['id'], $detail['id']);
      }

      $this->repoShipment->shipInventory($id, $inventoriesGen, $logsGen);
    }
  }

  public function reach($id) {
    $master = $this->repoShipment->master()->where('id', $id)->where('status', 'on-road')->first();
    $books = $this->repoShipment->book()->where('relation_id', $id)->get();
    foreach ($books as $book) {
      $book->inventory;
    }
    $books = $books->toArray();

    if ($master && $books) {
      $inventoriesGen = $this->formShipment->genReachInventory($books, $master['warehouse_to_id']);
      $this->repoShipment->reachWarehouse($id, $inventoriesGen);
    }
  }

  private function fifoShip($inventories, $qty) {
    $result = array();

    foreach ($inventories as $inventoryId => $inventory) {
      $requestDiff = $inventory['book_qty'] - $inventory['qty'];
      $inventoryDiff = $inventory['extra_qty'] - $requestDiff;

      if (($qty -= $inventoryDiff) > 0) {
        if ($requestDiff > 0) {
          $result[$inventoryId]['qty'] = 0;
          $result[$inventoryId]['extra_qty'] = $inventoryDiff;

        } else {
          $result[$inventoryId]['qty'] = -$requestDiff;
          $result[$inventoryId]['extra_qty'] = $inventory['extra_qty'];

        }

      } else {
        if ($requestDiff > 0) {
          $result[$inventoryId]['qty'] = 0;
          $result[$inventoryId]['extra_qty'] = $qty + $inventoryDiff;

        } else {
          if (($lastDiff = -$requestDiff - ($qty + $inventoryDiff)) > 0) {
            $result[$inventoryId]['qty'] = $qty + $inventoryDiff;
            $result[$inventoryId]['extra_qty'] = 0;

          } else {
            $result[$inventoryId]['qty'] = -$requestDiff;
            $result[$inventoryId]['extra_qty'] = -$lastDiff;

          }

        }
        break;
      }
    }

    if ($qty > 0) {
      throw new \Exception('inventory can become under-allocated');
    }

    return $result;
  }
}
