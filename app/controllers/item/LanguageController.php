<?php

class LanguageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('item.language.index', array('languages' => Item::languageList()->paginate()));
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
			Item::languageCreate(array('name' => Input::get('name')));
			return Redirect::route('core.item.language.index')
				->with('success', 'Create Lang Successfully.');
		} catch (Exception $e) {
			return Redirect::route('core.item.language.index')
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
			return View::make('item.language.edit', array('language' => Item::languageFind($id)));
		} catch (Exception $e) {
			return Redirect::route('core.item.language.index')
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
			$lang = Item::languageFind($id);
			$lang->name = Input::get('name');
			$lang->save();
			return Redirect::route('core.item.language.index')
				->with('success', "Update Language [$id] Successfully.");
		} catch (Exception $e) {
			return Redirect::route('core.item.language.edit', $id)
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
			$lang = Item::languageFind($id);
			$lang->delete();
			return Redirect::route('core.item.language.index')
				->with('success', "Delete Lang [$id] Successfully.");
		} catch (Exception $e) {
			return Redirect::route('core.item.language.index')
				->with('exception', $e->getMessage());
		}
	}

}