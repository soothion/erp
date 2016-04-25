<?php

use Bluebanner\Core\Item\ItemServiceInterface;

class ItemController extends \BaseController {

	public function __construct(ItemServiceInterface $item)
	{
		$this->item = $item;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('item.index', array('items' => $this->item->itemList()->paginate()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('item.create', array(
			'categories' => $this->item->categoryIdNamePairsList(),
			'status'	=> $this->item->itemStatusList(),
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			$item = $this->item->itemCreate(array(
				'sku'	=> Input::get('sku'),
				'category_id'	=> Input::get('category_id'),
				'line_state'	=> Input::get('line_state'),
				'description'	=> Input::get('description'),
			));
			return Redirect::route('core.item.info.edit', $item->id);
		} catch (Exception $e) {
			return Redirect::route('core.item.info.create')
				->withInput()
				->with('exception', $e->getMessage());
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		echo 'show';
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$item = $this->item->itemFind($id);
			return View::make('item.edit', array(
				'item'	=> $item,
				'categories' => $this->item->categoryIdNamePairsList(),
				'status'	=> array_combine($this->item->itemStatusList(), $this->item->itemStatusList()),
				'languages'	=> $this->item->languageList()->get(),
				'attributes' => $this->item->itemAttributeList($id),
			));
		} catch (Exception $e) {
			return Redirect::route('core.item.info.index')
				->with('exception', $e->getMessage());
		}
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try {
			$item = $this->item->itemFind($id);
			$item->category_id = Input::get('category_id');
			$item->line_state = Input::get('line_state');
			$item->description = Input::get('description');
			
			$item->is_drop = Input::get('is_drop');
			$item->is_virtual = Input::get('is_virtual');
			$item->active = Input::get('active');
			$item->is_hold_inv = Input::get('is_hold_inv');
			
			$item->length = Input::get('length');
			$item->width = Input::get('width');
			$item->height = Input::get('height');
			$item->weight = Input::get('weight');
			$item->reserve_qty = Input::get('reserve_qty');
			$item->reserve_day = Input::get('reserve_day');
			$item->save();
			
			// attributes
			foreach (Input::all() as $key => $value) {
				if (starts_with($key, 'attributes')) {
					list(, $lang_id, $attr) = explode('_', $key);
					$this->item->itemAttributeSet($id, $lang_id, $attr, $value);
				}
			}
			
			return Redirect::route('core.item.info.index')
				->with('success', 'Update Item Successfully.');
		} catch (Exception $e) {
			return Redirect::route('core.item.info.edit', $id)
				->withInput()
				->with('exception', $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function images($id)
	{
		# code...
	}

}