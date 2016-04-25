'use strict';

erp.factory('CacheService', [function () {

	return {
		get: function(key) {
			return JSON.parse(localStorage.getItem(key));
		},
		set: function(key, val) {
			return localStorage.setItem(key, JSON.stringify(val));
		},
		unset: function(key) {
			return localStorage.removeItem(key);
		},
		clear:function(){
			return localStorage.clear();
		},
	};
}]);