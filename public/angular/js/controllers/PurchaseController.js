'use strict';

erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
	$routeProvider.when('/purchase/vendor', {
		templateUrl: 'angular/views/purchase/vendor/index.html',
		controller: 'vendorCtrl'
	}).
	when('/purchase/vendor/edit/:id', {
		templateUrl: 'angular/views/purchase/vendor/edit.html',
		controller: 'vendorEditCtrl'
	}).
	when('/purchase/quotation', {
		templateUrl: 'angular/views/purchase/quotation/index.html',
		controller: 'quotationCtrl'
	}).
	when('/purchase/quotation/edit/:id', {
		templateUrl: 'angular/views/purchase/quotation/edit.html',
		controller: 'quotationEditCtrl'  
	}).
	when('/purchase/uploadRequest', {
		templateUrl: 'angular/views/purchase/request/indexUpload.html',
		controller: 'uploadRequestCtrl'
	}).
	when('/purchase/request', {
		templateUrl: 'angular/views/purchase/request/index.html',
		controller: 'requestCtrl'
	}).
	when('/purchase/request/edit/:id', {
		templateUrl: 'angular/views/purchase/request/edit.html',
		controller: 'requestEditCtrl'
	}).
	when('/purchase/request/view/:id', {
		templateUrl: 'angular/views/purchase/request/view.html',
		controller: 'requestViewCtrl'
	}).
	when('/purchase/order', {
		templateUrl: 'angular/views/purchase/order/index.html',
		controller: 'orderCtrl'
	}).
	when('/purchase/mergeOrder', {
		templateUrl: 'angular/views/purchase/order/merge.html',
		controller: 'mergeOrderCtrl'
	}).
	when('/purchase/order/showPrint/:id', {
		templateUrl: 'angular/views/purchase/order/print.html',
		controller: 'orderShowPrint'
	}).
	when('/purchase/order/special/:id', {
				templateUrl: 'angular/views/purchase/order/special.html',
				controller: 'orderSpecailCtrl'
	}).
	when('/purchase/order/edit/:id', {
		templateUrl: 'angular/views/purchase/order/edit.html',
		controller: 'orderEditCtrl'
	}).
	when('/purchase/assign', {
		templateUrl: 'angular/views/purchase/assign/index.html',
		controller: 'assignCtrl'
	}).
	when('/purchase/check', {
		templateUrl: 'angular/views/purchase/check/index.html',
		controller: 'PCheckCtrl'
	}).
	when('/purchase/return', {
		templateUrl: 'angular/views/purchase/return/index.html',
		controller: 'returnCtrl'
	}).
	when('/purchase/return/create', {
		templateUrl: 'angular/views/purchase/return/create.html',
		controller: 'returnNewCtrl'
	}).
	when('/purchase/return/update/:id', {
		templateUrl: 'angular/views/purchase/return/update.html',
		controller: 'returnUpdateCtrl'
	}).
	when('/purchase/return/special/:id', {
		templateUrl: 'angular/views/purchase/return/specail.html',
		controller: 'returnSpecailCtrl'

	}).
//	when('/purchase/exec', {
//		templateUrl: 'angular/views/purchase/planexec/index.html',
//		controller: 'execCtrl'
//	}).
	when('/purchase/exec', {
	templateUrl: 'angular/views/purchase/planexec/exec.html',
	controller: 'PP2POCtrl'
	}).
	when('/purchase/pp2po', {
		templateUrl: 'angular/views/purchase/planexec/pp2po.html',
		controller: 'PP2POCtrl'
	}).
	when('/purchase/ship', {
		templateUrl: 'angular/views/purchase/ship/index.html',
		controller: 'shipCtrl'
	}).
	when('/purchase/packing', {
		templateUrl: 'angular/views/purchase/packing/index.html',
		controller: 'packingCtrl'
	}).
	when('/purchase/packing/new', {
		templateUrl: 'angular/views/purchase/packing/detail.html',
		controller: 'packingNewCtrl'
	}).
	when('/purchase/packing/edit/:id', {
		templateUrl: 'angular/views/purchase/packing/detail.html',
		controller: 'packingEditCtrl'
	}).when('/audit/pr', {
		templateUrl: 'angular/views/purchase/audit/pr.html',
		controller: 'AuditPrCtrl'
	}).when('/audit/pr/edit/:id', {
		templateUrl: 'angular/views/purchase/audit/edit.html',
		controller: 'AuditPrEditCtrl'
	}).when('/audit/pr/view/:id', {
		templateUrl: 'angular/views/purchase/audit/view.html',
		controller: 'AuditPrViewCtrl'
	})
	.when('/audit/pr/view_spe/:id', {
		templateUrl: 'angular/views/purchase/audit/view_special.html',
		controller: 'AuditPrViewSpeCtrl'
	})
	.when('/purchase/costparams', {
		templateUrl: 'angular/views/purchase/costparams/index.html',
		controller: 'CostParamsCtrl'
	}).when('/purchase/costparams/edit/:id', {
		templateUrl: 'angular/views/purchase/costparams/edit.html',
		controller: 'CostParamsEditCtrl'
	})
	;
}]);

erp.controller('vendorCtrl', ['$scope', 'PurchaseService', function ($scope, PurchaseService) {
	  
	$scope.vendors = PurchaseService.vendorStore.query();
}]);
erp.controller('orderSpecailCtrl', ['$scope','$location','PurchaseService', 'FlashService','$routeParams',function ($scope, $location,PurchaseService,FlashService,$routeParams) {
	   $scope.id= $routeParams.id;
	   $scope.orderReturn = function(data){
	   	  	  PurchaseService.orderReturn.orderReturn({id:$routeParams.id},function(data){
			  if(data.return==0)
			  {   
				    alert("整单返回成功");
				   $location.path('/purchase/order'); 
			  }
			  else{
				  alert(data.ErrMsg);
			  }
		});   
	   };
    	  
}]);
erp.controller('orderShowPrint', ['$scope', '$routeParams','PurchaseService','MetaService', function ($scope,$routeParams,PurchaseService,MetaService){
	$scope.order =PurchaseService.orderStore.get({id:$routeParams.id},function(data){ 
		             var total_qty = 0;
		             var total_price = 0;
		  	 	for (var i in data.details) {
					   total_price += $scope.order.details[i].qty * 1 * $scope.order.details[i].unit_price;
					    total_qty  += data.details[i].qty*1;
					    $scope.order.details[i].unit_price_real = $scope.order.details[i].unit_price;
				}  
				  $scope.order.total_qty =   total_qty;
		          $scope.order.total_price ="¥"+ total_price;
				  $scope.order.total_font = $scope.changeNumber(total_price);
	          
	});
	
	$scope.changePrice = function(value){
	   var total_price=0 ;
	   var total_qty=0;
		switch(value) {
			case "in_us": 
				for (var i in $scope.order.details) {
					$scope.order.details[i].unit_price_real = $scope.order.details[i].usd_unit_price;
					total_price += $scope.order.details[i].qty * 1 * $scope.order.details[i].usd_unit_price;
					total_qty += parseInt($scope.order.details[i].qty);
					
				}
				break;
			case "in_ch":
				for (var i in $scope.order.details) {
					$scope.order.details[i].unit_price_real = $scope.order.details[i].tax_unit_price;
					total_price += $scope.order.details[i].qty * 1 * $scope.order.details[i].tax_unit_price;
					total_qty += parseInt($scope.order.details[i].qty);
				};
				break;
			case "un_ch":
				for (var i in $scope.order.details) {
					$scope.order.details[i].unit_price_real = $scope.order.details[i].unit_price;
					total_price += $scope.order.details[i].qty * 1 * $scope.order.details[i].unit_price;
					total_qty   += parseInt($scope.order.details[i].qty);
				}

		}
		if(value=="in_ch"||value=="un_ch"){
			 $scope.order.total_price ="¥"+ total_price; 
			 $scope.order.total_font = $scope.changeNumber(total_price);
		}else{
			 $scope.order.total_price = $scope.order.total_font ="$"+ total_price;
		}
		
		$scope.order.total_qty =   total_qty;
		$scope.order.font = total_font;
		
	};
   
    $scope.changeNumber=function(numberValue){
    	  

		var numberValue = new String(Math.round(numberValue * 100));
		var chineseValue = "";
		// 转换后的汉字金额
		var String1 = "零壹贰叁肆伍陆柒捌玖";
		// 汉字数字
		var String2 = "万仟佰拾亿仟佰拾万仟佰拾元角分";
		// 对应单位
		var len = numberValue.length;
		// numberValue 的字符串长度
		var Ch1;
		// 数字的汉语读法
		var Ch2;
		// 数字位的汉字读法
		var nZero = 0;
		// 用来计算连续的零值的个数
		var String3;
		// 指定位置的数值
		if (len > 15) {
			alert("超出计算范围");
			return "";
		}
		if (numberValue == 0) {
			chineseValue = "零元整";
			return chineseValue;
		}
		String2 = String2.substr(String2.length - len, len);
		// 取出对应位数的STRING2的值
		for (var i = 0; i < len; i++) {
			String3 = parseInt(numberValue.substr(i, 1), 10);
			// 取出需转换的某一位的值
			if (i != (len - 3) && i != (len - 7) && i != (len - 11) && i != (len - 15)) {
				if (String3 == 0) {
					Ch1 = "";
					Ch2 = "";
					nZero = nZero + 1;
				} else if (String3 != 0 && nZero != 0) {
					Ch1 = "零" + String1.substr(String3, 1);
					Ch2 = String2.substr(i, 1);
					nZero = 0;
				} else {
					Ch1 = String1.substr(String3, 1);
					Ch2 = String2.substr(i, 1);
					nZero = 0;
				}
			} else {// 该位是万亿，亿，万，元位等关键位
				if (String3 != 0 && nZero != 0) {
					Ch1 = "零" + String1.substr(String3, 1);
					Ch2 = String2.substr(i, 1);
					nZero = 0;
				} else if (String3 != 0 && nZero == 0) {
					Ch1 = String1.substr(String3, 1);
					Ch2 = String2.substr(i, 1);
					nZero = 0;
				} else if (String3 == 0 && nZero >= 3) {
					Ch1 = "";
					Ch2 = "";
					nZero = nZero + 1;
				} else {
					Ch1 = "";
					Ch2 = String2.substr(i, 1);
					nZero = nZero + 1;
				}
				if (i == (len - 11) || i == (len - 3)) {// 如果该位是亿位或元位，则必须写上
					Ch2 = String2.substr(i, 1);
				}
			}
			chineseValue = chineseValue + Ch1 + Ch2;
		}
		if (String3 == 0) {// 最后一位（分）为0时，加上“整”
			chineseValue = chineseValue + "整";
		}
		return chineseValue;

    	   
      } ;

	$scope.print = function(index) {
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

/*		bdhtml=window.document.body.innerHTML;  
		alert(bdhtml);
		sprnstr="<!--startprint-->";  
		eprnstr="<!--endprint-->";  
		prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);  
		prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));  
		window.document.body.innerHTML=prnhtml;  
		window.print();  */
	};

	$scope.printPreview = function(){
		  alert("this is for printPreview");
	};
	$scope.download = function(){
		 alert("this is for downlaod");
	};
}]);
erp.controller('vendorEditCtrl', ['$scope','MetaService', '$routeParams', '$location', 'PurchaseService', 'ItemService', function ($scope, MetaService,$routeParams, $location, PurchaseService, ItemService) {
	var brand = ($routeParams.id == 'new');

	$scope.categories = ItemService.cateStore.query();
	$scope.vendor = brand ? {} : PurchaseService.vendorStore.get({id: $routeParams.id});
	$scope.update = brand ? function() {
		PurchaseService.vendorStore.save($scope.vendor, function() {
			$location.path('/purchase/vendor');
		});
	} : function() {
		PurchaseService.vendorStore.update($scope.vendor, function() {
			$location.path('/purchase/vendor');
		});
	};
}]);

erp.controller('quotationCtrl', ['$scope', 'PurchaseService', function ($scope, PurchaseService) {
	$scope.quotations = PurchaseService.quotationStore.query();
}]);

erp.controller('quotationEditCtrl', ['$scope', '$routeParams', '$location', 'PurchaseService', 'ItemService', function ($scope, $routeParams, $location, PurchaseService, ItemService) {
	var brand = ($routeParams.id == 'new');

	$scope.items = ItemService.getItemList();
	$scope.vendors = PurchaseService.vendorStore.query();
	$scope.taxs = ItemService.metaStore.query({key: 'taxList'});


	var quotation = brand ? {} : PurchaseService.quotationStore.get({id: $routeParams.id}, function() {
		$scope.quotation = quotation;
		$scope.remote = angular.copy(quotation);
		$scope.quotation.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.quotation);
	};

	$scope.update = brand ? function() {
		PurchaseService.quotationStore.save($scope.quotation, function() {
			$location.path('/purchase/quotation');
		});
	} : function() {
		PurchaseService.quotationStore.update($scope.quotation, function() {
			$location.path('/purchase/quotation');
		});
	};

	$scope.destroy = function() {
		quotation.$remove(function() {
			$location.path('/purchase/quotation');
		});
	};
}]);
erp.controller('uploadRequestCtrl', ['$scope','$upload','Paginator','MetaService','PurchaseService',function ($scope, $upload,Paginator,MetaService,PurchaseService) {
   	var fetchFunction = function(offset, limit, callback) {
		PurchaseService.requestQueues.query({offset: offset, limit: limit}, function(queues) {
			callback(queues);
		});
	};

	$scope.paginator = Paginator(fetchFunction, MetaService.config.page.size);

	$scope.refresh = function() {$scope.paginator._load();};

	$scope.showError = function(item) {
		$scope.error_display = item;
		jQuery('#error_modal').modal();
	};
	
	
	

}]);
 
