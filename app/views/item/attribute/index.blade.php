@extends('layouts.master')

@section('title')
	{{ trans('item.attribute_list') }}
	@parent
@stop

@section('content')
<div class="span7">
	<div class="widget stacked widget-table">
		<div class="widget-header">
			<i class="icon-magnet"></i>
			<h3>{{trans('item.attribute_list')}}</h3>
		</div>
		<div class="widget-content">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>{{ trans('admin.name') }}</th>
						<th>{{ trans('admin.category') }}</th>
						<th>{{ trans('admin.create') }}</th>
						<th>{{ trans('admin.update') }}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($attributes as $item)
					{{ Form::open(array('url' => route('core.item.attribute.destroy', $item->id), 'method' => 'DELETE', 'class' => 'form-inline')) }}
					<tr>
						<td>{{$item->name}}</td>
						<td>{{ $item->category ? $item->category->name : ''}}</td>
						<td>{{$item->created_at}}</td>
						<td>{{$item->updated_at}}</td>
						<td>
							@if (Sentry::getUser()->hasAccess('core.item.attribute.update'))
								<a class="btn btn-info" href="{{ route('core.item.attribute.edit', $item->id) }}"><i class="icon-pencil"></i> {{ trans('label.edit') }}</a>
							@endif
							@if (Sentry::getUser()->hasAccess('core.item.attribute.destroy'))
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
	{{ $attributes->links() }}
</div>

<div class="span5">
	<div class="widget stacked widget-box">
			
		<div class="widget-header">
			<h3>{{ trans('item.attribute_create')}}</h3>
		</div>
					
		<div class="widget-content">
			@if (Sentry::getUser()->hasAccess('core.item.attribute.store'))
			<form id="create-category" class="form-horizontal" action="{{ route('core.item.attribute.store') }}" method="post">
				<fieldset>
		
					<div class="control-group">
	  				{{Form::label('category_id', trans('item.category'), array('class'=> 'control-label'))}}
	  				<div class="controls">
	  					{{Form::select('category_id', $categories, Input::old('category_id') ?: '', array('class'=>'input-large'))}}
	  				</div>
	  			</div>
					
					<div class="control-group">
	  				{{Form::label('name', trans('item.attribute_name'), array('class'=> 'control-label'))}}
	  				<div class="controls">
	  					{{Form::text('name', Input::old('name') ?: '', array('class'=>'input-large'))}}
	  				</div>
	  			</div>
	
					<div class="form-actions">
	  				<button type="submit" class="btn btn-primary"><i class="icon-plus"></i> {{ trans('label.create') }}</button>
	  			</div>

				</fieldset>
			</form>
			@endif
		</div>
	</div>
</div>
@stop