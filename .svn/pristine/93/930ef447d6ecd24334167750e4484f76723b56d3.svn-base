'use strict';

erp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {

	$routeProvider.when('/platform', {
			controller: 'PlatformController',
			templateUrl: 'angular/views/platform.html'
		}).when('/platform/edit/:id', {
			templateUrl: 'angular/views/platformedit.html',
			controller: 'PlatformEditController'
		}).when('/platform/new', {
			templateUrl: 'angular/views/platformedit.html',
			controller: 'PlatformNewController'
		});
}]);

erp.controller('PlatformController', ['$scope', 'MetaService', function ($scope, MetaService) {
	$scope.platforms = MetaService.store.query({module: 'platforms'});
}]);

erp.controller('PlatformEditController', ['$scope', '$location', '$resource', '$routeParams', function ($scope, $location, $resource, $routeParams) {

	var store = $resource('/api/platforms/:id', {id: '@id'}, {update: {method:'PUT'}});

	var platform = store.get({id:$routeParams.id}, function () {
		$scope.platform = platform;
		$scope.remote = angular.copy(platform);
		$scope.platform.$id = $routeParams.id;
	});

	$scope.isClean = function () {
		return angular.equals($scope.remote, $scope.platform);
	}

	$scope.update = function () {
		platform.$update(function (){
			$location.path('/platform');
		}, function (error) {
			console.log(error.data.error.message);
		});
	}

	$scope.destroy = function () {
		platform.$remove(function () {
			$location.path('/platform');
		}, function (error) {
			console.log(error.data.error.message);
		});
	}
	
}]);

erp.controller('PlatformNewController', ['$scope', '$location', 'MetaService', function ($scope, $location, MetaService) {
	$scope.update = function () {
		MetaService.store.save({module: 'platforms'}, $scope.platform, function () {
			$location.path('/platform');
		}, function (error) {
			console.log(error.data.error.message);
		});
	}
}]);