erp.controller('requestCtrl', ['$scope','$location', 'PurchaseService','MetaService', function ($scope, $location,PurchaseService,MetaService) {

	$scope.requests = PurchaseService.requestStore.query();
	$scope.statuses	= MetaService.PRStatusList();
	$scope.types	= MetaService.PRTypeList();
	$scope.warehouses = MetaService.whList();
	$scope.skus		= MetaService.itemList();
	
	
	
	$scope.toFilter=function()
	{
		var params={};
		params.invoice=$scope.searchModel.invoice?$scope.searchModel.invoice:"";
		params.relation_id=$scope.searchModel.relation_id?$scope.searchModel.relation_id:"";
		params.sku = $scope.searchModel.sku ? $scope.searchModel.sku.id : '';
		params.status =$scope.searchModel.status ? $scope.searchModel.status.id : '';
		params.warehouse = $scope.searchModel.warehouse ? $scope.searchModel.warehouse.id : '';
		params.type =$scope.searchModel.type ? $scope.searchModel.type.id : '';
		
		if(! params.sku)
		{
			params.skuLike=jQuery(".form-control#sku").val();
		}
		
		var list = PurchaseService.requestStore.query(params, function() {
			$scope.requests = list;
		});
	}
	
	$scope.toExport=function(){
		
	}
	
	var nowDate=new Date();
	
	function strToDate(dateStr)
	{
		var date = new Date(dateStr);
	    //add by zhunian
	    if( isNaN(date) )
	    {	
	  	  var dateWithTimeRe=/^([\d]{4})[\-\/]([\d]{1,2})[\-\/]([\d]{1,2})\s+[\d]{1,2}[\:][\d]{1,2}[\:][\d]{1,2}$/;
	  	  var dateWithoutTimeRe=/^([\d]{4})[\-\/]([\d]{1,2})[\-\/]([\d]{1,2})$/;        	  
	  	  if(dateWithTimeRe.test(dateStr))
	  	  {
	  		  var arr =dateWithTimeRe.exec(dateStr); 
	  		  date=new Date(parseInt(arr[1]),parseInt(arr[2])-1,parseInt(arr[3]));        		  
	  	  }
	  	  else if(dateWithoutTimeRe.test(dateStr))
	        {
	  		  var arr =dateWithoutTimeRe.exec(dateStr);
	  		  date=new Date(parseInt(arr[1]),parseInt(arr[2])-1,parseInt(arr[3]));  
	        }
	    }
	    
	    if(isNaN(date))
	    {
	    	date=new Date();
	    }
	    
	    return date;
	}
	
	$scope.isExpired=function(request)
	{
		//如果未提交 则提醒
		if(request.status=="confirmed" || request.status=="pending")
		{
			var eD=strToDate(request.expired_at);
			if(nowDate.getTime() >=eD.getTime()) return true;
			else
				return false;
		}
		//状态为过期状态
		else if(request.status=="expired")
		{
			return true;
		}
		//其他为已经审核  和审核之后的状态
		else
			return false;
		
	}
	
	$scope.isToExpiring=function(request)
	{
		
		//如果未提交 则提醒
		if(request.status=="confirmed" || request.status=="pending")
		{
			var eD=strToDate(request.expired_time);
			if((nowDate.getTime() >= (eD.getTime()+2*86400*1000)) && (nowDate.getTime() <= (eD.getTime()))) return true;
			else
				return false;
		}
		//其他为已经审核  和审核之后的状态
		else
			return false;
	}
	
	
	$scope.destroy=function(id){
		PurchaseService.requestStore.remove({id:id}, function() {
			$scope.requests = PurchaseService.requestStore.query();
		});
	};
	
	function findRequestById(request_id)
	{
		for(var i in $scope.requests)
		{
			if($scope.requests[i].id==request_id)
				return i;
		}
		return -1;
	}
	
	$scope.confirm=function(request_id){
		var index=findRequestById(request_id);
		if(index!=-1)
		{
			$scope.requests[index].status="confirmed";
			PurchaseService.requestStore.update($scope.requests[index], function() {			
				$location.path('/purchase/request/');
			});
			return false;
		}
	};
	
	$scope.unconfirm=function(request_id){
		
		var index=findRequestById(request_id);
		if(index!=-1)
		{
			$scope.requests[index].status="pending";
			PurchaseService.requestStore.update($scope.requests[index], function() {			
				$location.path('/purchase/request/');
			});
			return false;
		}
	};
	
	jQuery("[data-toggle='tooltip']").live("mouseover",function(){
		//alert("123");
		jQuery(this).tooltip({placement:'top'});
	});	
}]);
 
   erp.controller('uploadCtrl', function ($scope) {
        $scope.uploadComplete = function (content, completed) {
            if (completed&&content) { 
            	
                alert("文件导入成功");
                window.location.reload();
            }
        };
    }); 
erp.controller('requestEditCtrl', ['$scope', '$routeParams', '$upload','$location', 'ItemService','MetaService', 'FlashService','PurchaseService','$filter', function ($scope, $routeParams, $upload, $location, ItemService,MetaService, FlashService,PurchaseService,$filter) {
	 // common list
	$scope.skus = MetaService.itemList();
	$scope.status = MetaService.PRStatusList();
	$scope.types = MetaService.PRTypeList();
	$scope.whs = MetaService.whList();
	$scope.platforms = MetaService.platformList();
	$scope.trans = MetaService.transportList();
	$scope.request_id = $routeParams.id;
	$scope.holder_detail={};
	
	$scope.allCostFee=PurchaseService.costparamStore.query({id:'getAll',costparams:'allCostparamsFee'});
	
	var feeCostparams=MetaService.storeBuilder('item','meta').query({key:'purchaseCostparams'},function(data){
		feeCostparams=data;
	});
	var vendorQuotations=MetaService.storeBuilder('item','meta').query({key:'vendorQuotation'},function(data){
		vendorQuotations=data;
	});
	var skuDefault=MetaService.storeBuilder('item','meta').query({key:'skudefaultvendor'},function(data){
		skuDefault=data;
	});
	
	
	var brand = ($routeParams.id == 'new');
	$scope.isAddNewDetail=false;
	
	$scope.persisted = ! brand;
	$scope.request = {
		details: []
	};
	
	 
	var request = PurchaseService.requestStore.get({id: $routeParams.id}, function() {
		$scope.request = request;
		$scope.remote = angular.copy(request);
		$scope.request.$id = $routeParams.id;
	});
	
	if(!$scope.persisted)
	{
		var nowDate=new Date();
		$scope.request.expired_time=new Date(nowDate.getTime()+5*86400*1000);
	}
	
	
	
	$scope.getMinExpiredTime=function()
	{
		var nowDate=new Date();
		return new Date(nowDate.getTime()+5*86400*1000);
	}
	
	$scope.expired_at_min_d=$scope.getMinExpiredTime();
	
	$scope.checkExpiredAt=function(input_expired_at)
	{
		var inputTime;
		if(angular.isString(input_expired_at))
		{
			if(input_expired_at.length<10) 
			{
				return true;
			}
			else
			{
				inputTime=new Date(input_expired_at.substring(0,10));
			}
		}
		else if(angular.isDate(input_expired_at))
		{
			inputTime=new Date(input_expired_at);
		}
		
		var pass= inputTime.getTime() <=$scope.expired_at_min_d.getTime();
		return pass;
	};
	
	jQuery("[data-toggle='tooltip']").tooltip({placement:'top',delay: { show: 600, hide: 200 }});
	
	
	$scope.reflushAfterUpload=function(){
		 window.location.reload(); 
	};
	$scope.uploadInfo=[];
	
	$scope.onFileSelect = function($files,$id) {
		
	    for (var i = 0; i < $files.length; i++) {
			var file = $files[i];
			$scope.upload = $upload.upload({
				url: '/api/purchase/requestImport/'+$id,
				file: file,
				data:{"request_id":$id},
			}).progress(function(event) {
				// console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
			}).success(function(data, status, headers, config) 
			 {
				var formatData=data.split("\n");	
				for (var i=0;i<formatData.length;i++)
				{
					var tmp={};
					tmp.index=i;
					tmp.msg=formatData[i];
					$scope.uploadInfo.push(tmp);
				}
				
				jQuery('#error_modal_upload').modal();
			});
		}
	};
	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.request);
	};

	$scope.isHolderClean = function() {
		return angular.equals($scope.holder_origin, $scope.holder_detail);
	}

	$scope.details_new = function() {
		$scope.btn_add_show = true;
		$scope.holder_origin = angular.copy({});
		$scope.holder_detail = {};
		jQuery('#request_edit').modal();
		$scope.isAddNewDetail=true;
	};

	$scope.details_edit = function(index) {	
		$scope.btn_add_show = false;
		var detail = $scope.request.details[index];
		$scope.holder_origin = angular.copy(detail);
		$scope.holder_detail = detail;

		// customer matching, see: http://stackoverflow.com/questions/15326164/setting-the-selected-item-in-angularjs-select-directive
		for(var i in $scope.platforms)
		{
			if(angular.isDefined($scope.platforms[i].id) && angular.isDefined(detail.platform_id))
			{
				if($scope.platforms[i].id==detail.platform_id)
				{
					var platform=$scope.platforms[i];
					$scope.holder_detail.platform=platform;
				}
			}	
		}
		
		jQuery('#request_edit').modal();
		$scope.isAddNewDetail=false;
	};

	$scope.details_remove = function(index) {
		// $scope.request.details.splice(index, 1);
		$scope.request.details = _.reject($scope.request.details, function(detail) {
			return detail.parent_id == $scope.request.details[index].id || detail.id == $scope.request.details[index].id;
		});
	}

	$scope.holder_push = function() {
		if($scope.isAddNewDetail)
		{
			$scope.request.details.push($scope.holder_detail);
		}
		else
		{
			
		}
		$scope.holder_detail = {};
		jQuery('.modal').modal('hide');
	};

	$scope.update = brand ? function() {

		PurchaseService.requestStore.save($scope.request, function(data) {
			if(data.id)
			{
				alert("保存成功");
				$location.path('/purchase/request/edit/'+data.id);
			}
			else
			{
				location.href="#/purchase/request";
			}
		});

	} : function() {
		PurchaseService.requestStore.update($scope.request, function() {
			alert("修改成功");
			window.location.reload(); 
			//$location.path('/purchase/request/edit/'+$routeParams.id);
		});
	};
	
	
	$scope.confirm=brand ?function(){return;}:function(){
		$scope.request.status="confirmed";
		PurchaseService.requestStore.update($scope.request, function() {
		
			$location.path('/purchase/request/edit/'+$routeParams.id);
		});
	};
	
	$scope.unconfirm=brand ?function(){return;}:function(){
		$scope.request.status="pending";
		PurchaseService.requestStore.update($scope.request, function() {
			$location.path('/purchase/request/edit/'+$routeParams.id);
		});
	};
	
	$scope.destroy=brand ?function(){return;}:function(){		
		PurchaseService.requestStore.remove({id:$routeParams.id}, function() {
			$location.path('/purchase/request/');
		});
	};
	
	$scope.change=function(){
		if($scope.request.type =='Shipment' || $scope.request.type=='Local') $scope.request.relation_id='0';
	};
	
	
	$scope.getFee=function(wh_id,item_id)
	{
		var fee={}
		for(var i in $scope.allCostFee)
		{
			if($scope.allCostFee[i].warehouse_id==wh_id &&$scope.allCostFee[i].item_id==item_id)
			{
				fee.air_cost=$scope.allCostFee[i].air_cost;
				fee.sea_cost=$scope.allCostFee[i].sea_cost;
			}
		}
		return fee;
	}
	
	
	$scope.getLeadTime=function(){
    	//
    	if(!$scope.holder_detail.item) return 5;
    	else
    	{
    		var item_id=$scope.holder_detail.item.id;
    		var vqModel=_.find(vendorQuotations,function(vq){
    			return vq.item_id==item_id;
    		});
    		return vqModel.lead_time;    		
    	}
    }
	
	var nowDate=new Date();
	
	//审核需要时间 这里取两天
	var verifiedNeedDays=2;
	
	//产品交期
	$scope.lTimeDays=5;
	
	if(!angular.isDefined($scope.holder_detail.item)) 
	{
		$scope.holder_detail.item={};
	}
	
	if(!angular.isDefined($scope.holder_detail.item.fee)) 
	{
		$scope.holder_detail.item.fee={};
	}
	
	$scope.$watch("request.warehouse_id",function(wh_id){
		for(var i in $scope.request.details)
		{
			$scope.request.details[i].item.fee=$scope.getFee(wh_id,$scope.request.details[i].item.id);
		}
	});
	
	//判定当前sku是否可用
	$scope.isSkuCanBeUsed=true;
	
	//sku选定后执行的操作
	$scope.afterChangeItem=function()
	{
		if(angular.isDefined($scope.holder_detail.item) && angular.isDefined($scope.holder_detail.item.id)) 
		{
			var item_id=$scope.holder_detail.item.id;
			$scope.holder_detail.item.fee=$scope.getFee($scope.request.warehouse_id,item_id);
			
			if(skuDefault.length>0)
			{
				var vendor_id=null;
				for(var i in skuDefault)
				{
					if(skuDefault[i].item_id==item_id)
					{
						vendor_id=skuDefault[i].vendor_id;
						break;
					}
				}
				
				if(vendor_id==null)
				{
					$scope.isSkuCanBeUsed=false;
					$scope.skuCanBeUsedReason="sku的默认供应商信息未配置";
					return;
				}
				else
				{
					for(var i in vendorQuotations)
					{
						if(vendorQuotations[i].vendor_id==vendor_id && vendorQuotations[i].item_id==item_id)
						{
							$scope.lTimeDays=parseInt(vendorQuotations[i].lead_time);
							$scope.min_d=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays); 
						    $scope.max_d=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+120+$scope.lTimeDays+verifiedNeedDays);
						    $scope.airTimeStart=$scope.min_d;
							$scope.seaTimeStart=$scope.min_d;
						    $scope.airTimeEnd=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays+3); 
						    $scope.seaTimeEnd=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays+21);
						    $scope.skuCanBeUsedReason="";
						    $scope.isSkuCanBeUsed=true;
						    return ;
						}
					}
					
					$scope.isSkuCanBeUsed=false;
					$scope.skuCanBeUsedReason="指定供应商的信息未配置,或者该供应商提供的此产品不存在!";
					return;
				}
				
			}
			else
			{
				$scope.isSkuCanBeUsed=false;
				$scope.skuCanBeUsedReason="sku的默认供应商信息未配置";
				return;
			}
			
		}
		else
		{
			$scope.isSkuCanBeUsed=false;
			$scope.skuCanBeUsedReason="不能识别的sku";
		}
	}
	
