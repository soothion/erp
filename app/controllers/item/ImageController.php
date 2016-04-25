<?php

use Bluebanner\Core\Item\ItemServiceInterface;
use Bluebanner\Core\Model\ItemImage;

class ImageController extends \BaseController {

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
		//
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
			$this->item->itemImageCreate(Input::get('id'), Input::file('file'));
			return Response::json('success', 200);
		} catch (Exception $e) {
			return Response::json(array('jsonrpc' => '2.0', 'error' => array('code' => $e->getCode(), 'message' => $e->getMessage())));
		}


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $type = 'thumb')
	{
		$image = ItemImage::find($id);
		$realPath=storage_path() . ($type == 'thumb' ? $image->thumb : $image->original);
		if(is_file($realPath))
		{
			return Image::make( $realPath)->response();
		}
		else
		{
			throw new Exception("404 , not find the iamges!");
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$images = $this->item->itemImageList($id)->get();
		return View::make('item.image.index', array('id' => $id, 'images' => $images));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
			$item_id = $this->item->itemImageRemove($id);
			return Redirect::route('core.item.image.edit', $item_id);
		} catch (Exception $e) {
			return Redirect::route('core.item.image.edit', $id);
		}
	}

}