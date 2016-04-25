'use strict';

erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
	$routeProvider.when('/inventory/nowday', {
		templateUrl: 'angular/views/inventory/nowday.html',
		controller: 'NowdayCtrl'
	}).when('/inventory/changes', {
		templateUrl: 'angular/views/inventory/changes.html',
		controller: 'ChangesCtrl'
	}).when('/inventory/dailies', {
		templateUrl: 'angular/views/inventory/dailies.html',
		controller: 'DailiesCtrl'
	}).when('/inventory/books', {
		templateUrl: 'angular/views/inventory/books.html',
		controller: 'BooksCtrl'
	}).when('/inventory/allocations', {
		templateUrl: 'angular/views/inventory/allocations.html',
		controller: 'AllocationsCtrl'
	})
	.when('/inventory/query', {
		templateUrl: 'angular/views/inventory/query/index.html',
		controller: 'Inventory/QueryCtrl'
	})
	.when('/inventory/detail', {
		templateUrl: 'angular/views/inventory/detail/index.html',
		controller: 'Inventory/DetailCtrl'
	})
	.when('/inventory/summary', {
		templateUrl: 'angular/views/inventory/summary/index.html',
		controller: 'Inventory/SummaryCtrl'
	})
	.when('/inventory/log', {
		templateUrl: 'angular/views/inventory/log/index.html',
		controller: 'Inventory/LogCtrl'
	})
	.when('/inventory/allot', {
		templateUrl: 'angular/views/inventory/allot/index.html',
		controller: 'Inventory/AllotCtrl'
	})
	.when('/inventory/allog', {
		templateUrl: 'angular/views/inventory/allog/index.html',
		controller: 'Inventory/AllogCtrl'
	})
	.when('/inventory/book', {
		templateUrl: 'angular/views/inventory/book/index.html',
		controller: 'Inventory/BookCtrl'
	})
	.when('/inventory/io', {
		templateUrl: 'angular/views/inventory/io/index.html',
		controller: 'Inventory/IOCtrl'
	})
	.when('/inventory/balance', {
		templateUrl: 'angular/views/inventory/balance/index.html',
		controller: 'Inventory/BalanceCtrl'
	})
	.when('/inventory/search', {
		templateUrl: 'angular/views/inventory/search/index.html',
		controller: 'Inventory/SearchCtrl'
	})
	;
}]);

erp.controller('Inventory/QueryCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.warehouse = _.chain(MetaService.whList()).unshift({id: '', name: ''}).value();
	$scope.items = MetaService.itemList();

	var store = MetaService.storeBuilder('inventory', 'query');

	$scope.search = {
		warehouse: '',
		status: {stocked: true, onroad: false},
		condition: {normal: true, likenew: false, used: false, defective: false},
	};

	$scope.list = {}
	
	$scope.searching = function() {
		var params = angular.copy($scope.search);
		params.sku = $scope.search.sku ? $scope.search.sku.id : '';
		params.status = _.map($scope.search.status, function(v, k) {return v == true ? (k == 'stocked' ? 1 : 0) : ''});
		params.condition = _.map($scope.search.condition, function(v, k) {return v == true ? k : ''});

		var list = store.query(params, function() {
			$scope.list = list;
		});
	};

}]);

erp.controller('Inventory/DetailCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.warehouse = _.chain(MetaService.whList()).unshift({id: '', name: ''}).value();
	$scope.items = MetaService.itemList();

	var store = MetaService.storeBuilder('inventory', 'inventory');
	
	$scope.search = {
		warehouse: '',
		//from: startDate,
		to: '',
		status: {stocked: true, onroad: false},
		condition: {normal: true, likenew: false, used: false, defective: false},
	};

	$scope.list = {}
	
	$scope.searching = function() {
		var params = angular.copy($scope.search);
		params.sku = $scope.search.sku ? $scope.search.sku.id : '';
		params.status = _.map($scope.search.status, function(v, k) {return v == true ? (k == 'stocked' ? 1 : 0) : ''});
		params.condition = _.map($scope.search.condition, function(v, k) {return v == true ? k : ''});

		var list = store.query(params, function() {
			$scope.list = list;
		});
	};

}]);

