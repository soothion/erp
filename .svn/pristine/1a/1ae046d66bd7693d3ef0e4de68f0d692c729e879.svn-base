@extends('layouts.master')

@section('title')
	{{ trans('admin.platform_update') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked ">
		<div class="widget-header">
			<i class="icon-user"></i>
				<h3>{{ trans('admin.platform_update') }}</h3>
		</div>
		<div class="widget-content">
			{{ Form::open(array('url' => route('core.admin.platform.update', $platform->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
				<fieldset>
					<div class="control-group">											
						<label class="control-label" for="name">{{ trans('label.name') }}</label>
						<div class="controls">
							<input type="text" class="input-medium disabled" id="name" name="name" value="{{ Input::old('name') ?: $platform->name }}" >
							<p class="help-block">{{ trans('Platform name is required and uniqued.') }}</p>
						</div>

						<label class="control-label" for="abbreviation">{{ trans('label.abbreviation') }}</label>
						<div class="controls">
							<input type="text" class="input-medium disabled" id="name" name="abbreviation" value="{{ Input::old('abbreviation') ?: $platform->abbreviation }}" >
							<p class="help-block">{{ trans('Platform abbreviation is required and uniqued.') }}</p>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">{{ trans('label.save') }}</button>
						<a class="btn" href="{{ route('core.admin.platform.index') }}">{{ trans('label.cancel') }}</a>
					</div>
				</fieldset>
			{{ Form::close() }}
		</div>
	</div>
</div>

@stop