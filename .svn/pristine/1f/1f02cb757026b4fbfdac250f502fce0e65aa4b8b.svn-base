'use strict';

erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
	$routeProvider.when('/system/channel', {
		templateUrl: 'angular/views/system/channel/index.html',
		controller: 'System/ChannelCtrl'
	}).when('/system/channel/edit/:id', {
		templateUrl: 'angular/views/system/channel/edit.html',
		controller: 'System/Channel/EditCtrl'
	}).when('/system/users', {
		templateUrl: 'angular/views/system/users/index.html',
		controller: 'System/UsersCtrl'
	}).when('/system/users/edit/:id', {
		templateUrl: 'angular/views/system/users/edit.html',
		controller: 'System/Users/EditCtrl'
	}).when('/system/groups', {
		templateUrl: 'angular/views/system/groups/index.html',
		controller: 'System/GroupsCtrl'
	}).when('/system/groups/edit/:id', {
		templateUrl: 'angular/views/system/groups/edit.html',
		controller: 'System/Groups/EditCtrl'
	});
}]);

erp.controller('System/ChannelCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.channels = MetaService.storeBuilder('system', 'channel').query();
}]);

erp.controller('System/Channel/EditCtrl', ['$scope', '$routeParams', '$location', 'MetaService', function ($scope, $routeParams, $location, MetaService) {
	var brand = ($routeParams.id == 'new');

	$scope.platforms = MetaService.platformList();

	$scope.channel = brand ? {} : MetaService.storeBuilder('system', 'channel').get({id: $routeParams.id}, function() {
		$scope.remote = angular.copy($scope.channel);
		$scope.channel.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.channel);
	};

	$scope.update = brand ? function() {
		MetaService.storeBuilder('system', 'channel').save($scope.channel, function() {
			$location.path('/system/channel');
		});
	} : function() {
		MetaService.storeBuilder('system', 'channel').update($scope.channel, function() {
			$location.path('/system/channel');
		});
	};

	$scope.destroy = function() {
		$scope.channel.$remove(function() {
			$location.path('/system/channel');
		});
	};
}]);

erp.controller('System/UsersCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	
	var store = MetaService.storeBuilder('system', 'user');

	$scope.users = store.query();


}]);

erp.controller('System/GroupsCtrl', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.groups = MetaService.storeBuilder('system', 'group').query();
}]);

erp.controller('System/Users/EditCtrl', ['$scope', '$routeParams', '$location', 'MetaService', function ($scope, $routeParams, $location, MetaService) {

	var brand = ($routeParams.id == 'new');

	$scope.adding = {'permission': 1};

	$scope.user = brand ? {
		permissions: {}
	} : MetaService.storeBuilder('system', 'user').get({id: $routeParams.id}, function() {
		$scope.remote = angular.copy($scope.user);
		$scope.user.$id = $routeParams.id;
	});

	$scope.groups = MetaService.storeBuilder('system', 'grouplist').query();

	$scope.permissions = MetaService.storeBuilder('system', 'permissions').query();

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.user);
	};

	$scope.addPermission = function() {
		if ( angular.isArray($scope.user.permissions)) {
			$scope.user.permissions = {};
		}
		$scope.user.permissions[$scope.adding.id] = $scope.adding.permission;
		$scope.adding = {'permission': 1};
	};

	$scope.update = brand ? function() {
		MetaService.storeBuilder('system', 'user').save($scope.user, function() {
			$location.path('/system/users');
		});
	} : function() {
		MetaService.storeBuilder('system', 'user').update($scope.user, function() {
			$location.path('/system/users');
		});
	};

	$scope.destroy = function() {
		$scope.user.$remove(function() {
			$location.path('/system/users');
		});
	};
}]);

erp.controller('System/Groups/EditCtrl', ['$scope', '$routeParams', '$location', 'MetaService', function ($scope, $routeParams, $location, MetaService) {
	
	var brand = ($routeParams.id == 'new');

	$scope.adding = {'permission': 1};

	$scope.permissions = MetaService.storeBuilder('system', 'permissions').query();

	$scope.group = brand ? {
		permissions: {}
	} : MetaService.storeBuilder('system', 'group').get({id: $routeParams.id}, function() {
		$scope.remote = angular.copy($scope.group);
		$scope.group.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.group);
	};

	$scope.addPermission = function() {
		if ( angular.isArray($scope.group.permissions)) {
			$scope.group.permissions = {};
		}
		$scope.group.permissions[$scope.adding.id] = $scope.adding.permission;
		$scope.adding = {'permission': 1};
	};

	$scope.update = brand ? function() {
		MetaService.storeBuilder('system', 'group').save($scope.group, function() {
			$location.path('/system/groups');
		});
	} : function() {
		MetaService.storeBuilder('system', 'group').update($scope.group, function() {
			$location.path('/system/groups');
		});
	};

	$scope.destroy = function() {
		$scope.group.$remove(function() {
			$location.path('/system/groups');
		});
	};
}]);