erp.controller('Inventory/SummaryCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.warehouse = _.chain(MetaService.whList()).unshift({id: '', name: ''}).value();
	$scope.types = MetaService.invTypeList();
	$scope.items = MetaService.itemList();
	$scope.agents = MetaService.userList();

	$scope.search = {
		warehouse: '',
		date: new Date(),
		status: {stocked: true, onroad: false},
		condition: {normal: true, likenew: false, used: false, defective: false}
	};

	var store = MetaService.storeBuilder('inventory', 'summary');

	$scope.searching = function() {
		var params = angular.copy($scope.search);
		params.sku = $scope.search.sku ? $scope.search.sku.id : '';
		params.status = _.map($scope.search.status, function(v, k) {return v == true ? (k == 'stocked' ? 1 : 0) : ''});
		params.condition = _.map($scope.search.condition, function(v, k) {return v == true ? k : ''});

		var list = store.query(params, function() {
			$scope.list = list;
			if(params.sku !='' && list.length > 0)
			{	
				
				params.id=params.sku;
				var logItems = store.query(params,function() {
					$scope.logItems = logItems;
				});
			}
		});
		
	};
}])

erp.controller('Inventory/LogCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.warehouse = _.chain(MetaService.whList()).unshift({id: '', name: ''}).value();
	$scope.types = MetaService.invTypeList();
	$scope.items = MetaService.itemList();
	$scope.agents = MetaService.userList();
	
	var today = new Date();
	$scope.search = {
		warehouse: '',
		from: new Date(today.getFullYear(), (today.getMonth()-1), 1),
		to: new Date(today.getFullYear(), (today.getMonth()), (today.getDate()+1)),
	};

	var store = MetaService.storeBuilder('inventory', 'log');

	$scope.searching = function() {
		var params = angular.copy($scope.search);
		params.sku = $scope.search.sku ? $scope.search.sku.id : '';
		params.agent = $scope.search.agent ? $scope.search.agent.id : '';

		var list = store.query(params, function() {
			$scope.list = list;
		});
	};

}]);

erp.controller('Inventory/IOCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.warehouse = _.chain(MetaService.whList()).unshift({id: '', name: ''}).value();
	$scope.types = MetaService.ioTypeList();
	$scope.items = MetaService.itemList();
	$scope.vendors = MetaService.vendorList();
	$scope.agents = MetaService.userList();

	$scope.search = {
		warehouse: '',
		from: new Date(),
		to: new Date()
	};

	var store = MetaService.storeBuilder('inventory', 'output');

	$scope.searching = function() {
		var params = angular.copy($scope.search);
		params.sku = $scope.search.sku ? $scope.search.sku.id : '';
		params.vendor = $scope.search.vendor ? $scope.search.vendor.id : '';
		params.agent = $scope.search.agent ? $scope.search.agent.id : '';

		var list = store.query(params, function() {
			$scope.list = list;
		});
	};
}]);

erp.controller('Inventory/BalanceCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.warehouse = _.chain(MetaService.whList()).unshift({id: '', name: ''}).value();
	$scope.items = MetaService.itemList();

	var today = new Date();
	$scope.search = {
		warehouse: '',
		from: new Date(today.getFullYear(), (today.getMonth()-3), 1),
		to: today
	};


	var store = MetaService.storeBuilder('inventory', 'balance');

	$scope.searching = function() {
		var params = angular.copy($scope.search);
		params.sku = $scope.search.sku ? $scope.search.sku.id : '';
		params.search_type = 'start';
		var start = store.query(params, function() {
			$scope.start = parseInt(start[0].balance);
		});

		params.search_type = 'list';
		var list = store.query(params, function() {
			$scope.list = list;

		});
		//alert(JSON.stringify(list));
	};
	
	$scope.getStartTotal=function()
	{	
		return $scope.start;
	};
	
	$scope.getEndTotal=function()
	{
		var sum=$scope.getStartTotal();
		for(var i in $scope.list)
		{
			sum += parseInt($scope.list[i].qty);
		}
		return sum;
	}
	
	$scope.getEndBalance=function(){
		if($scope.list.length>0)
		{
			var i=$scope.list.length-1;
			return $scope.list[i].balance;
		}
	}
	
	$scope.getRemainingAmount=function(sumIndex)
	{
		var sum=$scope.getStartTotal();
		for(var i in $scope.list)
		{
			if(i>sumIndex) break;
			sum += parseInt($scope.list[i].qty);
		}
		return sum;
	}

}]);


