'use strict';

erp.factory('ItemService', ['$resource', 'CacheService', function ($resource, CacheService) {

	return {

		getItemList: function() {
			var items = CacheService.get('item.list');
			if (!items) {
				console.log('data fetching...');
				items = this.itemStore.query(function() {
					CacheService.set('item.list', items);
				});
			};
			return items;
		},

		 queues: $resource('/api/item/queues'),
       
        imageQueues: $resource('/api/item/imageQueues'),
        imageUploadStore: $resource('/api/item/imageUpload/',{},  {imageUpload: {method: 'POST'}}),
        
		metaStore: $resource('/api/item/meta/:key/:id', {key: '@key', id: '@id'}),
		
		itemSimpleImagesStore: $resource('/api/item/simpleItemImages/:id', {id: '@id'}),

		itemStore: $resource('/api/item/info/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		
		itemTestStore: $resource('http://bbc.apiary-mock.com/api/purchase/request/options/warehouse', {}, {update: {method: 'PUT'}}),

		imageStore: $resource('/api/item/image/:id', {id: '@id'}, {update: {method: 'POST'}}),

		cateStore: $resource('/api/item/categories/:id', {id: '@id'}, {update: {method: 'PUT'}}),

		langStore: $resource('/api/item/languages/:id', {id: '@id'}, {update: {method: 'PUT'}}),

		attributeStore: $resource('/api/item/attributes/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		
		customStore:$resource('/api/item/customs/:id', {id: '@id'},{update: {method: 'PUT'}})

	};
}])