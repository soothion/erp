<?php
use Bluebanner\Core\Item\ItemImageServiceInterface;
use Bluebanner\Core\Model\ItemImageQueue;
use Bluebanner\Core\Model\ItemImageQueueError;
use Bluebanner\Core\Item\ImageUploadService;
use Bluebanner\Core\Item\ItemImageService;
use Bluebanner\Core\Model\ItemImage;
use VIPSoft\Unzip\Unzip;

class APIItemImageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {

		
	}
	
	
	public function DisplaySimpleItemImages($sid)
	{
	   $service=new ItemImageService();
	   return $service->ItemImagesFindByItemId($sid)->get();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		echo "this is for update pictures";
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

	public function imageUpload() {

		$file = Input::file('file');
		$path = storage_path() . '/upload/queues/uploadimage/'. Sentry::getUser()->id . '/' . date('Ymdhis');

		$file -> move($path, $file -> getClientOriginalName());
		$service = new ImageUploadService();
		$service -> setUploadFilePath($path . '/' . $file -> getClientOriginalName());
		try {

			$service -> validate();

		} catch (Exception $e) {

			return $e -> getMessage();

		}

		$queue = ItemImageQueue::create(array('filename' => $file -> getClientOriginalName(), 'agent' => Sentry::getUser() -> id, ));

		$service -> setQueueId($queue -> id);

		Queue::push('Bluebanner\Core\Item\Queue\UploadImage', serialize($service));

	}

	public function imageQueues() {
	   	    
		return ItemImageQueue::with('errors') -> orderBy('created_at', 'desc') -> limit(Input::get('limit')) -> offset(Input::get('offset')) -> get();
	}

}