/// Book

erp.controller('Inventory/BookCtrl',[ '$scope','InventoryService','MetaService', function ($scope,InventoryService,MetaService){
	$scope.booklist=InventoryService.bookStore.query();
	$scope.skus = MetaService.itemList();
	
	$scope.getSkuByItemId=function(item_id)
	{
		for(var i in $scope.skus)
		{
			if($scope.skus[i].id == item_id)
			{
				return $scope.skus[i].sku;
			}
		}
		return "";
	}
	
	$scope.toFilter=function()
	{
		var params={};
		params.invoice=$scope.searchModel.invoice?$scope.searchModel.invoice:"";
		params.status =_.map($scope.searchModel.status, function(v, k) {return v == true ? k : ''});
		params.status =_.map($scope.searchModel.status, function(v, k) {return v == true ? k : ''});
		params.type =_.map($scope.searchModel.type, function(v, k) {return v == true ? k : ''});;
		params.timeFrom = $scope.searchModel.timeStart;
		params.timeTo = $scope.searchModel.timeEnd;
		
		var booklist = InventoryService.bookStore.query(params, function() {
			$scope.booklist = booklist;
		});
	}
}]);

erp.controller('NowdayCtrl', ['$scope', 'InventoryService', 'MetaService', 'factoryPaging', function ($scope, InventoryService, MetaService, factoryPaging) {
	$scope.invsSearch = {};

	$scope.warehouseLists = [{'name': '== 全部仓库 =='},
		{'id': 1, 'name': 'US-CA'},
		{'id': 2, 'name': 'CN-FUTIAN'}];
	$scope.invsSearch.warehouse = $scope.warehouseLists[0];

	$scope.itemLists = MetaService.itemList();

	var callback = function (pg, size) {
		var params = {};
		params.pg = pg || 1;
		params.size = size || 20;
		params.warehouse_id = $scope.invsSearch.warehouse ? $scope.invsSearch.warehouse.id : '';
		params.item_id = $scope.invsSearch.item ? $scope.invsSearch.item.id : '';
		params.status = $scope.invsSearch.status || '';

		$scope.inventories = InventoryService.nowday.query(params);
		return $scope.inventories;
	};

	$scope.invsSearch.size = 20;
	$scope.paging = factoryPaging(callback, $scope.invsSearch.size);

	$scope.cleanSearch = function () {
		$scope.invsSearch = {};
		$scope.invsSearch.warehouse = $scope.warehouseLists[0];
		$scope.paging.first();
	}
}]);

erp.controller('ChangesCtrl', ['$scope', 'InventoryService', 'MetaService', 'factoryPaging', function ($scope, InventoryService, MetaService, factoryPaging) {
	$scope.logsSearch = {};

	$scope.warehouseLists = [{'name': '== 全部仓库 =='},
		{'id': 1, 'name': 'US-CA'},
		{'id': 2, 'name': 'CN-FUTIAN'}];
	$scope.logsSearch.warehouse = $scope.warehouseLists[0];

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
	$scope.logsSearch.type = $scope.typeLists[0];

	$scope.itemLists = MetaService.itemList();

	var callback = function (pg, size) {
		var params = {};
		params.pg = pg || 1;
		params.size = size || 20;
		params.warehouse_id = $scope.logsSearch.warehouse ? $scope.logsSearch.warehouse.id : '';
		params.item_id = $scope.logsSearch.item ? $scope.logsSearch.item.id : '';
		params.type = $scope.logsSearch.type ? $scope.logsSearch.type.id : '';
		params.status = $scope.logsSearch.status || '';
		params.relation_id = $scope.logsSearch.relation_id || '';
		params.description = $scope.logsSearch.description || '';
		params.agent = $scope.logsSearch.agent || '';
		params.updated_from = $scope.logsSearch.updated_from || '';
		params.updated_to = $scope.logsSearch.updated_to || '';

		$scope.logs = InventoryService.changes.query(params);
		return $scope.logs;
	};

	$scope.logsSearch.size = 20;
	$scope.paging = factoryPaging(callback, $scope.logsSearch.size);

	$scope.cleanSearch = function () {
		$scope.logsSearch = {};
		$scope.logsSearch.warehouse = $scope.warehouseLists[0];
		$scope.logsSearch.type = $scope.typeLists[0];
		$scope.paging.first();
	}
}]);
