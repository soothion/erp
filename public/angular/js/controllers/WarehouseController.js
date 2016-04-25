'use strict';
//-----------------route start--------------------------//
erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
	 
	$routeProvider.when('/warehouse/rmaList', {
		templateUrl: 'angular/views/warehouse/rma/index.html',
		controller: 'warehouseRMACtrl'
	}).when('/warehouse/rma/create/new', {
		templateUrl: 'angular/views/warehouse/rma/create.html',
		controller: 'RMACreateCtrl'
	}).when('/warehouse/rma/edit/:id', {
		templateUrl: 'angular/views/warehouse/rma/update.html',
		controller: 'RMAUpdateCtrl'
	}).when('/warehouse/list', {
		templateUrl: 'angular/views/warehouse/warehouse/index.html',
		controller: 'warehouseCtrl'
	}).when('/warehouse/warehouse/edit/:id', {
		templateUrl: 'angular/views/warehouse/warehouse/edit.html',
		controller: 'warehouseEditCtrl'
	}).when(
		'/warehouse/otherIOInventory', {
			templateUrl: 'angular/views/warehouse/otherIOInventory/index.html',
			controller: 'otherIOInventoryCtrl'
	}).when(
		'/warehouse/otherIOInventory/create', {
			templateUrl: 'angular/views/warehouse/otherIOInventory/create.html',
			controller: 'otherIOInventoryCreateCtrl'
	}).when(
			'/warehouse/otherIOInventory/update/:id', {
			templateUrl: 'angular/views/warehouse/otherIOInventory/update.html',
			controller: 'otherIOInventoryUpdateCtrl'
	}).when(
			'/warehouse/otherIOInventory/specail/:id', {
				templateUrl: 'angular/views/warehouse/otherIOInventory/specail.html',
				controller: 'otherIOInventorySpecailCtrl'
	}).when(
			'/warehouse/IOList', {
			templateUrl: 'angular/views/warehouse/IOList/index.html',
			controller: 'IOListCtrl'
	}).when(
			'/warehouse/IOListIn/update/:id', {
				templateUrl: 'angular/views/warehouse/IOList/update.in.html',
				controller: 'IOListCtrlUpdate'
	}).when(
			'/warehouse/IOListOut/update/:id', {
				templateUrl: 'angular/views/warehouse/IOList/update.out.html',
				controller: 'IOListCtrlUpdate'
	}).when(
			'/warehouse/IOList/:type', {
				templateUrl: 'angular/views/warehouse/IOList/list.html',
				controller: 'IOListListCtrl'
	}).when(
			'/warehouse/IOPurchase/showPrint/:id', {
				templateUrl: 'angular/views/warehouse/IOList/purchase_io.html',
				controller: 'IOPurchaseCtrl'
	}).when(
			'/warehouse/counting', {
				templateUrl: 'angular/views/warehouse/counting/index.html',
				controller: 'WHCountCtrl'
	}).when(
			'/warehouse/counting/create', {
				templateUrl: 'angular/views/warehouse/counting/create.html',
				controller: 'WHCountCreateCtrl'
	}).when(
			'/warehouse/counting/update/:id', {
				templateUrl: 'angular/views/warehouse/counting/update.html',
				controller: 'WHCountUpdateCtrl'
	}).when(
			'/warehouse/dispatch', {
				templateUrl: 'angular/views/warehouse/dispatch/index.html',
				controller: 'WHDispatchCtrl'
	}).when(
			'/warehouse/dispatch/create', {
				templateUrl: 'angular/views/warehouse/dispatch/create.html',
				controller: 'WHDispatchCreateCtrl'
	}).when(
			'/warehouse/dispatch/update/:id', {
				templateUrl: 'angular/views/warehouse/dispatch/update.html',
				controller: 'WHDispatchUpdateCtrl'
	}).when(
			'/warehouse/dispatch/specail/:id', {
				templateUrl: 'angular/views/warehouse/dispatch/specail.html',
				controller: 'WHDispatchSpecailCtrl'
	})
	;}]);
//-----------------route end--------------------------//


//-----------------controller start--------------------------//
erp.controller('warehouseCtrl', ['$scope', 'WarehouseService', function ($scope, WarehouseService) {
    $scope.warehouseLists =  WarehouseService.warehouse.query();
    $scope.showAddress = function(warehouse) {
    	$scope.modal = warehouse;
    	jQuery('.modal').modal();
    }
}]);
erp.controller('warehouseRMACtrl', ['$scope', 'WarehouseService', 'MetaService', function ($scope, WarehouseService, MetaService) {
	 $scope.warehouseRMALists =  WarehouseService.rma.query();
	 $scope.deleteRMA=function(id)
		{
			WarehouseService.rma.remove({id:id},function(data){		
				if(data.return == 0)
				{
			  	location.href="#/warehouse/rmaList/";
				}
				else
				{
					alert(data.return);
				}
			});
		}
}]);
erp.controller('RMACreateCtrl', ['$scope', '$location','WarehouseService', 'MetaService', function ($scope,$location,WarehouseService, MetaService) {
	$scope.rma = WarehouseService.rma.get({id:'new'});
	$scope.warehouses =  MetaService.whList();
	$scope.create=function()
	{         
		       
			    WarehouseService.rma.save($scope.rma,function(data){
			    console.log(data);
			    alert("保存记录成功")
			//    $location.path("/warehouse/rmaList/");
		});
	}
	
}]);
erp.controller('uploadCtrl', function ($scope) {
            $scope.foo = "Hello World";
            $scope.disabled = false;
            $scope.bar = function(content) {
              if (console) {
              	$scope.uploadResponse = content.msg;
              } 
              
              
            };
        });
erp.controller('mainCtrl', function ($scope) {
        $scope.uploadComplete = function (content, completed) {
            if (completed && content) { 
            	console.log(content);
                alert("文件导入成功");
                window.location.reload();
            }
        };
    });        
