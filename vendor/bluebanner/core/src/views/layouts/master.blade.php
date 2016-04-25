@extends('ui::layouts.master')

@section('menu')
	@parent
	<li class="dropdown {{Request::is('configuration*') ? 'active' : ''}}">					
		<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-wrench"></i>
			<span>{{ trans('core::menu.config') }}</span>
			<b class="caret"></b>
		</a>	
		<ul class="dropdown-menu">
			<li><a href="">{{ trans('core::menu.company') }}</a></li>
			<li><a href="">{{ trans('core::menu.users') }}</a></li>
			<li class="dropdown-submenu">
				<a tabindex="-1" href="#">Dropdown menu</a>
				<ul class="dropdown-menu">
				<li><a tabindex="-1" href="#">Second level link</a></li>
				<li><a tabindex="-1" href="#">Second level link</a></li>
				<li><a tabindex="-1" href="#">Second level link</a></li>
				</ul>
			</li>
		</ul>    				
	</li>
	@if (Sentry::getUser()->isSuperUser())
		<li class='dropdown {{ starts_with(route::currentRouteName(), 'core.admin') ? 'active' : '' }}'>
			<a href="javascript:;" class="dropdown-toggle" data-toggle='dropdown'>
				<i class='icon-user'></i>
				<span>{{ trans('core::menu.admin') }}</span>
				<b class='caret'></b>
			</a>
			<ul class="dropdown-menu">
				<li><a tabindex="-1" href="{{ route('core.admin.platform') }}">{{ trans('core::menu.platform') }}</a></li>
				<li><a tabindex="-1" href="{{ route('core.admin.channel') }}">{{ trans('core::menu.channel') }}</a></li>
				<li><a tabindex="-1" href="{{ route('core.admin.user') }}">{{ trans('core::menu.users') }}</a></li>
			</ul>
		</li>
		
	@endif
@stop