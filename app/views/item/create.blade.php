@extends('layouts.master')

@section('css')
	@parent
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/fuelux.min.css') }}" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/fuelux-responsive.min.css') }}" type="text/css" media="screen" title="no title" charset="utf-8">
@stop

@section('script')
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/require.js') }}"></script>
	<script type="text/javascript" charset="utf-8">
		requirejs.config({
			paths: {
				'jquery': '{{ asset('packages/bluebanner/ui/js/libs/jquery-1.8.3.min') }}',
				'bootstrap': '{{ asset('packages/bluebanner/ui/js/libs/bootstrap/js') }}',
				'fuelux': '{{ asset('packages/bluebanner/ui/js/fuelux') }}'
			}
		});
		require(['jquery', 'fuelux/all'], function($) {

		});
		
	</script>
	
@stop

@section('title')
	{{ trans('item.create') }}
	@parent
@stop

@section('content')

<div class="span12 fuelux">
	<div class="widget stacked ">
		<div class="widget-header">
			<i class="icon-list-alt"></i>
				<h3>{{ trans('item.create') }}</h3>
		</div>
		
		<div class="widget-content">
			
			<div class="wizard">
				<ul class="steps">
					<li data-target="#step1" class="active"><span class="badge badge-info">1</span>{{ trans('item.basic_info') }}<span class="chevron"></span></li>
					<li data-target="#step2"><span class="badge">2</span>{{ trans('item.features') }}<span class="chevron"></span></li>
					<li data-target="#step3"><span class="badge">3</span>{{ trans('item.attributes') }}<span class="chevron"></span></li>
					<li data-target="#step4"><span class="badge">4</span>{{ trans('item.pictures') }}<span class="chevron"></span></li>
					<li data-target="#step5"><span class="badge">5</span>{{ trans('item.finish') }}<span class="chevron"></span></li>
				</ul>
			</div>
			
			<br/>
			
			<div class="step-content">
				<div class="step-pane active" id="step1">
					{{ Form::open(array('url' => route('core.item.info.store'), 'method' => 'POST', 'class' => 'form-horizontal')) }}
					<fieldset>
						<div class="control-group">											
							{{ Form::label('sku', trans('item.sku'), array('class' => 'control-label')) }}
							<div class="controls">
								{{ Form::text('sku', Input::old('sku') ?: '', array('class' => '')) }}
								<p class="help-block">{{ trans('SKU is required and uniqued.') }}</p>
							</div>
						</div>

						<div class="control-group">
							{{ Form::label('category_id', trans('item.category'), array('class' => 'control-label')) }}
							<div class="controls">
								{{ Form::select('category_id', $categories, Input::old('category_id') ?: '', array('class' => '')) }}
							</div>
						</div>

						<div class="control-group">											
							{{ Form::label('line_state', trans('item.state'), array('class' => 'control-label')) }}
							<div class="controls">
								{{ Form::select('line_state', $status, Input::old('line_state') ?: '', array('class' => '')) }}
							</div>
						</div>

						<div class="control-group">
							{{ Form::label('description', trans('item.description'), array('class' => 'control-label')) }}
							<div class="controls">
								{{ Form::textarea('description', Input::old('description') ?: '', array('class' => '')) }}
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="btn btn-primary">{{ trans('label.next') }}</button>
							<a class="btn" href="{{ route('core.item.info.index') }}">{{ trans('label.cancel') }}</a>
						</div>
					</fieldset>
					{{ Form::close() }}
				</div>
				<div class="step-pane" id="step2">
					2
				</div>
				<div class="step-pane" id="step3">This is step 3</div>
				<div class="step-pane" id="step4">This is step 4</div>
				<div class="step-pane" id="step5">This is step 5</div>
			</div>
		</div>
	</div>
</div>

@stop