erp.controller('RMAUpdateCtrl', ['$scope', '$location','WarehouseService', 'MetaService','$routeParams', function ($scope,$location,WarehouseService, MetaService,$routeParams) {
	
	var thisId= $routeParams.id;
	$scope.rma = WarehouseService.rma.get({id:$routeParams.id});
//	$scope.statuses= MetaService.otherInvStatusList();
//	$scope.types=MetaService.otherInvTypeList();
	$scope.skus = MetaService.itemList();
	$scope.warehouses =  MetaService.whList();
	$scope.create=function()
	{      
			WarehouseService.rma.save($scope.rma,function(data){	
				$location.path("/warehouse/rmaList/");
		});
	};
	$scope.details_new = function() {
		$scope.rma.details.push({});
	};
	
	$scope.details_remove = function(index) {
		
		if($scope.rma.details[index].id)
		{
			WarehouseService.rma.destory({id:$scope.rma.details[index].id,type:'detail'},function(){
				
			});
		}
		
		$scope.rma.details.splice(index, 1);
	};
	
	$scope.update=function()
	{  
		WarehouseService.rma.update($scope.rma,function(data){
			if(data.return == 0)
			{
				window.location.reload(); 
			}
			else
			{
				alert(data.ErrMsg);
			}
		});
	};
	$scope.confirm=function()
	{
		$scope.rma.status="confirmed";
		
		var detailNum=$scope.rma.details.length;
		if(detailNum>0)
		{
			WarehouseService.rma.confirm($scope.rma,function(data){
				if(data.return == 0)
				{
					$location.path('/warehouse/rmaList');
				}
				else
				{
					alert(data.ErrMsg);
				}
			});
		}
		else
		{
			alert("请先添加明细!");
		}
		
	};
	//整单返回rmaRepending
	$scope.returnPending=function()
	{
		 
		  WarehouseService.rmaRepending.returnPending({id:thisId},function(data){
			  if(data.return==0)
			  {
				  window.location.reload();
			  }
			  else{
				  alert(data.ErrMsg);
			  }
		});
	};
	$scope.generate=function()
	{   
		
		WarehouseService.rmaGenerate.generate({id:$routeParams.id},function(data){
			if(data.return ==0)
			{  
				window.location.reload(); 
				$location.path('/warehouse/rmaList');
			}
			else
			{
				alert(data.errorMsg);
			}
		});
	};
	$scope.test =function(){
		  alert("fsdasdf"); 
	};
	
}]);

erp.controller('IOPurchaseCtrl', ['$scope', 'WarehouseService','$routeParams', function ($scope, WarehouseService,$routeParams) {
           WarehouseService.IOPurchase.showPrint({id:$routeParams.id},function(data){
           $scope.print = data;
    });
    	$scope.printOrder = function(index) {
    		
		if (index < 10) {
					var bdhtml=document.body.innerHTML;   //获取当前页的html代码
					var sprnstr="<!--startprint-->";     //设置打印开始区域
					var eprnstr="<!--endprint-->";       //设置打印结束区域
					var prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
					prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
					document.body.innerHTML=prnhtml;
					window.print();
					document.body.innerHTML=bdhtml;
		} else {
			window.print();
		}

	};
}]);

erp.controller('warehouseEditCtrl', ['$scope', '$routeParams', '$location', 'WarehouseService',  function ($scope, $routeParams, $location, WarehouseService) {
	var brand = ($routeParams.id == 'new');
	 var warehouse = brand ? {} : WarehouseService.warehouse.get({id: $routeParams.id},function(){
		$scope.warehouse = warehouse;
		$scope.remote = angular.copy(warehouse);
		$scope.warehouse.$id = $routeParams.id;        
	});
	$scope.update = brand ? function() {
		WarehouseService.warehouse.save($scope.warehouse, function() {
//	    $location.path('/warehouse/list');
		});
	} : function() {
		WarehouseService.warehouse.update($scope.warehouse, function() {
  //      $location.path('/warehouse/list');
		});
	};
	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.warehouse);
	};

	$scope.destroy = function() {
		warehouse.$remove(function() {
			$location.path('/warehouse/list');
		});
	};
}]);

erp.controller('otherIOInventoryCtrl', ['$scope', 'WarehouseService', 'MetaService','ItemService',function ($scope, WarehouseService,MetaService,ItemService) {
	
	$scope.iolist=WarehouseService.otherIOInventoryStore.query();
	
	$scope.warehouses = MetaService.whList();
	
	$scope.skus = MetaService.itemList();
	
	$scope.jumpToChange=function($index)
	{
		if($scope.iolist[$index].typeid >0)
		{
			location.href="#/warehouse/otherIOInventory/update/"+$scope.iolist[$index].id;
		}
		else
		{
			location.href='#/warehouse/otherIOInventory/update/'+$scope.iolist[$index].id;
		}
	}
	
	var nowDate=new Date();
	
	$scope.searchModel={};
	
	$scope.searchModel.timeEnd=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	
	nowDate.setTime(nowDate.getTime()-86400000*7);
	$scope.searchModel.timeStart=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	
	//var store = MetaService.storeBuilder('warehouse', 'otherIOInventory');
	$scope.toFilter=function()
	{
		var params={};
		params.invoice=$scope.searchModel.invoice?$scope.searchModel.invoice:"";
		params.sku = $scope.searchModel.sku ? $scope.searchModel.sku.id : '';
		params.status =_.map($scope.searchModel.status, function(v, k) {return v == true ? k : ''});
		params.warehouse = $scope.searchModel.warehouse ? $scope.searchModel.warehouse.id : '';
		params.timeFrom = $scope.searchModel.timeStart;
		params.timeTo = $scope.searchModel.timeEnd;
		if(! params.sku)
		{
			params.skuLike=jQuery(".form-control#sku").val();
		}
		
		var list = WarehouseService.otherIOInventoryStore.query(params, function() {
			$scope.iolist = list;
		});
	}
	
	$scope.toExport=function()
	{
		alert("in working!");
	}
	
	
	$scope.toPrint=function($index)
	{
		
		alert("this for print !");
	}
	
	//$scope.moreFilter=false;
	$scope.toggleMoreFilter=function()
	{
		if($scope.moreFilter) $scope.moreFilter=false;
		else $scope.moreFilter=true;
	}
	
	$scope.deleteInventory=function(id)
	{
	
		WarehouseService.otherIOInventoryStore.remove({id:id},function(data){		
			if(data.return == 0)
			{	
				location.href="#/warehouse/otherIOInventory/";
			}
			else
			{
				alert(data.return);
			}
		});
	}
}]);

