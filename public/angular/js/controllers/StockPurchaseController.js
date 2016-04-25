'use strict';

erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
	$routeProvider.when('/stock/purchase/lists', {
		templateUrl: 'angular/views/stock/purchase/lists.html',
		controller: 'PurchaseListsCtrl'
	}).when('/stock/purchase/show/:id', {
		templateUrl: 'angular/views/stock/purchase/show.html',
		controller: 'PurchaseShowCtrl'
	}).when('/stock/io/lists', {
		templateUrl: 'angular/views/stock/io/lists.html',
		controller: 'IOListsCtrl'
	}).when('/stock/io/show/:id', {
		templateUrl: 'angular/views/stock/io/show.html',
		controller: 'IOShowCtrl'
	});
}]);

erp.controller('PurchaseListsCtrl', ['$scope', 'StockService', 'MetaService', function ($scope, StockService, MetaService) {
	var curPage = 1;
	var size = 20;
	var params = {};
	var orders = {};
	$scope.ordersSearch = {};

	function getParams() {
		params.item_id = $scope.ordersSearch.item ? $scope.ordersSearch.item.id : '';
		params.description = $scope.ordersSearch.description || '';
		params.invoice = $scope.ordersSearch.invoice || '';
		params.pg = $scope.ordersSearch.pg || curPage;
		params.size = $scope.ordersSearch.size || size;
	}

	$scope.itemLists = MetaService.itemList();
	$scope.vendorLists = MetaService.vendorList();


	function getOrders() {
		getParams();
		$scope.orders = orders = StockService.purchaseOrders.query(params);
		return orders;
	}

	$scope.hasNextPage = function () {
		if (orders.length === size + 1) {
			$scope.orders = orders.slice(0, size);
			return true;
		}
		return false;
	};

	$scope.hasPrePage = function () {
		return curPage > 1;
	};

	$scope.goNextPage = function () {
		params.pg = curPage += 1;
		getOrders();
	};

	$scope.goPrePage = function () {
		params.pg = curPage -= 1;
		getOrders();
	};

	$scope.filterSearch = function () {
		params.pg = curPage = 1;
		getOrders();
	};

	$scope.cleanSearch = function () {
		$scope.ordersSearch = {};
		params = {};
		getOrders();
	};

	getOrders();
}]);

erp.controller('PurchaseShowCtrl', ['$scope', '$routeParams', 'StockService', function ($scope, $routeParams, StockService) {
	var order = {};
	$scope.order = order = StockService.purchaseOrder.get({id: $routeParams.id});

	$scope.isQtyFull = function (qty_rest) {
		return qty_rest == 0;
	};

	$scope.genStockIO = function () {
		StockService.purchaseOrder.genStockIO(order, function () {
			window.location.reload();
		});
	};
}]);

erp.controller('IOListsCtrl', ['$scope', '$routeParams', 'StockService', 'MetaService', 'factoryPaging', function ($scope, $routeParams, StockService, MetaService, factoryPaging) {
	$scope.ordersSearch = {};

	$scope.typeLists = [{'name': '== 所有类别 =='},
		{'category': '入库', 'name': '采购入库', 'value': 1},
		{'category': '入库', 'name': '盘盈入库', 'value': 2},
		{'category': '入库', 'name': '加工入库', 'value': 3},
		{'category': '入库', 'name': '调度入库', 'value': 4},
		{'category': '入库', 'name': '拆分入库', 'value': 5},
		{'category': '入库', 'name': '其他入库', 'value': 6},
		{'category': '出库', 'name': '盘亏出库', 'value': -2},
		{'category': '出库', 'name': '加工出库', 'value': -3},
		{'category': '出库', 'name': '调度出库', 'value': -4},
		{'category': '出库', 'name': '拆装出库', 'value': -5},
		{'category': '出库', 'name': '其他出库', 'value': -6},
		{'category': '其他', 'name': '取消关闭', 'value': 7},
		{'category': '其他', 'name': 'FBA Return', 'value': 8},
		{'category': '其他', 'name': 'RMA 回库', 'value': 9},
		{'category': '其他', 'name': '采购退货出库', 'value': 10}];
	$scope.ordersSearch.type = $scope.typeLists[0];

	$scope.statusLists = [{'name': '== 全部 =='},
		{'name': '已入库', 'value': 1},
		{'name': '未入库', 'value': 0}];
	$scope.ordersSearch.status = $scope.statusLists[0];

	$scope.warehouseLists = [{'name': '== 全部仓库 =='},
		{'id': 1, 'name': 'US-CA'},
		{'id': 2, 'name': 'CN-FUTIAN'}];
	$scope.ordersSearch.warehouse = $scope.warehouseLists[0];

	$scope.itemLists = MetaService.itemList();
	$scope.vendorLists = MetaService.vendorList();

	var callback = function (pg, size) {
		var params = {};
		params.pg = pg || 1;
		params.size = size || 20;
		params.invoice = $scope.ordersSearch.invoice || '';
		params.relation_invoice = $scope.ordersSearch.relation_invoice || '';
		params.item_id = $scope.ordersSearch.item ? $scope.ordersSearch.item.id : '';
		params.created_at_from = $scope.ordersSearch.created_at_from || '';
		params.exec_at_to = $scope.ordersSearch.exec_at_to || '';
		params.type = $scope.ordersSearch.type.value || '';
		params.status = $scope.ordersSearch.status.value == 0 || $scope.ordersSearch.status.value == 1 ? $scope.ordersSearch.status.value : '';
		params.warehouse_id = $scope.ordersSearch.warehouse.id || '';
		params.vendor_id = $scope.ordersSearch.vendor ? $scope.ordersSearch.vendor.id : '';

		$scope.orders = StockService.ioOrders.query(params);
		return $scope.orders;
	};

	$scope.ordersSearch.size = 20;
	$scope.paging = factoryPaging(callback, $scope.ordersSearch.size);

	$scope.cleanSearch = function () {
		$scope.ordersSearch = {};
		$scope.ordersSearch.type = $scope.typeLists[0];
		$scope.ordersSearch.status = $scope.statusLists[0];
		$scope.ordersSearch.warehouse = $scope.warehouseLists[0];
		$scope.paging.first();
	};
}]);

erp.controller('IOShowCtrl', ['$scope', '$routeParams', 'StockService', function ($scope, $routeParams, StockService) {
	$scope.order = StockService.ioOrder.get({id: $routeParams.id});

	$scope.stockIn = function () {
		StockService.toInventory.get({id: $routeParams.id}, function () {
			window.location.reload();
		});
	};
}]);