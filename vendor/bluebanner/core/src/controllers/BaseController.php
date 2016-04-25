<?php namespace Bluebanner\Core;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
  /**
   * 
   * @return void
   */
  public function setupLayout()
  {
    if (! is_null($this->layout)) {
      $this->layout = View::make($this->layout);
    }
  }
}