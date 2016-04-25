@extends('ui::layouts.master')

@section('menu')
	@parent
	@if (Sentry::getUser()->hasAccess('core.item'))
	<li class='dropdown {{ starts_with(route::currentRouteName(), 'core.item') ? 'active' : '' }}'>
		<a href="{{ route('core.item.info.index') }}" class="dropdown-toggle" data-toggle='dropdown'>
			<i class='icon-list-alt'></i>
			<span>{{ trans('menu.item') }}</span>
			<b class='caret'></b>
		</a>
		<ul class="dropdown-menu">
			<li><a tabindex="-1" href="{{ route('core.item.category.index') }}">{{ trans('menu.item_cate_list') }}</a></li>
			<li><a tabindex="-1" href="{{ route('core.item.language.index') }}">{{ trans('menu.item_lang_setup') }}</a></li>
			<li><a tabindex="-1" href="{{ route('core.item.attribute.index') }}">{{ trans('menu.item_cate_attributes') }}</a></li>
			<li class="dropdown-submenu">
				<a tabindex="-1" href="{{ route('core.item.info.index') }}">{{ trans('menu.item_list') }}</a>
				<ul class="dropdown-menu">
					<li><a tabindex="-1" href="">{{ trans('menu.item_book_list') }}</a></li>
					<li><a tabindex="-1" href="">{{ trans('menu.item_on_road_list') }}</a></li>
					<li><a tabindex="-1" href="">{{ trans('menu.item_inventory_list') }}</a></li>
				</ul>
			</li>
			<li><a tabindex="-1" href="{{ route('core.item.info.create') }}">{{ trans('menu.item_create') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_image_create') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_modification') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_cate_change') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_BOM') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_shipping_mapping') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_packing_rule') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_pi_rule') }}</a></li>
			<li><a tabindex="-1" href="">{{ trans('menu.item_select') }}</a></li>
		</ul>
	</li>
	@endif
	
	@if (Sentry::getUser()->isSuperUser())
	<li class='dropdown {{ starts_with(route::currentRouteName(), 'core.admin') ? 'active' : '' }}'>
		<a href="javascript:;" class="dropdown-toggle" data-toggle='dropdown'>
			<i class='icon-cogs'></i>
			<span>{{ trans('menu.admin') }}</span>
			<b class='caret'></b>
		</a>
		<ul class="dropdown-menu">
			<li><a tabindex="-1" href="{{ route('core.admin.platform') }}">{{ trans('menu.platform') }}</a></li>
			<li><a tabindex="-1" href="{{ route('core.admin.channel') }}">{{ trans('menu.channel') }}</a></li>
			<li><a tabindex="-1" href="{{ route('core.admin.user') }}">{{ trans('menu.users') }}</a></li>
		</ul>
	</li>
	@endif
@stop

@section('message')
<div class="span12">
	@if (Session::has('exception'))
	<div class="alert alert-error content clearfix">
	    <button type="button" class="close" data-dismiss="alert">×</button>
	    <i class="icon-remove-sign"></i> <strong>{{ trans('label.exception') }}!</strong> 
			<div>{{ Session::get('exception') }}</div>
	</div>
	@endif
	
	@if (Session::has('success'))
	<div class="alert alert-success content clearfix">
	    <button type="button" class="close" data-dismiss="alert">×</button>
	    <i class="icon-ok-sign"></i> <strong>{{ trans('label.success') }}!</strong> 
			<div>{{ Session::get('success') }}</div>
	</div>
	@endif
	
	@if (Session::has('warning'))
	<div class="alert alert-warning content clearfix">
	    <button type="button" class="close" data-dismiss="alert">×</button>
	    <i class="icon-warning-sign"></i> <strong>{{ trans('label.warning') }}!</strong> 
			<div>{{ Session::get('warning') }}</div>
	</div>
	@endif
</div>
@stop
