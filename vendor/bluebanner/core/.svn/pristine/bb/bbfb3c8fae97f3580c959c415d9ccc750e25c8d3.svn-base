<?php

/**
 * Created by EMACS
 * Created at 2014-11-12
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @package misc
 * @copyright 2014
 */

namespace Bluebanner\Core\Misc\Stock\Shipment;

use Bluebanner\Core\Abstracts\FileUploadQueueAbstract;

use Bluebanner\Core\Repo\StockShipment as RepoShipment;
use Bluebanner\Core\Form\Stock\Shipment as FormShipment;

class FileUploadQueueImpl extends FileUploadQueueAbstract {
  public function __construct() {
    $this->repoShipment = new RepoShipment();

    $this->formShipment = new FormShipment();
  }

  public function validate() {
    if (!file_exists($this->getUploadFilePath())) {
      throw new \Exception('file can not found in path:' . $this->getUploadFilePath());
    }

    if (!in_array(\File::extension($this->getUploadFilePath()), array('xlsx', 'xls'))) {
      throw new \Exception('only support xlsx, xls');
    }

    return true;
  }

  public function handler() {
    if (!$this->validate()) {
      throw new \Exception('file can not pass validation');
    }

    $queueId = $this->qid;
    $data = \Excel::selectSheetsByIndex(0)->load($this->getUploadFilePath())->get()->toArray();
    $params = json_decode($this->getParams());
    $shipmentId = $params->shipment_id;
    $approveds = $rejects = $columns = array();
    $rows = $this->formShipment->filterDetailsFromExcel($data, $queueId, $columns, $rejects);
    
    $items = $this->repoShipment->item()->whereIn('sku', $columns['sku'])->lists('sku', 'id');
    $platforms = $this->repoShipment->platform()->whereIn('name', $columns['platform'])->lists('name', 'id');

    $this->formShipment->genDetailsFromExcel($queueId, $shipmentId, $columns, $items, $platforms, $rows, $approveds, $rejects);
    $queueMaster = array('total' => count($data),
                         'approved' => count($approveds),
                         'reject' => count($rejects));


    $this->repoShipment->importDetails($queueId, $queueMaster, $approveds, $rejects);
  }
}

