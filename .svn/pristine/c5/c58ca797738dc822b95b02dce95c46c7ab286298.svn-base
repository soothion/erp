<?php

class AttributeController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('item.attribute.index', array(
			'attributes' => Item::attributeList()->paginate(),
			'categories'	=> Item::categoryIdNamePairsList(),
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			Item::attributeCreate(array('name' => Input::get('name'), 'category_id' => Input::get('category_id')));
			return Redirect::route('core.item.attribute.index')
				->with('success', 'Create Attribute Successfully.');
		} catch (Exception $e) {
			return Redirect::route('core.item.attribute.index')
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
		//
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
			$attribute = Item::attributeFind($id);
			return View::make('item.attribute.edit', array(
				'attribute' => $attribute,
				'categories'	=> Item::categoryIdNamePairsList(),
			));
		} catch (Exception $e) {
			return Redirect::route('core.item.attribute.index')
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
			$attribute = Item::attributeFind($id);
			$attribute->category_id = Input::get('category_id');
			$attribute->name = Input::get('name');
			$attribute->save();
			return Redirect::route('core.item.attribute.index')
				->with('success', "Update Attribute [$id] Successfully.");
		} catch (Exception $e) {
			return Redirect::route('core.item.attribute.edit', $id)
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
		try {
			$attribute = Item::attributeFind($id);
			$attribute->delete();
			return Redirect::route('core.item.attribute.index')
				->with('success', "Delete Attribute [$id] Successfully.");
		} catch (Exception $e) {
			return Redirect::route('core.item.attribute.index')
				->with('exception', $e->getMessage());
		}
	}

}