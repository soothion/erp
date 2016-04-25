<?php namespace Bluebanner\Core\Model;

class ItemAttributeValue extends BaseModel
{
	
	protected $table = 'core_item_attribute_desc';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'name' => 'required|unique:core_item_attribute_desc'
	);
	
	public function validate() {
		if ( ! $iid = $this->item_id)
			throw new ItemAttributeValueItemRequiredException('A item_id is required for an Attribute Value, none given.');
			
		if ( ! $lid = $this->lang_id)
			throw new ItemAttributeValueLangRequiredException('A lang_id is required for an Attribute Value, none given.');
			
		if ( ! $aid = $this->attr_id)
			throw new ItemAttributeValueAttrRequiredException('A attr_id is required for an Attribute Value, none given.');
			
		if ( ! $item = Item::find($iid))
			throw new ItemNotFoundException("A item_id is required for an Attribute Value, the given [$iid] can not found.");
			
		if ( ! $lang = ItemLanguage::find($lid))
			throw new ItemLanguageNotFoundException("A lang_id is required for an Attribute Value, the given [$lid] can not found.");
			
		if ( ! $attribute = ItemAttribute::find($aid))
			throw new ItemAttributeNotFoundException("A item_id is required for a Attribute, the given [$iid] can not found.");

		return true;
	}

}
