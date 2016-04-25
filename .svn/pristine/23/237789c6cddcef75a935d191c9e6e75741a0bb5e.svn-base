'use strict';

erp.controller('NavbarController', ['$scope', '$rootScope', '$location', 'AuthenticationService', 'CacheService', function ($scope, $rootScope, $location, AuthenticationService, CacheService) {

	$rootScope.theme = CacheService.get('theme') || 'default';
	$scope.themes = ['default', 'amelia', 'cerulean', 'cosmo', 'cyborg', 'flatly', 'journal', 'readable', 'simplex', 'slate', 'spacelab', 'united'];

	$scope.swith_theme = function(theme) {
		$rootScope.theme = theme;
		CacheService.set('theme', theme);
	};

	$scope.routeIs = function(routeName) {
		return $location.path().indexOf(routeName) == 0;
	};

	$scope.show = function() {
		return AuthenticationService.isLoggedIn();	
	};

	$scope.user = CacheService.get('auth.user');

	$scope.logout = function() {
		AuthenticationService.logout(function() {
			$location.path('#/');
		});
	};
	
	$scope.RemoveAllLocalStorage=function(){
		CacheService.clear();
		$location.path('#/');
	};
	
}]);