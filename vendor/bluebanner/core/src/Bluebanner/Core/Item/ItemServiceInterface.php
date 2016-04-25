<?php namespace Bluebanner\Core\Item;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ItemServiceInterface {
	
	/**
	 * check if SKU exists
	 *
	 * @param string $sku
	 * @return boolean 
	 */
	public function itemExists($sku);

	/**
	 * find item by KEY
	 * 
	 * @param int $id
	 * @return Item
	 * @throws ItemNotFoundException
	 */
	public function itemFind($id);

	/**
	 * find item by SKU
	 *
	 * @param string $sku
	 * @return Item
	 * @throws ItemNotFoundException
	 */
	public function itemFindBySKU($sku);

	/**
	 * item list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function itemList();

	/**
	 * all active item list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function itemListByActive();

	/**
	 * Get all of the items with a given category id
	 *
	 * @param int $cid
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function itemListByCategory($cid);

	/**
	 * Get all of the items with a given category id and a given keyword
	 *
	 * @param int $cid
	 * @param string $kw
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function itemListByCategoryAndKw($cid, $kw);

	/**
	 * Create a new Item
	 *
	 * @param array $array
	 * @return bool
	 */
	public function itemCreate(array $array);

	// attributes

	/**
	 * Get attributes from an item
	 *
	 * @param int $item_id
	 * @return array
	 * @throws ItemNotFoundException
	 */
	public function itemAttributeList($item_id);

	/**
	 * Set attribute
	 *
	 * @param int $item_id
	 * @param int $lang_id
	 * @param int $attr_id
	 * @param string $value
	 * @return void
	 */
	public function itemAttributeSet($item_id, $lang_id, $attr_id, $value);

	/**
	 * item status enums
	 *
	 * @return array
	 */
	public function itemStatusList();

	// images

	/**
	 * Get Images from an item
	 *
	 * @param int $item_id
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function itemImageList($item_id);

	/**
	 * Get Image By image KEY
	 *
	 * @param int $id
	 * @return ItemImage
	 * @throws ItemImageNotFoundException
	 */
	public function itemImageFind($id);

	/**
	 * Store a image for item
	 *
	 * @param int $item_id,$uid
	 * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
	 * @return 
	 */
	public function itemImageCreate($item_id, UploadedFile $file,$uid);

	/**
	 * Replace a image for item
	 *
	 * @param int $image_id
	 * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
	 * @return
	 */
	public function itemImageReplace($image_id, UploadedFile $file);

	/**
	 * Remove image for item
	 *
	 * @param int $id
	 * @return int $item_id
	 */
	public function itemImageRemove($id);

	// category

	/**
	 * Get All Categories
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function categoryList();

	/**
	 * Gen a ID=>Name pair list
	 *
	 * @return array
	 */
	public function categoryIdNamePairsList();

	/**
	 * Create category
	 *
	 * @param array $array
	 * @return 
	 */
	public function categoryCreate(array $array);

	// language

	/**
	 * Get language list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function languageList();

	/**
	 * Find language by KEY
	 *
	 * @param int $id
	 * @return ItemLanguage
	 * @throws ItemLanguageNotFoundException
	 */
	public function languageFind($id);

	/**
	 * Create language
	 *
	 * @param array $array
	 * @return 
	 */
	public function languageCreate(array $array);

	// attributes

	/**
	 * Get attribute  list
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function attributeList();

	/**
	 * Find attribute by KEY
	 *
	 * @param int $id
	 * @return ItemAttribute
	 * @throws ItemAttributeNotFoundException
	 */
	public function attributeFind($id);

	/**
	 * Create attribute
	 *
	 * @param array $array
	 * @return
	 */
	public function attributeCreate(array $array);

	/**
	 * 寻找sku的id
	 *
	 * @param $sku string
	 * @return id  array
	 */
	public function itemIDFindBySKU($sku);

}