//	$scope.$watch("holder_detail.item",function(item){
//		
//		if(!item) return ;
//		
//		var item_id=item.id;
//		
//		$scope.holder_detail.item.fee=$scope.getFee($scope.request.warehouse_id,item_id);
//		
//		var vqModel=_.find(vendorQuotations,function(vq){
//			return vq.item_id==item_id;
//		});
//		
//		
//		if(angular.isDefined(vqModel))
//		{
//			$scope.lTimeDays=vqModel.lead_time;
//		}		
//		$scope.min_d=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays); 
//	    $scope.max_d=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+120+$scope.lTimeDays+verifiedNeedDays);
//	    $scope.airTimeStart=$scope.min_d;
//		$scope.seaTimeStart=$scope.min_d;
//	     
//	    $scope.airTimeEnd=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays+3); 
//	    $scope.seaTimeEnd=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays+21); 
//	},true);

	
	 $scope.min_d=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays); 
     $scope.max_d=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+120+$scope.lTimeDays+verifiedNeedDays);
     $scope.airTimeStart=$scope.min_d;
	 $scope.seaTimeStart=$scope.min_d;
     
     $scope.airTimeEnd=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays+3); 
     $scope.seaTimeEnd=new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate()+$scope.lTimeDays+verifiedNeedDays+21);     
    	
	
     $scope.getTransportation=function(){
    	var chooseDate;
    	if(!$scope.holder_detail.end_date) 
		{
			return ;
		}
 		if($scope.isAddNewDetail)
 		{ 	
 			chooseDate=new Date($scope.holder_detail.end_date); 			
 		}
 		else
 		{
 			if(angular.isDate($scope.holder_detail.end_date))
 			{
 				chooseDate=$scope.holder_detail.end_date;
 			}
 			else
 			{
 				chooseDate=$filter('localDateTimeFilter')($scope.holder_detail.end_date);
 			}
 		}
 		
 			
 		
 			if(chooseDate.getTime()<$scope.min_d.getTime()) //一天以内 不可能到达
 			{
 				return "时间不可能";
 			}
 			else if(chooseDate.getTime() >= $scope.airTimeStart.getTime() && chooseDate.getTime() <= $scope.airTimeEnd.getTime() ) //一天到3天 只可空运
 			{ 				
 				$scope.holder_detail.transportation="air";
 			}
 			else if(chooseDate.getTime() >= $scope.seaTimeStart.getTime() && chooseDate.getTime() <= $scope.seaTimeEnd.getTime())
 			{ 				
 				$scope.holder_detail.transportation="sea";
 			}
 			else if(chooseDate.getTime() <= $scope.max_d.getTime())
 			{
				$scope.holder_detail.transportation="surface";
 			}
 			else
 			{
 				return "时间充分,可任意选择";
 			}
 		
 		return $scope.holder_detail.transportation;
 	}
    
     
	$scope.getTrans=function()
	{
		var t=[];
		for(var i in $scope.trans)
		{
			if($scope.trans[i].name !="surface")
			{
				var item={name:$scope.trans[i].name};
				t.push(item);
			}
		}
		return t;
	}
}]);


erp.controller('requestViewCtrl',['$scope', '$routeParams', '$upload','$location', 'ItemService','MetaService', 'FlashService','PurchaseService','$filter', function ($scope, $routeParams, $upload, $location, ItemService,MetaService, FlashService,PurchaseService,$filter){
	$scope.skus = MetaService.itemList();
	$scope.status = MetaService.PRStatusList();
	$scope.types = MetaService.PRTypeList();
	$scope.whs = MetaService.whList();
	$scope.platforms = MetaService.platformList();
	$scope.trans = MetaService.transportList();
	$scope.request_id = $routeParams.id;
	$scope.request = {
			details: []
		};
		 
	var request = PurchaseService.requestStore.get({id: $routeParams.id}, function() {
			$scope.request = request;
			$scope.request.$id = $routeParams.id;
	});
	
}]);

/**************************  purchase return *****************************/

erp.controller('returnCtrl',['$scope','PurchaseService', 'ItemService','MetaService',function($scope,PurchaseService, ItemService,MetaService){
	$scope.requests	=PurchaseService.returnStore.query();
	$scope.status	=MetaService.purchaseReturnStatusList();
	$scope.skus 	=MetaService.itemList();	
	$scope.exportModel={};
	
	$scope.toSearch=function(){
		var search={};
		if($scope.exportModel.invoice) search.invoice=$scope.exportModel.invoice;
		if($scope.exportModel.sku) search.item_id=$scope.exportModel.sku.id;
		if($scope.exportModel.vendor) search.vendor_id=$scope.exportModel.vendor;
		if($scope.exportModel.status) search.status=$scope.exportModel.status;
		if($scope.exportModel.timeStart) search.timeStart=$scope.exportModel.timeStart;
		if($scope.exportModel.timeEnd) search.timeEnd=$scope.exportModel.timeEnd;
		
		$scope.requests	=PurchaseService.returnStore.query(search,function(data){
			$scope.requests=data;
		});
	
	}
	
	$scope.export =function(){
		//alert("file will download later!");
		// PurchaseService.returnStore.query();
	}
	$scope.resetExport=function(){
		$scope.exportModel={};
	}
}])


erp.controller('returnNewCtrl',['$scope','$location','PurchaseService', 'ItemService','MetaService',function ($scope,$location, PurchaseService, ItemService,MetaService){
	$scope._returns = PurchaseService.returnStore.get({id:'new'});
	$scope.status	=MetaService.purchaseReturnStatusList();
	$scope.skus 	=MetaService.itemList();
	$scope.warehouses 	=MetaService.whList();
	$scope.vendors = MetaService.vendorList();	
	
	 var warehouseAddrList=MetaService.defaultShipAddrList();

    $scope.setShipAddr=function()
    {
    	var isDuttyAddr=function(addr)
    	{
    		if(!addr) return true;
    		for(var i in warehouseAddrList)
    		{
    			if(warehouseAddrList[i].addr==addr) return true;
    		}
    		return false;
    	};
    	var getWareHouseAddr=function(wid)
    	{
    		if(!wid) return '';
    		for(var i in warehouseAddrList)
    		{
    			if(warehouseAddrList[i].id==wid) return warehouseAddrList[i].addr;
    		}
    		return '';
    	};
    	
    	if(! isDuttyAddr($scope._returns.address)) return ;
    	else
    	{
    		$scope._returns.address=getWareHouseAddr($scope._returns.warehouse_id);
    	}
    };
    
	
	$scope.save=function(){
		PurchaseService.returnStore.save($scope._returns,function(data){	
			if(data.id)
			{
				$location.path("/purchase/return/update/"+data.id);
			}		
		})
	}
	
}])

erp.controller('returnUpdateCtrl', ['$scope', '$routeParams', '$location','PurchaseService', 'ItemService','MetaService', function ($scope, $routeParams, $location,PurchaseService, ItemService,MetaService) {
	alert(123);
	var oldStatus;
	
	$scope._returns		=PurchaseService.returnStore.get({id: $routeParams.id},function(){
		oldStatus=$scope._returns.status;
	});
	$scope.status	=MetaService.purchaseReturnStatusList();
	$scope.skus 	=MetaService.itemList();
	$scope.warehouses 	=MetaService.whList();
	$scope.vendors = MetaService.vendorList();	
	
	$scope.getReturnDetailsNum=function(){
		var i=0	
		for(; i< $scope._returns.details.length;i++)
		{
			i++;
		}		
		return i;
	}
	
	$scope.newDetail	= {return_id:$scope._returns.id};
	
	$scope.flush		=function(){
		$scope._returns		=PurchaseService.returnStore.get({id: $routeParams.id},function(){
			oldStatus=$scope._returns.status;
		});
	};
	
	$scope.update		= function(){		
		PurchaseService.returnStore.update($scope._returns, function() {
			location.href='#/purchase/return';
		});
	}
	
	$scope.generate		=function(){
		PurchaseService.returnStore.generate($scope._returns, function() {
			location.href='#/purchase/return';
		});		
	}
	
	$scope.canShowGenerateButton=function(){
		if(oldStatus =="confirmed" ) return true;
		else
			return false;
	};
	
	$scope.canUpdate=function()
	{
		if(oldStatus=="pending") return true;
		else
			return false;
	}
	
	$scope.confirm=function()
	{
		$scope._returns.status="confirmed";
		PurchaseService.returnStore.update($scope._returns, function() {
			location.href='#/purchase/return';
		});
	};
	
	$scope.destroy=function(){	
		//$scope.flush();	

		
		if($scope.getReturnDetailsNum() != 0)
		{
			alert('please delete the details first!');
			return false;
		}
		else
		{		
			PurchaseService.returnStore.destory({id:$scope._returns.id},function(){			
				$location.path('/purchase/return/');
			})
		}
	}
	
	$scope.showAddDetailsFrom	=function(){
		$scope.newDetail={return_id:$scope._returns.id};
		$scope.detailMethod="add";
		jQuery('.modal').modal();
	};
	
	$scope.CloseAddDetailsFrom	=function(){jQuery('.modal').modal("hide");};
	
	$scope.uploadDetail			=function(id){
		$scope.newDetail={};
		
		for(var i in $scope._returns.details)
		{
			
			if($scope._returns.details[i].id == id)
			{
				
				$scope.newDetail=$scope._returns.details[i];
			}
		}
		
		$scope.detailMethod="save";
		jQuery('.modal').modal();
		
	};
	
	$scope.deleteDetail			=function(id){
		PurchaseService.returnDetailStore.destory({id:id},function(){
			$scope.flush();
		})
	};
	
	$scope.addReturnDetail		=function(){
		$scope.newDetail.return_id=$scope._returns.id;
		//新增
		if($scope.detailMethod == "add")
		{
			PurchaseService.returnDetailStore.save($scope.newDetail);
		}
		else//更新
		{
			PurchaseService.returnDetailStore.update($scope.newDetail);
		}
		
		$scope.flush();
		jQuery('.modal').modal("hide");
	}	
}]);

