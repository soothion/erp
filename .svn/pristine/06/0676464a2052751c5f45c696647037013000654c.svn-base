'use strict';

erp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {

	$routeProvider.
		otherwise({redirectTo: '/home'}).
		when('/login', {
			templateUrl: 'angular/views/login.html',
			controller: 'LoginController'
		}).
		when('/home', {
			controller: 'HomeController',
			templateUrl: 'angular/views/home.html'
		});

}]).run(['$rootScope', '$location', 'AuthenticationService', 'FlashService', function ($rootScope, $location, AuthenticationService, FlashService) {
	
	var routesThatDontRequireAuth = ['/login'];
	var routesThatForAdmins = ['/admin'];

	var routeClean = function (route) {
		return window.find(routesThatDontRequireAuth, function (noAuthRoute) {
			return window.str.startsWith(route, noAuthRoute);
		});
	};

	$rootScope.$on('$locationChangeStart', function (ev, to, toParams, from, fromParams) {

		if (!routeClean($location.url()) && !AuthenticationService.isLoggedIn()) {
			$location.path('/login');
		}
	});
}]);

erp.controller('HomeController', function HomeController($scope) {	
});