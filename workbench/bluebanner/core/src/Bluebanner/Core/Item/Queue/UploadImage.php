<?php namespace Bluebanner\Core\Item\Queue;
use Bluebanner\Core\Item\ImageUploadServiceInterface;

/**
* 批量上传图片
*/
class UploadImage
{
	 public function fire($job, $data)
	{
		$service = $this->getService($data);
		$service->handler();
		$job->delete();
	}

	/**
	 * @return UploadServiceInterface $service
	 */
	private function getService($data)
	{
		return unserialize($data);
	}
}