erp.controller('otherIOInventoryCreateCtrl', ['$scope', 'WarehouseService','ItemService','MetaService', '$location',function ($scope, WarehouseService,ItemService,MetaService,$location) {
	$scope.otherIO = WarehouseService.otherIOInventoryStore.get({id:'new'});
	$scope.statuses= MetaService.otherInvStatusList();
	$scope.types=MetaService.otherInvTypeList();
	$scope.skus = MetaService.itemList();
	$scope.warehouses =  MetaService.whList();
	
	$scope.create=function()
	{
		if($scope.otherIO.invoice =="")
		{
			alert("invoice 不能为空");
			return false;
		}
		
			WarehouseService.otherIOInventoryStore.save($scope.otherIO,function(data){		
			if(data.return == 0)
			{	
				location.href="#/warehouse/otherIOInventory/update/"+data.id;
			}
			else
			{
				alert(data.return);
			}
		});
	}
}]);

erp.controller('otherIOInventoryUpdateCtrl', ['$scope','$routeParams', 'WarehouseService', 'ItemService', 'MetaService','$location',function ($scope,$routeParams, WarehouseService,ItemService,MetaService,$location) {
	$scope.statuses		= MetaService.otherInvStatusList();		
	$scope.types		= MetaService.otherInvTypeList();
	$scope.warehouses 	= MetaService.whList();
	$scope.skus 		= MetaService.itemList();
	
	var oldStatus;
	$scope.otherIO = WarehouseService.otherIOInventoryStore.get({id:$routeParams.id},function(){
		oldStatus=$scope.otherIO.status;
		
		$scope.remote = angular.copy($scope.otherIO);
	});	
	
	$scope.isClean=function(){
		return angular.equals($scope.remote, $scope.otherIO);
	};
	
	$scope.details_new = function() {
		$scope.otherIO.details.push({});
	};
	
	$scope.details_remove = function(index) {
		
		if($scope.otherIO.details[index].id)
		{
			WarehouseService.otherIOInventoryStore.destory({id:$scope.otherIO.details[index].id,type:'detail'},function(){
				
			});
		}
		
		$scope.otherIO.details.splice(index, 1);
	};
	
	$scope.canNotUpdate=function()
	{
		if(oldStatus == "pending") return false;
		else return true;
	}
	
	$scope.canNotGenerate=function()
	{	
		if(oldStatus == "confirmed") return false;
		else return true;
	}
	
	$scope.isPending=function(){
		if(oldStatus == "pending") return true;
		else return false;
	}
	
	$scope.update=function()
	{
		WarehouseService.otherIOInventoryStore.update($scope.otherIO,function(data){
			if(data.return == 0)
			{
				window.location.reload(); 
			}
			else
			{
				alert(data.ErrMsg);
			}
		});
	}
	
	$scope.confirm=function()
	{
		$scope.otherIO.status="confirmed";
		
		var detailNum=$scope.otherIO.details.length;
		if(detailNum>0)
		{
			WarehouseService.otherIOInventoryStore.confirm($scope.otherIO,function(data){
				if(data.return == 0)
				{
					$location.path('/warehouse/otherIOInventory');
				}
				else
				{
					alert(data.ErrMsg);
				}
			});
		}
		else
		{
			alert("请先添加明细!");
		}
		
	}
	

	
	$scope.generate=function()
	{
		WarehouseService.otherIOGenerateStore.generate({id:$routeParams.id},function(data){
			if(data.return ==0)
			{
				$location.path('/warehouse/otherIOInventory');
			}
			else
			{
				alert(data.errorMsg);
			}
		});
	}
	
	$scope.specailChange=function(id)
	{
		$location.path('/warehouse/otherIOInventory/specail/'+id);
	}
	
}]);

//其他出入库单的特殊修改

erp.controller('otherIOInventorySpecailCtrl', ['$scope','$routeParams', 'WarehouseService', 'ItemService', 'MetaService','$location',function ($scope,$routeParams, WarehouseService,ItemService,MetaService,$location) {
		var thisId= $routeParams.id;
		$scope.statuses		= MetaService.otherInvStatusList();		
		$scope.types		= MetaService.otherInvTypeList();
		$scope.warehouses   = MetaService.whList();
		$scope.skus 		= MetaService.itemList();
		$scope.otherIO = WarehouseService.otherIOInventoryStore.get({id:thisId},function(){
			$scope.remote = angular.copy($scope.otherIO.details);
		});	
		
		$scope.isClean=function(){
			return angular.equals($scope.remote,$scope.otherIO.details);
		};
		
		//sku替换
		$scope.updateSku=function()
		{
			var params={};
			params.id=thisId;
			params.formSku=$scope.skuModel.oldsku;
			params.toSku=$scope.skuModel.newsku;
			var skus=$scope.getAllSkus();
			var isExists=false;
			
			for(var i in skus)
			{
				if(skus[i] == params.formSku) 
				{
					isExists=true;
					break;
				}
			}
			
			if(isExists)
			{
				if(params.toSku !="")
				{
					WarehouseService.otherIOSpecailStore.updateSkus(params,function(data){
						if(data.return =="0")
						{
							$location.path('/warehouse/otherIOInventory/update/' + $routeParams.id);
						}
						else
						{
							alert(data.errorMsg);
						}
					});
				}
				else
				{
					alert("修改后SKU 不能为空!");
				}
			}
			else
			{
				alert("本出入库单 不包含此sku"+params.formSku);
			}		
		}
		
		//全部保存
		$scope.saveAll=function()
		{
			var params={};
			params.id=thisId;
			params.details=$scope.otherIO.details;
			WarehouseService.otherIOSpecailStore.setAllDetails(params,function(data){
				if(data.return =="0")
				{
					$location.path('/warehouse/otherIOInventory/update/' + $routeParams.id);
				}
				else
				{
					alert(data.errorMsg);
				}
			});
		}
		
		//整单返回
		$scope.returnPending=function()
		{
			WarehouseService.otherIOSpecailStore.returnPending({id:thisId},function(data){
				if(data.return == '0' )
				{
					$location.path('/warehouse/otherIOInventory/');
				}
				else
				{
					alert(data.errorMsg);
				}
			});
		}
		
		
		$scope.getAllSkus=function()
		{
			var skus=[];
			for(var i in $scope.otherIO.details)
			{
				skus[i]=$scope.otherIO.details[i].item.sku;
			}
			return skus;
		}
		
	
}]);


