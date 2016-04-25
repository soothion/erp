'use strict';

erp.factory('PurchaseService', ['$resource', function ($resource) {
	return {
		requestQueues: $resource('/api/purchase/requestQueues'),
		vendorStore: $resource('/api/purchase/vendor/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		quotationStore: $resource('/api/purchase/quotation/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		planStore: $resource('/api/purchase/plan/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		spePlanStore: $resource('/api/purchase/spePlan', {type: '@type'}),
		checkPlanStore: $resource('/api/purchase/check', {type: '@type'}),
		assignStore: $resource('/api/purchase/assign/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		revertAssignStore: $resource('/api/purchase/revertAssign', {}, {update: {method: 'PUT'}}),
		execStore: $resource('/api/purchase/exec/:id', {id: '@id'}, {update: {method: 'PUT'},getDetailList: {method: 'GET',isArray:true},confirmList:{method:'GET',isArray:true,params:{id:"confirmed"}}}),
		shipStore: $resource('/api/purchase/ship/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		shipSplitStore: $resource('/api/purchase/shipSplit/:id', {id: '@id'}, {shipSplit: {method: 'POST'}}),
		turnShipStore: $resource('/api/purchase/turnShip/:id', {id: '@id'}, {turnship: {method: 'POST'}}),
		turnOrderStore: $resource('/api/purchase/turnOrder/:id', {id: '@id'}, {turnorder: {method: 'POST'}}),
		batchUpdateStore: $resource('/api/purchase/exec/batchUpdate/:id', {id: '@id'}, {batchUpdate: {method: 'POST'}}),
		batchUpdateQtyStore: $resource('/api/purchase/exec/batchUpdateQty/:id', {id: '@id'},{batchUpdateQty: {method: 'POST'}}),
		exportStore: $resource('/api/purchase/exec/exports/:id', {id: '@id'},{exports: {method: 'POST'}}),
		requestStore: $resource('/api/purchase/request/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		requestImport: $resource('/api/purchase/requestImport/:id', {id: '@id'}, {requestImport: {method: 'POST'}}),
		orderReturn: $resource('/api/purchase/orderReturn/:id', {id: '@id'}, {orderReturn: {method: 'PUT'}}),
		//orderStore: $resource('/api/purchase/order/:id', {id: '@id'}, {update: {method: 'PUT'},destroy:{method: 'DELETE'},unconfirm:{method:'PUT',params:{type:'unconfirm'}},confirm:{method:'PUT',params:{type:'confirm'}}}),
		orderStore: $resource('/api/purchase/po/:operation/:id', {id: '@id'}, {update: {method: 'PUT'},destroy:{method: 'DELETE'},confirm:{method:'GET'}, invoice: {method: 'GET'},merge:{method:'POST',params:{operation:'merge'}}, generate: {method: 'POST', params: {operation: 'generate'}}}),
		returnStore: $resource('/api/purchase/return/:id', {id: '@id'}, {update: {method: 'PUT'},destory:{method: 'DELETE'},generate:{method: 'POST'}}),
		returnSpecailStore: $resource('/api/purchase/returnSpecail/:id', {id: '@id'}, {updateSkus:{method:'POST',params:{type:'updateSkus'}},setDetail:{method:'POST',params:{type:'setDetail'}},setAllDetails:{method:'POST',params:{type:'setAllDetails'}},returnPending:{method:'POST',params:{type:'returnPending'}}}),
		returnDetailStore: $resource('/api/purchase/returnDetail/:id', {id: '@id'}, {update: {method: 'PUT'},destory:{method: 'DELETE'}}),
		packingStore: $resource('/api/purchase/packing/:id', {id: '@id'}, {update: {method: 'PUT'}}),
		costparamStore: $resource('/api/purchase/:costparams/:id', {costparams:'costparams',id: '@id'}, {update: {method: 'PUT'}}),
		batchAuditStore: $resource('/api/audit/pr/batchUpdate/:id', {id: '@id'}, {batchUpdate: {method: 'POST'}}),
		auditStore: $resource('/api/audit/pr/:id',{id:'@id'},{update: {method: 'POST'},approve:{method:'PUT',params:{action:'approve'}},reject:{method:'PUT',params:{action:'reject'}}}),
		quotationVIStore:$resource('/api/item/vendorItem', {}, { getByVI: {method: 'POST'}}),
		last_element_holder: null
	};
}])