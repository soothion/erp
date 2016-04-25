'use strict';

erp.factory('InventoryService', ['$resource', function ($resource) {

	return {
		nowday: $resource('/api/inventory/nowday'),
		changes: $resource('/api/inventory/changes'),
		dailies: $resource('/api/inventory/dailies'),
		books: $resource('/api/inventory/books'),
		allocations: $resource('/api/inventory/allocations'),
		bookStore: $resource('/api/inventory/book/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		last_element_holder: null
	};
}])