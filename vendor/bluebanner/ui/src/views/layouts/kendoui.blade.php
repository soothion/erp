<!DOCTYPE html>
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
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/bluebanner/ui/css/kendoui/kendo.common.min.css') }}" media="screen" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/bluebanner/ui/css/kendoui/kendo.rtl.min.css') }}" media="screen" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/bluebanner/ui/css/kendoui/kendo.default.min.css') }}" media="screen" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/bluebanner/ui/css/kendoui/kendo.common.min.css') }}" media="screen" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/bluebanner/ui/css/kendoui/kendo.common.min.css') }}" media="screen" charset="utf-8">
	@show

	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

</head>
<body>

	@yield('content')

	@section('script')
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/kendoui/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/kendoui/kendo.web.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/kendoui/kendo.timezones.min.js') }}"></script>
	@show
</body>
</html>