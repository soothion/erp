<!doctype html>
<html xmlns:ng="http://angularjs.org" id="ng-app" ng-app="erp">
<head>
	<!--[if lte IE 8]>
      <script src="/path/to/json2.js"></script>
    <![endif]-->
	<title>蓝帜进销存管理系统 V2.0</title>
	<link rel="stylesheet" type="text/css" href="[[ asset('packages/bluebanner/ui/bootstrap/css/bootstrap.min.css') ]]" media="screen">
	<link rel="stylesheet" type="text/css" ng-show="theme" ng-href="[[ asset('packages/bluebanner/ui/bootstrap/css/bootstrap-') ]]{{theme}}.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="[[ asset('angular/css/token-input-facebook.css') ]]">
</head>
<body>

	<div class="navbar-fixed-bottom"><span id="loading" class="label label-default pull-right">loading</span></div>

	<div class="navbar navbar-default ng-cloak" ng-show="show()" ng-controller="NavbarController" >
		<a class="navbar-brand" href="#/home">蓝帜进销存管理系统</a>
		<ul class="nav navbar-nav">
			<li ng-class="{active: routeIs('/home')}">
				<a href="#/home">仪表盘</a>
			</li>
			<li class="dropdown" ng-class="{active: routeIs('/item')}">
				<a data-toggle="dropdown" href="">产品管理 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li><a href="#/item">产品列表</a></li>
					<li><a href="#/item/upload">上传新产品</a></li>
					<li><a href="#/item/image">上传图片</a></li>
					<li class="divider"></li>
					<li><a href="#/item/customs">关税</a></li>
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/item/category')}"><a href="#/item/category">产品分类管理</a></li>
					<li ng-class="{active: routeIs('/item/language')}"><a href="#/item/language">产品语言管理</a></li>
					<li ng-class="{active: routeIs('/item/attribute')}"><a href="#/item/attribute">产品属性管理</a></li>
					<li class="divider"></li>
					<li class="disabled"><a href="javascript:;">BOM</a></li>
					<li class="disabled"><a href="javascript:;">Mail Class Mapping</a></li>
					<li class="disabled"><a href="javascript:;">Packing Class Mapping</a></li>
					<li class="disabled"><a href="javascript:;">PI Mapping</a></li>
					<li class="disabled"><a href="javascript:;">Item Select</a></li>
				</ul>
			</li>
			<li class="dropdown" ng-class="{active: routeIs('/purchase')}">
				<a data-toggle="dropdown" href="">采购管理 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li ng-class="{active: routeIs('/purchase/request')}"><a href="#/purchase/request"><i class="glyphicon glyphicon-send"></i> 申购单填写</a>
						
					</li>
					<li ng-class="{active: routeIs('/audit/pr')}"><a href="#/audit/pr"><i class="glyphicon glyphicon-ok-circle"></i> 申购单审核</a></li>
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/purchase/plan')}"><a href="#/purchase/plan"><i class="glyphicon glyphicon-compressed"></i> 采购计划</a></li>
					<!-- <li ng-class="{active: routeIs('/purchase/assign')}"><a href="#/purchase/assign">申购汇总</a></li> -->
					<!-- <li ng-class="{active: routeIs('/purchase/check')}"><a href="#/purchase/check">汇总审核</a></li> -->
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/purchase/exec')}"><a href="#/purchase/exec">采购执行</a></li>
					<!-- 
					<li ng-class="{active: routeIs('/purchase/pp2po')}"><a href="#/purchase/pp2po">计划生成采购</a></li>
					 -->
					 <!-- 
					<li ng-class="{active: routeIs('/purchase/ship')}"><a href="#/purchase/ship">调度计划执行</a></li>
					 -->
					<!--li ng-class="{active: routeIs('/purchase/assign')}">
						<a href="#/purchase/assign">采购执行</a>
						<ul class="dropdown">
							<li><a href="#/purchase/plan">采购计划表</a></li>
							<li><a href="#/purchase/assign">申购汇总</a></li>
							<li><a href="#/purchase/exec">采购执行</a></li>
							<li><a href="#/">收发货明细表</a></li>
						</ul>
					</li-->
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/purchase/order')}"><a href="#/purchase/order">采购单</a></li>
					<!-- <li ng-class="{active: routeIs('/purchase/mergeOrder')}"><a href="#/purchase/mergeOrder">合并采购单</a></li> -->
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/purchase/return')}">
						<a href="#/purchase/return">采购退货单</a>
					</li>
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/purchase/vendor')}"><a href="#/purchase/vendor">供应商列表</a></li>
					<li ng-class="{active: routeIs('/purchase/quotation')}"><a href="#/purchase/quotation">供应商报价</a></li>
					<li ng-class="{active: routeIs('/purchase/packing')}"><a href="#/purchase/packing">SKU的默认值设置</a></li>
					
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/purchase/costparams')}"><a href="#/purchase/costparams">运费系数</a></li>

				</ul>
			</li>
			<li class="dropdown" ng-class="{active: routeIs('/inventory')}">
				<a data-toggle="dropdown" href="">库存管理 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
          <li ng-class="{active: routeIs('/inventory/nowday')}"><a href="#/inventory/nowday">库存查询</a></li>
          <li ng-class="{active: routeIs('/inventory/changes')}"><a href="#/inventory/changes">库存明细</a></li>
          <li ng-class="{active: routeIs('/inventory/dailies')}"><a href="#/inventory/dailies">库存日志</a></li>
          <li ng-class="{active: routeIs('/inventory/books')}"><a href="#/inventory/books">库存 Boook 日志</a></li>
          <li ng-class="{active: routeIs('/inventory/allocations')}"><a href="#/inventory/allocations">库存调拨日志</a></li>
					<!--<li ng-class="{active: routeIs('/inventory/query')}"><a href="#/inventory/query">库存查询</a></li>
					<li ng-class="{active: routeIs('/inventory/detail')}"><a href="#/inventory/detail">库存明细</a></li>
					<li ng-class="{active: routeIs('/inventory/summary')}"><a href="#/inventory/summary">库存报表</a></li>
					<li ng-class="{active: routeIs('/inventory/log')}"><a href="#/inventory/log">库存日志</a></li>
					<li ng-class="{active: routeIs('/inventory/book')}"><a href="#/inventory/book">库存BOOK日志</a></li>-->
					<li class="divider"></li>
					<li class="disabled" ng-class="{active: routeIs('/inventory/allot')}"><a href="javascript:;">库存调拨</a></li><!--#/inventory/allot-->
					<li class="disabled" ng-class="{active: routeIs('/inventory/allog')}"><a href="javascript:;">库存调拨日志</a></li><!--#/inventory/allog-->
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/inventory/io')}"><a href="#/inventory/io">出入库明细报表</a></li>
					<li ng-class="{active: routeIs('/inventory/balance')}"><a href="#/inventory/balance">仓库出入库平衡表</a></li>
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/inventory/search')}"><a href="#/inventory/search">出入库查询(打印)</a></li>
				</ul>
			</li>
			<li class="dropdown" ng-class="{active: routeIs('/warehouse')}">
				<a data-toggle="dropdown" href="">仓储管理 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li ng-class="{active: routeIs('/warehouse/list')}"><a href="#/warehouse/list">仓库列表</a></li>
					<li ng-class="{active: routeIs('/warehouse/IOList')}" class="dropdown" >
						<a href="#/warehouse/IOList" >出入库单列表</a>	
						<ul class="dropdown">
							<li><a href="#/warehouse/IOList/out">出库单</a></li>
							<li><a href="#/warehouse/IOList/in">入库单</a></li>
						</ul>				
					</li>
					<li ng-class="{active: routeIs('/warehouse/otherIOInventory')}"><a href="#/warehouse/otherIOInventory">其他出入库单</a></li>	
					<li class="divider"></li>				
					<li ng-class="{active: routeIs('/warehouse/counting')}"><a href="#/warehouse/counting">仓库盘点</a></li>					
					<li ng-class="{active: routeIs('/warehouse/rmaList')}"><a href="#/warehouse/rmaList">RMA回库</a></li>
					<li ng-class="{active: routeIs('/warehouse/dispatch')}"><a href="#/warehouse/dispatch">仓库调度</a></li>

          <li class="divider"></li>
          <li ng-class="{active: routeIs('/stock/purchase/lists')}"><a href="#/stock/purchase/lists">待采购入库单</a></li>

          <li class="divider"></li>
          <li ng-class="{active: routeIs('/stock/io/lists')}"><a href="#/stock/io/lists">出入库单日志</a></li>
				</ul>
			</li>

			<li class="dropdown" ng-class="{active: routeIs('/system')}">
				<a data-toggle="dropdown" href="">系统管理 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li ng-class="{active: routeIs('/platform')}"><a href="#/platform">平台管理</a></li>
					<li ng-class="{active: routeIs('/system/channel')}"><a href="#/system/channel">渠道管理</a></li>
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/system/users')}"><a href="#/system/users">用户管理</a></li>
					<li ng-class="{active: routeIs('/system/groups')}"><a href="#/system/groups">用户组管理</a></li>
				</ul>
			</li>

			<li class="dropdown" ng-class="{active: routeIs('/ship')}">
				<a data-toggle="dropdown" href="">发货 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">Prepare Orders</a></li>
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">Packing List</a></li>
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">Labels</a></li>
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">Tracking</a></li>
					<li class="divider"></li>
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">Prepare规则</a></li>
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">运输方式</a></li>
					<li ng-class="{active: routeIs('/ship')}"><a href="#/ship">SKU发货规则</a></li>
				</ul>
			</li>
			<li>
				<a ng-click="logout()" href="javascript:;">退出 ({{user.email}})</a> 
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li ng-class="{active: routeIs('/help')}">
				<a href="#/help"><i class="glyphicon glyphicon-question-sign"></i></a>
			</li>
			<li>
				<a title="删除本地缓存" ng-click="RemoveAllLocalStorage()"><i class="glyphicon glyphicon-remove-circle"></i></a>
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">风格 <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li ng-class="{active: t==theme}" ng-repeat="t in themes">
						<a href ng-click="swith_theme(t)">{{t}}</a>
					</li>
				</ul>
			</li>
		</ul>

	</div>

 	<div class="container-fluid ng-cloak" ng-show="flash">
		<div class="alert alert-danger">
		    <strong>{{flash}}</strong>
		</div>
 	</div>


	<div class="container-fluid">
		<div ng-view></div>
	</div>

	<!-- bootstrap -->
	<script type="text/javascript" src="[[ asset('packages/bluebanner/ui/js/libs/jquery-1.8.3.min.js') ]]"></script>
	<script type="text/javascript">
		jQuery.noConflict();
	</script>
	<script type="text/javascript" src="[[ asset('packages/bluebanner/ui/bootstrap/js/bootstrap.min.js') ]]"></script>

	<!-- libs -->
	<script type="text/javascript" src="[[ asset('angular/js/lib/angular.min.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/lib/i18n/angular-locale_zh-cn.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/lib/angular-resource.min.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/lib/angular-cookies.min.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/lib/angular-sanitize.min.js') ]]"></script>

	<!-- 3rd libs -->
	<script type="text/javascript" src="[[ asset('angular/js/pkgs/ui-bootstrap-tpls-0.5.0.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/pkgs/underscore-min.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/pkgs/jquery.tokeninput.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/pkgs/angular-file-upload.min.js') ]]"></script>

	<!-- app -->
	<script type="text/javascript" src="[[ asset('angular/js/app.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/HomeController.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/NavbarController.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/PlatformController.js') ]]"></script>

	<!-- global services -->
	<script type="text/javascript" src="[[ asset('angular/js/services/meta.js') ]]"></script>

	<!-- directives -->
	<script type="text/javascript" src="[[ asset('angular/js/directives/tokenInput.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/directives/EtaDatePicker.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/directives/validNumber.js') ]]"></script>

	<!-- filters -->
	<script type="text/javascript" src="[[ asset('angular/js/filters/inventory.js') ]]"></script>

	<!-- Auth -->
	<script type="text/javascript" src="[[ asset('angular/js/services/auth.js') ]]"></script>

	<!-- Cache -->
	<script type="text/javascript" src="[[ asset('angular/js/services/cache.js') ]]"></script>

	<!-- Pagination -->
	<script type="text/javascript" src="[[ asset('angular/js/services/paginator.js') ]]"></script>
  <script type="text/javascript" src="[[ asset('angular/js/services/paging.js') ]]"></script>

	<!-- Item Module -->
	<script type="text/javascript" src="[[ asset('angular/js/services/item.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/ItemController.js') ]]"></script>

	<!-- Purchase Module -->
	<script type="text/javascript" src="[[ asset('angular/js/services/purchase.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/PurchaseController.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/PurchasePlanController.js') ]]"></script>

	<!-- Inventory Module -->
	<script type="text/javascript" src="[[ asset('angular/js/services/inventory.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/InventoryController.js') ]]"></script>

	<!-- Warehouse Module -->
	<script type="text/javascript" src="[[ asset('angular/js/services/warehouse.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/services/ng-upload.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/WarehouseController.js') ]]"></script>

	<!-- Storage Module -->
	<script type="text/javascript" src="[[ asset('angular/js/controllers/StorageController.js') ]]"></script>

  <script type="text/javascript" src="[[ asset('angular/js/services/stock.js') ]]"></script>
  <script type="text/javascript" src="[[ asset('angular/js/controllers/StockPurchaseController.js') ]]"></script>

	<!-- System Module -->
	<script type="text/javascript" src="[[ asset('angular/js/services/system.js') ]]"></script>
	<script type="text/javascript" src="[[ asset('angular/js/controllers/SystemController.js') ]]"></script>

	<!-- csrf config -->
	<script type="text/javascript">
	angular.module('erp').constant('CSRF_TOKEN', '<?php echo csrf_token(); ?>');
	</script>

</body>
</html>