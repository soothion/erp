<?php namespace Bluebanner\Core\Item;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\ItemLanguage;
use Bluebanner\Core\Model\ItemAttribute;
use Bluebanner\Core\Model\ItemAttributeValue;
use Bluebanner\Core\Model\ItemImage;
use Bluebanner\Core\Model\Category;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Bluebanner\Core\Model\ItemCustoms;

class ItemImageService implements ItemImageServiceInterface
{
	
	public function itemExists($sku)
	{
		return Item::where('sku', '=', $sku)->count() === 1;
	}
	
	public function itemFind($id)
	{
		if ( ! $item = Item::find($id))
			throw new ItemNotFoundException("Item [$id] was not found.");
		
		return $item;
	}
	// change by fordream
	// 大小写 与 interface 统一啊
	public function itemFindBySKU($sku)
	{
		if ( ! $item = Item::where('sku', '=', $sku)->first())
			throw new ItemNotFoundException("Item [$sku] was not found.");
		
		return $item;
	}
	
	public  function  findItemIdBySKULike($sku)
	{
	    return Item::where('sku','like', "%".$sku."%")->lists('id');
	}

	public function itemList()
	{
		return Item::where('id', '>', 0);
	}
	
	/**
	 * @return array( 'lang_id1' => array('a_id1' => array('label => 'a_label1', 'value' => 'a_value1'), 'a_id2' => ... ), 'lang_id2' => array(...) );
	 */
	public function itemAttributeList($id)
	{
		if ( ! $item = $this->itemFind($id))
			throw new ItemNotFoundException("Item [$id] was not found.");
			
		$languages = ItemLanguage::all();

		$attributes = array_build(ItemAttribute::where('category_id', '=', $item->category_id)->get()->toArray(), function ($key, $value) {
			return array($value['id'], array('label' => $value['name'], 'value' => null));
		});

		$matrix = array();
		
		foreach ($languages as $language) {
			// fill the values
			$values = array_build($attributes, function($key, $value) use($item, $language) {
				$desc = ItemAttributeValue::where('item_id', '=', $item->id)
					->where('lang_id', '=', $language->id)
					->where('attr_id', '=', $key)->first();
				if ($desc)
					$value['value'] = $desc->desc;
				return array($key, $value);
			});
			
			$matrix[$language->id] = $values;
		}
		return $matrix;
	}
	
	/**
	 * @param int $item_id
	 * @param int $lang_id
	 * @param int $attr_id
	 * @param string $value
	 */
	public function itemAttributeSet($item_id, $lang_id, $attr_id, $value)
	{
		if (! $attrValue = ItemAttributeValue::where('item_id', '=', $item_id)->where('lang_id', '=', $lang_id)->where('attr_id', '=', $attr_id)->first())
			$attrValue = new ItemAttributeValue(array('item_id' => $item_id, 'lang_id' => $lang_id, 'attr_id' => $attr_id));
		$attrValue->desc = $value;
		return $attrValue->save();
	}
	
	public function itemListByActive()
	{
		return Item::active();
	}
	
	public function itemListByCategory($cid)
	{
		return Item::where('category_id', '=', $cid);
	}

	public function itemListByCategoryAndKw($cid, $kw)
	{
		$query = Item::active();
		if ($cid > 0)
			$query->where('category_id', '=', $cid);

		if ($kw != '') {
			$query->where(function($q) use ($kw) {
				$q->where('sku', 'like', "%$kw%")
					->orWhere('description', 'like', "%$kw%");
			});
		}

		return $query;
	}
	
	public function itemStatusList()
	{
		return array('Coming','New Arrival','Regular','Regular-INT','On Promotion','Clearance','Will Deactivate','Inactive','Semis','耗材');
	}

	public function itemCreate(array $array)
	{
		return Item::create($array);
	}
	
	public function categoryFind($id)
	{
		if ( ! $category = Category::find($id))
			throw new CategoryNotFoundException("Item Category [$id] was not found.");
		
		return $category;
	}
	
	public function categoryList()
	{
		return Category::where('id', '>', 0);
	}
	
	public function categoryIdNamePairsList()
	{
		$pairs = array();
		foreach ($this->categoryList()->get() as $attribute) {
			$pairs[$attribute->id] = $attribute->name;
		}
		return $pairs;
	}
	
	public function categoryCreate(array $array)
	{
		return Category::create($array);
	}
	
	public function languageList()
	{
		return ItemLanguage::where('id', '>', 0);
	}
	
	public function languageFind($id)
	{
		if ( ! $lang = ItemLanguage::find($id))
			throw new ItemLanguageNotFoundException("Item Language [$id] was not found.");
		
		return $lang;
	}
	
	public function languageCreate(array $array)
	{
		return ItemLanguage::create($array);
	}
	
	public function attributeList()
	{
		return ItemAttribute::where('id', '>', 0);
	}
	
