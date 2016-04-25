'use strict';

erp.factory('AuthenticationService', ['$resource', '$sanitize', 'CacheService', 'FlashService', 'CSRF_TOKEN', function ($resource, $sanitize, CacheService, FlashService, CSRF_TOKEN) {
	
	var store = $resource('/apilogin', {}, {
		login: {method: 'post'},
		logout: {method: 'get'}
	});
	
	var cacheSession = function() {
		CacheService.set('authenticated', true);
	};

	var uncacheSession = function() {
		CacheService.unset('authenticated', false);
	};

	var loginError = function(resp) {
		FlashService.show(resp.flash);
	};

	var sanitizeCredentials = function(credentials) {
		return {
			username: $sanitize(credentials.username),
			password: $sanitize(credentials.password),
			remenber: $sanitize(credentials.remenber),
			_token: CSRF_TOKEN
		};
	}

	return {
		login: function(credentials, success) {
			return store.login(sanitizeCredentials(credentials), function(rtn) {
				CacheService.set('auth.user', rtn);
				cacheSession();
				FlashService.clear();
				success();
			}, loginError);
		},
		logout: function(success) {
			return store.logout({}, function() {
				CacheService.unset('auth.user');
				uncacheSession();
				success();
			}, loginError);
		},
		isLoggedIn: function() {
			return CacheService.get('authenticated');
		}
	};
}]);