<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\ItemBomParentRequiredException;
use Bluebanner\Core\ItemBomChildRequiredException;
use Bluebanner\Core\ItemBomAgentRequiredException;

class ItemBom extends BaseModel
{
	
	protected $touches = array();
	
	protected $table = 'core_item_bom';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'request_id' => 'required|integer',
		'item_id' => 'required|integer',
	);

	public function validate() {
		if ( ! $pid = $this->parent_id)
			throw new ItemBomParentRequiredException('A Parent Item is required for a BOM, none given.');

		if ( ! $parent = Item::find($pid))
			throw new ItemNotFoundException("A Parent Item is required for a BOM, the given[$pid] can not found.");

		if ( ! $cid = $this->child_id)
			throw new ItemBomChildRequiredException('A Child Item is required for a BOM, none given.');

		if ( ! $child = Item::find($cid))
			throw new ItemNotFoundException("A Child Item is required for a BOM, the given[$pid] can not found.");

		if ( ! $uid = $this->agent)
			throw new ItemBomAgentRequiredException('An agent is required for a BOM, none given.');

		return true;
	}
	
	public function agent()
	{
		return $this->belongsTo('Cartalyst\Sentry\Users\Eloquent\User', 'agent');
	}
	
	public function parent()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

	public function child()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Item');
	}

  /**
   * @return array ids of children
   */
  public function splitSku($id) {
    return $this->where('parent_id', $id)->lists('child_id');
  }

  public function splitSkus($ids) {
    $result = array();
    foreach ($ids as $id) {
      $result[$id] = $this->splitSku($id);
    }
    return $result;
  }
}