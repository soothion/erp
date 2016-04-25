@extends('layouts.master')

@section('title')
	Profile
	@parent
@stop

@section('content')

<div class="span12">
	
	<div class="widget stacked widget-table">

		<div class="widget-header">
			<i class="icon-star"></i>
			<h3>{{trans('Profile')}}</h3>
		</div>
		
		<div class="widget-content">
			
			<br />

			{{ Form::open(array('url' => route('core.profile.post'), 'class'=>'form-horizontal', 'id'=>'validation-form')) }}
			<fieldset>
			
			  @if (Session::has('exception'))
  			<div class="alert alert-error content clearfix">
      	    <button type="button" class="close" data-dismiss="alert">×</button>
      	    <strong>Warning!</strong> 
  					<div>{{ Session::get('exception') }}</div>
      	</div>
  			@endif
			  
			  <div class="control-group">
  				{{Form::label('email', 'email', array('class'=> 'control-label'))}}
  				<div class="controls">
  					{{Form::text('email', Input::old('email') ?: $user->email, array('class'=>'input-large'))}}
  				</div>
  			</div>
  			
  			<div class="control-group">
  				{{Form::label('password', 'password', array('class'=> 'control-label'))}}
  				<div class="controls">
  					{{Form::password('password', '', array('class'=>'input-large'))}}
  				</div>
  			</div>

  			<div class="control-group">
  				{{Form::label('first_name', 'first_name', array('class'=> 'control-label'))}}
  				<div class="controls">
  					{{Form::text('first_name', Input::old('first_name') ?: $user->first_name, array('class'=>'input-large'))}}
  				</div>
  			</div>
			
  			<div class="control-group">
  				{{Form::label('last_name', 'last_name', array('class'=> 'control-label'))}}
  				<div class="controls">
  					{{Form::text('last_name', Input::old('last_name') ?: $user->last_name, array('class'=>'input-large'))}}
  				</div>
  			</div>
			
  		  <div class="form-actions">
  				<button type="submit" class="btn btn-danger btn">Save</button>&nbsp;&nbsp;
  				<button type="reset" class="btn" >Cancel</button>
  			</div>
  		  
			</fieldset>
			{{ Form::close() }}
				
		</div>
		
	</div>	

</div>
@stop