<?php namespace Bluebanner\Core\Item;

use Bluebanner\Core\Abstracts\FileUploadQueueAbstract;
use Bluebanner\Core\Model\QueueError;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ItemImage;
use VIPSoft\Unzip\Unzip;


class ImageUploadQueueImpl extends FileUploadQueueAbstract
{

  private static $categories;

  public function validate()
  {
    if ( ! file_exists($this->getUploadFilePath()))
      throw new \Exception('file can not found in path:' . $this->getUploadFilePath());

    if ( ! in_array(\File::extension($this->getUploadFilePath()), array('zip')))
      throw new \Exception('only support zip');

    return true;
  }

  public function handler()
  {
    if ( ! $this->validate())
      throw new \Exception('file can not pass validation.');

    $params = json_decode($this->getParams());

    $queue = \Bluebanner\Core\Model\Queue::find($this->qid);
    $tmp_path = storage_path() . '/upload/tmp/' . $queue->agent . '/' . date('Ymdhis') . '/';
    $img_path = storage_path() . '/upload/item/images/';
    $thumb_path = storage_path() . '/upload/item/images/thumb/';

    $unzip = new Unzip();
    $res = $unzip->extract($this->getUploadFilePath(), $tmp_path);

    $queue->update(array('total' => count($res), 'pending' => count($res)));

    foreach ($res as $filename) {
      $fp = $tmp_path . $filename;

      if (\File::isFile($fp) && 'jpg' == strtolower(\File::extension($fp)) && ($info = $this->decodeFilename($fp))) {
        if ($item = $this->itemFindBySKU($info['sku'])) {
          try {
            
            ItemImage::where('item_id', $item->id)
              ->where('desc', $info['desc'])
              ->increment('version', 1);

            $image = ItemImage::create(array(
              'item_id' => $item->id,
              'desc' => $info['desc'],
              'version' => 0,
              'agent' => $queue->agent,
            ));

            $dest = $this->hashcodeFilename($image) . '.' . strtolower(\File::extension($fp));
            $thumb = \Image::make($fp)->resize(200, null, function ($constraint) {
              $constraint->aspectRatio();
            })->save($thumb_path . $dest);
            \File::move($fp, $img_path . $dest);

            $image->fill(array(
              'thumb' => str_replace(storage_path(), '', $thumb_path) . $dest,
              'original' => str_replace(storage_path(), '', $img_path) . $dest,
            ));

            $image->save();
            $queue->increment('approved', 1);

          } catch (\Exception $e) {
            $queue->increment('error', 1);
            QueueError::create(array(
              'queue_id' => $queue->id,
              'line' => 0,
              'content' => $filename,
              'desc' => $e->getMessage(),
            ));
          }
        } else {
          $queue->increment('reject', 1);
          QueueError::create(array(
            'queue_id' => $queue->id,
            'line' => 0,
            'content' => $filename,
            'desc' => 'SKU can not found.',
          ));
        }
      } else {
        $queue->increment('reject', 1);
        QueueError::create(array(
          'queue_id' => $queue->id,
          'line' => 0,
          'content' => $filename,
          'desc' => 'file can not found or file name not match the reg "sku.desc.jpg".',
        ));
      }
      $queue->decrement('pending', 1);
    }

    // 删除临时目录
    \File::deleteDirectory($tmp_path);

  }

  private function itemFindBySKU($sku) {
    if ($item = Item::where('sku', $sku)->first()) {
      return $item;
    }
  }

  private function decodeFilename($filepath)
  {
    $pathes = explode('/', $filepath);
    $filename = array_splice($pathes, -1);

    if (3 > count($info = explode('.', $filename[0])))
      return false;

    list($item, $desc, ) = array_splice($info, -3);

    // if (strlen($desc) != 4)
    //   return false;

    if ( ! preg_match('/^[\d]+\-[\d]+\-[\d]+$/is', $item))
      return false;

    return array(
      'sku' =>  $item,
      'desc'  =>  $desc,
    );
  }

  private function hashcodeFilename(ItemImage $image)
  {
    return md5($image->item->sku . $image->desc . date('Ymdhis'));
  }
}