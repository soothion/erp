@extends('layouts.master')

@section('css.bak')
	@parent
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/fuelux.min.css') }}" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/fuelux-responsive.min.css') }}" type="text/css" media="screen" title="no title" charset="utf-8">
@stop

@section('script.bak')
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/require.js') }}"></script>
	<script type="text/javascript" charset="utf-8">
		requirejs.config({
			paths: {
				'jquery': '{{ asset('packages/bluebanner/ui/js/libs/jquery-1.8.3.min') }}',
				'bootstrap': '{{ asset('packages/bluebanner/ui/js/libs/bootstrap/js') }}',
				'fuelux': '{{ asset('packages/bluebanner/ui/js/fuelux') }}',
				'jqui': '{{ asset('packages/bluebanner/ui/js/libs/jquery-ui-1.10.0.custom.min') }}',
				'app': '{{ asset('packages/bluebanner/ui/js/Application') }}'
			}
		});
		require(['jquery', 'fuelux/all', 'jqui', 'app'], function($) {
			$('.btn-next').bind('click', function() {
				$('#item-edit-wizard').wizard('next');
			});
			$('.btn-prev').bind('click', function() {
				$('#item-edit-wizard').wizard('previous');
			});
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

			
			<div id="item-edit" class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#step1" data-toggle="tab">{{ trans('item.basic_info') }}</a></li>
					<li><a href="#step2" data-toggle="tab">{{ trans('item.features') }}</a></li>
					<li><a href="#step3" data-toggle="tab">{{ trans('item.attributes') }}</a></li>
					<li><a href="#step4" data-toggle="tab">{{ trans('item.pictures') }}</a></li>
					<li><a href="#step5" data-toggle="tab">{{ trans('item.finish') }}</a></li>
				</ul>
			</div>
			
			<br/>
			{{ Form::open(array('url' => route('core.item.info.update', $item->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
			<div class="tab-content">
				<div class="tab-pane fade in active" id="step1">@include('item.edit.basic')</div>
				<div class="tab-pane fade in" id="step2">@include('item.edit.features')</div>
				<div class="tab-pane fade in" id="step3">@include('item.edit.attributes')</div>
				<div class="tab-pane fade in" id="step4">include('item.edit.pictures')</div>
				<div class="tab-pane fade in" id="step5">This is step 5</div>
			</div>
			<div class="form-actions">
<!-- 				<button type="button" class="btn btn-primary btn-prev">{{ trans('label.prev') }}</button>
				<button type="button" class="btn btn-primary btn-next">{{ trans('label.next') }}</button> -->
				<button class="btn btn-primary" type="submit"><i class="icon-plus"></i> {{ trans('label.save') }}</button>
				<a class="btn" href="{{ route('core.item.info.index') }}">{{ trans('label.cancel') }}</a>
			</div>
			{{ Form::close() }}
			
		</div>
	</div>
</div>

@stop