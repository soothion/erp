@extends('layouts.master')

@section('title')
	{{ trans('item.category_update') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked ">
		<div class="widget-header">
			<i class="icon-user"></i>
				<h3>{{ trans('item.category_update') }}</h3>
		</div>
		<div class="widget-content">
			{{ Form::open(array('url' => route('core.item.category.update', $category->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
				<fieldset>
					<div class="control-group">											
						<label class="control-label" for="name">{{ trans('item.category_name') }}</label>
						<div class="controls">
							<input type="text" class="input-medium disabled" id="name" name="name" value="{{ Input::old('name') ?: $category->name }}" >
							<p class="help-block">{{ trans('Category name is required and uniqued.') }}</p>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">{{ trans('label.save') }}</button>
						<a class="btn" href="{{ route('core.item.category.index') }}">{{ trans('label.cancel') }}</a>
					</div>
				</fieldset>
			{{ Form::close() }}
		</div>
	</div>
</div>

@stop