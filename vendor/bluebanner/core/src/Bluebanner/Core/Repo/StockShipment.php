<?php

/**
 * Created by EMACS
 * Created at 2014-10-27
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package Repo
 * @copyright 2014
 */


namespace Bluebanner\Core\Repo;

use Bluebanner\Core\Model\StockShipmentMaster;
use Bluebanner\Core\Model\StockShipmentDetail;
use Bluebanner\Core\Model\StockIOMaster;
use Bluebanner\Core\Model\StockIODetail;
use Bluebanner\Core\Model\InventoryMaster;
use Bluebanner\Core\Model\InventoryBook;
use Bluebanner\Core\Model\InventoryChange;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\Queue;
use Bluebanner\Core\Model\QueueError;

use Illuminate\Support\Facades\DB;

class StockShipment {
  public function master() {
    return new StockShipmentMaster();
  }

  public function detail() {
    return new StockShipmentDetail();
  }

  public function change() {
    return new InventoryChange();
  }

  public function book() {
    return new InventoryBook();
  }

  public function inventory() {
    return new InventoryMaster();
  }

  public function ioMaster() {
    return new StockIOMaster();
  }

  public function ioDetail() {
    return new StockIODetail();
  }

  public function item() {
    return new Item();
  }

  public function platform() {
    return new Platform();
  }

  public function queue() {
    return new Queue();
  }

  public function queueDetail() {
    return new QueueError();
  }

  public function genShipment($master, array $details) {
    DB::beginTransAction();

    try {
      $masterRecord = $this->master()->create($master);
      $masterId = (int)$masterRecord['id'];

      foreach ($details as $detail) {
        $detail['shipment_id'] = $masterId;
        $this->detail()->create($detail);
      }
      
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Generate shipment failed');
    }
  }

  public function updateShipment($id, $master, array $detailsAppend, array $detailsModify, array $detailsDelete) {
    DB::beginTransAction();

    try {
      $this->master()->where('id', $id)->update($master);

      foreach ($detailsAppend as $detail) {
        $detail['shipment_id'] = $id;
        $this->detail()->create($detail);
      }

      foreach ($detailsModify as $detailId => $detail) {
        $this->detail()->where('id', $detailId)->where('shipment_id', $id)->update($detail);
      }

      foreach ($detailsDelete as $detailId) {
        $this->detail()->where('id', $detailId)->where('shipment_id', $id)->delete();
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Update shipment failed');
    }
  }

  public function deleteShipment($id) {
    DB::beginTransAction();

    try {
      $this->detail()->where('shipment_id', $id)->delete();
      $this->master()->where('id', $id)->delete();

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Delete shipment failed');
    }
  }

  public function shipInventory($id, $detailsInventories, $detailsLogs) {
    DB::beginTransAction();

    try {
      foreach ($detailsInventories as $detailId => $inventories) {
        foreach ($inventories as $inventoryId => $inventory) {
          $this->inventory()->where('id', $inventoryId)->update($inventory);
        }

        foreach ($detailsLogs[$detailId] as $log) {
          $this->book()->create($log);
        }
      }

      $this->master()->where('id', $id)->update(array('status' => 'on-road'));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Inventory sailing failed');
    }
  }

  public function shipIo($idf, array $detailsInventories, $detailsLogs, $ioMaster, $ioDetails) {
    DB::beginTransAction();

    try {
      $ioMasterRecord = $this->ioMaster()->create($ioMaster);
      $ioMasterId = (int)$ioMasterRecord['id'];

      foreach ($detailsInventories as $detailId => $inventories) {
        foreach ($inventories['from'] as $inventoryId => $inventory) {
          $this->inventory()->where('id', $inventoryId)->update($inventory);
          $invRecord = $this->inventory()->create($detailsInventories[$detailId]['to'][$inventoryId]);
          $log = $detailsLogs[$detailId][$inventoryId];
          $log['inventory_id'] = (int)$invRecord['id'];
          $this->book()->create($log);
        }

        $ioDetails[$detailId]['io_id'] = $ioMasterId;
        $this->ioDetail()->create($ioDetails[$detailId]);
      }

      $this->master()->where('id', $id)->update('status', 'submitted');
      
      DB::commit();
    } catch (\Exception $e) {
      throw new \Exception('generate io failed' . $e);
    }
  }

  public function confirmShipment($id, $detailsInventories, $detailsLogs) {
    DB::beginTransAction();

    try {
      $this->master()->where('id', $id)->update(array('status' => 'confirmed'));
      $this->detail()->where('shipment_id', $id)->update(array('status' => 'confirmed'));

      foreach ($detailsInventories as $detailId => $inventories) {
        foreach ($inventories as $inventoryId => $inventory) {
          $this->inventory()->where('id', $inventoryId)->update($inventory);
          $this->book()->create($detailsLogs[$detailId][$inventoryId]);
        }
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Confirm shipment failed' . $e);
    }
  }

  public function unconfirmShipment($id, $inventories) {
    DB::beginTransAction();

    try {
      foreach ($inventories as $inventoryId => $inventory) {
        $this->inventory()->where('id', $inventoryId)->update($inventory);
      }

      $this->book()->where('relation_id', $id)->delete();
      $this->master()->where('id', $id)->update(array('status' => 'pending'));
      $this->detail()->where('shipment_id', $id)->update(array('status' => 'pending'));

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Unconfim shipment failed');
    }
  }

  public function genIo($id, $master, $details) {
    DB::beginTransAction();

    try {
      $masterRecord = $this->ioMaster()->create($master);
      $io_id = (int)$masterRecord['id'];

      foreach ($details as $detail) {
        $detail['io_id'] = $io_id;
        $this->ioDetail()->create($detail);
      }
      $this->master()->where('id', $id)->update(array('status' => 'submitted'));

      DB::commit();
    } catch (\Exception $e) {
      throw new \Exception('Generate Io failed' . $e);
    }
  }


  public function reachWarehouse($id, array $inventories) {
    DB::beginTransAction();

    try {
      foreach ($inventories['from'] as $inventoryId => $inventory) {
        $this->inventory()->where('id', $inventoryId)->update($inventory);
      }

      foreach ($inventories['to'] as $inventory) {
        $this->inventory()->create($inventory);
      }

      $this->master()->where('id', $id)->update('status', 'completely received');
      $this->book()->where('relation_id', $id)->update('status', 'done');

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Unbook inventory failed');
    }
  }

  public function importDetails($queueId, $queueMaster, $success, $failed) {
    DB::beginTransAction();

    $this->queue()->where('id', $queueId)->update($queueMaster);

    foreach ($failed as $record) {
      $this->queueDetail()->create($record);
    }

    foreach ($success as $record) {
      $this->detail()->create($record);
    }

    try {
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw new \Exception('Import failed');
    }
  }

}