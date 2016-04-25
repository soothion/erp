'use strict';

erp.config(['$routeProvider', function ($routeProvider) {
	$routeProvider.when('/storage', {
		templateUrl: 'angular/views/storage/index.html',
		controller: 'StorageCtrl'
	}).when('/storage/:id', {
		templateUrl: 'angular/views/storage/edit.html',
		controller: 'StorageEditCtrl'
	});
}]);

erp.controller('StorageCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.whList = MetaService.whList();
	// 当前仓库
	$scope.current_wh = 0;

	// 当前节点
	$scope.current_node = 0;

	// 父路径
	$scope.node_path = [];

	var store = MetaService.storeBuilder('storage', 'container');

	$scope.label = function (id) {
		return _.find($scope.child, function (container) { return container.id == id;});
	}

	$scope.switch_wh = function (id, parent) {
		parent = parent ? parent : 0;
		$scope.current_wh = id;
		$scope.node_path = [];
		store.query({id: id}, function (data) {
			$scope.child = data;
			$scope.remote = angular.copy(data);
			$scope.show(parent);
		});
	};

	$scope.show = function (parent) {
		$scope.current_node = parent;
		$scope.node_path = _.filter($scope.node_path, function (node) { return node < parent;});
		$scope.node_path.push(parent);

		$scope.list = _.filter($scope.child, function (item) { return item.parent_id == parent});
	};

	$scope.create_container = function (id) {
		$scope.container_new = {
			warehouse_id: id,
			parent_id: $scope.current_node,
		};
		jQuery('.modal').modal();
	};

	$scope.save_container = function () {
		store.save($scope.container_new, function () {
			$scope.switch_wh($scope.current_wh, $scope.current_node);
			jQuery('.modal').modal('hide');
		});
	};

	$scope.update_container = function (id) {
		var child = _.find($scope.child, function(container) {
			return container.id == id;
		});
		store.update(child, function(container) {
			var remote = _.find($scope.remote, function(remote) {
				return remote.id == container.id;
			});
			remote.desc = container.desc;
			remote.barcode = container.barcode;
			remote.png = container.png;
			child.png = container.png;
		});
	};

	$scope.reset_container = function (id) {
		var current = _.find($scope.child, function(child) {
			return child.id == id;
		});
		var remote = _.find($scope.remote, function(remote) {
			return remote.id == id;
		});
		current.desc = remote.desc;
		current.barcode = remote.barcode;
	}

	$scope.isClean = function (id) {

		return angular.equals(_.find($scope.remote, function(container) {
			return container.id == id;
		}), _.find($scope.child, function(container) {
			return container.id == id;
		}));

	}

}]);

erp.controller('StorageEditCtrl', ['$scope', '$routeParams', 'MetaService', function ($scope, $routeParams, MetaService) {
	$scope.wh = _.find(MetaService.whList(), $routeParams.id);
}]);