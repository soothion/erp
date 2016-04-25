<?php namespace Bluebanner\Core\Item;

use Bluebanner\Core\Model\ItemQueue;
use Bluebanner\Core\Model\ItemQueueError;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ItemAttribute;
use Bluebanner\Core\Model\ItemInstruction;
use Bluebanner\Core\Model\ItemFeature;
use Bluebanner\Core\Model\ItemKeyword;
use Bluebanner\Core\Model\Category;

class FileNotFoundException extends \Exception {};
class FileExtensionNotSupportedException extends \Exception {};
class FileInvalidateException extends \Exception {};

class UploadService implements UploadServiceInterface
{

	protected $qid;

	protected $file;

	private static $categories;

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

	public function handler()
	{
		
		if( ! $this->validate())
			throw new FileInvalidateException('file can not pass validation.');

		$data = \Excel::excel2Array($this->getUploadFilePath());

		$rows = array_splice($data[0], 3);

		$queue = ItemQueue::find($this->qid);

		$queue->update(array('total' => count($rows), 'pending' => count($rows)));

		if (is_array($rows)) {
			foreach ($rows as $k => $row) {
				$prototype = $this->producePrototype($row[0] + array('agent' => $queue->agent));
				$attributes = $this->produceAttributes($row[0]);
				$instructions = $this->produceInstructions($row[0]);
				$features = $this->produceFeatures($row[0]);
				$keywords = $this->produceKeywords($row[0]);

				$item = Item::firstOrNew(array('sku' => $prototype['sku']));

				try {
					$item->fill($prototype);
					$item->save();

					// attributes
					foreach ($attributes as $lang_id => $attribute) {
						$instance = ItemAttribute::firstOrNew(array('item_id' => $item->id, 'lang_id' => $lang_id));
						$instance->fill($attribute + array('agent' => $queue->agent));
						$instance->save();
					}

					// instruction
					foreach ($instructions as $lang_id => $instruction) {
						$instance = ItemInstruction::firstOrNew(array('item_id' => $item->id, 'lang_id' => $lang_id));
						$instance->fill(array('agent' => $queue->agent));
						if ($instruction) {
							$instance->save();
						} else {
							$instance->delete();
						}
						
					}

					// features
					foreach ($features as $lang_id => $feature) {
						ItemFeature::where('item_id', '=', $item->id)->where('lang_id', '=', $lang_id)->forceDelete();
						foreach ($feature as $value) {
							$instance = ItemFeature::create(array('item_id' => $item->id, 'lang_id' => $lang_id, 'feature' => $value) + array('agent' => $queue->agent));
						}
					}

					// keywords
					foreach ($keywords as $lang_id => $keyword) {
						ItemKeyword::where('item_id', '=', $item->id)->where('lang_id', '=', $lang_id)->forceDelete();
						foreach ($keyword as $value) {
							$instance = ItemKeyword::create(array('item_id' => $item->id, 'lang_id' => $lang_id, 'keyword' => $value) + array('agent' => $queue->agent));
						}
					}


					$queue->increment('approved', 1);
				} catch (\Exception $e) {
					$queue->increment('error', 1);
					$this->errorLogBuild($queue->id, $row[0], $e->getMessage());
				}
				$queue->decrement('pending', 1);
			}
		}

	}

	public function validate()
	{
		// check if exists
		if ( ! file_exists($this->getUploadFilePath()))
			throw new FileNotFoundException('file can not found in path:' . $this->getUploadFilePath());

		// check extension
		if ( ! in_array(\File::extension($this->getUploadFilePath()), array('xlsx', 'xls')))
			throw new FileExtensionNotSupportedException('only support xlsx, xls');

		return true;

	}

	private function produceAttributes($row)
	{
		return array(
			1	=>	array(
				'title'	=>	$row['49'],
				'detail'	=>	$row['52'],
				'detail_html'	=>	$row['53'],
			),
			2	=>	array(
				'title'	=>	$row['54'],
				'detail'	=>	$row['57'],
				'detail_html'	=>	$row['58'],
			),
			3	=>	array(
				'title'	=>	$row['59'],
				'detail'	=>	$row['62'],
				'detail_html'	=>	$row['63'],
			),
			4	=>	array(
				'title'	=>	$row['64'],
				'detail'	=>	$row['67'],
				'detail_html'	=>	$row['68'],
			),
			5	=>	array(
				'title'	=>	$row['69'],
				'detail'	=>	$row['72'],
				'detail_html'	=>	$row['73'],
			),
			6	=>	array(
				'title'	=>	$row['74'],
				'detail'	=>	$row['77'],
				'detail_html'	=>	$row['78'],
			),
			7	=>	array(
				'title'	=>	$row['79'],
				'detail'	=>	$row['82'],
				'detail_html'	=>	$row['83'],
			),
			8	=>	array(
				'title'	=>	$row['84'],
				'detail'	=>	$row['87'],
				'detail_html'	=>	$row['88'],
			),
		);
	}

