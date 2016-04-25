'use strict';

erp.factory('StockService', ['$resource', function ($resource) {
	return {
		purchaseOrders: $resource('/api/stock/purchase'),
		purchaseOrder: $resource('/api/stock/purchase/:id', {id: '@id'}, {genStockIO: {method: 'PUT'}}),

		ioOrders: $resource('/api/stock/io'),
		ioOrder: $resource('/api/stock/io/:id', {id: '@id'}),
		toInventory: $resource('/api/stock/io/store/:id', {id: '@id'})
	};
}]);