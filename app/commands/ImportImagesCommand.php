<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ItemImage;
use VIPSoft\Unzip\Unzip;

class ImportImagesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'images:upload';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '批量上传大图片包，图片包通过FTP等事先传到服务器';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$path = $this->argument('path');
		$tmp_path = storage_path() . '/upload/tmp/' . 0 . '/' . date('Ymdhis') . '/';
		$img_path = storage_path() . '/upload/item/images/';
		$thumb_path = storage_path() . '/upload/item/images/thumb/';

		$unzip = new Unzip();
    $res = $unzip->extract($path, $tmp_path);

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
              'agent' => 1,
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

          } catch (\Exception $e) {

          }
        }
      }
    }

    // 删除临时目录
    \File::deleteDirectory($tmp_path);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('path', InputArgument::REQUIRED, '需要上传的图片包的服务器绝对路径.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
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
