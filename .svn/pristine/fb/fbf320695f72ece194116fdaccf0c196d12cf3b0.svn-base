@extends('layouts.master')

@section('title')
	{{ trans('admin.platform') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked ">

		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('admin.platform_list')}}</h3>
		</div>
		
		<div class="widget-content">
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>{{ trans('admin.name') }}</th>
						<th>{{ trans('admin.abbreviation') }}</th>
						<th>{{ trans('admin.create') }}</th>
						<th>{{ trans('admin.update') }}</th>
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
			
			{{ $platforms->links() }}

		</div>
		
		
		
	</div>
	
</div>

@stop