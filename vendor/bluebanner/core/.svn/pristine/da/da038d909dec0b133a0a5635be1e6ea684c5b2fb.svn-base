<?php namespace Bluebanner\Core\Item;

use Bluebanner\Core\Abstracts\FileUploadQueueAbstract;
use Bluebanner\Core\Model\QueueError;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ItemAttribute;
use Bluebanner\Core\Model\ItemInstruction;
use Bluebanner\Core\Model\ItemFeature;
use Bluebanner\Core\Model\ItemKeyword;
use Bluebanner\Core\Model\Category;

class FileUploadQueueImpl extends FileUploadQueueAbstract
{

  private static $categories;

  public function validate()
  {
    if ( ! file_exists($this->getUploadFilePath()))
      throw new \Exception('file can not found in path:' . $this->getUploadFilePath());

    if ( ! in_array(\File::extension($this->getUploadFilePath()), array('xlsx', 'xls')))
      throw new \Exception('only support xlsx, xls');

    return true;
  }

  public function handler()
  {
    if ( ! $this->validate())
      throw new \Exception('file can not pass validation.');

    $params = json_decode($this->getParams());

    $queue = \Bluebanner\Core\Model\Queue::find($this->qid);

    $rows = \Excel::selectSheetsByIndex(0)->load($this->getUploadFilePath())->noHeading()->get()->toArray();

    $queue->update(array('total' => count($rows) - 3, 'pending' => count($rows) - 3));
    
    foreach ($rows as $num => $row) {
      if ($num > 2) {

        $prototype = $this->producePrototype($row + array('agent' => $queue->agent));
        $attributes = $this->produceAttributes($row);
        $instructions = $this->produceInstructions($row);
        $features = $this->produceFeatures($row);
        $keywords = $this->produceKeywords($row);

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
          QueueError::create(array(
            'queue_id' => $queue->id,
            'line' => $num + 1,
            'content' => implode("|", $row),
            'desc' => $e->getMessage(),
          ));
        }
        $queue->decrement('pending', 1);
      }
    }

  }

  private function produceAttributes($row)
  {
    return array(
      1 =>  array(
        'title' =>  $row['50'] || '',
        'detail'  =>  $row['53'] || '',
        'detail_html' =>  $row['54'] || '',
      ),
      2 =>  array(
        'title' =>  $row['55'] || '',
        'detail'  =>  $row['58'] || '',
        'detail_html' =>  $row['59'] || '',
      ),
      3 =>  array(
        'title' =>  $row['60'] || '',
        'detail'  =>  $row['63'] || '',
        'detail_html' =>  $row['64'] || '',
      ),
      4 =>  array(
        'title' =>  $row['65'] || '',
        'detail'  =>  $row['68'] || '',
        'detail_html' =>  $row['69'] || '',
      ),
      5 =>  array(
        'title' =>  $row['70'] || '',
        'detail'  =>  $row['73'] || '',
        'detail_html' =>  $row['74'] || '',
      ),
      6 =>  array(
        'title' =>  $row['75'] || '',
        'detail'  =>  $row['78'] || '',
        'detail_html' =>  $row['79'] || '',
      ),
      7 =>  array(
        'title' =>  $row['80'] || '',
        'detail'  =>  $row['83'] || '',
        'detail_html' =>  $row['84'] || '',
      ),
      8 =>  array(
        'title' =>  $row['85'] || '',
        'detail'  =>  $row['88'] || '',
        'detail_html' =>  $row['89'] || '',
      ),
    );
  }

  private function produceInstructions($row)
  {
    return array(
      1 =>  $row['38'],
      2 =>  $row['39'],
      3 =>  $row['40'],
      4 =>  $row['41'],
      5 =>  $row['42'],
      6 =>  $row['43'],
      7 =>  $row['44'],
      8 =>  $row['45'],
    );
  }

  private function produceKeywords($row)
  {
    return array(
      1 =>  explode(';', str_replace('；', ';', $row['51'])),
      2 =>  explode(';', str_replace('；', ';', $row['56'])),
      3 =>  explode(';', str_replace('；', ';', $row['61'])),
      4 =>  explode(';', str_replace('；', ';', $row['66'])),
      5 =>  explode(';', str_replace('；', ';', $row['71'])),
      6 =>  explode(';', str_replace('；', ';', $row['76'])),
      7 =>  explode(';', str_replace('；', ';', $row['81'])),
      8 =>  explode(';', str_replace('；', ';', $row['86'])),
    );
  }

  private function produceFeatures($row)
  {
    return array(
      1 =>  explode(';', str_replace('；', ';', $row['52'])),
      2 =>  explode(';', str_replace('；', ';', $row['57'])),
      3 =>  explode(';', str_replace('；', ';', $row['62'])),
      4 =>  explode(';', str_replace('；', ';', $row['67'])),
      5 =>  explode(';', str_replace('；', ';', $row['72'])),
      6 =>  explode(';', str_replace('；', ';', $row['77'])),
      7 =>  explode(';', str_replace('；', ';', $row['82'])),
      8 =>  explode(';', str_replace('；', ';', $row['87'])),
    );
  }

  private function producePrototype($row)
  {
    return array(
      'sku' => $row[1],
      'agent' => $row['agent'],
      'description' =>  $row[2] || '',
      'category_id' =>  $this->categoryId($row[3]),
      'status'  =>  $row[4],
      'is_active' =>  $row[6] || true,
      'is_drop' =>  $row[5] || false,
      'is_virtual'  =>  $row[7] || false,
      'is_hold_inv' =>  $row[8] || true,
      'product_length'  =>  $row[9] || 0,
      'product_width' =>  $row[10] || 0,
      'product_height'  =>  $row[11] || 0,
      'product_weight'  =>  $row[12] || 0,

      'packing_length'  =>  $row[13] || 0,
      'packing_width' =>  $row[14] || 0,
      'packing_height'  =>  $row[15] || 0,
      'packing_weight'  =>  $row[16] || 0,

      'packing_quantity'  =>  $row[17] || 0,
      'pallet_quantity' =>  $row[18] || 0,

      'carton_length' =>  $row[19] || 0,
      'carton_width'  =>  $row[20] || 0,
      'carton_height' =>  $row[21] || 0,
      'carton_weight' =>  $row[22] || 0,

      'hs_model'  =>  $row[25] || '',
      'hs_desc_cn'  =>  $row[24] || '',
      'hs_desc_en'  =>  $row[28] || '',
      'hs_code_cn'  =>  $row[27] || '',
      'hs_code_us'  =>  $row[29] || '',
      'hs_code_eu'  =>  $row[30] || '',
      'hs_drawback_cn'  =>  $row[26] || '',
      'hs_tariff_us'  =>  $row[31] || '',
      'hs_tariff_eu'  =>  $row[32] || '',
      'hs_tariff_uk'  =>  $row[33] || '',
      'hs_tariff_jp'  =>  $row[34] || '',


      'brand' =>  $row[35] || '',
      'packing_color_box' =>  $row[36] || false,
      'instructions'  =>  $row[37],

      'silk_screen' =>  $row[46] || false,
      'certification' =>  $row[47],
      'warranty_card' =>  $row[48] || false,
      'remark'  =>  $row[49],


    );
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