erp.controller('IOListCtrl', ['$scope', '$location','WarehouseService','ItemService', 'MetaService',function ($scope,$location, WarehouseService,ItemService,MetaService) {
	$scope.iolist=WarehouseService.IOListStore.query();	
	$scope.statuses=MetaService.ioStatusList();	
	$scope.types=MetaService.ioTypeList();
	$scope.skus = MetaService.itemList();
	$scope.warehouses = MetaService.whList();
	$scope.jumpToChange=function($index)
	{
		if($scope.iolist[$index].typeid >0)
		{
			$location.path('/warehouse/IOListIn/update/'+$scope.iolist[$index].id);
		}
		else
		{
			$location.path('/warehouse/IOListOut/update/'+$scope.iolist[$index].id);
		}
	}
	
	$scope.toPrint	=function($index)
	{
		alert($scope.iolist[$index].id);
		alert("this for print !");
	}
	
	$scope.getTypeName=function(index)
	{ 
		var id=$scope.iolist[index].type;
		for(var i in $scope.types)
		{
			if($scope.types[i].id==id)
			{
				return $scope.types[i].name;
			}
		}
		return "unknow["+id+"]";
	}
	
	$scope.getStatusName=function(index)
	{
		var id=$scope.iolist[index].status;
		
		for(var i in $scope.statuses)
		{
			if($scope.statuses[i].id==id)
			{
				return $scope.statuses[i].name;
			}
		}
		return "unknow["+id+"]";
	}
	
	
//	$scope.moreFilter=false;
//	$scope.toggleMoreFilter=function()
//	{
//		if($scope.moreFilter) 
//		{
//			$scope.moreFilter=false;
//		}
//		else
//		{
//			$scope.search={};
//			$scope.moreFilter=true;			
//		}
//	}
	
	$scope.deleteList=function($index)
	{
			
	}
	
	$scope.OldSearch={};
	
	$scope.FilterSearch=function()
	{
		var queryParams={};
		
		if($scope.OldSearch.invoice) queryParams.invoice=$scope.OldSearch.invoice;
		if($scope.OldSearch.relation_invoice) queryParams.relation_invoice=$scope.OldSearch.relation_invoice;
		if($scope.OldSearch.item) queryParams.item_id=$scope.OldSearch.item.id;
		if($scope.OldSearch.status) queryParams.status=_.map($scope.OldSearch.status, function(v, k) {return v == true ? k : ''});
		if($scope.OldSearch.type) queryParams.leibie=$scope.OldSearch.type;
		if($scope.OldSearch.warehouse) queryParams.warehouse=$scope.OldSearch.warehouse;
		if($scope.OldSearch.exec_at_from) queryParams.exec_at_from=$scope.OldSearch.exec_at_from;
		if($scope.OldSearch.exec_at_to) queryParams.exec_at_to=$scope.OldSearch.exec_at_to;
		if($scope.OldSearch.created_at_from) queryParams.created_at_from=$scope.OldSearch.created_at_from;
		if($scope.OldSearch.created_at_to) queryParams.created_at_to=$scope.OldSearch.created_at_to;
		
		
		WarehouseService.IOListStore.query(queryParams
				,
				function(data){
						$scope.iolist=data;
				}
		);	
	}
	
	$scope.cleanSearch=function(){
		$scope.OldSearch=$scope.search={};
	}
	
	$scope.export=function()
	{
		WarehouseService.IOListStore.query( {type:"export",query1: $scope.OldSearch,query2:$scope.search },function(data){
				
		});	
	}
}]);


erp.controller('IOListListCtrl', ['$scope', '$routeParams','$location','WarehouseService','ItemService', 'MetaService',function ($scope,$routeParams,$location, WarehouseService,ItemService,MetaService) {
	
	$scope.statuses=MetaService.ioStatusList();	
	$scope.isInList=$routeParams.type == "in";
	$scope.types=MetaService.ioTypeList();
	$scope.skus = MetaService.itemList();
	$scope.warehouses = MetaService.whList();
	$scope.iolist=WarehouseService.IOListStore.query({type:$routeParams.type});	

	$scope.listTypes=$scope.isInList?[{"id":1,"name":"Purchasing","dr":"in"},{"id":2,"name":"CheckStockIn","dr":"in"},{"id":3,"name":"MakingIn","dr":"in"},{"id":4,"name":"ShipmentIn","dr":"in"},{"id":5,"name":"SplitIn","dr":"in"},{"id":6,"name":"OtherIn","dr":"in"},{"id":7,"name":"Order Closed Cancel","dr":"in"},{"id":8,"name":"FBA Return In","dr":"in"},{"id":9,"name":"RMA Restock","dr":"in"}]:[{"id":-1,"name":"Purchasing Return Vendor","dr":"out"},{"id":-2,"name":"CheckStockOut","dr":"out"},{"id":-3,"name":"MakingOut","dr":"out"},{"id":-4,"name":"ShipmentOut","dr":"out"},{"id":-5,"name":"SplitOut","dr":"out"},{"id":-6,"name":"OtherOut","dr":"out"}];
	
	
	

	
	$scope.jumpToChange=function($index)
	{
		if($scope.iolist[$index].typeid >0)
		{
			$location.path('/warehouse/IOListIn/update/'+$scope.iolist[$index].id);
		}
		else
		{
			$location.path('/warehouse/IOListOut/update/'+$scope.iolist[$index].id);
		}
	}
	
	$scope.toPrint	=function($index)
	{
		alert($scope.iolist[$index].id);
		alert("this for print !");
	}
	
	$scope.getTypeName=function(index)
	{ 
		var id=$scope.iolist[index].type;
		for(var i in $scope.types)
		{
			if($scope.types[i].id==id)
			{
				return $scope.types[i].name;
			}
		}
		return "unknow["+id+"]";
	}
	
	$scope.getStatusName=function(index)
	{
		var id=$scope.iolist[index].status;
		
		for(var i in $scope.statuses)
		{
			if($scope.statuses[i].id==id)
			{
				return $scope.statuses[i].name;
			}
		}
		return "unknow["+id+"]";
	}
	

	$scope.deleteList=function($index)
	{
			
	}
	
	$scope.OldSearch={};
	
	$scope.FilterSearch=function()
	{
		var queryParams={};
		queryParams.type=$routeParams.type;
		if($scope.OldSearch.invoice) queryParams.invoice=$scope.OldSearch.invoice;
		if($scope.OldSearch.relation_invoice) queryParams.relation_invoice=$scope.OldSearch.relation_invoice;
		if($scope.OldSearch.item) queryParams.item_id=$scope.OldSearch.item.id;
		if($scope.OldSearch.status) queryParams.status=_.map($scope.OldSearch.status, function(v, k) {return v == true ? k : ''});
		if($scope.OldSearch.type) queryParams.leibie=$scope.OldSearch.type;
		if($scope.OldSearch.warehouse) queryParams.warehouse=$scope.OldSearch.warehouse;
		
		if($scope.OldSearch.exec_at_from) queryParams.exec_at_from=$scope.OldSearch.exec_at_from;
		if($scope.OldSearch.exec_at_to) queryParams.exec_at_to=$scope.OldSearch.exec_at_to;
		if($scope.OldSearch.created_at_from) queryParams.created_at_from=$scope.OldSearch.created_at_from;
		if($scope.OldSearch.created_at_to) queryParams.created_at_to=$scope.OldSearch.created_at_to;
		
		
		WarehouseService.IOListStore.query(queryParams
				,
				function(data){
						$scope.iolist=data;
				}
		);	
	}
	
	$scope.cleanSearch=function(){
		$scope.OldSearch=$scope.search={};
	}
	
	$scope.export=function()
	{
		WarehouseService.IOListStore.query( {type:"export",query1: $scope.OldSearch,query2:$scope.search },function(data){
				
		});	
	}
}]);


