<!doctype html>
<html lang="{{ Config::get('application.language') }}">
<head>
	<meta charset="utf-8">
	<title>
		@section('title')
		::	{{ Config::get('core::site_name') }}
		@show
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">    
	<meta name="description" content="ui">
	<meta name="author" content="">
	
	@section('css')
	
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/bootstrap.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/bootstrap-responsive.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/font-awesome.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/ui-lightness/jquery-ui-1.10.0.custom.min.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/base-admin-2.css') }}" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/base-admin-2-responsive.css') }}" type="text/css" media="screen" charset="utf-8">
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	@show

	<!-- The fav icon -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
		
</head>

<body>
	@include('ui::lib.navbar')
	
	<div class="main">
	    <div class="container">
	      <div class="row">
					@section('message')
					@show
					@yield('content')
				</div>
			</div>
	</div>
	
	@include('ui::lib.extra')
	@include('ui::lib.foot')
	@section('script')
	
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/libs/jquery-1.8.3.min.js')}}"></script>
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/libs/jquery-ui-1.10.0.custom.min.js')}}"></script>
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/libs/bootstrap.min.js')}}"></script>
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/Application.js')}}"></script>
	
	@show

</body>
</html>