	private function produceInstructions($row)
	{
		return array(
			1	=>	$row['37'],
			2	=>	$row['38'],
			3	=>	$row['39'],
			4	=>	$row['40'],
			5	=>	$row['41'],
			6	=>	$row['42'],
			7	=>	$row['43'],
			8	=>	$row['44'],
		);
	}

	private function produceKeywords($row)
	{
		return array(
			1	=>	explode(';', str_replace('；', ';', $row['50'])),
			2	=>	explode(';', str_replace('；', ';', $row['55'])),
			3	=>	explode(';', str_replace('；', ';', $row['60'])),
			4	=>	explode(';', str_replace('；', ';', $row['65'])),
			5	=>	explode(';', str_replace('；', ';', $row['70'])),
			6	=>	explode(';', str_replace('；', ';', $row['75'])),
			7	=>	explode(';', str_replace('；', ';', $row['80'])),
			8	=>	explode(';', str_replace('；', ';', $row['85'])),
		);
	}

	private function produceFeatures($row)
	{
		return array(
			1	=>	explode(';', str_replace('；', ';', $row['51'])),
			2	=>	explode(';', str_replace('；', ';', $row['56'])),
			3	=>	explode(';', str_replace('；', ';', $row['61'])),
			4	=>	explode(';', str_replace('；', ';', $row['66'])),
			5	=>	explode(';', str_replace('；', ';', $row['71'])),
			6	=>	explode(';', str_replace('；', ';', $row['76'])),
			7	=>	explode(';', str_replace('；', ';', $row['81'])),
			8	=>	explode(';', str_replace('；', ';', $row['86'])),
		);
	}

	private function producePrototype($row)
	{
		return array(
			'sku' => $row[0],
			'agent' => $row['agent'],
			'description' =>	$row[1],
			'category_id'	=> 	$this->categoryId($row[2]),
			'status'	=>	$row[3],
			'is_active'	=>	$row[5],
			'is_drop'	=>	$row[4],
			'is_virtual'	=>	$row[6],
			'is_hold_inv'	=>	$row[7],
			'product_length'	=>	$row[8],
			'product_width'	=>	$row[9],
			'product_height'	=>	$row[10],
			'product_weight'	=>	$row[11],

			'packing_length'	=>	$row[12],
			'packing_width'	=>	$row[13],
			'packing_height'	=>	$row[14],
			'packing_weight'	=>	$row[15],

			'packing_quantity'	=>	$row[16],
			'pallet_quantity'	=>	$row[17],

			'carton_length'	=>	$row[18],
			'carton_width'	=>	$row[19],
			'carton_height'	=>	$row[20],
			'carton_weight'	=>	$row[21],

			'hs_model'	=>	$row[24],
			'hs_desc_cn'	=>	$row[23],
			'hs_desc_en'	=>	$row[27],
			'hs_code_cn'	=>	$row[26],
			'hs_code_us'	=>	$row[28],
			'hs_code_eu'	=>	$row[29],
			'hs_drawback_cn'	=>	$row[25],
			'hs_tariff_us'	=>	$row[30],
			'hs_tariff_eu'	=>	$row[31],
			'hs_tariff_uk'	=>	$row[32],
			'hs_tariff_jp'	=>	$row[33],


			'brand'	=>	$row[34],
			'packing_color_box'	=>	$row[35],
			'instructions'	=>	$row[36],

			'silk_screen'	=>	$row[45],
			'certification'	=>	$row[46],
			'warranty_card'	=>	$row[47],
			'remark'	=>	$row[48],


		);
	}

	private function errorLogBuild($qid, $row, $desc)
	{
		ItemQueueError::create(array('queue_id' => $qid, 'content' => implode(';', $row), 'desc' => $desc));
	}

	private function categoryId($name)
	{
		if ( ! static::$categories)
			static::$categories = Category::all();

		foreach (static::$categories as $category) {
			if ($name == $category->name)
				return $category->id;
		}
	}
	

}