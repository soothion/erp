@extends('layouts.master')

@section('title')
	{{ trans('item.category_list') }}
	@parent
@stop

@section('content')
<div class="span8">
	<div class="widget stacked widget-table">
		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('item.category_list')}}</h3>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>{{ trans('admin.name') }}</th>
						<th>{{ trans('admin.create') }}</th>
						<th>{{ trans('admin.update') }}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($categories as $item)
					{{ Form::open(array('url' => route('core.item.category.destroy', $item->id), 'method' => 'DELETE', 'class' => 'form-inline')) }}
					<tr>
						<td>{{$item->name}}</td>
						<td>{{$item->created_at}}</td>
						<td>{{$item->updated_at}}</td>
						<td>
							@if (Sentry::getUser()->hasAccess('core.item.category.update'))
								<a class="btn btn-info" href="{{ route('core.item.category.edit', $item->id) }}"><i class="icon-pencil"></i> {{ trans('label.edit') }}</a>
							@endif
							<a class="btn btn-info" href="" ><i class="icon-list-alt" title="{{ trans('item.item_list') }}"></i> {{ trans('label.items') }}</a>
							@if (Sentry::getUser()->hasAccess('core.item.category.destroy'))
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
	{{ $categories->links() }}
</div>

<div class="span4">
	<div class="widget stacked widget-box">
			
		<div class="widget-header">
			<h3>{{ trans('item.category_create')}}</h3>
		</div>
					
		<div class="widget-content">
			@if (Sentry::getUser()->hasAccess('core.item.category.create'))
			<form id="create-category" class="form-horizontal" action="{{ route('core.item.category.store') }}" method="post">
				<fieldset>
					<div class="input-append">
				    <input name="name" id="name" class="input-large" id="appendedInputButton" size="16" type="text" placeholder="{{ trans('label.name') }}"><button class="btn btn-primary" type="submit"><i class="icon-plus"></i> {{ trans('label.create') }}</button>
					</div>
				</fieldset>
			</form>
			@endif
		</div>
	</div>
</div>
@stop