erp.controller('IOListCtrlUpdate',['$scope', '$routeParams','$location','WarehouseService',function($scope,$routeParams,$location, WarehouseService){	
	//这个入库时判断是否有对应out的判断可以拿掉－－－131206 shipment的出入库单可以不用一一对应
	$scope.shipmentinByNotOut=true;
	$scope.shipmentInMsg="";
	$scope.IOList		=WarehouseService.IOListStore.get({id: $routeParams.id},function(data){
		if(data.type && data.type=="ShipmentIn")
		{
			$scope.shipmentinByNotOut;
			WarehouseService.IOListStore.get({id: $routeParams.id,type:'ShipmentIn',relation_id:data.relation_id},function(data){
				if(data.err)
				{
					$scope.shipmentinByNotOut=true;
					$scope.shipmentInMsg=data.msg;
				}
				else
					$scope.shipmentinByNotOut=false;
			})
		}
		else
			$scope.shipmentinByNotOut=false;
		
	});
	$scope.isIOIn		=$scope.IOList.typeid>0 ? true:false;
	
	//$scope.hasBooked	=$scope.IOList.status==0 ? true : false;//没有book时才显示
	//$scope.hasOuted		=$scope.IOList.status==1 ? true : false;
	$scope.hasIned		=$scope.IOList.status==1?true:false;
	
	$scope.getStatusName=function(){
		var statusName;
		if($scope.IOList.status==1) 
			statusName="Stocked";
		else if($scope.IOList.status==0)
			statusName="Not Stock";
		else if($scope.IOList.status==2)
			statusName="Booked";
		else
			statusName="unknown";
		return statusName;
	};
	
	$scope.getCNTypeName=function(ename)
	{
		switch(ename)
		{
		 	case "OtherOut":
		 	case "OtherIn":
		 		return "其他";
		 	case "Purchasing":
		 		return "采购";
		 	case "Purchasing Return Vendor":
		 		return "采购退货";
		 	case "CheckStockIn":
		 		return "盘盈";
		 	case "CheckStockOut":
		 		return "盘亏";
		 	case "MakingIn":
		 		return "加工成品";
		 	case "MakingOut":
		 		return "加工物料";
		 	case "SplitIn":
		 		return "拆分物料";
		 	case "SplitOut":
		 		return "拆分成品";
		 	case "Order Closed Cancel":
		 		return "订单取消库存";
	
		 		
		 	default:
		 		return ename;
		 		
		 		
		 		
		}
	}
	
	$scope.reflushModel=function()
	{
		$scope.IOList		=WarehouseService.IOListStore.get({id: $routeParams.id});
		//$scope.isIOIn		=$scope.IOList.typeid>0 ? true : false;
		//$scope.hasBooked	=$scope.IOList.status==2 ? true : false;
		//$scope.hasOuted		=$scope.IOList.status==1 ? true : false;
		$scope.hasIned		=$scope.IOList.status==1?true:false;
	}
	
	$scope.isBooked=function(){
		return $scope.IOList.status==0 ? true : false;
	}
	
	$scope.isUnBooked=function(){
		return ($scope.IOList.status==2) ? true : false;
	}

	$scope.isStocked=function(){
		return ($scope.IOList.status==2 || $scope.IOList.status==0) ? true : false;
	}

	$scope.isUnStocked=function(){
		return ($scope.IOList.status==1) ? true : false;
	}
	
	$scope.isSplit=function(){
		return $scope.IOList.status==0 ? true : false;
	}	
	
	$scope.showChai	=function(){		
		jQuery('.modal').modal();
	};
	
	//拆分入库单
	$scope.doChaifenIn=function(){
		WarehouseService.IOListStore.book({id: $routeParams.id,type:"chai-in",data:$scope.IOList.details},function(data){	
			if(data.return =="0")
			{
				alert("拆分入库单 成功");
				$scope.IOList		=WarehouseService.IOListStore.get({id: $routeParams.id});
			}
			else
			{
				alert("拆分失败\n 参考:"+data.errorMsg);
			}
			
		});
	};
	
	//拆分出库单
	$scope.doChaifen=function(){
		WarehouseService.IOListStore.book({id: $routeParams.id,type:"chai-out",data:$scope.IOList.details},function(data){	
			if(data.return =="0")
			{
				alert("拆分出库单 成功");
				$scope.IOList		=WarehouseService.IOListStore.get({id: $routeParams.id});
			}
			else
			{
				alert("拆分失败\n 参考:"+data.errorMsg);
			}
			
		});
	};
	
	//简单检查拆分的正确性
	$scope.validateChaifenForm=function(){
		var totalQty=0;
	
		for(var $d in $scope.IOList.details)
		{				
			if(typeof($scope.IOList.details[$d].newqty) =="undefined")
			{
				$scope.IOList.details[$d].newqty = 0;
			}
			
			if(parseInt($scope.IOList.details[$d].newqty) >  parseInt($scope.IOList.details[$d].qty))
			{
				return true;
			}
			totalQty +=parseInt($scope.IOList.details[$d].newqty);
		}
		
		if(totalQty < 1)
		{
			return true;
		}
		else
			return false;
	};
	
	$scope.book	=function(){
		WarehouseService.IOListStore.book({id: $routeParams.id,type:"book"},function(data){			
			if(data.return =="0")
			{
				location.reload();
				//location.href='/warehouse/IOListOut/update/'+$routeParams.id;
			}
			else
			{
				alert("book 失败\n 参考:"+data.errorMsg);
			}
			
		});
	};
	
	$scope.unbook	=function(){
		WarehouseService.IOListStore.unbook({id: $routeParams.id,type:"unbook"},function(data){
			if(data.return =="0")
			{		
				location.reload();
				//location.href='/warehouse/IOListOut/update/'+$routeParams.id;
			}
			else
			{
				alert("unbook 失败\n 参考:"+data.errorMsg);
			}
			
		});
	};
	
	//入库
	$scope.stockPush=function(){
		WarehouseService.IOListStore.unbook({id: $routeParams.id,type:"in"},function(data){
			if(data.return =="0")
			{
				alert("入库 成功");
				location.reload();
				//location.href='/spa#/warehouse/IOListIn/update/'+$routeParams.id;
			}
			else
			{
				alert("入库 失败\n 参考:"+data.errorMsg);
			}
			
		});
	}
	
	//反入库
	$scope.stockPop=function(){
		WarehouseService.IOListStore.unbook({id: $routeParams.id,type:"unin"},function(data){
			if(data.return =="0")
			{
				alert("反入库成功");
				location.reload();
				//$location.path('/warehouse/IOListOut/update/'+$routeParams.id);
			}
			else
			{
				alert("出库失败\n 参考:"+data.errorMsg);
			}
			
		});	
	}
	
	//出库
	$scope.moveOutOfStock=function(){
		WarehouseService.IOListStore.unbook({id: $routeParams.id,type:"out"},function(data){
			if(data.return =="0")
			{
				alert("出库成功");
				location.reload();
				//$location.path('/warehouse/IOListOut/update/'+$routeParams.id);
			}
			else
			{
				alert("出库失败\n 参考:"+data.errorMsg);
			}
			
		});	
	}
	
	//反出库
	$scope.unmoveOutOfStockToBook=function(){
		
			WarehouseService.IOListStore.unbook({id: $routeParams.id,type:"unout" , toStatus:"book"},function(data){
			if(data.return =="0")
			{		
				location.reload();
			}
			else
			{
				alert("反出库 失败\n 参考:"+data.errorMsg);
			}
			
		});
	}
	
	$scope.unmoveOutOfStockToNotstock=function(){
		WarehouseService.IOListStore.unbook({id: $routeParams.id,type:"unout",oStatus:"book" },function(data){
			if(data.return =="0")
			{		
				location.reload();
				//location.href='/warehouse/IOListOut/update/'+$routeParams.id;
			}
			else
			{
				alert("反出库 失败\n 参考:"+data.errorMsg);
			}
		});
	}
		
	//扫描  条形码
	$scope.autoScanCode=function(){
		alert("in working!");
	};
	
	//输入 条形码
	$scope.customScanCode=function(){
		alert("in working!");
	};
	
}]);



