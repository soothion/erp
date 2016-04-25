<?php namespace Bluebanner\Core;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class ProfileController extends BaseController
{
  
  public function index()
  {
    return View::make('core::profile.index', array('user' => Sentry::getUser()));
  }
  
  public function update()
  {
    
    try {
      
      $user = Sentry::getUser();
      
      $input = Input::all();
      
      if ($input['password'] == '')
        unset($input['password']);
      
      $user->update($input);
    
      if ($user->save())
        echo 'OK';
      

      return Redirect::route('core.profile');
      
    } catch (\Exception $e) {
      return Redirect::route('core.profile')
        ->withInput(Input::except('password'))
        ->with('exception', $e->getMessage());
    }
    
  }

}
