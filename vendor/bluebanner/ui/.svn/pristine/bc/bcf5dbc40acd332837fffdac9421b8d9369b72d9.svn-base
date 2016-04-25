<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{{ Config::get('ui::sitename') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="description" content="">
	<meta name="author" content="Mars Zhou, Thomas">

  <link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/bootstrap.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/bootstrap-responsive.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/font-awesome.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/ui-lightness/jquery-ui-1.10.0.custom.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/base-admin-2.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/base-admin-2-responsive.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/pages/signin.css') }}" type="text/css" media="screen" charset="utf-8">

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="favicon.ico">
		
</head>

<body>
		<div class="navbar navbar-inverse navbar-fixed-top">

		<div class="navbar-inner">

			<div class="container">

				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<i class="icon-cog"></i>
				</a>

				<a class="brand" href="{{ URL::to(Config::get('ui::uri')) }}">
					{{ Config::get('ui::sitename') }} <sup>{{Config::get('application.version')}}</sup>				
				</a>		

				<div class="nav-collapse">
					<ul class="nav pull-right">

						<li class="">						
							<a href="#" class="">
								Create an Account
							</a>

						</li>

						<li class="">						
							<a href="{{ URL::to(Config::get('ui::uri')) }}" class="">
								<i class="icon-chevron-left"></i>
								Back to Homepage
							</a>

						</li>
					</ul>

				</div><!--/.nav-collapse -->	

			</div> <!-- /container -->

		</div> <!-- /navbar-inner -->

	</div> <!-- /navbar -->

   @yield('content')
   
   <script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/libs/jquery-1.8.3.min.js') }}"></script>
   <script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/libs/jquery-ui-1.10.0.custom.min.js') }}"></script>
   <script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/libs/bootstrap.min.js') }}"></script>
   <script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/Application.js') }}"></script>
</body>
</html>
