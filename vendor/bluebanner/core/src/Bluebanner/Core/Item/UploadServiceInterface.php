<?php namespace Bluebanner\Core\Item;

interface UploadServiceInterface {

	public function setQueueId($id);

	public function getQueueId();

	public function setUploadFilePath($path);

	public function getUploadFilePath();

	public function handler();

}