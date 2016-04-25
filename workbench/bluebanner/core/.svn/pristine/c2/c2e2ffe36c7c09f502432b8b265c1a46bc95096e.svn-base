@extends('core::layouts.master')

@section('title')
	{{ trans('core::admin.channel') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked widget-table">

		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('core::admin.channel_list')}}</h3>
		</div>
		
		<div class="widget-content">
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
					  <th>{{ trans('core::admin.platform') }}</th>
						<th>{{trans('core::admin.name')}}</th>
						<th>{{trans('core::admin.abbreviation')}}</th>
						<th>{{ trans('core::admin.service_email') }}
						<th>{{ trans('core::admin.bill_email') }}
						<th>{{trans('core::admin.create')}}</th>
						<th>{{trans('core::admin.update')}}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($channels as $item)
					<tr>
					  <td>{{ $item->platform->name }}</td>
						<td>{{$item->name}}</td>
						<td>{{$item->abbreviation}}</td>
						<td>{{ $item->service_email }}</td>
						<td>{{ $item->bill_email }}</td>
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
		
		{{$channels->links()}}
		
	</div>
</div>

@stop