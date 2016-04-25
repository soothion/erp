'use strict';

erp.factory('WarehouseService', ['$resource', function ($resource) {

	return {
		warehouse: $resource('/api/warehouse/list/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		rma: $resource('/api/warehouse/rmaList/:id', {id: '@id'}, {update: {method: 'PUT'},confirm:{method:'PUT',params:{type:'confirmed'}},destory:{method: 'DELETE'}}),
		otherIOInventoryStore: $resource('/api/warehouse/otherIOInventoryStore/:id', {id: '@id'}, {update: {method: 'PUT'},confirm:{method:'PUT',params:{type:'confirmed'}},destory:{method: 'DELETE'} }),
		//otherIOUpdateStore: $resource('/api/warehouse/otherIOInventoryStore/:id/edit', {id: '@id'}, {getone: {method: 'GET'}}),
		IOListStore: $resource('/api/warehouse/IOList/:id', {id: '@id'}, {update: {method: 'PUT'},destory:{method: 'DELETE'},book:{method:'PUT'},unbook:{method:'PUT'}}),		
		IOPurchase:  $resource('/api/warehouse/IOPurchase/:id', {id: '@id'}, {showPrint:{method:'POST'}}),
		rmaRepending:  $resource('/api/warehouse/rmaReturn/:id', {id: '@id'}, {returnPending:{method:'POST'}}),
		rmaGenerate:  $resource('/api/warehouse/rmaGen/:id', {id: '@id'}, {generate:{method:'POST'}}),
		otherIOGenerateStore: $resource('/api/warehouse/otherIOGenerate/:id', {id: '@id'}, {generate:{method:'POST'}}),
		otherIOSpecailStore: $resource('/api/warehouse/otherIOSpecailStore/:id', {id: '@id'}, {updateSkus:{method:'POST',params:{type:'updateSkus'}},setDetail:{method:'POST',params:{type:'setDetail'}},setAllDetails:{method:'POST',params:{type:'setAllDetails'}},returnPending:{method:'POST',params:{type:'returnPending'}}}),
		WHCountingStore: $resource('/api/warehouse/WHCounting/:id', {id: '@id'}, {update: {method: 'PUT'},confirm:{method:'PUT',params:{type:'confirmed'}},checking:{method:'PUT',params:{type:'check'}},generate:{method:'PUT',params:{type:'generate'}},returnPending:{method:'PUT',params:{type:'returnPending'}},destory:{method: 'DELETE'} }),
		WHShipStore: $resource('/api/warehouse/dispatch/:id', {id: '@id'}, {update: {method: 'PUT'},confirm:{method:'PUT',params:{type:'confirmed'}},checking:{method:'PUT',params:{type:'check'}},generate:{method:'PUT',params:{type:'generate'}},returnPending:{method:'PUT',params:{type:'returnPending'}},updateSkus:{method:'PUT',params:{type:'updateSkus'}},setAllDetails:{method:'PUT',params:{type:'setAllDetails'}},updateBoxId:{method:'PUT',params:{type:'updateBoxId'}},destory:{method: 'DELETE'} }),
		WHShipSpeStore: $resource('/api/warehouse/dispatchSpecail/:id', {id: '@id'}, {confirm:{method:'PUT',params:{type:'confirmed'}},checking:{method:'PUT',params:{type:'check'}},generate:{method:'PUT',params:{type:'generate'}},returnPending:{method:'PUT',params:{type:'returnPending'}},updateSkus:{method:'PUT',params:{type:'updateSkus'}},setAllDetails:{method:'PUT',params:{type:'setAllDetails'}},updateBoxId:{method:'PUT',params:{type:'updateBoxId'}} }),
		
		last_element_holder: null
	};
}])