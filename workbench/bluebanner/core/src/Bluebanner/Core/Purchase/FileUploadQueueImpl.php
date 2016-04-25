<?php namespace Bluebanner\Core\Purchase;

use Bluebanner\Core\Abstracts\FileUploadQueueAbstract;
use Bluebanner\Core\Model\QueueError;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\PurchaseRequestDetail;

class FileUploadQueueImpl extends FileUploadQueueAbstract
{

  public function validate()
  {
    if ( ! file_exists($this->getUploadFilePath()))
      throw new \Exception('file can not found in path:' . $this->getUploadFilePath());

    if ( ! in_array(\File::extension($this->getUploadFilePath()), array('xlsx', 'xls')))
      throw new \Exception('only support xlsx, xls');

    return true;
  }

  public function handler()
  {
    if ( ! $this->validate())
      throw new \Exception('file can not pass validation.');

    $data = \Excel::excel2Array($this->getUploadFilePath());

    $params = json_decode($this->getParams());

    $rows = array_splice($data[0], 1);

    $queue = \Bluebanner\Core\Model\Queue::find($this->qid);

    $queue->update(array('total' => count($rows), 'pending' => count($rows)));

    if (is_array($rows)) {
      // 准备验证数据
      $skus = Item::lists('sku', 'id');
      $platforms = Platform::lists('name', 'id');
      foreach ($rows as $num => $row) {
        // 开始处理
        $queue->decrement('pending');

        list($sku, $qty, $platform, $eta) = $row[0];
        if ('' == $sku || false == ($item_id = array_search($sku, $skus))) {
          QueueError::create(array(
            'queue_id' => $queue->id,
            'line' => $num + 1,
            'content' => implode("|", $row[0]),
            'desc' => 'invalid SKU',
          ));
          $queue->increment('reject');
          continue;
        }
        if ('' == $platform || false == ($platform_id = array_search($platform, $platforms))) {
          QueueError::create(array(
            'queue_id' => $queue->id,
            'line' => $num + 1,
            'content' => implode("|", $row[0]),
            'desc' => 'invalid Platform',
          ));
          $queue->increment('reject');
          continue;
        }

        PurchaseRequestDetail::create(array(
          'request_id' => $params->id,
          'item_id' => $item_id,
          'platform_id' => $platform_id,
          'qty' => $qty,
          'end_date' => $eta,
          'transportation' => 'sea',
        ));

        $queue->increment('approved');
      }
    }

  }
}