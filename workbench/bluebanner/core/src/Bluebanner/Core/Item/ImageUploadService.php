<?php
namespace Bluebanner\Core\Item;

use Bluebanner\Core\Model\ItemImageQueue;
use Bluebanner\Core\Model\ItemImageQueueError;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ItemImage;
use Bluebanner\Core\Model\Category;
use VIPSoft\Unzip\Unzip;

class FileNotFoundException extends \Exception {
}

;
class FileExtensionNotSupportedException extends \Exception {
};
class FileInvalidateException extends \Exception {
};

class ImageUploadService implements ImageUploadServiceInterface {

	protected $qid;

	protected $file;

	public function setQueueId($id) {
		$this -> qid = $id;
	}

	public function getQueueId() {
		return $this -> qid;
	}

	public function setUploadFilePath($path) {
		$this -> file = $path;
	}

	public function getUploadFilePath() {
		return $this -> file;
	}

	public function handler() {

		if (!$this -> validate())
			throw new FileInvalidateException('file can not pass validation.');

		$queue = ItemImageQueue::find($this->qid);
		$tmp_path = storage_path() . '/upload/tmp/' . $queue->agent . '/' . date('Ymdhis') . '/';
		$img_path = storage_path() . '/upload/item/images/';
		$thumb_path = storage_path() . '/upload/item/images/thumb/';

		$unzip = new Unzip();
		$res = $unzip->extract($this->getUploadFilePath(), $tmp_path);

		$queue->update(array('total' => count($res), 'pending' => count($res)));

		foreach ($res as $filename) {
			$fp = $tmp_path . $filename;
			if (\File::isFile($fp) && 'png' == strtolower(\File::extension($fp)) && ($info = $this->decodeFilename($fp))) {
				
				try {
					ItemImage::where('item_id', '=', $this->itemFindBySKU($info['sku']))->where('desc', 'like', $info['desc'])->increment('version', 1);

					$image = ItemImage::create(array(
						'item_id' => $this->itemFindBySKU($info['sku']),
						'desc' => $info['desc'],
						'version' => 0,
						'agent'	=> $queue->agent,
					));

					$dest = $this->hashcodeFilename($image) . '.' . \File::extension($fp);
					$thumb = \Image::make($fp)->resize(200, null, true)->save($thumb_path . $dest);
					\File::move($fp, $img_path . $dest);

					$image->fill(array(
						'thumb'	=> str_replace(storage_path(), '', $thumb_path) . $dest,
						'original' => str_replace(storage_path(), '', $img_path) . $dest,
					));
					
					$image->save();

					$queue->increment('approved', 1);

				} catch (\Exception $e) {
					$queue->increment('error', 1);
					$this->errorLogBuild($queue->id, $filename, $e->getMessage());
				}

			} else {
				$queue->increment('reject', 1);
			}
			
			$queue->decrement('pending', 1);

		}

		\File::deleteDirectory($tmp_path);

	}

	public function validate() {
		// check if exists
		if (!file_exists($this -> getUploadFilePath()))
			throw new FileNotFoundException('file can not found in path:' . $this -> getUploadFilePath());

		// check extension
		if (!in_array(\File::extension($this -> getUploadFilePath()), array('zip')))
			throw new FileExtensionNotSupportedException('only support zip');

		return true;

	}

	private function errorLogBuild($qid, $row, $desc) {
		ItemImageQueueError::create(array('queue_id' => $qid, 'content' => $row, 'desc' => $desc));
	}

	private function categoryId($name) {
		$categories = Category::all();
		foreach ($categories as $category) {
			if ($name == $category -> name)
				return $category -> id;
		}
	}

	public function itemFindBySKU($sku) {
		if ($item = Item::where('sku', '=', $sku) -> first()) {
			return intval($item -> id);
		}

	}

	private function decodeFilename($filepath)
	{
		$pathes = explode('/', $filepath);
		$filename = array_splice($pathes, -1);

		if (3 > count($info = explode('.', $filename[0])))
			return false;

		list($item, $desc, ) = array_splice($info, -3);

		if (strlen($desc) != 4)
			return false;

		if ( ! preg_match('/^[\d]+\-[\d]+\-[\d]+$/is', $item))
			return false;

		return array(
			'sku'	=>	$item,
			'desc'	=>	$desc,
		);
	}

	private function hashcodeFilename(ItemImage $image)
	{
		return md5($image->item->sku . $image->desc . date('Ymdhis'));
	}

}
