'use strict';

erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
	// 	when('/purchase/plan', {
	// 	templateUrl: 'angular/views/purchase/plan/index.html',
	// 	controller: 'planCtrl'
	// }).
	// when('/purchase/plan/new', {
	// 	templateUrl: 'angular/views/purchase/plan/detail.html',
	// 	controller: 'planNewCtrl'
	// }).
	// when('/purchase/plan/edit/:id', {
	// 	templateUrl: 'angular/views/purchase/plan/edit.html',
	// 	controller: 'planEditCtrl'
	// }).
	$routeProvider.when('/purchase/plan', {
		templateUrl: 'angular/views/purchase/plan/index.html',
		controller: 'Purchase/PlanCtrl'
	})
	.when('/purchase/plan/edit/:id', {
		templateUrl: 'angular/views/purchase/plan/edit.html',
		controller: 'Purchase/PlanEditCtrl'
	});
}]);

erp.controller('Purchase/PlanCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {

	$scope.load = function() {
		MetaService.store.query({module: 'purchase', service: 'plan'}, function(rtn) {
			$scope.plans = rtn;
		});

		MetaService.store.query({module: 'purchase', service: 'plan-free'}, function(rtn) {
			$scope.free = rtn;
		});
	};

	$scope.load();

	$scope.add_to_plan = function() {
		MetaService.store.get({module: 'purchase', service: 'plan-add'}, function(rtn) {
			$scope.load();
		});
	};

	$scope.create_to_plan = function() {
		MetaService.store.save({module: 'purchase', service: 'plan-create'}, {name: $scope.new_plan_name}, function(rtn) {
			$scope.load();
		});
	};
}]);

erp.controller('Purchase/PlanEditCtrl', ['$scope', '$route', '$location', '$routeParams', 'MetaService', function ($scope, $route, $location, $routeParams, MetaService) {

	// scope init
	$scope.plan = {status: 'confirmed'};

	MetaService.store.get({module: 'purchase', service: 'plan'}, {id: $routeParams.id}, function(rtn) {
		rtn.warehouse = {};
		$scope.plan = rtn;
	});

	MetaService.store.query({module: 'purchase', service: 'cwlist'}, function(rtn) {
		$scope.cwlist = rtn;
	});

	MetaService.store.query({module: 'warehouse', service: 'list'}, function(rtn) {
		$scope.whlist = rtn;
	});

	$scope.load = function() {
		MetaService.store.query({module: 'purchase', service: 'plan-summary'}, {id: $routeParams.id}, function(rtn) {
			$scope.summary = {};
			$scope.persistent = {};
			angular.forEach(rtn, function(v, k) {
				$scope.summary[v.item_id] = v;
				$scope.persistent[v.item_id] = angular.copy(v);
			});
		});

		MetaService.store.query({module: 'purchase', service: 'plan-change'}, {id: $routeParams.id}, function(rtn) {
			$scope.changes = rtn;
		});

		MetaService.store.query({module: 'purchase', service: 'plan-free'}, function(rtn) {
			$scope.free = rtn;
		});
	};

	$scope.load();

	$scope.delta = function(id) {
		var n = 0;
		angular.forEach($scope.cwlist, function(v, k) {
			n = n + ($scope['summary'][id][v.name + '-' + v.transportation] - $scope['persistent'][id][v.name + '-' + v.transportation]);
		});
		return n;
	};

	$scope.save = function() {
		MetaService.store.update({module: 'purchase', service: 'plan', id: $routeParams.id}, {plan: $scope.plan, detail: $scope.summary}, function(rtn) {
			alert('修改采购计划成功!');
			$scope.load();
		});
	};

	$scope.confirm = function() {
		MetaService.store.update({module: 'purchase', service: 'plan-confirm', id: $routeParams.id}, function(rtn) {
			alert('计划表确认成功！');
			$location.path('/purchase/plan/');
		});
	};

	$scope.isDirty = function(id, wh, trans) {
		return $scope['persistent'][id][wh + '-' + trans] != $scope['summary'][id][wh + '-' + trans];
	};

	$scope.isClean = function() {
		return angular.equals($scope.summary, $scope.persistent);
	};

	$scope.canModify = function() {
		return $scope.plan.status == 'open';
	};

	$scope.add_to_plan = function() {
		MetaService.store.get({module: 'purchase', service: 'plan-add'}, function(rtn) {
			$scope.load();
		});
	};
}]);