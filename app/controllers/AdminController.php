<?php

class AdminController extends BaseController
{
  
  public function index()
  {
    return View::make('admin.index', array('user' => Sentry::getUser()));
  }
  
  public function platform()
  {
    return View::make('admin.platform', array('platforms' => Core::platformList()->paginate()));
  }
  
  public function channel()
  {
    return View::make('admin.channel', array('channels' => Core::accountList()->paginate()));
  }
  
  public function user()
  {
    return View::make('admin.user', array('users' => Sentry::getUserProvider()->findAll()));
  }

}
