<?php namespace Bluebanner\Core\Order;

use Bluebanner\Core\Abstracts\FileUploadQueueAbstract;
use Bluebanner\Core\Model\QueueError;

class FileUploadQueueImpl extends FileUploadQueueAbstract
{

  public function validate()
  {
    if ( ! file_exists($this->getUploadFilePath()))
      throw new \Exception('file can not found in path:' . $this->getUploadFilePath());

    if ( ! in_array(\File::extension($this->getUploadFilePath()), array('xlsx', 'xls', 'txt', 'csv')))
      throw new \Exception('only support xlsx, xls, txt, csv');

    return true;
  }

  public function handler()
  {
    if ( ! $this->validate())
      throw new \Exception('file can not pass validation.');

    $params = json_decode($this->getParams());
    $service = new ImportService($params->platform,$params->channel,$this->getUploadFilePath());
    $service->run();
    $report = $service->report;

    $queue = \Bluebanner\Core\Model\Queue::find($this->qid);
    $queue->update(array('total' => count($report), 'pending' => count($report)));

    if (is_array($report)) {
      foreach ($report as $num => $row) {
        // 开始处理
        $queue->decrement('pending');

        if (!$row['status']) {
          QueueError::create(array(
            'queue_id' => $queue->id,
            'line' => $num + 1,
            'action' => $row['action'],
            'third_party_order_id' => $row['third_party_order_id'],
          ));
          $queue->increment('reject');
          continue;
        }

        $queue->increment('approved');
      }
    }

  }
}