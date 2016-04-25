@extends('ui::layouts.master')

@section('css')
	@parent
	
	<link rel="stylesheet" href="{{ asset('packages/bluebanner/ui/css/pages/dashboard.css') }}" type="text/css" media="screen" charset="utf-8" />
@stop


@section('content')
<div class="span6">
	
	<div class="widget stacked">
	<div class="widget-header">
	<i class="icon-star"></i>
	<h3>Quick Stats</h3>
	</div> <!-- /widget-header -->
	<div class="widget-content">
	<div class="stats">
	<div class="stat">
	<span class="stat-value">12,386</span>									
	Site Visits
	</div> <!-- /stat -->
	<div class="stat">
	<span class="stat-value">9,249</span>									
	Unique Visits
	</div> <!-- /stat -->
	<div class="stat">
	<span class="stat-value">70%</span>									
	New Visits
	</div> <!-- /stat -->
	</div> <!-- /stats -->
	<div id="chart-stats" class="stats">
	<div class="stat stat-chart">							
	<div id="donut-chart" class="chart-holder"></div> <!-- #donut -->							
	</div> <!-- /substat -->
	<div class="stat stat-time">									
	<span class="stat-value">00:28:13</span>
	Average Time on Site
	</div> <!-- /substat -->
	</div> <!-- /substats -->
	</div> <!-- /widget-content -->
	</div>
	
	
</div>

<div class="span6">
	
<div class="widget stacked">
<div class="widget-header">
<i class="icon-bookmark"></i>
<h3>Quick Shortcuts</h3>
</div> <!-- /widget-header -->
<div class="widget-content">
<div class="shortcuts">
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-list-alt"></i>
<span class="shortcut-label">Apps</span>
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-bookmark"></i>
<span class="shortcut-label">Bookmarks</span>								
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-signal"></i>
<span class="shortcut-label">Reports</span>	
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-comment"></i>
<span class="shortcut-label">Comments</span>								
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-user"></i>
<span class="shortcut-label">Users</span>
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-file"></i>
<span class="shortcut-label">Notes</span>	
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-picture"></i>
<span class="shortcut-label">Photos</span>	
</a>
<a href="javascript:;" class="shortcut">
<i class="shortcut-icon icon-tag"></i>
<span class="shortcut-label">Tags</span>
</a>				
</div> <!-- /shortcuts -->	
</div> <!-- /widget-content -->
</div> <!-- /widget -->

</div>

@stop

@section('script')
	@parent
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/plugins/flot/jquery.flot.js') }}"></script>
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/plugins/flot/jquery.flot.pie.js') }}"></script>
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/plugins/flot/jquery.flot.resize.js') }}"></script>
	<script type="text/javascript" charset="utf-8" src="{{ asset('packages/bluebanner/ui/js/charts/donut.js') }}"></script>
	
@stop