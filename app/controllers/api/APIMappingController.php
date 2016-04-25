<?php
use Bluebanner\Core\Model\Mapping;
class APIMappingController extends \BaseController {

	public function __construct(Mapping $model){
		$this->model = $model;
	}

	public function index(){
		$param = Input::get();
		return $this->model->findByAttributes($param)->get();
	}

	public function store()
    {
        $param = Input::get();
	   	return Mapping::create($param);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$model = $this->model->find($id);
		$model->update(Input::get());
		return $model;
	}


	public function destroy($id)
	{
		$mapping = Mapping::find($id);
		$mapping->forceDelete();
	}

}
