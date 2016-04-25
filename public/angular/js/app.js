'use strict';

var erp = angular.module('erp', ['ngResource', 'ngSanitize', 'ngCookies', 'ui.bootstrap', 'angularFileUpload']);

erp.config(['$httpProvider', function ($httpProvider) {
	var logsOutUser401 = function($location, $q, CacheService, FlashService) {

		var success = function(resp) {
			FlashService.clear();
			return resp;
		};;

		var error = function(resp) {
			if (resp.status === 401) {
				CacheService.unset('authenticated');
				$location.path('/login');
				FlashService.show(resp.data.error.message);
			};
			if (resp.status === 500) {
				FlashService.show(resp.data.error.message);
			};
			return $q.reject(resp);
		};

		return function(promise) {
			return promise.then(success, error);
		};
	};

	var interceptor = ['$q', 'LoadingIndicatorHandler', function($q, LoadingIndicatorHandler) {
		return function(promise) {
			LoadingIndicatorHandler.enable();

			return promise.then(function(response) {
				LoadingIndicatorHandler.disable();
				return response;
			}, function(response) {
				LoadingIndicatorHandler.disable();
				return $q.reject(response);
			});
		};
	}];

	$httpProvider.responseInterceptors.push(logsOutUser401);
	$httpProvider.responseInterceptors.push(interceptor);
}]);



erp.controller('LoginController', ['$scope', '$cookieStore', '$location', '$routeParams', 'AuthenticationService', function ($scope, $cookieStore, $location, $routeParams, AuthenticationService) {

	var rtn = $routeParams.rtn || '/';
	$scope.input = {username: 'test@test.com', password: 'test', remember: true};

	$scope.login = function() {
		var user = AuthenticationService.login($scope.input, function() {
			$location.path(rtn);
		});
	}

}]);

erp.factory('FlashService', ['$rootScope', function ($rootScope) {

	return {
		show: function(message) {
			$rootScope.flash = message;
		},
		clear: function() {
			$rootScope.flash = '';
		}
	};
}]);

erp.factory('LoadingIndicatorHandler', [function () {
	
	var $element = jQuery('#loading');

	return {

		enable_count: 0,
		disable_count: 0,

		enable: function() {
			this.enable_count++;
			if ($element.length) {
				$element.show();
			}
		},

		disable: function() {
			this.disable_count++;
			if (this.enable_count == this.disable_count) {
				if ($element.length) {
					$element.hide();
				}
			}
		}

	};
}])