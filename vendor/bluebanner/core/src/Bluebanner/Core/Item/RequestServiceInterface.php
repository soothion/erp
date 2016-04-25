<?php namespace Bluebanner\Core\Item;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface RequestServiceInterface {
	
	public function setQueueId($id);

	public function getQueueId();

	public function setUploadFilePath($path);

	public function getUploadFilePath();

	public function handler();
	

}