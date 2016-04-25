@extends('layouts.master')

@section('title')
	{{ trans('item.language_list') }}
	@parent
@stop

@section('content')
<div class="span8">
	<div class="widget stacked widget-table">
		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('item.language_list')}}</h3>
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
					@foreach ($languages as $item)
					{{ Form::open(array('url' => route('core.item.language.destroy', $item->id), 'method' => 'DELETE', 'class' => 'form-inline')) }}
					<tr>
						<td>{{$item->name}}</td>
						<td>{{$item->created_at}}</td>
						<td>{{$item->updated_at}}</td>
						<td>
							@if (Sentry::getUser()->hasAccess('core.item.language.update'))
								<a class="btn btn-info" href="{{ route('core.item.language.edit', $item->id) }}"><i class="icon-pencil"></i> {{ trans('label.edit') }}</a>
							@endif
							@if (Sentry::getUser()->hasAccess('core.item.language.destroy'))
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
	{{ $languages->links() }}
</div>

<div class="span4">
	<div class="widget stacked widget-box">
		<div class="widget-header">
			<h3>{{ trans('item.language_create') }}</h3>
		</div>
		<div class="widget-content">
			@if (Sentry::getUser()->hasAccess('core.item.language.create'))
			<form id="create-language" class="form-horizontal" action="{{ route('core.item.language.store') }}" method="post">
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