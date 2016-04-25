<?php namespace Bluebanner\Core;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
  
  public function index()
  {
    return View::make('core::home');
  }

}
