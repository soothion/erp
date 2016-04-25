@extends('layouts.master')

@section('title')
	{{ trans('item.list') }}
	@parent
@stop

@section('content')

<div class="span12">
	<div class="widget stacked widget-table">
		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('item.item_list')}}</h3>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>{{ trans('admin.sku') }}</th>
						<th>{{ trans('admin.category') }}</th>
						<th>{{ trans('admin.create') }}</th>
						<th>{{ trans('admin.update') }}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($items as $item)
					{{ Form::open(array('url' => route('core.item.info.destroy', $item->id), 'method' => 'DELETE', 'class' => 'form-inline')) }}
					<tr>
						<td>{{$item->sku}}</td>
						<td>{{ $item->category ? $item->category->name : ''}}</td>
						<td>{{$item->created_at}}</td>
						<td>{{$item->updated_at}}</td>
						<td>
							@if (Sentry::getUser()->hasAccess('core.item.info.update'))
								<a class="btn btn-info" href="{{ route('core.item.info.edit', $item->id) }}"><i class="icon-pencil"></i> {{ trans('label.edit') }}</a>
							@endif
							@if (Sentry::getUser()->hasAccess('core.item.image.edit'))
								<a class="btn btn-info" href="{{ route('core.item.image.edit', $item->id) }}"><i class="icon-picture"></i> {{ trans('label.images') }}</a>
							@endif
							@if (Sentry::getUser()->hasAccess('core.item.info.destroy'))
								<button type="submit" class="btn btn-danger"><i class="icon-trash"></i> {{ trans('label.delete') }}</button>
							@endif
						</td>
					</tr>
					{{ Form::close() }}
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	{{ $items->links() }}
</div>
</div>
@stop
