@extends('layouts.master')

@section('title')
	{{ trans('item.attribute_update') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked ">
		<div class="widget-header">
			<i class="icon-user"></i>
				<h3>{{ trans('item.attribute_update') }}</h3>
		</div>
		<div class="widget-content">
			{{ Form::open(array('url' => route('core.item.attribute.update', $attribute->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
				<fieldset>
					
					<div class="control-group">
						{{Form::label('category_id', trans('item.category'), array('class'=> 'control-label'))}}
						<div class="controls">
							{{Form::select('category_id', $categories, Input::old('category_id') ?: $attribute->category_id, array('class'=>'input-large'))}}
						</div>
					</div>
					
					<div class="control-group">											
						{{Form::label('name', trans('item.attribute_name'), array('class'=> 'control-label'))}}
						<div class="controls">
							{{Form::text('name', Input::old('name') ?: $attribute->name, array('class'=>'input-large'))}}
							<p class="help-block">{{ trans('Attribute name is required and uniqued.') }}</p>
						</div>
					</div>
					
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">{{ trans('label.save') }}</button>
						<a class="btn" href="{{ route('core.item.attribute.index') }}">{{ trans('label.cancel') }}</a>
					</div>
				</fieldset>
			{{ Form::close() }}
		</div>
	</div>
</div>

@stop