/////////////////////////////////////////////
//仓库盘点
////////////////////////////////////////////
erp.controller('WHCountCtrl',['$scope', '$routeParams','$location','WarehouseService','MetaService',function($scope,$routeParams,$location, WarehouseService,MetaService){	
	
	$scope.countList=WarehouseService.WHCountingStore.query();
	
	$scope.warehouses = MetaService.whList();
	
	$scope.skus = MetaService.itemList();

	
	var nowDate=new Date();
	
	$scope.searchModel={};
	
	$scope.searchModel.timeEnd=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	
	nowDate.setTime(nowDate.getTime()-86400000*7);
	$scope.searchModel.timeStart=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	
	//var store = MetaService.storeBuilder('warehouse', 'otherIOInventory');
	$scope.toFilter=function()
	{
		var params={};
		params.invoice=$scope.searchModel.invoice?$scope.searchModel.invoice:"";
		params.sku = $scope.searchModel.sku ? $scope.searchModel.sku.id : '';
		params.status =_.map($scope.searchModel.status, function(v, k) {return v == true ? k : ''});
		params.warehouse = $scope.searchModel.warehouse ? $scope.searchModel.warehouse.id : '';
		params.timeFrom = $scope.searchModel.timeStart;
		params.timeTo = $scope.searchModel.timeEnd;
		if(! params.sku)
		{
			params.skuLike=jQuery(".form-control#sku").val();
		}
		
		var list = WarehouseService.WHCountingStore.query(params, function() {
			$scope.countList = list;
		});
	}
	
	$scope.toExport=function()
	{
		alert("in working!");
	}
	
	
	$scope.toPrint=function($index)
	{
		
		alert("this for print !");
	}
	
	//$scope.moreFilter=false;
	$scope.toggleMoreFilter=function()
	{
		if($scope.moreFilter) $scope.moreFilter=false;
		else $scope.moreFilter=true;
	}
	
	$scope.deleteInventory=function(id)
	{
	
		WarehouseService.WHCountingStore.remove({id:id},function(data){		
			if(data.return == 0)
			{	
				location.href="#/warehouse/counting/";
			}
			else
			{
				alert(data.return);
			}
		});
	}
}]);

erp.controller('WHCountCreateCtrl',['$scope', '$routeParams','$location','WarehouseService','MetaService',function($scope,$routeParams,$location, WarehouseService,MetaService){	
	$scope.counting = WarehouseService.WHCountingStore.get({id:'new'});
	$scope.warehouses =  MetaService.whList();
	$scope.create=function()
	{
		if($scope.counting.invoice =="")
		{
			alert("invoice 不能为空");
			return false;
		}
		
			WarehouseService.WHCountingStore.save($scope.counting,function(data){		
			if(data.id)
			{	
				location.href="#/warehouse/counting/update/"+data.id;
			}
			else
			{
				alert(data.return);
			}
		});
	}
}]);

