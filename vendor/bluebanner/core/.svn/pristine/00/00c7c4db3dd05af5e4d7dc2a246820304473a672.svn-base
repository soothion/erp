<?php namespace Bluebanner\Core\Abstracts;

use Bluebanner\Core\Interfaces\FileUploadQueueInterface;

abstract class FileUploadQueueAbstract implements FileUploadQueueInterface
{
  
  protected $qid;

  protected $file;

  protected $params;

  public function setQueueId($id)
  {
    $this->qid = $id;
  }

  public function getQueueId()
  {
    return $this->qid;
  }
  
  public function setUploadFilePath($path)
  {
    $this->file = $path;
  }

  public function getUploadFilePath()
  {
    return $this->file;
  }

  public function setParams($params)
  {
    $this->params = $params;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function fire($job, $data)
  {
    $service = unserialize($data);
    $service->handler();
    $job->delete();
  }

  abstract public function handler();

  abstract public function validate();
  
}