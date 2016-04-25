<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\ItemLanguageNameRequiredException;
use Bluebanner\Core\ItemLanguageNameDuplicatedException;
use Illuminate\Support\Facades\DB;

class ItemLanguage extends BaseModel
{
	
	protected $table = 'core_item_language';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'name' => 'required|unique:core_item_language'
	);
	
	public function validate() {
		if ( ! $name = $this->name)
			throw new ItemLanguageNameRequiredException('A name is required for an Language, none given.');

		$query = $this->newQuery();
		$persisted = $query->where('name', '=', $name)->first();
		
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new ItemLanguageNameDuplicatedException("An Language already exists with name [$name], name must be unique for languages.");

		return true;
	}
	
	
	//这里最好做个缓存
	public static function getListName()
	{
	    return DB::table('core_item_language')->lists('name','id');
	}

}
