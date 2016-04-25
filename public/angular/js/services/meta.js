'use strict';

/*
* config.page.size 分页
*/

erp.factory('MetaService', ['$resource', 'CacheService', function ($resource, CacheService) {

	var service = {

		// 基础配置
		config: {
			page : {
				size : CacheService.get('config.page.size') || 15,
			}
		},

		// 产品相关
		item: {

			categories: function() {
				var categories = CacheService.get('item.categories');
				if ( ! categories) {
					categories = service.store.query({module: 'item', service: 'categories'}, function() {
						CacheService.set('item.categories', categories);
					});
				};
				return categories;
			}
		},


		platformList : function() {
			var platforms = CacheService.get('platform.list');
			if ( ! platforms) {
				platforms = this.store.query({module: 'platforms'}, function() {
					CacheService.set('platform.list', platforms);
				});
			};
			return platforms;
		},

		itemList: function() {
			var items = CacheService.get('item.list');
			if (!items) {
				items = this.store.query({module: 'item', service: 'info'}, function() {
					CacheService.set('item.list', items);
				});
			};
			return items;
		},

		vendorList: function() {
			var vendors = CacheService.get('vendor.list');
			if (!vendors) {
				vendors = this.store.query({module: 'purchase', service: 'vendor', 'select': 'id,name,code'}, function() {
					CacheService.set('vendor.list', vendors);
				});
			};
			return vendors;
		},

		whList: function() {
			var whs = CacheService.get('wh.list');
			if (!whs) {
				whs = this.store.query({module: 'item', service: 'meta', key: 'warehouseList'}, function() {
					CacheService.set('wh.list', whs);
				});
			};
			return whs;
		},

		invTypeList: function() {
			var invts = CacheService.get('inv.type.list');
			if (!invts) {
				invts = this.store.query({module: 'item', service: 'meta', key: 'inventoryTypeList'}, function() {
					CacheService.set('inv.type.list', invts);
				});
			};
			return invts;
		},
		
		PRStatusList: function() {
			var prsl = CacheService.get('purchase.request.status.list');
			if (!prsl) {
				prsl = this.store.query({module: 'item', service: 'meta', key: 'requestStatus'}, function() {
					CacheService.set('purchase.request.status.list', prsl);
				});
			};
			return prsl;
		},
		
		PRTypeList: function() {
			var prtl = CacheService.get('purchase.request.type.list');
			if (!prtl) {
				prtl = this.store.query({module: 'item', service: 'meta', key: 'requestTypes'}, function() {
					CacheService.set('purchase.request.type.list', prtl);
				});
			};
			return prtl;
		},
		
		//其他出入库单类型
		otherInvTypeList: function() {
			var oinvts = CacheService.get('otherinv.type.list');
			if (!oinvts) {
				oinvts = this.store.query({module: 'item', service: 'meta', key: 'otherInventoryTypeList'}, function() {
					CacheService.set('otherinv.type.list', oinvts);
				});
			};
			return oinvts;
		},
		//其他出入库单状态
		otherInvStatusList: function() {
			var oinvss = CacheService.get('oinv.status.list');
			if (!oinvss) {
				oinvss = this.store.query({module: 'item', service: 'meta', key: 'otherInventoryStatusList'}, function() {
					CacheService.set('oinv.status.list', oinvss);
				});
			};
			return oinvss;
		},
		//采购退货状态
		purchaseReturnStatusList: function() {
			var prsl = CacheService.get('purcr.status.list');
			if (!prsl) {
				prsl = this.store.query({module: 'item', service: 'meta', key: 'purchaseReturnStatusList'}, function() {
					CacheService.set('purcr.status.list', prsl);
				});
			};
			return prsl;
		},
		//仓库盘点状态
		warehouseCountStatusList: function() {
			var wcsl = CacheService.get('whct.status.list');
			if (!wcsl) {
				wcsl = this.store.query({module: 'item', service: 'meta', key: 'warehouseCountStatusList'}, function() {
					CacheService.set('whct.status.list', wcsl);
				});
			};
			return wcsl;
		},
		//仓库调度状态
		warehouseShipStatusList: function() {
			var wssl = CacheService.get('wssl.status.list');
			if (!wssl) {
				wssl = this.store.query({module: 'item', service: 'meta', key: 'warehouseShipStatusList'}, function() {
					CacheService.set('wssl.status.list', wssl);
				});
			};
			return wssl;
		},
		//仓库盘点状态
		warehouseShipTsStatusList: function() {
			var wstssl = CacheService.get('wstssl.status.list');
			if (!wstssl) {
				wstssl = this.store.query({module: 'item', service: 'meta', key: 'warehouseShipTSStatusList'}, function() {
					CacheService.set('wstssl.status.list', wstssl);
				});
			};
			return wstssl;
		},

		ioTypeList: function() {
			var iots = CacheService.get('io.type.list');
			if (!iots) {
				iots = this.store.query({module: 'item', service: 'meta', key: 'ioTypeList'}, function() {
					CacheService.set('io.type.list', iots);
				});
			};
			return iots;
		},
		
		ioStatusList: function() {
			var ioss = CacheService.get('io.status.list');
			if (!ioss) {
				ioss = this.store.query({module: 'item', service: 'meta', key: 'ioStatusList'}, function() {
					CacheService.set('io.status.list', ioss);
				});
			};
			return ioss;
		},

		userList: function() {
			var users = CacheService.get('user.list') || this.store.query({module: 'item', service: 'meta', key: 'userList'}, function() {
				CacheService.set('user.list', users);
			});
			return users;
		},
		
		chanelList: function() {
			var chanelLists = CacheService.get('user.chanel.list') || this.store.query({module: 'item', service: 'meta', key: 'chanelList'}, function() {
				CacheService.set('user.chanel.list', chanelLists);
			});
			return chanelLists;
		},
		
		transportList: function() {
			var transportLists = CacheService.get('user.transport.list') || this.store.query({module: 'item', service: 'meta', key: 'transportList'}, function() {
				CacheService.set('user.transport.list', transportLists);
			});
			return transportLists;
		},
		
		defaultShipAddrList:function(){
			var shipaddrs =CacheService.get('warehouse.shipaddr.list') || this.store.query({module: 'item', service: 'meta', key: 'defaultWHShipAddr'}, function() {
				CacheService.set('warehouse.shipaddr.list', shipaddrs);
			});
			return shipaddrs;
		},
		
		//运费系数
		costparamList:function(){
			var costparamLists =CacheService.get('purchase.costparams.list') || this.store.query({module: 'item', service: 'meta', key: 'purchaseCostparams'}, function() {
				CacheService.set('purchase.costparams.list', costparamLists);
			});
			return costparamLists;
		},
		//供应商报价列表
		vendorQuotationList:function(){
			var vendorQuotationLists =CacheService.get('vendor.quotation.list') || this.store.query({module: 'item', service: 'meta', key: 'vendorQuotation'}, function() {
				CacheService.set('vendor.quotation.list', vendorQuotationLists);
			});
			return vendorQuotationLists;
		},
		
		itemModelList: function() {
			var items = CacheService.get('itemModel.list');
			if (!items) {
				items = this.store.query({module: 'item', service: 'meta',key:'itemInfo'}, function() {
					CacheService.set('itemModel.list', items);
				});
			};
			return items;
		},
		
		
		//
		//清空所有本地存储 localStorage 用于刷新等
		emptyAll: function(){
			CacheService.clear();
		},

		store: $resource('/api/:module/:service/:key/:id', {module: '@module', service: '@service', key: '@key', id: '@id'}, {update: {method: 'PUT'}}),

		storeBuilder: function(module, service, actions) {
			return $resource('/api/:module/:service/:key/:id', {module: module, service: service, key: '@key', id: '@id'}, _.extend({update: {method: 'PUT'}}, actions));
		}

	};

	return service;
}]);