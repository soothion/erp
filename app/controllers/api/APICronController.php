<?php
use Bluebanner\Core\Model\Cron;
class APICronController extends \BaseController {

	public function __construct(Cron $model){
		$this->model = $model;
	}

	public function index(){
		$param = Input::get();
		return $this->model->findByAttributes($param)->get();
	}

	public function store()
    {
        $param = Input::get();
        $param['last'] = time();
        $param['next'] = $param['last'] + $param['interval']*60;
	   	return Cron::create($param);
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

	public function show($platform)
	{
		$model = Cron::firstByAttributes(array('platform'=>$platform));
		if($result = $model['config'])
			return $result;
		else return null;
	}

	public function destroy($id)
	{
		$mapping = Cron::find($id);
		$mapping->forceDelete();
	}

	public function accountList(){
		return Cron::distinct('account')->select('account')->get();
	}

}
