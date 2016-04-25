<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<i class="icon-cog"></i>
			</a>
			<a class="brand" href="{{ route(Config::get('core::uri')) }}">
				{{ Config::get('core::site_name') }} <sup>{{Config::get('core::version')}}</sup>
			</a>		
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-cog"></i>
							Settings
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="javascript:;">Account Settings</a></li>
							<li><a href="javascript:;">Privacy Settings</a></li>
							<li class="dropdown-submenu">
								<a tabindex="-1" href="#">Language Settings</a>
								<ul class="dropdown-menu">
								<li><a tabindex="-1" href="">English</a></li>
								<li><a tabindex="-1" href="">简体中文</a></li>
								</ul>
							</li>
							
							<li class="divider"></li>
							<li><a href="javascript:;">Help</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-user"></i> 
							{{ Sentry::getUser()->email }}
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('core.profile') }}">My Profile</a></li>
							<li><a href="javascript:;">My Groups</a></li>
							<li class="divider"></li>
							<li><a href="{{ url('logout') }}">Logout</a></li>
						</ul>
					</li>
				</ul>
				<form class="navbar-search pull-right">
					<input type="text" class="search-query" placeholder="Search">
				</form>
			</div>
		</div>
	</div>
</div>

<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
			<a class="btn-subnavbar collapsed" data-toggle="collapse" data-target=".subnav-collapse">
				<i class="icon-reorder"></i>
			</a>
			<div class="subnav-collapse collapse">
				<ul class="mainnav">
					@section('menu')
					<li class="{{Route::is(Config::get('core::uri')) || Request::is('/') ? 'active' : ''}}">
						<a href="{{ route(Config::get('core::uri')) }}">
							<i class="icon-home"></i>
							<span>{{ trans('menu.dashboard') }}</span>
						</a>	    				
					</li>
					@show
				</ul>
			</div>
		</div>
	</div>
</div>