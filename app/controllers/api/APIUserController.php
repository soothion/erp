<?php

class APIUserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$list = array();

		foreach (Sentry::getUserProvider()->findAll() as $user) {
			$list[] = array_except($user->getAttributes(), array('password', 'activation_code', 'persist_code', 'reset_password_code'));
		}

		return $list;
	}

	public function permissions()
	{
		$list = array(array('id' => 'superuser'));

		// dd(Route::currentRouteName());
		foreach (Route::getRoutes() as $key=>$route) {
			$list[] = array('id' => $key, 'path' => $route->getPath());
		}

		return $list;
	}

	public function grouplist()
	{
		$list = array();

		foreach (Sentry::findAllGroups() as $group) {
			$list[] = array_except($group->getAttributes(), array('permissions'));
		}

		return $list;
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
		$user = Sentry::createUser(array(
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'first_name' => Input::get('first_name'),
			'last_name' => Input::get('last_name'),
			'permissions' => Input::get('permissions'),
		));

		foreach (Input::get('groups') as $group) {
			$user->addGroup(Sentry::findGroupById($group['id']));
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
		$user = Sentry::findUserById($id);
		$groups = array();
		foreach($user->getGroups() as $group) {
			$groups[] = array_except($group->getAttributes(), array('permissions', 'created_at', 'updated_at'));
		}

		$user->groups = $groups;

		return $user;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = Sentry::findUserById($id);
		$user->email = Input::get('email');
		$user->activated = Input::get('activated');
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->permissions = Input::get('permissions');
		$user->save();

		foreach ($user->getGroups() as $g) {
			$user->removeGroup($g);
		}

		foreach (Input::get('groups') as $group) {
			$user->addGroup(Sentry::findGroupById($group['id']));
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
		$user = Sentry::findUserById($id);
		$user->delete();
	}

}