erp.controller('returnSpecailCtrl', ['$scope', '$routeParams', '$location','PurchaseService', 'SessionService', 'ItemService','MetaService', function ($scope, $routeParams, $location,PurchaseService, SessionService, ItemService,MetaService) {
	var thisId= $routeParams.id;
	
	$scope._returns		=PurchaseService.returnStore.get({id: $routeParams.id},function(){
		$scope.remote = angular.copy($scope._returns.details);
	});
	$scope.status	=MetaService.purchaseReturnStatusList();
	$scope.skus 	=MetaService.itemList();
	$scope.warehouses 	=MetaService.whList();
	$scope.vendors = MetaService.vendorList();	
	
	
	$scope.isClean=function(){
		return angular.equals($scope.remote,$scope._returns.details);
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
				PurchaseService.returnSpecailStore.updateSkus(params,function(data){
					if(data.return =="0")
					{
						$location.path('/purchase/return/update/' + $routeParams.id);
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
		params.details=$scope._returns.details;
		PurchaseService.returnSpecailStore.setAllDetails(params,function(data){
			if(data.return =="0")
			{
				$location.path('/purchase/return/update/' + $routeParams.id);
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
	
		PurchaseService.returnSpecailStore.returnPending({id:thisId},function(data){
			if(data.return == '0' )
			{
				$location.path('/purchase/return/');
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
		for(var i in $scope._returns.details)
		{
			skus[i]=$scope._returns.details[i].item.sku;
		}
		return skus;
	}
	
}]);




//return end 


erp.controller('orderCtrl', ['$scope', 'PurchaseService','MetaService' ,function ($scope, PurchaseService,MetaService) {

	var curPage = 1;
	var params = {};
	var orders = {};
	$scope.orderSearch = {};
	$scope.skus = MetaService.itemList();
	$scope.status = [{id:"pending",name:'pending'},{id:"confirmed",name:'confirmed'},{id:"partially received",name:"partially received"},{id:"completely received",name:"completely received"},{id:"canceld",name:'canceld'}];
	$scope.warehouses = MetaService.whList();
	$scope.users= MetaService.userList();
	
	
	
	//合并所选采购单
	$scope.mergeChecked=function()
	{
		var checkList=[];
		var id;
		jQuery("input:checkbox[name='checkIdList']").each(function()
		{
			if(jQuery(this).attr('checked')=='checked')
			{
				id=jQuery(this).val();
				checkList.push(id);
			}	
		});
		
		if(checkList.length<2)
		{
			alert("合并时,至少选中两项");
		}
		else
		{
			var params={};
			params.orders=checkList;
			PurchaseService.orderStore.merge(params,function(data){
				window.location.href=window.location.href;
			});
		}
		
	}
	
	$scope.toggleCheckedAll=function()
	{
		var o= jQuery("input:checkbox[name='checkAllToggleList']");
		var operaToSeleteAll=o.attr('checked') =='checked';
		jQuery("input:checkbox[name='checkIdList']").each(function()
		{
			if(operaToSeleteAll)
			{
				jQuery(this).attr('checked',true);
			}
			else
			{
				jQuery(this).attr('checked',false);
			}
		});
		
	}
	
	

	function getParams() {
		params.invoice = $scope.orderSearch.invoice || '';
		params.status = $scope.orderSearch.status || '';
		params.warehouse_id = $scope.orderSearch.warehouse_id || '';
		params.created_at = $scope.orderSearch.created_at || '';
		params.updated_at = $scope.orderSearch.updated_at || '';
		params.pg = $scope.orderSearch.pg || curPage;

		if ($scope.orderSearch.item) {
			params.item_id = $scope.orderSearch.item.id;
		}
		if ($scope.orderSearch.agent) {
			params.agent = $scope.orderSearch.agent.id;
		}

	}

	function getOrders() {
		getParams();
		$scope.orders = orders = PurchaseService.orderStore.query(params);
		return orders;
	}

	$scope.hasNextPage = function () {
		if (orders.length === 16) {
			$scope.orders = orders.slice(0, 15);
			return true;
		}
		return false;
	};

	$scope.hasPrePage = function () {
		return curPage > 1;
	};

	$scope.goNextPage = function () {
		params.pg = curPage += 1;
		getOrders();
	};

	$scope.goPrePage = function () {
		params.pg = curPage -= 1;
		getOrders();
	};

	$scope.FilterSearch = function () {
		params.pg = curPage = 1;
		getOrders();
	};

	$scope.cleanSearch = function () {
		$scope.orderSearch = {};
		params = {};
		getOrders();
	};

	getOrders();
    /*if ($routeParams.pg) {
        $scope.orders = PurchaseService.orderStore.query({pg: $routeParams.pg});
    } else {
        $scope.orders = PurchaseService.orderStore.query();
    }

	$scope.skus = MetaService.itemList();
	$scope.status = [{id:"pending",name:'pending'},{id:"confirmed",name:'confirmed'},{id:"partially received",name:"partially received"},{id:"completely received",name:"completely received"},{id:"canceld",name:'canceld'}];
	$scope.warehouses = MetaService.whList();
	$scope.users= MetaService.userList();
    $scope.orderSearch = {};
	$scope.FilterSearch=function()
	{    
		var queryParams={};
		if($scope.orderSearch.planName) queryParams.planName=$scope.orderSearch.planName;
		if($scope.orderSearch.invoice)  queryParams.invoice =$scope.orderSearch.invoice;
		if($scope.orderSearch.item) queryParams.item_id=$scope.orderSearch.item.id;
		if($scope.orderSearch.status) queryParams.status=$scope.orderSearch.status;
		if($scope.orderSearch.warehouse) queryParams.warehouse_id=$scope.orderSearch.warehouse.id; 
		if($scope.orderSearch.agent) queryParams.agent=$scope.orderSearch.agent.id;
		if($scope.orderSearch.created_at) queryParams.created_at=$scope.orderSearch.created_at;
		if($scope.orderSearch.updated_at) queryParams.updated_at=$scope.orderSearch.updated_at;
		PurchaseService.orderStore.query(queryParams,
				function(data){
						$scope.orders=data;
				}
		);	
	}

	$scope.cleanSearch=function(){
		$scope.orderSearch = {};
	};*/
}]);



erp.controller('mergeOrderCtrl', ['$scope', 'PurchaseService','MetaService' ,function ($scope, PurchaseService,MetaService) {
	$scope.orders=[];
	var orders=PurchaseService.orderStore.query({},function(data){
		orders=data;
		$scope.orders=orders;
	});

}]);


erp.controller('orderEditCtrl', ['$scope', '$routeParams','FlashService','PurchaseService','WarehouseService' ,'MetaService', '$location', function ($scope, $routeParams,FlashService,PurchaseService, WarehouseService,MetaService, $location) {
	var brand = ($routeParams.id != 'new');
	$scope.holdWarehouse=true;
	$scope.vendors = MetaService.vendorList();
	$scope.warehouses = MetaService.whList();
	$scope.items = MetaService.itemList();
	$scope.statueslist = ['pending','confirmed','partially received','completely received','cancelled'];
	$scope.rates = ['0.17', '0.12'];
	$scope.payments = [{key:0, name:'cash'}, {key:1, name:'terms'}];
	$scope.currencies = ['CNY', 'USD'];
    $scope.price_types = ['normal', 'tax', 'usd'];
    
    var warehouseAddrList=MetaService.defaultShipAddrList();
    
    if(!brand){
    	     $scope.order = {details:[],status:"pending"};

	    PurchaseService.orderStore.invoice({id: 'new', operation: 'invoice'}, function (data) {

		    $scope.order.invoice = data.invoice;
	    });
    	      PurchaseService.orderStore.get({id:$routeParams.id},function(data){
    	   	  //$scope.order.invoice =   data.invoice;

    	   	  $scope.brand = false;
    	   })               
        }else{
    	$scope.order = PurchaseService.orderStore.get({id:$routeParams.id},function(data){
								   		switch(data.price_type) {
												case "usd": 
													for (var i in $scope.order.details) {
														$scope.order.details[i].total = $scope.order.details[i].qty * 1*$scope.order.details[i].usd_unit_price*$scope.order.details[i].discount;
													}
													break;
												case "tax":
													for (var i in $scope.order.details) {
														$scope.order.details[i].total = $scope.order.details[i].qty * 1*$scope.order.details[i].tax_unit_price*$scope.order.details[i].discount;
													};
													break;
												case "normal":
													for (var i in $scope.order.details) {
														$scope.order.details[i].total = $scope.order.details[i].qty * 1*$scope.order.details[i].unit_price*$scope.order.details[i].discount; 
													}
									
											}
				                 var object="";
								 object =   WarehouseService.warehouse.get({id: data.warehouse_id});
							     $scope.ship_address = object;
							     $scope.brand = (angular.isNumber(data.plan_id))?false:true;
    	});
    }

    $scope.setShipAddr=function()
    {
    	var isDuttyAddr=function(addr)
    	{
    		if(!addr) return true;
    		for(var i in warehouseAddrList)
    		{
    			if(warehouseAddrList[i].addr==addr) return true;
    		}
    		return false;
    	};
    	var getWareHouseAddr=function(wid)
    	{
    		if(!wid) return '';
    		for(var i in warehouseAddrList)
    		{
    			if(warehouseAddrList[i].id==wid) return warehouseAddrList[i].addr;
    		}
    		return '';
    	};
    	
    	if(! isDuttyAddr($scope.order.ship_to)) return ;
    	else
    	{
    		$scope.order.ship_to=getWareHouseAddr($scope.order.warehouse_id);
    	}
    };
    
    
	$scope.details_new = function() {
		$scope.order.details.push({});
		
	};

	$scope.details_remove = function($index,idx) {
		 $scope.order.details.splice(idx, 1);
		 PurchaseService.orderStore.destroy({id:$index,"type":"detail"},function(data){
		 	  
		 	  if(!data.return){
		 	  	 FlashService.show("记录删除成功");
		 	  	
		 	  }else{
		 	  	  FlashService.show("记录删除失败");
		 	  	  
		 	  }
		 })
		 
	};
	$scope.destroy = function($id){
		    	 PurchaseService.orderStore.destroy({id:$id,"type":"master"},function(data){
		 	  //alert(alert(JSON.stringify(data)));
		 	  if(!data.return){
		 //	  	 alert("记录删除成功");
		 //	  	 $location.path('/purchase/order');
		 	  	
		 	  }else{
		 	  	  FlashService.show("记录删除失败");
		 	  	  
		 	  }
		 })
	}
	
	function makePostData(info)
	{
		
		var ruleInfo={};
		ruleInfo.master=info;
		ruleInfo.master.vendor_id = ruleInfo.master.vendor.id;
		ruleInfo.master.payment_terms = info.payment_terms || '';
		ruleInfo.master.delivery_date = info.delivery_date || '';
		ruleInfo.master.note = info.note || '';
		ruleInfo.master.ship_to = info.ship_to || '';
		if(info.details)
		{
			ruleInfo.childs=info.details;
			for (var i in ruleInfo.childs) {
				ruleInfo.childs[i].item_id = ruleInfo.childs[i].item.id;
				ruleInfo.childs[i].total = ruleInfo.childs[i].unit_prpice * ruleInfo.childs[i].qty;
				ruleInfo.childs[i].item = undefined;
			}
		}
		ruleInfo.master.details=undefined;
		return ruleInfo;
	}
	
	$scope.update = brand ?  function() {
		
		var postData=makePostData($scope.order);
		postData.id = $routeParams.id;
		 PurchaseService.orderStore.update(postData, function() {
			     window.location.reload();
		});
	}:function() {
		var postData=makePostData($scope.order);
		PurchaseService.orderStore.save( postData, function() {
			  $location.path('/purchase/order');
		});
	} ;

	var store = MetaService.storeBuilder('purchase', 'order', {gen: {method: 'POST'}});

	$scope.gen = function() {
		store.gen({module: 'purchase', service: 'order'}, $scope.order, function(data) {
			if(data.return ==1){
		 	  	 alert("生成采购待入库单成功");
				$location.path('/purchase/order');  	
		 	}else{
		 	  	  FlashService.show(data.ErrMsg);
		 	}
		});
	};
	
	$scope.unconfirm =function(){
		   //PurchaseService.orderStore.unconfirm({id:$scope.order.id},function(){
		   //	     return ture;
		   //})
		PurchaseService.orderStore.confirm({id: $routeParams.id, operation: 'confirm'}, function () {
			window.location.reload();
		})
	};
	
	$scope.confirm =function(){
		var detailNum=$scope.order.details.length;
		if(detailNum>0)
		{

			  //MetaService.store.update({module: 'purchase', service: 'po'}, postData, function() {
				  //window.location.reload();
			  //});
			PurchaseService.orderStore.confirm({id: $routeParams.id, operation: 'confirm'}, function () {
				window.location.reload();
			});
		}else{
			 alert("请先添加明细")
		}
		
	};


}]);

//----------------------------purchase plan--------------//
erp.controller('planCtrl', ['$scope', 'PurchaseService', function ($scope, PurchaseService) {
	$scope.plans = PurchaseService.planStore.query();
}]);

erp.controller('planNewCtrl', ['$scope', '$location', 'PurchaseService', function ($scope, $location, PurchaseService) {
	$scope.update = function() {
		PurchaseService.planStore.save($scope.plan, function() {
			$location.path('/purchase/plan');
		});
	};
}]);

erp.controller('planEditCtrl', ['$scope', '$routeParams', '$location', 'PurchaseService', 'ItemService' ,  function ($scope, $routeParams, $location, PurchaseService, ItemService) {
	$scope.whs = ItemService.metaStore.query({key: 'warehouseList'});
	$scope.trans = ItemService.metaStore.query({key: 'transportList'});
	$scope.taxs = ItemService.metaStore.query({key: 'taxList'});
	//$scope.skus = ItemService.getItemList();
	//$scope.vendors = PurchaseService.vendorStore.query();
	//$scope.selectObj = [];
	var plan = PurchaseService.planStore.get({id: $routeParams.id}, function() {
		$scope.plan = plan;
		$scope.remote = angular.copy(plan);
		$scope.plan.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.plan);
	};

	$scope.status = ['open', 'closed'];

	$scope.destroy = function () {
		plan.$remove(function (data) {
			if(data.f == 0){
				alert(data['m']);
				window.location.reload();
			}

			$location.path('/purchase/plan');
		}, function (error) {
			console.log(error.data.error.message);
		});
	}

	jQuery('#purchaseplan a').click(function (e) {
		jQuery('.nav a').parent().each(function(){
			jQuery(this).removeClass('active');
		});

		jQuery(this).parent().addClass('active');
		var i= '#div'+jQuery(this).attr('id');
		jQuery('#div1').hide();
		jQuery('#div2').hide();
		jQuery('#div3').hide();
		jQuery(i).show();
	})

	$scope.update = function() {
		PurchaseService.planStore.update($scope.plan, function() {
			$location.path('/purchase/plan');
		});
	}


}]);
//----------------------------request assign--------------//
erp.controller('assignCtrl', ['$scope' ,'$routeParams','$location','PurchaseService','ItemService','MetaService','$filter', function ($scope ,$routeParams,$location,PurchaseService,ItemService,MetaService,$filter) {
	
	$scope.status = ItemService.metaStore.query({key: 'requestStatus'});
	$scope.types = ItemService.metaStore.query({key: 'requestTypes'});
	$scope.whs = ItemService.metaStore.query({key: 'warehouseList'});
	$scope.platforms = MetaService.platformList();
	$scope.trans = ItemService.metaStore.query({key: 'transportList'});
	$scope.skus = ItemService.getItemList();
	$scope.plans = PurchaseService.spePlanStore.query({type:'open'});
	//自动搜索
	//$scope.assigns = PurchaseService.assignStore.query($scope.seachform);
	//伪造的数据
	var today = new Date();
	var oldFilter={
			from_date: new Date(today.getFullYear(), (today.getMonth()-2), 1),
			to_date: new Date(today.getFullYear(), (today.getMonth()), (today.getDate()+1)),
			item:null,
			warehouse:null,
			platform:null,
			transport:null
		};
	
	$scope.seachform = oldFilter;
	
	//未分配
	$scope.assigns=PurchaseService.assignStore.query();
	//已分配
	$scope.hasAssignedDetails=PurchaseService.spePlanStore.query({type:'pendToCheck'});
	
	//默认显示项
	$scope.showtype="pendingToAssign";
	
	//筛选后的数据
	$scope.afterFilterDetails=$scope.assigns;
	//选中的id
	$scope.checkedIds=[];
	
	$scope.resetAll=function()
	{
		$scope.assigns=PurchaseService.assignStore.query();
		$scope.hasAssignedDetails=PurchaseService.spePlanStore.query({type:'pendToCheck'});
		$scope.afterFilterDetails=$scope.assigns;
		$scope.checkedIds=[];
		$scope.seachform = oldFilter;
	}
	
	function in_array(array,value)
	{
		for(var k in array)
		{
			if(array[k]===value)
			{
				return k;
			}
		}
		return false;
	}
	
	$scope.toggleAddToPlanList=function(aid)
	{
		
		var key=in_array($scope.checkedIds,aid);
		if(key===false)
		{
			$scope.checkedIds.push(aid);
		}
		else
		{
			$scope.checkedIds.splice(key,1);
		}
	}

	
	$scope.exportOfFilter=function(){
		alert("导出所有明细!");
	};
	
	$scope.resetFilter=function(){

		$scope.seachform =oldFilter;
		$scope.afterFilterDetails=$scope.assigns;
		return true;
	};
	
	//取消分配
	$scope.revertAssigned=function(planDetailId)
	{	
		PurchaseService.revertAssignStore.save({detailId:planDetailId},function(){
			$scope.resetAll();
		});
	}

	
	$scope.$watch('seachform',function(searchForm){		
		if($scope.assigns.length==0) return;
		
		//alert("date from:"+searchForm.from_date+"\n"+"date from:"+searchForm.to_date+"\n"+"item:"+searchForm.item+"\n"+"warehouse:"+searchForm.warehouse+"\n"+"platform:"+searchForm.platform+"\n"+"transport:"+searchForm.transport+"\n");
		var tmpAssign=[];
	
		
		angular.forEach($scope.assigns,function(detail){
			//alert("date from:"+searchForm.from_date+"\n"+"date from:"+searchForm.to_date+"\n"+detail.end_date);
			var isPassed=true;
			var dateWithTimeRe=/^([\d]{4})[\-\/]([\d]{1,2})[\-\/]([\d]{1,2})\s+[\d]{1,2}[\:][\d]{1,2}[\:][\d]{1,2}$/;
			if(searchForm.from_date && searchForm.to_date && detail.end_date)
			{				
				if(dateWithTimeRe.test(detail.end_date))
				{
					 var arr =dateWithTimeRe.exec(detail.end_date); 
					 var end_date=new Date(parseInt(arr[1]),parseInt(arr[2])-1,parseInt(arr[3]));
					 var from_date=new Date(searchForm.from_date);
					 var to_date=new Date(searchForm.to_date);
					 if(end_date.getTime()<=from_date.getTime() || end_date.getTime()>=to_date.getTime())
					 {
							isPassed=isPassed&&false;
					 }
				}
			
			}
			
			//item
			if(isPassed && searchForm.item && searchForm.item!=null && searchForm.item.id && detail.item && detail.item.id)
			{
				isPassed=isPassed&&(searchForm.item.id==detail.item.id);
				
			}
			
			//warehouse
			if(isPassed && searchForm.warehouse && searchForm.warehouse!=null && detail.request && detail.request.warehouse && detail.request.warehouse.id)
			{
				
				isPassed=isPassed&&(searchForm.warehouse==detail.request.warehouse.id);
			}
			
			//platform
			if(isPassed && searchForm.platform && searchForm.platform!=null  && detail.platform && detail.platform.id)
			{
				isPassed=isPassed&&(searchForm.platform==detail.platform.id);
			}
			
			//transport
			if(isPassed && searchForm.transport && searchForm.transport!=null  && detail.transportation)
			{
				isPassed=isPassed&&(searchForm.transport==detail.transportation);
			
			}
		
			
			if(isPassed)
			{
				tmpAssign.push(detail);
			}
		},tmpAssign);
		$scope.afterFilterDetails=tmpAssign;
		$scope.checkedIds=[];
	},true);

	$scope.checkall = function(){
		var o= jQuery("input:checkbox[name='all']");
		if(o.attr('checked') =='checked'){
			jQuery("input:checkbox[name!='all']").each(function(){
				if(!jQuery(this).checked) jQuery(this).attr('checked',true);
			});
			$scope.checkedIds=[];
			for(var index in $scope.afterFilterDetails)
			{
				$scope.checkedIds.push($scope.afterFilterDetails[index].id);
			}
		}else{
			
			jQuery("input:checkbox:checked[name!='all']").each(function(){
				 jQuery(this).attr('checked',false);
			});
			$scope.checkedIds=[];
		}
	}

	$scope.trStyle = function(line_state,req_bom,id){
		var o = jQuery("#tr"+id);
		if(req_bom !='') o.attr('style','background-color:#F5FFFA!important');
		if(line_state == 'New Arrival') o.attr('style', 'background-color:#FFFACD!important');
	}

	
	$scope.csearch = function(){
		//alert(JSON.stringify($scope.seachform.sku));
		$scope.seachform.item_id = ($scope.seachform.sku == undefined ? '' : $scope.seachform.sku.id);
		$scope.assigns = PurchaseService.assignStore.query($scope.seachform);
	}

	$scope.addPlanShow = function(flag){
		$scope.selectplan_flag = flag;
 		jQuery('.modal').modal();
 	}

	//添加计划
	$scope.addPlan = function(){
		PurchaseService.planStore.save({name:$scope.plan.invoice},function(){
			$scope.plans = PurchaseService.spePlanStore.query({type:'open'});
		});
		jQuery('.modal').modal("hide");
	}

	$scope.selectplan =function(plan_id){
		var params={};
		params.plan_id=plan_id;
		params.requestIds=$scope.checkedIds;
		
		if(!params.plan_id)
		{
			alert("请先选着计划表");
			return false;
		}
		
		if(params.requestIds.length<=0)
		{
			alert("明细不能为空");
			return false;
		}
		
		PurchaseService.assignStore.save(params,function(data){
			//$scope.assigns = PurchaseService.assignStore.query();
		});
		$scope.resetAll();
	}
	
	$scope.selectplanall=function(plan_id){
		var params={};
		params.plan_id=plan_id;
		var ids=[];
		
		for(var index in $scope.afterFilterDetails)
		{
			ids.push($scope.afterFilterDetails[index].id);
		}
		
		params.requestIds=ids;
		
		if(!params.plan_id)
		{
			alert("请先选着计划表");
			return false;
		}
		
		if(params.requestIds.length<=0)
		{
			alert("明细不能为空");
			return false;
		}
		
		PurchaseService.assignStore.save(params,function(data){
			//$scope.assigns = PurchaseService.assignStore.query();
		});
		$scope.resetAll();
	}

	/*$scope.selectplanall =function(plan_id,invoice){
		var params = {};
		params.type = 'add';
		params.plan_id = plan_id;
		params.request_ids = 'all';
		params.invoice = invoice;

		PurchaseService.assignStore.save(params,function(data){
			window.location.reload(); 
			//$location.path('/purchase/assign');
		});
	}*/

	//剔除采购计划
//	$scope.rejectdetail = function(plan_id,request_ids){
//		$scope.seachform.type = 'reject';
//		$scope.seachform.plan_id = plan_id;
//		$scope.seachform.request_ids = request_ids;
//		PurchaseService.assignStore.save($scope.seachform,function(data){
//			$scope.assigns = PurchaseService.assignStore.query($scope.seachform);
//		});
//	}
}]);




//------------------------plan check---------------------------------//
erp.controller('PCheckCtrl', ['$scope' ,'$routeParams','$location','PurchaseService','ItemService','MetaService','$filter', function ($scope ,$routeParams,$location,PurchaseService,ItemService,MetaService,$filter) {
	$scope.trans = ItemService.metaStore.query({key: 'transportList'});
	$scope.whs = ItemService.metaStore.query({key: 'warehouseList'});
	$scope.platforms = MetaService.platformList();
	$scope.plans = PurchaseService.spePlanStore.query({type:'open'});
	$scope.planDetails = PurchaseService.spePlanStore.query({type:'pendToCheck'});
	$scope.checkedIds=[];
	$scope.afterFilterDetails=$scope.planDetails;
	
	$scope.hasCheckDetails = PurchaseService.spePlanStore.query({type:'checked'});
	$scope.showtype="needCheck";
	
	function resetMain()
	{
		$scope.planDetails = PurchaseService.spePlanStore.query({type:'pendToCheck'});
		$scope.checkedIds=[];
		$scope.afterFilterDetails=$scope.planDetails;
		$scope.hasCheckDetails = PurchaseService.spePlanStore.query({type:'checked'});
	}
	
	$scope.$watch('seachform',function(searchForm){		
		if($scope.planDetails.length==0) return;
		
		//alert("date from:"+searchForm.from_date+"\n"+"date from:"+searchForm.to_date+"\n"+"item:"+searchForm.item+"\n"+"warehouse:"+searchForm.warehouse+"\n"+"platform:"+searchForm.platform+"\n"+"transport:"+searchForm.transport+"\n");
		var tmpAssign=[];
	
		
		angular.forEach($scope.planDetails,function(detail){
			//alert("date from:"+searchForm.from_date+"\n"+"date from:"+searchForm.to_date+"\n"+detail.end_date);
			var isPassed=true;
			//warehouse
			if(searchForm.warehouse && searchForm.warehouse!=null && detail.warehouse_id)
			{
				isPassed=isPassed&&(searchForm.warehouse==detail.warehouse_id);
			}
			
			//plan
			if(searchForm.plan_id && searchForm.plan_id!=null &&detail.plan &&detail.plan.id)
			{
				isPassed=isPassed&&(searchForm.plan_id==detail.plan.id);
			}
			
			//platform
			if(searchForm.platform && searchForm.platform!=null  && detail.platform && detail.platform.id)
			{
				isPassed=isPassed&&(searchForm.platform==detail.platform.id);
			}
			
			//transport
			if(searchForm.transportation && searchForm.transportation!=null  && detail.transportation)
			{
				isPassed=isPassed&&(searchForm.transportation==detail.transportation);
			}
			
			if(isPassed)
			{
				tmpAssign.push(detail);
			}
		},tmpAssign);
		$scope.afterFilterDetails=tmpAssign;
		$scope.checkedIds=[];
	},true);
	
	function in_array(array,value)
	{
		for(var k in array)
		{
			if(array[k]===value)
			{
				return k;
			}
		}
		return false;
	}
	
	$scope.toggleAddToCheckList=function(aid)
	{
		
		var key=in_array($scope.checkedIds,aid);
		if(key===false)
		{
			$scope.checkedIds.push(aid);
		}
		else
		{
			$scope.checkedIds.splice(key,1);
		}
	}
	
	$scope.checkall = function(){
		var o= jQuery("input:checkbox[name='all']");
		if(o.attr('checked') =='checked'){
			jQuery("input:checkbox[name!='all']").each(function(){
				if(!jQuery(this).checked) jQuery(this).attr('checked',true);
			});
			$scope.checkedIds=[];
			for(var index in $scope.afterFilterDetails)
			{
				$scope.checkedIds.push($scope.afterFilterDetails[index].id);
			}
		}else{
			
			jQuery("input:checkbox:checked[name!='all']").each(function(){
				 jQuery(this).attr('checked',false);
			});
			$scope.checkedIds=[];
		}
	}
	
	function checked(ids,type)
	{
		
		if(!ids)
		{
			alert("请选择要审核的明细");
			return false;
		}
		if(!type)
		{
			type="allow";
		}
		var params={};
		params.idList=ids;
		params.type=type;
		PurchaseService.checkPlanStore.save(params,function(data){
			
		});
		resetMain();
	}
	
	function getAllPlanDetailId()
	{
		var idList=[];
		for(var index in $scope.afterFilterDetails)
		{
			idList.push($scope.afterFilterDetails[index].id);
		}
		return idList;
	}
	
	$scope.allowCheckedPlanDetail=function()
	{
		if($scope.checkedIds.length<=0)
		{
			alert("请选择要审核的明细");
		}
		else
			checked($scope.checkedIds);
	}
	
	$scope.disallowCheckedPlanDetail=function()
	{
		if($scope.checkedIds.length<=0)
		{
			alert("请选择要审核的明细");
		}
		else
			checked($scope.checkedIds,'disallow');
	}
	
	$scope.allowAllPlanDetail=function()
	{
		var ids=getAllPlanDetailId();
		if(ids.length<=0)
		{
			alert("没有需要审核的明细");
		}
		else
			checked(ids);
		
	}
	
	$scope.disallowAllPlanDetail=function()
	{
		var ids=getAllPlanDetailId();
		if(ids.length<=0)
		{
			alert("没有需要审核的明细");
		}
		else
			checked(ids,'disallow');
	}
	
	$scope.allowToPurchase=function(id)
	{
		var ids=[];
		ids.push(id);
		checked(ids);
	}
	
	$scope.disallowToPurchase=function(id)
	{
		var ids=[];
		ids.push(id);
		checked(ids,'disallow');
	}
	
}]);


//----------------------------plan exec--------------//
erp.controller('execCtrl', ['$scope' ,'$routeParams','$location','PurchaseService','ItemService', 'MetaService',function ($scope ,$routeParams,$location,PurchaseService,ItemService,MetaService) {
	
	
	$scope.whs = ItemService.metaStore.query({key: 'warehouseList'});
	$scope.chanels = ItemService.metaStore.query({key: 'chanelList'});
	$scope.trans = ItemService.metaStore.query({key: 'transportList'});
	$scope.status=[{"status":"pending"},{"status":"approve"},{"status":"reject"}] 
	$scope.taxs = ItemService.metaStore.query({key: 'taxList'});
	$scope.statueslist = ['pending','purchasing','completely purchased','shipping','completely shipped','closed'];
	
	$scope.skus =  MetaService.itemList();
	$scope.seachform = {plan_id:''};
	$scope.vendors = PurchaseService.vendorStore.query();
	
	$scope.selectObj = [];
	$scope.select = {};
	
	$scope.plandetails=[];
	
	$scope.plans = PurchaseService.planStore.query({},function(data){
		$scope.plans=data;
		if($scope.plans.length>0)
		{
			var lastId=$scope.plans[$scope.plans.length-1].id;
			
			$scope.plandetails=PurchaseService.execStore.query({id:lastId},function(data){
				$scope.plandetails=data;
			});
		}
			
	});
	

	//搜索框的初始值
	$scope.csearch = function(){
		var params = angular.copy($scope.seachform);
		params.sku= params.sku ? params.sku.id : '';
		params.vendor = params.vendor ? params.vendor.id : '';
		params.id=params.plan_id;
		$scope.plandetails = PurchaseService.execStore.query(params,function(){});
	}

	$scope.trStyle = function(line_state,isParent,id){
		var o = jQuery("#tr"+id);
		//if(isParent) o.attr('style','background-color:#F5FFFA!important');
		if(line_state == 'New Arrival') o.attr('style', 'background-color:#FFFACD!important');
	}
	$scope.ckStyle = function(parent_id,id){//...
		var o = jQuery("#tr"+id).children(0);
		if(parent_id >0) o.attr('style','background-color:#F5FFFA!important');
	}
	
	//搜索框的初始值
	$scope.batch_action = function(){
		jQuery('.action_area').children().each(function(){
			this.disabled = true;
			jQuery(this).hide();
			var tmp = $scope.baction+'_a';
			if(this.id == tmp) {
				jQuery(this).show();
				this.disabled = false;
			}
		});
	}

	//单个修改
	$scope.update = function (detail){
	
		var v = {};
		v.detail_id 	= detail.id;
		v.vendor_id 	= detail.vendor.id;
		v.price_type 	= detail.price_type;
		v.transportation = detail.transportation;
		v.real_qty 		= detail.real_qty;
		v.to_purchase_qty = detail.to_purchase_qty;
		v.unit_price 	= detail.unit_price;
		v.status 	= detail.status;
		//alert(JSON.stringify(v));
		PurchaseService.batchUpdateStore.batchUpdate(v,function(data){
				if(data.f == 0) 
				{
					alert(data.m)
				}else{
					alert('调整成功');
				}
				$scope.csearch();//刷新
		});
	}
	//批量操作
	$scope.dobatch = function(){
		var v = {'plan_dids' : ''};
		if(jQuery('#baction').val() ==""){alert("没有选择批量修改的类型！");return false;}

		jQuery(':checkbox').each(function() {
			if(jQuery(this).attr('checked')){
				v.plan_dids = v.plan_dids ? (v.plan_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});
		
		if(v.plan_dids == '')
		{
			alert('没有选择明细');
			return false;
		}

		switch(jQuery('#baction').val()){
			case 'vendor':
				if (jQuery('#vendor_a').val() == "") alert("请选择一个供应商");
				v.field = 'vendor_id';
				v.value = $scope.action.vendor.id;
				break;
			case 'tax':
				if (jQuery('#tax_a').val() == "") alert("请选择一个价格类型");
				v.field = 'price_type';
				v.value = $scope.action.price_type;
				break;
			case 'trans':
				if (jQuery('#trans_a').val() == "") alert("请选择一个物流方式");
				v.field = 'transportation';
				v.value = $scope.action.transportation;
				break;
			case 'status':
			if (jQuery('#status_a').val() == "") alert("请选择一个状态");
			v.field = 'status';
			v.value = $scope.action.status;
			break;
		}

		PurchaseService.batchUpdateStore.batchUpdate(v,function(data){	
			//alert(JSON.stringify(data));
			if(data.f == 0){
				alert(data.m);
			}else{
				alert('修改成功');
			}
			$scope.csearch();
		});
	}

	//批量操作
	$scope.dobatchQty = function(type){
		var v = {'plan_dids' : ''};

		jQuery(':checkbox').each(function() {
			if(jQuery(this).attr('checked')){
				v.plan_dids = v.plan_dids ? (v.plan_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});
		
		if(v.plan_dids == '')
		{
			alert('没有选择明细');
			return false;
		}

		v.type = type;
		PurchaseService.batchUpdateQtyStore.batchUpdateQty(v,function(data){
				if(data.f == 1) 
				{
					alert('调整成功');
				}else{
					alert(v.m);
				}
				
			$scope.csearch();
		});
	}
  
  	//这里有问题，删除以后再添加的时候
	$scope.addData = function(obj,id){
		var i=0;
		var tmp = $scope.selectObj;
		var f = 0;
		if(jQuery('#'+id).attr('checked')){//
			jQuery.each($scope.selectObj,function(sdf,item){
				if(item.id == id){
					f =1;
				}
			});

			if(f ==0) $scope.selectObj.push(obj);//不存在则添加
		}else{
			jQuery.each($scope.selectObj,function(sdf,item){
				if(item.id == id){
					tmp.splice(i,1);
				}
				i++;
			});

			$scope.selectObj = tmp;
		}
	}

	//生成采购单
	$scope.turnToOrder = function(){
		var params = {};
		params.selectObj = $scope.selectObj;
		params.plan_id = $scope.seachform.plan_id;
		params.pur_warehouse = $scope.select.pur_warehouse.id;
		//alert(JSON.stringify(params));
		if(!params.pur_warehouse)
		{
			alert("请选择采购入库仓！");
			return false;
		}

		PurchaseService.turnOrderStore.turnorder(params,function(data){	
			if(data.f ==0) {
				alert(data.m);
			}
			else{
				alert('创建成功');
			}
			window.location.reload();
		});
	}

	//用modal方式生成采购单的预览
	$scope.turnToPurchase = function(){
		var plan_dids = '';
	
		jQuery(":checkbox[name!='all']").each(function() {
			if(jQuery(this).attr('checked')){
				plan_dids = plan_dids ? (plan_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});

		if((plan_dids == '')){
			alert('没有选择明细');
			return false;
		}

		//判断是否同一个供应商，是否同一个仓库或者渠道，是否含税与不含税相同
		var data = { value:
			[{name:'vendor_sure',error:'供应商不一致'},
		 	{name:'tax_sure',error:'价格类型不一致[含税价or不含税价]'},
		 	{name:'order_sure',error:'订单不一致'}
		 	]};

		 var message =  '';
		 jQuery.each(data.value,function(idx,item){
		 	if(judyDiff(item.name,item.error) == 0) {
		 		message = (message =='') ? item.error : (message + '\r\n'+item.error);
		 	}
		 });

		if(message != '') 
		{
		 	alert(message);
		 	return false;
		}

		var f = $scope.selectObj;
		f = f[0];
		var order_id  = f.relation_id ?  f.relation_id : '';
		$scope.select = {'vendor': f.vendor.name, 'order_id':order_id, 'price_type': f.price_type};
		//alert(JSON.stringify($scope.select));

		jQuery('.modal').modal();
	}

	function judyDiff(objname,text){
		var i=0;
		var tmp;
		var ret = 1;
		var value;

		jQuery('input:checked').parent().parent().find('.'+objname).each(function() {
			if(objname == 'vendor_sure')
			{
				value = jQuery(this).val();
			}else if(objname == 'order_sure')
			{
				value = jQuery(this).text();
			}else{
				value = jQuery(this).val();
			}


			if(i == 0)
			{
				tmp = value;
			}
			if(tmp != value) 
			{
				ret = 0;
				return false;//跳出循环
			}

			i++;
		}); 
		return ret;
	}

	$scope.checkall = function(){
		var o= jQuery("#all");
	
		if(o.attr('checked')){
		 	jQuery(".check-list :checkbox").attr("checked",true);
		}else{
			jQuery(".check-list :checkbox").attr("checked",false);
		}
	}

	$scope.exports = function(type){
		var params = {'type':type,'plan_id':$scope.seachform.plan_id};
		PurchaseService.exportStore.exports(params,function(data){
			var a = jQuery('.export_a');
			a.parent().show();
			if(data.f == 1){
				a.attr('href',data.url);
				a.text('数据准备完毕,点击此处下载报表:'+data.name);
				a.click();
			}else{
				a.text(data.m);
				a.click();
			}
		});
	}

	$scope.afterfiledown = function(){
		jQuery('#export_a').parent().hide();
	}
}]);
//---------------------purchase ship[调度是多个计划一起做的]--------------//
erp.controller('shipCtrl', ['$scope' ,'$routeParams','$location','PurchaseService','ItemService', 'MetaService',function ($scope ,$routeParams,$location,PurchaseService,ItemService,MetaService) {
	$scope.whs = ItemService.metaStore.query({key: 'warehouseList'});
	$scope.chanels = ItemService.metaStore.query({key: 'chanelList'});
	$scope.trans = ItemService.metaStore.query({key: 'transportList'});
	$scope.taxs = ItemService.metaStore.query({key: 'taxList'});
	$scope.statueslist = ['pending','purchasing','completely purchased','shipping','completely shipped','closed'];
	$scope.plans = PurchaseService.planStore.query();
	$scope.skus =  MetaService.itemList();
	$scope.seachform = {plan_id:''};
	$scope.vendors = PurchaseService.vendorStore.query();
	$scope.selectObj = [];
	$scope.splitObj = [];
	$scope.select = {};


	var plan = PurchaseService.shipStore.query(function(){
		$scope.shipdetails = PurchaseService.shipStore.query($scope.seachform);
	});

	//搜索框的初始值
	$scope.csearch = function(){
		var params = angular.copy($scope.seachform);
		params.sku= params.sku ? params.sku.id : '';
		$scope.shipdetails = PurchaseService.shipStore.query(params,function(){});
	}

	//这里有问题，删除以后再添加的时候
	$scope.addData = function(obj,id){
		var i=0;
		var tmp = $scope.selectObj;
		var f = 0;
		if(jQuery('#'+id).attr('checked')){//
			jQuery.each($scope.selectObj,function(sdf,item){
				if(item.id == id){
					f =1;
				}
			});

			if(f ==0) $scope.selectObj.push(obj);//不存在则添加
		}else{
			jQuery.each($scope.selectObj,function(sdf,item){
				if(item.id == id){
					tmp.splice(i,1);
				}
				i++;
			});

			$scope.selectObj = tmp;
		}
	}

	$scope.trStyle = function(line_state,isParent,id){
		var o = jQuery("#tr"+id);
		//if(isParent) o.attr('style','background-color:#F5FFFA!important');
		if(line_state == 'New Arrival') o.attr('style', 'background-color:#FFFACD!important');
	}
	$scope.ckStyle = function(parent_id,id){//...
		var o = jQuery("#tr"+id).children(0);
		if(parent_id >0) o.attr('style','background-color:#F5FFFA!important');
	}

	$scope.showSplit = function(obj){
		$scope.splitObj = [];	
		$scope.splitObj.push(obj);
		//alert(obj.child_i);
		if(obj.child_i && (obj.child_i !='undefined')){
			var tmp = obj.child_i.toString().split(',');
			jQuery.each(tmp,function(idx,i){
				$scope.splitObj.push($scope.shipdetails[i]);
			});
		}
		jQuery('.split').modal();
	}

	$scope.changeChild = function (flag,i){
		var id = '#sqty'+i;
		var qty = jQuery(id).val();
		if(flag ==1){
			jQuery(":text[id*='sqty']").each(function(){
				var t = jQuery(this).attr('id').indexOf('y');
				t= jQuery(this).attr('id').substring(t+1);
				var tmpq = ($scope.shipdetails[t].real_qty / $scope.shipdetails[i].real_qty) * qty;
				jQuery(this).val(tmpq);
			});
		}
	}

	$scope.Split = function(){
		var params = {};
		params.splitObj = $scope.splitObj;
		//需求数量不能大于未发数量
		var f = 1;
		jQuery.each($scope.splitObj,function(idx,item){
			if(item.split_qty > item.shipmenting) f =0;
		});

		if(f ==0){
			alert('拆分后的需求数量不能大于未发数量');
			return false;
		}
				//alert(JSON.stringify(params));

		PurchaseService.shipSplitStore.shipSplit(params,function(data){	
			if(data.f ==0) {
				alert(data.m);
			}
			else{
				alert('创建成功');
			}

			window.location.reload();
		});
	}
	//生成采购单
	$scope.turnToShip = function(){
		var params = {};
		params.selectObj = $scope.selectObj;
		params.pur_warehouse = $scope.select.pur_warehouse;
		params.warehouse_id = $scope.select.warehouse_id;
		params.price_type = $scope.select.price_type;
		params.invoice = $scope.select.invoice;
		params.transportation = $scope.select.transportation;
		//alert(JSON.stringify(params));
		if(!params.price_type)
		{
			alert("价格类型");
			return false;
		}

		if(!params.invoice)
		{
			alert("请输入invoice");
			return false;
		}

		PurchaseService.turnShipStore.turnship(params,function(data){	
			if(data.f ==0) {
				alert(data.m);
			}
			else{
				alert('创建成功');
			}
			$scope.csearch();
		});
	}

	//用modal方式生成采购单的预览
	$scope.turnToShipment = function(){
		var plan_dids = '';
	
		jQuery(':checkbox').each(function() {
			if(jQuery(this).attr('checked')){
				plan_dids = plan_dids ? (plan_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});

		if((plan_dids == '')){
			alert('没有选择明细');
			return false;
		}

		//判断是否同一个供应商，是否同一个仓库或者渠道，是否含税与不含税相同
		var data = { value:
			[
		 	//{name:'tax_sure',error:'价格类型不一致[含税价or不含税价]'},
		 	{name:'tran_sure',error:'运输方式不一致'},
		 	{name:'warehouse_sure',error:'仓库不一致'}
		 	]};

		 var message =  '';
		 jQuery.each(data.value,function(idx,item){
		 	if(judyDiff(item.name,item.error) == 0) {
		 		message = (message =='') ? item.error : (message + '\r\n'+item.error);
		 	}
		 });

		if(message != '')
		{
		 	alert(message);
		 	return false;
		}

		var f = $scope.selectObj;
		f = f[0];
		$scope.select = {
						'warehouse': f.warehouse.name,
						'warehouse_id': f.warehouse.id,
						'pur_warehouse': f.pur_warehouse,
						'price_type': f.price_type,
						'invoice': f.invoice,
						'transportation': f.transportation
						};
		//alert(JSON.stringify($scope.select));
		jQuery('.turn').modal();
	}

	function judyDiff(objname,text){
		var i=0;
		var tmp;
		var ret = 1;
		var value;

		jQuery('input:checked').parent().parent().find('.'+objname).each(function() {
			value = jQuery(this).text();
			if(i == 0)
			{
				tmp = value;
			}
			if(tmp != value) 
			{
				ret = 0;
				return false;//跳出循环
			}

			i++;
		}); 

		return ret;
	}

	$scope.exports = function(type){
		var params = {'type':type,'plan_id':$scope.seachform.plan_id};
		PurchaseService.exportStore.exports(params,function(data){
			var a = jQuery('.export_a');
			a.parent().show();
			if(data.f == 1){
				a.attr('href',data.url);
				a.text('数据准备完毕,点击此处下载报表:'+data.name);
				a.click();
			}else{
				a.text(data.m);
				a.click();
			}
		});
	}

	$scope.afterfiledown = function(){
		jQuery('#export_a').parent().hide();
	}
}]);
//----------------------------purchase packing--------------//
erp.controller('packingCtrl', ['$scope', 'PurchaseService', function ($scope, PurchaseService) {
	$scope.packings = PurchaseService.packingStore.query(function(){
	});
}]);

erp.controller('packingNewCtrl', ['$scope', '$location', 'PurchaseService','ItemService', function ($scope, $location, PurchaseService,ItemService) {
	$scope.skus = ItemService.getItemList();
	$scope.vendors = PurchaseService.vendorStore.query();
	$scope.update = function() {
		 PurchaseService.packingStore.save($scope.packing, function() {
		//	$location.path('/purchase/packing');
		});
	};
}]);

erp.controller('packingEditCtrl', ['$scope', '$routeParams', '$location', 'PurchaseService','ItemService', function ($scope, $routeParams, $location, PurchaseService,ItemService) {
	$scope.skus = ItemService.getItemList();
	$scope.vendors = PurchaseService.vendorStore.query();
	var packing = PurchaseService.packingStore.get({id: $routeParams.id}, function() {
		$scope.packing = packing;
		$scope.remote = angular.copy(packing);
		$scope.packing.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.packing);
	};

	$scope.update = function() {
		 
		//alert(JSON.stringify($scope.packing));
		packing.$update(function (){
			 window.location.reload();
			$location.path('/purchase/packing');
		}, function (error) {
			console.log(error.data.error.message);
		});
	};
	$scope.destroy = function () {
		packing.$remove(function () {
			$location.path('/purchase/packing');
		}, function (error) {
			console.log(error.data.error.message);
		});
	}
}]);

/*
单据审核
*/
erp.controller('AuditPrCtrl', ['$scope',  '$location', 'PurchaseService', 'FlashService', function ($scope, $location, PurchaseService, FlashService) {
	$scope.requests= PurchaseService.auditStore.query();
    $scope.check_time=function(time){
            var expired_time = time.split(' ');
			var  now_time= new Date();
           expired_time = new Date(expired_time[0])
            var days= expired_time.getTime()-now_time.getTime();
           days = days/86400000;
           days = Math.round(days);
            if(days<0){
            	 $scope.flag=false;
            	 return days*-1;
            }if(days>0){
            	  $scope.flag=true;
            	 return days;
            }
    	 
    };
    $scope.reflushAfterUpload=function(){
		$location.path('/audit/pr');
	};
	
	
	
    $scope.dobatch = function(index,action){
    	 
    	//防止ID冲突的问题
    	 var data = {'index':index,'action':action,'check_note':''};
    	     PurchaseService.batchAuditStore.batchUpdate(data
    		     	,function(data){
//	     	            if(data.returnData=='successful'){
//	     	                      $scope.warning="提交成功";
//	     	                    jQuery('#warning').modal();
//	     	                
//	     	            }else{
//	     	            	 $scope.warning='提交失敗';
//	     	                 jQuery('#warning').modal();
//	     	            }
    	    	 		$location.path('/purchase/packing');
			  		}); 
    	/*
    	if(index){ 
    		 
    	}else{
    		   var actionValue=document.getElementById("batchAction");
         var  action= actionValue.value;
		 var v = {'audit_dids' : '','action':action};
		jQuery(':checkbox').each(function() {
			if(jQuery(this).attr('checked')){
				v.audit_dids = v.audit_dids ? (v.audit_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});
		if(v.audit_dids == '')
		{   
			$scope.error="请选择其中几项或全部！"
			jQuery("#alert").fadeIn();
			return false;
		}
		
		 	            PurchaseService.batchAuditStore.batchUpdate(v,function(data){
	     	              // window.location.reload();
			  		}); */
		}
	$scope.hidden= function(){
   	    jQuery("#alert").hide(); 
   }
	
	$scope.operaType="readonly";
	$scope.operaId=0;
	
	/**
	 * 显示详情
	 */
	$scope.showDetail=function(mainID,type)
	{
		$scope.operaId=mainID;
		var auditList = PurchaseService.auditStore.get({id: $scope.operaId}, function() {
			$scope.auditList = auditList;
		     $scope.status = auditList.status;
		}); 
		if(type=="verified")
		{
			type="reject";
		}
		
		if(type=="rejected")
		{
			type="approve";
		}
		
		$scope.operaType=type;
		jQuery("#requestDetails").modal();
		return false;
	}
	
	/**
	 * 显示批注
	 */
	$scope.showNote=function(opera)
	{
		if(opera)
		{
			$scope.operaType=opera;
		}
		$scope.checkNote="";
		jQuery("#addNote").modal();
	}
	
	/**
	 * 直接审核
	 */
	$scope.stepToCheck=function(mainID,type)
	{
		$scope.operaId=mainID;
		$scope.operaType=type;
		$scope.showNote();
	}
	
	/**
	 * 真正到服务器审核
	 */
	$scope.toCheck=function()
	{
		if($scope.operaType=="approve")
		{
			 PurchaseService.auditStore.approve({id:$scope.operaId,note:$scope.checkNote}
		     	,function(data){
		     		alert("审核成功!");
		     		$scope.requests= PurchaseService.auditStore.query();
		     	}); 
		}
		else if($scope.operaType=="reject")
		{
			PurchaseService.auditStore.reject({id:$scope.operaId,note:$scope.checkNote}
	     	,function(data){
	     		alert("审核成功!");
	     		$scope.requests= PurchaseService.auditStore.query();
	     	});
		}
		else
		{
			alert("不允许的操作'"+$scope.operaType+"'");
		}
	}
    	
     
	
	  $scope.cutStr=function(str, len, hasDot) {
		  if(!str) return str;
            var newLength = 0;
            var newStr = "";
            var chineseRegex = /[^\x00-\xff]/g;
            var singleChar = "";
            var strLength = str.replace(chineseRegex,"**").length;
            for(var i = 0;i < strLength;i++) {
                singleChar = str.charAt(i).toString();
                if(singleChar.match(chineseRegex) != null) {
                    newLength += 2;
                } else {
                    newLength++;
                }
                if(newLength > len) {
                    break;
                }
                newStr += singleChar;
            }
            if(hasDot && strLength > len) {
                newStr += "...";
            }
           
            return newStr;
        } 

}]);

//查看申购明细的页面
erp.controller('AuditPrViewCtrl', ['$scope',  '$location', '$routeParams','PurchaseService', function ($scope, $location,$routeParams, PurchaseService) {
	    //$scope.requests= PurchaseService.auditStore.query();

		var auditList = PurchaseService.auditStore.get({id: $routeParams.id}, function() {
		$scope.auditList = auditList;
	     $scope.status = auditList.status;
	}); 
	     
	      $scope.expand=function(){
   	     var value= jQuery("#expand").html();
   	      if(value=='展开'){
   	      	   jQuery("#expand").html('收起');
   	      }else{
   	      	     jQuery("#expand").html('展开');
   	      }
   	      
   	      jQuery("#detail").toggle();
   }
       $scope.dobatch = function(index,action){
    	 
    	//防止ID冲突的问题
    	 var data = {'index':index,'action':action,'check_note':$scope.auditList.check_note};
    	     PurchaseService.batchAuditStore.batchUpdate(data
    		     	,function(data){
	     	            if(data.returnData=='successful'){
	     	                      $scope.warning="提交成功";
	     	                     jQuery('#warning').modal();
	     	                
	     	            }else{
	     	            	 $scope.warning='提交失敗';
	     	                 jQuery('#warning').modal();
	     	            }
	     	            
			  		}); 
    	/*
    	if(index){ 
    		 
    	}else{
    		   var actionValue=document.getElementById("batchAction");
         var  action= actionValue.value;
		 var v = {'audit_dids' : '','action':action};
		jQuery(':checkbox').each(function() {
			if(jQuery(this).attr('checked')){
				v.audit_dids = v.audit_dids ? (v.audit_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});
		if(v.audit_dids == '')
		{   
			$scope.error="请选择其中几项或全部！"
			jQuery("#alert").fadeIn();
			return false;
		}
		
		 	            PurchaseService.batchAuditStore.batchUpdate(v,function(data){
	     	              // window.location.reload();
			  		}); */
		}
	 $scope.reflushAfterUpload=function(){
		 window.location.reload(); 
	};
}]);
erp.controller('AuditPrViewSpeCtrl', ['$scope',  '$location', '$routeParams','PurchaseService', function ($scope, $location,$routeParams, PurchaseService) {
	$scope.requests= PurchaseService.auditStore.query();

		var auditList= PurchaseService.auditStore.get({id: $routeParams.id}, function(data) {
	 	  $scope.auditList = auditList;
	 	   
	 });
	      $scope.expand=function(){
   	     var value= jQuery("#expand").html();
   	      if(value=='展开'){
   	      	   jQuery("#expand").html('收起');
   	      }else{
   	      	     jQuery("#expand").html('展开');
   	      }
   	      
   	      jQuery("#detail").toggle();
   }
       $scope.dobatch = function(index,action){
    	 
    	//防止ID冲突的问题
    	 var data = {'index':index,'action':action,'check_note':$scope.auditList.check_note};
    	     PurchaseService.batchAuditStore.batchUpdate(data
    		     	,function(data){
	     	            if(data.returnData=='successful'){
	     	                      $scope.warning="提交成功";
	     	                   jQuery('#warning').modal();
	     	                
	     	            }else{
	     	            	 $scope.warning='提交失败';
	     	                jQuery('#warning').modal();
	     	            }
	     	            
			  		}); 

		}
		
	 $scope.reflushAfterUpload=function(){
	//	 	$location.path('/audit/pr'); 
		 	window.location.reload();
	};
}]);
//编辑申购单明细的页面
erp.controller('AuditPrEditCtrl', ['$scope', '$routeParams', '$location', 'PurchaseService', 'FlashService', function ($scope, $routeParams, $location, PurchaseService, FlashService) {
	$scope.requests= PurchaseService.auditStore.query();
	var auditList= PurchaseService.auditStore.get({id: $routeParams.id}, function(data) {
	 	  $scope.auditList = auditList;
	 	   
	 });
	 

   $scope.hidden= function(){
   	    jQuery("#alert").hide(); 
   }
   $scope.checkall = function(){
		var o= jQuery("#all");
	
		if(o.attr('checked')){
		 	jQuery(".check-list :checkbox").attr("checked",true);
		}else{
			jQuery(".check-list :checkbox").attr("checked",false);
		}
	}
    $scope.dobatch = function(index){
    	if(index){ 
    		     PurchaseService.batchAuditStore.batchUpdate(index
    		     	,function(data){
	     	                window.location.reload();
			  		}); 
    	}else{
    		   var actionValue=document.getElementById("batchAction");
         var  action= actionValue.value;
		var v = {'audit_dids' : '','action':action};
		jQuery(':checkbox').each(function() {
			if(jQuery(this).attr('checked')){
				v.audit_dids = v.audit_dids ? (v.audit_dids + ','+jQuery(this).attr('name')) : jQuery(this).attr('name');
			}
		});
		if(v.audit_dids == '')
		{   
			$scope.error="请选择其中几项或全部！"
			jQuery("#alert").fadeIn();
			return false;
		}
		
		 	 PurchaseService.batchAuditStore.batchUpdate(v,function(data){
	     	               window.location.reload();
			  		}); 
		}
	
    	
     
	}
   $scope.expand=function(){
   	     var value= jQuery("#expand").html();
   	      if(value=='展开'){
   	      	   jQuery("#expand").html('收起');
   	      }else{
   	      	     jQuery("#expand").html('展开');
   	      }
   	      
   	      jQuery("#detail").toggle();
   }
}]);


erp.controller('CostParamsCtrl',['$scope', '$routeParams', '$location', 'MetaService','PurchaseService','$upload',function($scope, $routeParams, $location, MetaService,PurchaseService,$upload){
	$scope.items =MetaService.itemList();
	$scope.warehouses = MetaService.whList();
	$scope.cplist=PurchaseService.costparamStore.query();
	

	$scope.searching=function(){
		var params={};
		
		if($scope.search.warehouse)
		{
			params.warehouse_id=$scope.search.warehouse;
		}
		
		if($scope.search.sku &&$scope.search.sku.id)
		{
			params.item_id=$scope.search.sku.id;
		}
		
		if(params!={})
		{
			$scope.cplist=PurchaseService.costparamStore.query(params);
		}
		
		for(var i in $scope.cplist)
		{
			
			alert($scope.cplist[i].air_cost);
		}
	}
	
	$scope.remove=function($id)
	{
		PurchaseService.costparamStore.remove({id:$id},function(){
			 window.location.reload();
		});
		
	}
	
}]);

erp.controller('CostParamsEditCtrl',['$scope', '$routeParams', '$location', 'MetaService','PurchaseService','$upload',function($scope, $routeParams, $location, MetaService,PurchaseService,$upload){
	$scope.isNew = !!($routeParams.id == 'new');
	
	$scope.items =MetaService.itemList();
	$scope.warehouses = MetaService.whList();
	$scope.cp={};
	if(!$scope.isNew)
	{
		var packing = PurchaseService.costparamStore.get({id: $routeParams.id}, function() {
			$scope.cp = packing;
			$scope.remote = angular.copy(packing);
			$scope.cp.$id = $routeParams.id;
			$scope.cp.item=(_.findWhere($scope.items, {id: $scope.cp.item_id})).sku;
		});
		
	}
	
	$scope.onFileSelect = function($files) {
		
	    for (var i = 0; i < $files.length; i++) {
			var file = $files[i];
			$scope.upload = $upload.upload({
				url: '/api/purchase/uploadcostparams',
				file: file,
			}).progress(function(event) {
				// console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
			}).success(function(data, status, headers, config) {
			//	console.log(data);
			  window.location.reload(); 
			});
		}
	};
	
	
	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.cp);
	};
	
	$scope.update=function(){
		if(!$scope.isNew)
		{
			PurchaseService.costparamStore.update($scope.cp, function() {
				$location.path('/purchase/costparams');
			});
		}
		else
		{
			PurchaseService.costparamStore.save($scope.cp, function() {
				$location.path('/purchase/costparams');
			});
		}
	}
	
	
}]);


//计划变采购单 新
erp.controller('PP2POCtrl', ['$scope' ,'$routeParams','$location','PurchaseService','ItemService', 'MetaService',function ($scope ,$routeParams,$location,PurchaseService,ItemService,MetaService) {
		

	$scope.whs = ItemService.metaStore.query({key: 'warehouseList'});
	$scope.chanels = ItemService.metaStore.query({key: 'chanelList'});
	$scope.trans = ItemService.metaStore.query({key: 'transportList'});
	$scope.taxs = ItemService.metaStore.query({key: 'taxList'});
	$scope.skus =  MetaService.itemList();
	$scope.vendors = PurchaseService.vendorStore.query();
	$scope.currencies = ['CNY', 'USD'];
	
	//所操作的计划表
	$scope.plan_id =null;
	
	//可用计划列表
	$scope.plans=[];
	
	//
	$scope.selectRepeatData = [];
	
	//已选中的detail
	$scope.selectObj = [];
	
	//可供选择的计划明细
	$scope.plandetails=[];
	
	//构造出来的采购单数据
	$scope.constructFormData={};
	
	//搜索数据
	$scope.seachform={};
	

	
	
	//清空数据
	function emptyOperaData()
	{
		$scope.selectObj = [];
		$scope.plandetails=[];
		$scope.constructFormData={};
	}
	
	function inArray(findMe,arraySource)
	{
		if(findMe==null) return false;
		if(arraySource.length<1) return false;
		for(var i in arraySource)
		{
			if(arraySource[i]==findMe) return true
		}
		return false;
	}
	
	//搜索
	$scope.csearch=function()
	{
		
		if(!$scope.seachform.plan_id)
		{
			alert("必须指定一个计划表");
			return ;
		}
		else
		{
			emptyOperaData();
			$scope.plan_id=$scope.seachform.plan_id;
			var params = angular.copy($scope.seachform);
			params.item= params.sku ? params.sku.id : '';
			params.vendor_id = params.vendor ? params.vendor.id : '';
			params.warehouse_id=params.warehouse_id?params.warehouse_id:'';
			params.transportation=params.transportation?params.transportation:'';
			params.price_type=params.price_type?params.price_type:'';
			params.plan_id=$scope.plan_id;
			
			//params.id=params.plan_id;
			$scope.plandetails = PurchaseService.execStore.getDetailList(params,function(data){
				$scope.plandetails=data;
			
			});
		}
	}
	
	
	//初始化
	function init()
	{
		$scope.plans = PurchaseService.execStore.confirmList({},function(data){
			$scope.plans=data;
			if($scope.plans.length>0)
			{
				$scope.plan_id=$scope.plans[$scope.plans.length-1].id;
				$scope.seachform.plan_id=$scope.plan_id;
				$scope.csearch();
			}	
		});
	}
	
	init();
	
	
	//全选
	$scope.checkall = function(){
		var o= jQuery("#all");
		var isCheckAll=o.attr('checked');
		
		if(isCheckAll)
		{
			for(var index in $scope.plandetails)
			{
				$scope.selectObj.push($scope.plandetails[index].id);
			}
		}
		else
		{
			$scope.selectObj = [];
		}
		
		if(isCheckAll){
		 	jQuery(".check-list :checkbox").attr("checked",true);
		}else{
			jQuery(".check-list :checkbox").attr("checked",false);
		}
		//alert($scope.selectObj.length);
	}
	
	//改变
	$scope.toggleAddData=function(detailId,index)
	{
		if(angular.isDefined($scope.selectRepeatData[index]))
		{
			if($scope.selectRepeatData[index])
			{
				if(!inArray(detailId,$scope.selectObj))
				{
					$scope.selectObj.push(detailId);
				}
			}
			else
			{
				if(inArray(detailId,$scope.selectObj))
				{
					for(var i in $scope.selectObj)
					{
						if($scope.selectObj[i]==detailId)
							$scope.selectObj.splice(i,1);
					}
				}
			}
		}
		
		//alert($scope.selectObj.length);
		
	}
	
	//是否只选中了一个
	$scope.isOnlySelectOneDetail=function(){
		
		//没时间就不写了
		return false;
		return $scope.selectObj.length==1;
	}
	
	//选中同类项
	//此功能只在 只选中了一个时有用
	$scope.checkAllSameDetails=function(){
		if($scope.isOnlySelectOneDetail())
		{
			
		}
		else
		{
			alert("此功能在只选中了一项时才有用");
		}
	}
	
	//批量操作确定
	$scope.doMutilDetailOpera	=function()
	{
		var action=$scope.baction;
		if(!$scope.baction || $scope.baction=="")
		{
			alert("请选择批量操作的类型");
		}
		
		switch(action)
		{
			case "vendor":
				$scope.changeMutilDetailVendor();
			break;
			case "tax":
				$scope.changeMutilDetailTax();
			break;
			case "trans":
				$scope.changeMutilDetailTrans();
			break;
		}
	}
	
	//批量操作 更改供应商
	$scope.changeMutilDetailVendor=function()
	{
		var selectVendor=$scope.action.vendor;
		if(!selectVendor)
		{
			alert("请选择一个供应商!");
		}
		else
		{
			for(var i in $scope.plandetails)
			{
				if(inArray($scope.plandetails[i].id,$scope.selectObj))
				{
					$scope.plandetails[i].vendor=selectVendor;
					$scope.updateDataAfterChangedVendor($scope.plandetails[i]);
				}
			}
		}
	}
	
	
	
	//更改供应商之后要进行的操作
	$scope.updateDataAfterChangedVendor=function(detail)
	{
		var params={};
		if( angular.isDefined(detail.vendor) && angular.isDefined(detail.vendor.id) && angular.isDefined(detail.item) && angular.isDefined(detail.item.id ))
		{
			var vendor_id=detail.vendor.id;
			var item_id=detail.item.id;
			PurchaseService.quotationVIStore.getByVI({item_id:item_id,vendor_id:vendor_id},function(data){
				if(angular.isDefined(data.spq))
				{
					detail.spq=data.spq;
				}
				else
					detail.spq=null;
			});
		}
	}
	//批量操作 更改含税
	$scope.changeMutilDetailTax=function()
	{
		var price_type=$scope.action.tax;
		if(!price_type)
		{
			alert("请选择一个含税方式!");
		}
		else
		{
			for(var i in $scope.plandetails)
			{
				if(inArray($scope.plandetails[i].id,$scope.selectObj))
				{
					$scope.plandetails[i].price_type=price_type;
				}
			}
		}
	}
	
	//批量操作 更改运输方式
	$scope.changeMutilDetailTrans=function()
	{
		var transportation=$scope.action.transportation;
		if(!transportation)
		{
			alert("请选择一个含税方式!");
		}
		else
		{
			for(var i in $scope.plandetails)
			{
				if(inArray($scope.plandetails[i].id,$scope.selectObj))
				{
					$scope.plandetails[i].transportation=transportation;
				}
			}
		}
	}
	
	//批量操作 按标准装箱数调整数量
	$scope.changeMutilDetailQty=function(type)
	{
		var changeType=type;
		if(!changeType)
		{
			alert("请选择一个调整方式!");
		}
		else
		{
			for(var i in $scope.plandetails)
			{
				if(inArray($scope.plandetails[i].id,$scope.selectObj))
				{
					var spq = $scope.plandetails[i].spq;
					var request_qty=$scope.plandetails[i].request_qty;
					spq=parseInt(spq);
					request_qty=parseInt(request_qty);
					var realQtyAfterChange=request_qty;
					if(spq&&request_qty)
					{
						switch(changeType)
						{
							case "middle": 
								realQtyAfterChange=Math.round(request_qty/spq) * spq;
							break;
							case "up": 
								realQtyAfterChange=Math.ceil(request_qty/spq) * spq;
							break;
							case "down": 
								realQtyAfterChange=Math.floor(request_qty/spq) * spq;
							break;
						}
						
						$scope.plandetails[i].real_qty=realQtyAfterChange;
						
						$scope.plandetails[i].to_purchase_qty=realQtyAfterChange - parseInt($scope.plandetails[i].stock_qty);
					}
				}
			}
		}
	}
	
	//构造生成的表头信息
	$scope.order={};
	//构造的要生成明细信息
	$scope.SysMakedOrderDetail=[];
	
	//公共的信息	
	$scope.commonVendorId=null;
	$scope.commonWarehouseId=null;
	$scope.commonTax=null;
	$scope.commonTrans=null;
	
	//构造明细信息
	function makeOrderDetail()
	{
		$scope.SysMakedOrderDetail=[];
		for(var i in $scope.plandetails)
		{
			if(inArray($scope.plandetails[i].id,$scope.selectObj))
			{
				var detail=$scope.plandetails[i];
				$scope.SysMakedOrderDetail.push(detail);
			}
		}
	}
	
	//构造表头信息
	function makeOrderMaster()
	{
		$scope.order={};
		$scope.order.vendor_id = $scope.commonVendorId;
		$scope.order.warehouse_id = $scope.commonWarehouseId;
		$scope.order.price_type = $scope.commonTax;
		$scope.order.status="pending";
		$scope.order.plan_id = $scope.plan_id;
		$scope.order.note = $scope.order.note || '';
		$scope.order.delivery_date = $scope.order.delivery_date || '';
		$scope.order.payment_terms = $scope.order.payment_terms || '';
		$scope.order.ship_to = $scope.order.ship_to || '';
		PurchaseService.orderStore.invoice({id: 'new', operation: 'invoice'}, function (data) {

			    $scope.order.invoice = data.invoice;
		})
		
		//$scope.order.transportation = $scope.commonTrans;
		//$scope.order.plan_id = $scope.plan_id;
	}
	
	//检查详细信息
	function checkOrderDetail()
	{
		$scope.commonVendorId=null;
		$scope.commonWarehouseId=null;
		$scope.commonTax=null;
		$scope.commonTrans=null;
		
		if($scope.SysMakedOrderDetail.length<1)
		{
			alert("check:至少选择一项");
		}
		else
		{
			for(var i in $scope.SysMakedOrderDetail)
			{
				if(
					!($scope.SysMakedOrderDetail[i].vendor
					  &&$scope.SysMakedOrderDetail[i].vendor.id
					  &&$scope.SysMakedOrderDetail[i].vendor.id)
				  )
				
				if(!$scope.SysMakedOrderDetail[i].warehouse_id)
				{
					alert("所选明细的需求仓库未填写");
					return false;
				}
				
				if(!$scope.SysMakedOrderDetail[i].vendor_id)
				{
					alert("所选明细的供应商未填写");
					return false;
				}
				
				if(!($scope.SysMakedOrderDetail[i].vendor&&$scope.SysMakedOrderDetail[i].vendor.id))
				{
					alert("所选明细的供应商未填写");
					return false;
				}
				
				if(!$scope.SysMakedOrderDetail[i].price_type)
				{
					alert("所选明细的含税方式未填写");
					return false;
				}
				
				if(!$scope.SysMakedOrderDetail[i].transportation)
				{
					alert("所选明细的含税方式未填写");
					return false;
				}
				
				if($scope.commonWarehouseId==null)
				{
					$scope.commonWarehouseId=$scope.SysMakedOrderDetail[i].warehouse_id;
				}
				else
				{
					if($scope.commonWarehouseId != $scope.SysMakedOrderDetail[i].warehouse_id)
					{
						alert("所选明细的需求仓库不同");
						return false;
					}
				}
				
				if($scope.commonVendorId==null)
				{
					$scope.commonVendorId=$scope.SysMakedOrderDetail[i].vendor.id;
				}
				else
				{
					if($scope.commonVendorId != $scope.SysMakedOrderDetail[i].vendor.id)
					{
						alert("所选明细的供应商不同");
						return false;
					}
				}
				
				if($scope.commonTax==null)
				{
					$scope.commonTax=$scope.SysMakedOrderDetail[i].price_type;
				}
				else
				{
					if($scope.commonTax != $scope.SysMakedOrderDetail[i].price_type)
					{
						alert("所选明细的含税方式不同");
						return false;
					}
				}
				
				if($scope.commonTrans==null)
				{
					$scope.commonTrans=$scope.SysMakedOrderDetail[i].transportation;
				}
				else
				{
					if($scope.commonTrans != $scope.SysMakedOrderDetail[i].transportation)
					{
						alert("所选明细的运输方式不同");
						return false;
					}
				}
			}
		}
		
		return ($scope.commonWarehouseId!=null)&&($scope.commonVendorId!=null)&&($scope.commonTax!=null)&&($scope.commonTrans!=null);
			
	}
	
	//生成采购单预处理
	$scope.preActionToMakeOrder=function()
	{
		if($scope.selectObj.length<1)
		{
			alert("至少选择一项");
			return;
		}
		else
		{
			makeOrderDetail();
			if(checkOrderDetail())
			{
				makeOrderMaster();
				jQuery('#makeOrderFormNew').modal();
				return true;
			}
		}
	}
	
	//生成采购单
	$scope.makeOrder=function()
	{
		var params={};
		params.master=$scope.order;
		params.childs=[];
		for(var i in $scope.SysMakedOrderDetail)
		{
			var item=$scope.SysMakedOrderDetail[i];
			item.planDetailId=item.id;
			if(item.vendor && angular.isDefined(item.vendor.id))
			{
				item.vendor_id = item.vendor.id;
			}
			else
			{
				item.vendor_id = $scope.commonVendorId;
			}
			
			params.childs.push(item);
		}
		
		PurchaseService.orderStore.generate( params, function() {
			 
		});
		
		$location.path($location.path());
	}
	
	//计算总金额
	$scope.getTotal=function(detail){
		if(detail&&detail.to_purchase_qty&&detail.unit_price)
		{
			return detail.to_purchase_qty*detail.unit_price;
		}
		else
			return 0;
	}
	
	
	
}]);

