<?php namespace Bluebanner\Core;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Core;

class AdminController extends BaseController
{
  
  public function index()
  {
    return View::make('core::admin.index', array('user' => Sentry::getUser()));
  }
  
  public function platform()
  {
    return View::make('core::admin.platform', array('platforms' => Core::platformList()->paginate()));
  }
  
  public function channel()
  {
    return View::make('core::admin.channel', array('channels' => Core::accountList()->paginate()));
  }
  
  public function user()
  {
    return View::make('core::admin.user', array('users' => Sentry::getUserProvider()->findAll()));
  }

}
