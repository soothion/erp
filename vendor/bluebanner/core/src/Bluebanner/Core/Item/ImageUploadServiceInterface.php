<?php namespace Bluebanner\Core\Item;

interface ImageUploadServiceInterface {

	public function setQueueId($id);

	public function getQueueId();

	public function setUploadFilePath($path);

	public function getUploadFilePath();

	public function handler();

}