'use strict';

erp.factory('SessionService', [function () {

	return {
		get: function(key) {
			return JSON.parse(sessionStorage.getItem(key));
		},
		set: function(key, val) {
			return sessionStorage.setItem(key, JSON.stringify(val));
		},
		unset: function(key) {
			return sessionStorage.removeItem(key);
		}
	};
}]);