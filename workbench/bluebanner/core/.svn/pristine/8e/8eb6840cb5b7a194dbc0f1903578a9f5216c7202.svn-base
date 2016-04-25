<?php namespace Bluebanner\Core\Item\Queue;

use Bluebanner\Core\Item\UploadServiceInterface;

/**
* 产品上传
*/
class UploadItem
{
	/**
	 * @param $job
	 * @param UploadServiceInterface $service
	 */
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