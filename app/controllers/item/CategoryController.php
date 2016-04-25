<?php

class CategoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('item.category.index', array('categories' => Item::categoryList()->paginate()));
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
			Item::categoryCreate(array('name' => Input::get('name')));
			return Redirect::route('core.item.category.index')
				->with('success', 'Create Lang Successfully.');
		} catch (Exception $e) {
			return Redirect::route('core.item.category.index')
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
			return View::make('item.category.edit', array('category' => Item::categoryFind($id)));
		} catch (Exception $e) {
			return Redirect::route('core.item.category.index')
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
			$cate = Item::categoryFind($id);
			$cate->name = Input::get('name');
			$cate->save();
			return Redirect::route('core.item.category.index')
				->with('success', "Update Category [$id] Successfully.");
		} catch (Exception $e) {
			return Redirect::route('core.item.category.edit', $id)
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
			$cate = Item::categoryFind($id);
			$cate->delete();
			return Redirect::route('core.item.category.index')
				->with('success', "Delete Category [$id] Successfully.");
		} catch (Exception $e) {
			return Redirect::route('core.item.category.index')
				->with('exception', $e->getMessage());
		}
	}

}