erp.controller('WHCountUpdateCtrl',['$scope', '$routeParams','$location','WarehouseService','MetaService',function($scope,$routeParams,$location, WarehouseService,MetaService){	
	var oldStatus;
	$scope.counting = WarehouseService.WHCountingStore.get({id:$routeParams.id},function(){
		oldStatus=$scope.otherIO.status;
		
		$scope.remote = angular.copy($scope.counting);
	});	
	
	$scope.warehouses 	= MetaService.whList();
	$scope.skus 		= MetaService.itemList();
	
	
	$scope.isClean=function(){
		return angular.equals($scope.remote, $scope.counting);
	};
	
	$scope.details_new = function() {
		$scope.counting.details.push({});
	};
	
	$scope.details_remove = function(index) {
		
		if($scope.counting.details[index].id)
		{
			WarehouseService.WHCountingStore.destory({id:$scope.counting.details[index].id,type:'detail'},function(){
				
			});
		}
		
		$scope.counting.details.splice(index, 1);
	};
	
	$scope.update=function()
	{
		WarehouseService.WHCountingStore.update($scope.counting,function(){
			window.location.reload(); 			
		});
	}
	
	$scope.confirm=function()
	{
		$scope.counting.status="confirmed";
		
		var detailNum=$scope.counting.details.length;
		if(detailNum>0)
		{
			WarehouseService.WHCountingStore.confirm($scope.counting,function(){
				window.location.reload();			
			});
		}
		else
		{
			alert("请先添加明细!");
		}
		
	}
	
	$scope.checking=function()
	{
		WarehouseService.WHCountingStore.checking({id:$routeParams.id},function(){
			window.location.reload(); 	
		});
	}
	
	$scope.allDetailIsChecked=function()
	{
		for(var i in $scope.counting.details)
		{
			if($scope.counting.details[i].diff_qty ==null)
			{
				return false;
			}
		}
		return true;
	}
	
	$scope.generate=function()
	{
		WarehouseService.WHCountingStore.generate({id:$routeParams.id},function(){
			window.location.reload(); 	
		});
	}
	
	$scope.returnPending=function()
	{
		WarehouseService.WHCountingStore.returnPending({id:$routeParams.id},function(){
			window.location.reload(); 
		});
	}

}]);




///////////////////////////////////////////////////////////
//调度单的ctrl
///////////////////////////////////////////////////////////

erp.controller('WHDispatchCtrl', ['$scope', 'WarehouseService', 'MetaService','ItemService',function ($scope, WarehouseService,MetaService,ItemService) {
	
	
	$scope.dispatchList=WarehouseService.WHShipStore.query();
	
	$scope.warehouses = MetaService.whList();
	
	var wareHouseRemote=angular.copy($scope.warehouses);
	
	$scope.skus = MetaService.itemList();
	
	$scope.statuses=MetaService.warehouseShipStatusList();
	
	$scope.TsStatus=MetaService.warehouseShipTsStatusList();
	
	
	var nowDate=new Date();
	
	$scope.searchModel={};
	
	$scope.searchModel.timeEnd=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	
	nowDate.setTime(nowDate.getTime()-86400000*7);
	$scope.searchModel.timeStart=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	
	$scope.getFromWarehouses=function()
	{
		var tempWareHouse=angular.copy(wareHouseRemote);
		if(! $scope.searchModel.towarehouse)
		{
			return tempWareHouse;
		}
		else
		{
			var id = $scope.searchModel.towarehouse.id;
			var rt=new Array();
			var j=0;
			for(var i in tempWareHouse)
			{
				if(tempWareHouse[i].id != id)
				{
					var temObj={};
					temObj.id=tempWareHouse[i].id ;
					temObj.name=tempWareHouse[i].name ;
					rt[j]=temObj;
					j++;
				}	
			}
			return rt;
		}
	
	}
	
	$scope.getToWarehouses=function()
	{
		var tempWareHouse=angular.copy(wareHouseRemote);
		if(! $scope.searchModel.fromwarehouse)
		{
			return tempWareHouse;
		}
		else
		{
			var id = $scope.searchModel.fromwarehouse.id;
			var rt=new Array();
			var j=0;
			for(var i in tempWareHouse)
			{
				if(tempWareHouse[i].id != id)
				{
					var temObj={};
					temObj.id=tempWareHouse[i].id ;
					temObj.name=tempWareHouse[i].name ;
					rt[j]=temObj;
					j++;
				}
					
			}
			return rt;
		}
	}
	
	//var store = MetaService.storeBuilder('warehouse', 'WHDispatch');
	$scope.toFilter=function()
	{
		var params={};
		params.invoice=$scope.searchModel.invoice?$scope.searchModel.invoice:"";
		params.sku = $scope.searchModel.sku ? $scope.searchModel.sku.id : '';
		params.status =$scope.searchModel.status ? $scope.searchModel.status.id : '';
		params.towarehouse = $scope.searchModel.towarehouse ? $scope.searchModel.towarehouse.id : '';
		params.fromwarehouse = $scope.searchModel.fromwarehouse ? $scope.searchModel.fromwarehouse.id : '';
		params.timeFrom = $scope.searchModel.timeStart;
		params.timeTo = $scope.searchModel.timeEnd;
		
		params.outTimeFrom = $scope.searchModel.dateOutTimeStart;
		params.outTimeTo = $scope.searchModel.dateOutTimeEnd;
		
		params.receiveTimeFrom = $scope.searchModel.dateReceiveTimeStart;
		params.receiveTimeTo = $scope.searchModel.dateReceiveTimeEnd;
		
		if(! params.sku)
		{
			params.skuLike=jQuery(".form-control#sku").val();
		}
		
		var list = WarehouseService.WHShipStore.query(params, function() {
			$scope.dispatchList = list;
		});
	}
	
	$scope.toExport=function()
	{
		alert("in working!");
	}
	
	
	$scope.toPrint=function($index)
	{
		
		alert("this for print !");
	}
	
	//$scope.moreFilter=false;
	$scope.toggleMoreFilter=function()
	{
		if($scope.moreFilter) $scope.moreFilter=false;
		else $scope.moreFilter=true;
	}
	
	$scope.deleteDispatch=function(id)
	{
	
		WarehouseService.WHShipStore.destory({id:id},function(data){		
			if(data.return == 0)
			{	
				location.href="#/warehouse/dispatch";
			}
			else
			{
				alert(data.return);
			}
		});
	}
}]);

//新建
erp.controller('WHDispatchCreateCtrl', ['$scope', 'WarehouseService','ItemService','MetaService', '$location',function ($scope, WarehouseService,ItemService,MetaService,$location) {
	
	$scope.dispatch = WarehouseService.WHShipStore.get({id:'new'});
	
	$scope.warehouses =  MetaService.whList();
	
	$scope.skus = MetaService.itemList();
	
	$scope.statuses=MetaService.warehouseShipStatusList();
	
	$scope.TsStatus=MetaService.warehouseShipTsStatusList();	
	
	$scope.create=function()
	{
		if($scope.dispatch.invoice =="")
		{
			alert("invoice 不能为空");
			return false;
		}
		
			WarehouseService.WHShipStore.save($scope.dispatch,function(data){		
			if(data.id)
			{	
				location.href="#/warehouse/dispatch/update/"+data.id;
			}
			else
			{
				alert(data.return);
			}
		});
	}
	
}]);