	public function attributeFind($id)
	{
		if ( ! $attribute = ItemAttribute::find($id))
			throw new ItemAttributeNotFoundException("Item Attribute [$id] was not found.");
		
		return $attribute;
	}
	
	public function attributeCreate(array $array)
	{
		return ItemAttribute::create($array);
	}

	public function itemImageList($item_id)
	{
		return ItemImage::where('item_id', '=', $item_id)->where('version', '=', 0);
	}

	public function itemImageFind($id)
	{
		if ( ! $image = ItemImage::find($id))
			throw new ItemImageNotFoundException("Item Image [$id] was not found.");

		return $image;
	}
	
	public function ItemImagesFindByItemId($item_id)
	{
	    $model=ItemImage::where("item_id",'=',intval($item_id) );
	    return $model;
	}

	public function itemImageCreate($item_id, UploadedFile $file,$uid)
	{
		$path = storage_path() . '/upload/item/images/' . $item_id . '/';
		if ( ! is_dir($path))
			mkdir($path);
		$name = $file->getClientOriginalName();
		$mime = $file->getMimeType();
		$hash = str_random(10) . '.' . $file->getClientOriginalExtension();
		$thumb = \Image::make($file->getRealPath())->resize(200, null, true)->save($path . 's-' . $hash);
		$file->move($path, $hash);
		return $image = ItemImage::create(array('item_id' => $item_id, 'desc' => $name, 'thumb' => 's-' . $hash, 'original' => $hash, 'mime' => $mime,'agent'=>$uid));
	}
	
	public function itemImageReplace($image_id, UploadedFile $file)
	{
		#todo 
	}
	
	public function itemImageReplaceByType($image_id, UploadedFile $file,$type="thumb")
	{
	    $image = ItemImage::findOrFail($image_id);
	    $path = storage_path() . '/upload/item/images/' . $image->item_id . '/';	    
	    if ( ! is_dir($path))
	        mkdir($path);	    
	    $hash = str_random(10) . '.' . $file->getClientOriginalExtension();
	    if($type=="thumb")
	    {
	        $hash = "s-".$hash;
	        unlink($path . $image->thumb);
	    }
	    else if($type=="original")
	    {
	        unlink($path . $image->thumb);
	    }
	    
	    
	    $file->move($path, $hash);
	    
	    if($type=="thumb")
	    {
	        $image->thumb=$hash;
	    }
	    else if($type=="original")
	    {
	        $image->original=$hash;
	    }
	    
	    $image->save();
	    
	    return $image->id;
	    
	}

	public function itemImageRemove($id)
	{
		$image = ItemImage::find($id);

		$path = storage_path() . '/upload/item/images/' . $image->item_id . '/';
		unlink($path . $image->thumb);
		unlink($path . $image->original);

		$image->delete();

		return $image->item_id;
	}

	/*通过模糊查询sku查找对应的产品ids*/
	public function itemIDFindBySKU($sku)
	{
		return Item::where('sku', 'like', '%'.$sku.'%')->select('id')->get();
	}
	
	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////
	/// Item customs
	///
	/////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////
	
	/**
	 * @param array $customs
	 * @return Ambigous <\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\static, \Bluebanner\Core\Model\ItemCustoms>
	 */
	public function createCustoms(array $customs)
	{
	   return ItemCustoms::create($customs);
	}
	
	public function updateCustoms($pk,array $customs)
	{
	    $model=$this->findCustomByPk($pk);
	    foreach ($customs as $attr => $value)
	    {
	        $model->$attr=$value;
	    }
	    if($model->save())
	    {
	        return $model;
	    }
	    else
	        throw new Exception("保存失败,未知异常");
	}
	
	/**
	 * @param integer $pk
	 */
	public function DeleteCustoms($pk)
	{
	    $model=$this->findCustomByPk($pk);
	    return $model->delete();
	}
	
	/**
	 * @param integer $pk
	 * @return Ambigous <\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\Collection, \Illuminate\Database\Eloquent\static, NULL>
	 */
	public function findCustomByPk($pk)
	{
	    return ItemCustoms::with('item','user')->findOrFail($pk);
	}
	
	/**
	 * @param array $conditions
	 * @return Ambigous <\Illuminate\Database\Eloquent\Builder, \Illuminate\Database\Eloquent\static, \Illuminate\Database\Eloquent\Builder>
	 */
	public function findCustomsByCondition(array $conditions)
	{
	 
	    $temp=ItemCustoms::with('item','user');
	    foreach($conditions as $condition)
	    {
	       
	        if(!isset($condition['opera'])) $condition['opera']='=';	       
	        if($condition['opera'] == "in")
	        {
	            $temp->whereIn($condition['field'],$condition['value']);
	        }
	        else
	        {
	            $temp->where($condition['field'],$condition['opera'],$condition['value']);
	        }
	    }
	    return $temp;
	}

}
