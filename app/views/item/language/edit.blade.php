@extends('layouts.master')

@section('title')
	{{ trans('item.language_update') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked ">
		<div class="widget-header">
			<i class="icon-user"></i>
				<h3>{{ trans('item.language_update') }}</h3>
		</div>
		<div class="widget-content">
			{{ Form::open(array('url' => route('core.item.language.update', $language->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
				<fieldset>
					<div class="control-group">											
						<label class="control-label" for="name">{{ trans('item.language_name') }}</label>
						<div class="controls">
							<input type="text" class="input-medium disabled" id="name" name="name" value="{{ Input::old('name') ?: $language->name }}" >
							<p class="help-block">{{ trans('Language name is required and uniqued.') }}</p>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">{{ trans('label.save') }}</button>
						<a class="btn" href="{{ route('core.item.language.index') }}">{{ trans('label.cancel') }}</a>
					</div>
				</fieldset>
			{{ Form::close() }}
		</div>
	</div>
</div>

@stop