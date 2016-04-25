<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\CategoryNameRequiredException;
use Bluebanner\Core\CategoryNameDuplicatedException;

class Category extends BaseModel
{
	
	protected $table = 'core_item_category';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'name' => 'required|unique:core_item_category'
	);
	
	public function validate() {
		if ( ! $name = $this->name)
			throw new CategoryNameRequiredException('A name is required for an Category, none given.');

		$query = $this->newQuery();
		$persisted = $query->where('name', '=', $name)->first();
		
		if ($persisted && $persisted->getKey() != $this->getKey())
			throw new CategoryNameDuplicatedException("A Category already exists with name [$name], name must be unique for categories.");

		return true;
	}

}
