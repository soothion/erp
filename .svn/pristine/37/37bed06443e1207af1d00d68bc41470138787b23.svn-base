@extends('layouts.master')

@section('title')
	{{ trans('admin.user') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked widget-table">

		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('admin.user_list')}}</h3>
		</div>
		
		<div class="widget-content">
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
					  <th>{{ trans('admin.first_name') }}</th>
						<th>{{trans('admin.last_name')}}</th>
						<th>{{trans('admin.email')}}</th>
						<th>{{ trans('admin.activated') }}
						<th>{{ trans('admin.permissions') }}
						<th>{{trans('admin.create')}}</th>
						<th>{{trans('admin.update')}}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $item)
					<tr>
					  <td>{{ $item->first_name }}</td>
						<td>{{$item->last_name}}</td>
						<td>{{$item->email}}</td>
						<td>{{ $item->activated }}</td>
						<td>{{-- $item->permissions --}}</td>
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
		
		{{--$channels->links()--}}
		
	</div>
</div>

@stop