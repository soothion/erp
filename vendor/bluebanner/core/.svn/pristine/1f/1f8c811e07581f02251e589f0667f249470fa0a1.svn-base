<?php namespace Bluebanner\Core\Interfaces;

interface FileUploadQueueInterface {

  public function setQueueId($id);

  public function getQueueId();

  public function setUploadFilePath($path);

  public function getUploadFilePath();

  public function setParams($params);

  public function getParams();

  public function validate();

  public function handler();

  public function fire($job, $data);

}