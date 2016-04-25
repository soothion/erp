@extends('ui::layouts.noauth')

  @section('content')
  <div class="account-container stacked">

  	<div class="content clearfix">

  	{{ Form::open(array('url'=>'login', 'class'=>'form-horizontal')) }}

  			<h1>Sign In</h1>		

  			@if (Session::has('login_errors'))
      	<div class="alert alert-error">
      	    <button type="button" class="close" data-dismiss="alert">×</button>
      	    <strong>Warning!</strong> 
						<div>{{ Session::get('login_errors') }}</div>
      	</div>
      	@endif

  			<div class="login-fields">

  				<p>Sign in using your registered account:</p>

  				<div class="field">
  					<label for="username">Username:</label>
						{{ Form::email('username', Input::old('username'), array('class' => 'login username-field', 'placeholder' => 'Username')) }}
  				</div> <!-- /field -->

  				<div class="field">
  					<label for="password">Password:</label>
  					<input type="password" id="password" name="password" placeholder="Password" class="login password-field" value="{{Input::old('password')}}"/>
  				</div> <!-- /password -->

  			</div> <!-- /login-fields -->

  			<div class="login-actions">

  				<span class="login-checkbox">
  					<input id="Field" name="remember" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" @if (Input::old('remember')) checked @endif />
  					<label class="choice" for="Field">Keep me signed in</label>
  				</span>

  				{{ Form::Submit('Sing In', array('class'=>'button btn btn-warning btn-large')) }}

  			</div> <!-- .actions -->

  			<!-- <div class="login-social">
  				<p>Sign in using social network:</p>

  				<div class="twitter">
  					<a href="#" class="btn_1">Login with Twitter</a>				
  				</div>

  				<div class="fb">
  					<a href="#" class="btn_2">Login with Facebook</a>				
  				</div>
  			</div> -->

  		{{ Form::close() }}

  	</div> <!-- /content -->

  </div> <!-- /account-container -->

  <!-- Text Under Box -->
  <div class="login-extra">
  	Don't have an account? <a href="./signup.html">Sign Up</a><br/>
  	Remind <a href="#">Password</a>
  </div> <!-- /login-extra -->

  @endsection