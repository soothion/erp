@extends('core::layouts.master')

@section('title')
	{{ trans('core::admin.platform') }}
	@parent
@stop

@section('content')

<div class="span8">
	<div class="widget stacked widget-table">

		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('core::admin.platform_list')}}</h3>
		</div>
		
		<div class="widget-content">
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>{{ trans('core::admin.name') }}</th>
						<th>{{ trans('core::admin.abbreviation') }}</th>
						<th>{{ trans('core::admin.create') }}</th>
						<th>{{ trans('core::admin.update') }}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($platforms as $item)
					<tr>
						<td>{{$item->name}}</td>
						<td>{{$item->abbreviation}}</td>
						<td>{{$item->created_at}}</td>
						<td>{{$item->updated_at}}</td>
						<td>
							<a class="btn btn-info" href=""><i class="icon-pencil"></i></a>
							<a class="btn btn-info" href=""><i class="icon-barcode"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		{{$platforms->links()}}
		
	</div>
</div>

<div class="span4">
	<div class="widget widget-plain">
		<div class="widget-content">
			<a href="" class="btn btn-large btn-warning btn-support-ask" style="display: block; font-size: 22px; padding: 14px 0; font-weight: 600; margin-bottom: .75em;">Create New Platform</a>	
			<a href="javascript:;" class="btn btn-large btn-support-contact" style="display: block; padding: 12px 0; font-size: 18px; font-weight: 600;">Contact Support</a>
		</div>
	</div>
	
	<div class="widget stacked widget-box">
		<div class="widget-header">	
			<h3>Most Popular Questions</h3>			
		</div>
		<div class="widget-content">
			xxx
		</div>
</div>
@stop