//调度单单的更新
erp.controller('WHDispatchUpdateCtrl', ['$scope','$routeParams', 'WarehouseService', 'ItemService', 'MetaService','$location',function ($scope,$routeParams, WarehouseService,ItemService,MetaService,$location) {
	$scope.warehouses =  MetaService.whList();
	
	$scope.skus = MetaService.itemList();
	
	$scope.statuses=MetaService.warehouseShipStatusList();
	
	$scope.TsStatus=MetaService.warehouseShipTsStatusList();	
	$scope.dispatch = WarehouseService.WHShipStore.get({id:$routeParams.id},function(){		
		$scope.remote = angular.copy($scope.dispatch);
	});
	
	$scope.isClean=function(){
		return angular.equals($scope.remote, $scope.dispatch);
	};
	
	$scope.details_new = function() {
		$scope.dispatch.details.push({});
	};
	
	$scope.details_remove = function(index) {
		
		if($scope.dispatch.details[index].id)
		{
			WarehouseService.WHShipStore.destory({id:$scope.dispatch.details[index].id,type:'detail'},function(){
				
			});
		}
		
		$scope.dispatch.details.splice(index, 1);
	};
	
	jQuery('#shipment a').click(function (e) {
		jQuery('.nav a').parent().each(function(){
			jQuery(this).removeClass('active');
		});

		jQuery(this).parent().addClass('active');
		var i= '#div'+jQuery(this).attr('id');
		jQuery('#div1').hide();
		jQuery('#div2').hide();
		jQuery(i).show();
	})
	
	$scope.update=function()
	{
		
		WarehouseService.WHShipStore.update($scope.dispatch,function(data){
			if(data.return == 0)
			{
				window.location.reload(); 
			}
			else
			{
				alert(data.ErrMsg);
			}
		});
	}
	
	$scope.confirm=function()
	{
		//$scope.dispatch.status="confirmed";
		
		var detailNum=$scope.dispatch.details.length;
		if(detailNum>0)
		{
			WarehouseService.WHShipStore.confirm($scope.dispatch,function(data){
				if(data.return == 0)
				{
					$location.path('/warehouse/dispatch');
				}
				else
				{
					alert(data.ErrMsg);
				}
			});
		}
		else
		{
			alert("请先添加明细!");
		}
		
	}
	

	
	$scope.generate=function()
	{
		WarehouseService.WHShipSpeStore.generate({id:$routeParams.id},function(data){
			if(data.return ==0)
			{
				alert("generate ok!");
				window.location.reload(); 
				//$location.path('/warehouse/dispatch/update/'+$routeParams.id);
			}
			else
			{
				alert(data.errorMsg);
			}
		});
	}
	
	$scope.specailChange=function(id)
	{
		$location.path('/warehouse/WHDispatch/specail/'+id);
	}
	
}]);

//调度单的特殊修改

erp.controller('WHDispatchSpecailCtrl', ['$scope','$routeParams', 'WarehouseService', 'ItemService', 'MetaService','$location',function ($scope,$routeParams, WarehouseService,ItemService,MetaService,$location) {
		var thisId= $routeParams.id;
		$scope.warehouses =  MetaService.whList();
		
		$scope.skus = MetaService.itemList();
		
		$scope.TsStatus=MetaService.warehouseShipTsStatusList();	
		$scope.dispatch = WarehouseService.WHShipStore.get({id:$routeParams.id},function(){		
			$scope.remote = angular.copy($scope.dispatch.details);
		});
	
		
		$scope.isClean=function(){
			return angular.equals($scope.remote,$scope.dispatch.details);
		};
		
		//sku替换
		$scope.updateSku=function()
		{
			var params={};
			params.id=thisId;
			params.formSku=$scope.skuModel.oldsku;
			params.toSku=$scope.skuModel.newsku;
			var skus=$scope.getAllSkus();
			var isExists=false;
			
			for(var i in skus)
			{
				if(skus[i] == params.formSku) 
				{
					isExists=true;
					break;
				}
			}
			
			if(isExists)
			{
				if(params.toSku !="")
				{
					alert(123456);
					WarehouseService.WHShipSpeStore.updateSkus(params,function(data){
						if(data.return =="0")
						{
							$location.path('/warehouse/dispatch/specail/' + $routeParams.id);
						}
						else
						{
							alert(data.errorMsg);
						}
					});
				}
				else
				{
					alert("修改后SKU 不能为空!");
				}
			}
			else
			{
				alert("本出入库单 不包含此sku"+params.formSku);
			}		
		}
		
		//全部保存
		$scope.saveAll=function()
		{
			var params={};
			params.id=thisId;
			params.details=$scope.dispatch.details;
			WarehouseService.WHShipSpeStore.setAllDetails(params,function(data){
				if(data.return =="0")
				{
					$location.path('/warehouse/dispatch/specail/' + $routeParams.id);
				}
				else
				{
					alert(data.errorMsg);
				}
			});
		}
		
		//整单返回
		$scope.returnPending=function()
		{
			WarehouseService.WHShipSpeStore.returnPending({id:thisId},function(data){
				if(data.return == '0' )
				{
					$location.path('/warehouse/dispatch/');
				}
				else
				{
					alert(data.errorMsg);
				}
			});
		}
		
		//更改条码
		$scope.UpdateAllBoxId=function()
		{
			var params={};
			params.id=thisId;
			params.details=$scope.dispatch.details;
			WarehouseService.WHShipSpeStore.updateBoxId(params,function(data){
				if(data.return == '0' )
				{
					$location.path('/warehouse/dispatch/specail/' + $routeParams.id);
				}
				else
				{
					alert(data.errorMsg);
				}
			});
		}
		
		
		$scope.getAllSkus=function()
		{
			var skus=[];
			for(var i in $scope.dispatch.details)
			{
				skus[i]=$scope.dispatch.details[i].item.sku;
			}
			return skus;
		}
		
	
}]);

//-----------------controller end--------------------------//