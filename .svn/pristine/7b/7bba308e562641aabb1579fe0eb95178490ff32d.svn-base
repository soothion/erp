'use strict';

erp.config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {

	$routeProvider.when('/item', {
		templateUrl: 'angular/views/item/index.html',
		controller: 'ItemCtrl'
	}).
	when('/item/new', {
		templateUrl: 'angular/views/item/index_detail.html',
		controller: 'ItemNewCtrl'
	}).
	when('/item/upload', {
		templateUrl: 'angular/views/item/index_upload.html',
		controller: 'ItemUploadCtrl'
	}).
	when('/item/edit/:id', {
		templateUrl: 'angular/views/item/index_detail.html',
		controller: 'ItemDetailCtrl'
	}).
	when('/item/info/:id', {
		templateUrl: 'angular/views/item/item_detail_image.html',
		controller: 'ItemShowCtrl'
	}).
	when('/item/image/:id', {
		templateUrl: 'angular/views/item/detail.image.html',
		controller: 'ItemDetailImageCtrl'
	}).
   	when('/item/image/:id', {
		templateUrl: 'angular/views/item/detail.image.html',
		controller: 'ItemDetailImageCtrl'
	}).

	when('/item/category', {
		templateUrl: 'angular/views/item/category.html',
		controller: 'ItemCateCtrl'
	}).
	
	when('/item/image', {
		templateUrl: 'angular/views/item/image.html',
		controller: 'ItemImageCtrl'
	}).
	when('/item/category/new', {
		templateUrl: 'angular/views/item/category_detail.html',
		controller: 'ItemCateNewCtrl'
	}).
	when('/item/category/edit/:id', {
		templateUrl: 'angular/views/item/category_detail.html',
		controller: 'ItemCateDetailCtrl'
	}).

	when('/item/language/', {
		templateUrl: 'angular/views/item/language.html',
		controller: 'ItemLangCtrl'
	}).
	when('/item/language/new', {
		templateUrl: 'angular/views/item/language_detail.html',
		controller: 'ItemLangNewCtrl'
	}).
	when('/item/language/edit/:id', {
		templateUrl: 'angular/views/item/language_detail.html',
		controller: 'ItemLangDetailCtrl'
	}).

	when('/item/attribute/', {
		templateUrl: 'angular/views/item/attribute.html',
		controller: 'ItemAttributeCtrl'
	}).
	when('/item/attribute/new', {
		templateUrl: 'angular/views/item/attribute_detail.html',
		controller: 'ItemAttributeNewCtrl'
	}).
	when('/item/customs/', {
		templateUrl: 'angular/views/item/custom_index.html',
		controller: 'ItemCustomCtrl'
	}).
	when('/item/customs/update/:id', {
		templateUrl: 'angular/views/item/custom_edit.html',
		controller: 'ItemCustomUpdateCtrl'
	}).
	when('/item/attribute/edit/:id', {
		templateUrl: 'angular/views/item/attribute_detail.html',
		controller: 'ItemAttributeDetailCtrl'
	});
}]);

erp.controller('ItemCtrl', ['$scope', 'MetaService', 'Paginator', function ($scope, MetaService, Paginator) {

	var store = MetaService.storeBuilder('item', 'info');

	$scope.searchModel = {kw: '', 'category': 0};

	var fetchFunction = function(offset, limit, callback) {
		var kw = {kw: $scope.searchModel.kw, category: $scope.searchModel.category};
		store.query(angular.extend(kw, {offset: offset, limit: limit}), function(items) {
			callback(items);
		});
	};

	$scope.paginator = Paginator(fetchFunction, MetaService.config.page.size);
	$scope.categories = MetaService.item.categories();

}]);

erp.controller('ItemShowCtrl', ['$scope', 'ItemService','MetaService','$routeParams',function ($scope, ItemService,MetaService,$routeParams) {
		$scope.item = ItemService.itemStore.get({id: $routeParams.id});
		$scope.images= ItemService.imageStore.query({id: $routeParams.id});
        
}]);
erp.controller('ItemNewCtrl', ['$scope', '$location', 'CacheService', 'ItemService',function ($scope, $location, CacheService, ItemService) {

	$scope.categories = ItemService.cateStore.query();
	$scope.isNew=true;

	jQuery("[data-toggle='tooltip']").tooltip({placement:'right'});
	
	$scope.accordion=function(show){
		
		show?jQuery('.panel-collapse').collapse('show'):jQuery('.panel-collapse').collapse('hide');
	};
	$scope.showShuoming=function()
	{
		if($scope.item.hasOwnProperty("brand_instructions"))
		{
			alert("ook");
		}
		else
			alert("fuck");
		
		//alert($scope.item.brand_instructions);
	}
	
	$scope.states = CacheService.get('item.stateList') || ItemService.metaStore.query({key: 'stateList'}, function() {
		CacheService.set('item.stateList', $scope.states);
	});

	$scope.update = function() {
		ItemService.itemStore.save($scope.item, function() {
			$location.path('/item');
		});
	};
}]);

erp.controller('ItemUploadCtrl', ['$scope', '$location', '$upload', 'ItemService', 'MetaService', 'Paginator', function ($scope, $location, $upload, ItemService, MetaService, Paginator) {
   
	var fetchFunction = function(offset, limit, callback) {
		ItemService.queues.query({offset: offset, limit: limit}, function(queues) {
			callback(queues);
		});
	};

	$scope.paginator = Paginator(fetchFunction, MetaService.config.page.size);

	$scope.refresh = function() {$scope.paginator._load();};

	$scope.showError = function(item) {
		$scope.error_display = item;
		jQuery('#error_modal').modal();
	};

	$scope.onFileSelect = function($files) {
	
		for (var i = 0; i < $files.length; i++) {
			var file = $files[i];
			$scope.upload = $upload.upload({
				url: '/api/item/upload',
				file: file,
			}).progress(function(event) {
				// console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
			}).success(function(data, status, headers, config) {
				console.log(data);
				$scope.refresh();
			});
		}
	};

}]);

erp.controller('ItemDetailImageCtrl', ['$scope', '$location', '$upload', 'ItemService', 'MetaService', 'Paginator','$routeParams', function ($scope, $location, $upload, ItemService, MetaService,Paginator,$routeParams) {
	$scope.id=$routeParams.id;
	$scope.currentUpdateId=-1;
	$scope.image_desc="";
	var selectedFile=false;
	var addNewimage=false;
	$scope.isNew=true;
	$scope.big_image_url="#";
	var images=ItemService.itemSimpleImagesStore.query({id:$routeParams.id},function(){		
		$scope.images=images;
		if(typeof(images.length)!="number" || images.length<=0)
		{
			$scope.isNew=true;
		}
		else
			$scope.isNew=false;
	});

	$scope.onFileSelect = function($files) {
		if($files.length>1) return ;
		else
			selectedFile=$files[0];
	};
	
	
	$scope.sendImageInfo=function(id,otherInfo)
	{		
		$scope.upload = $upload.upload({
			url: '/api/item/image_detail/'+id,
			file: selectedFile,
			data: otherInfo,
		}).progress(function(event) {
			// console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
		}).success(function(data, status, headers, config) {
			console.log(data);
			//$location.path('/api/item/image_detail/'+$scope.id);
		});
		
		ItemService.itemSimpleImagesStore.query({id:$routeParams.id},function(){		
			$scope.images=images;
		});
	}
	
	$scope.showImageModal=function(real_image_url)
	{
		$scope.big_image_url=real_image_url;
	
		jQuery("#showImageModal").modal();
	};
	
	$scope.showChangeForm=function(id)
	{
		$scope.currentUpdateId=id;
		jQuery("#showImageChangeFormModal").modal();
	};
	
	$scope.updateImage=function()
	{
		var other={};
		if(addNewimage)
		{
			other.isNew=true;
		}
		other.desc=$scope.image_desc;
		$scope.sendImageInfo($scope.currentUpdateId,other);
		//return false;
	};
	
	$scope.addNewImage=function()
	{
		$scope.currentUpdateId=$scope.id;
		addNewimage=true;
		jQuery("#showImageChangeFormModal").modal();
	}
	
}]);

//注释 和 注释掉的代码不要删啊  by 朱念
erp.controller('ItemDetailCtrl', ['$scope', '$routeParams', '$location', 'CacheService', 'ItemService', '$upload', function ($scope, $routeParams, $location, CacheService, ItemService,$upload) {
	var id=$routeParams.id;
	var item = ItemService.itemStore.get({id: $routeParams.id}, function() {		
		$scope.item = item;
		$scope.remote = angular.copy(item);
		$scope.item.$id = $routeParams.id;
	});
	
	$scope.isNew=false;
	
	jQuery("[data-toggle='tooltip']").tooltip({placement:'right'});
	
	var uploadFile_zn,uploadFile_en,uploadFile_fr,uploadFile_gm,uploadFile_it,uploadFile_jp,uploadFile_pt,uploadFile_sp;
	
	$scope.accordion=function(show){
		
		show?jQuery('.panel-collapse').collapse('show'):jQuery('.panel-collapse').collapse('hide');
	};
	$scope.categories = ItemService.cateStore.query();

	$scope.states = CacheService.get('item.stateList') || ItemService.metaStore.query({key: 'stateList'}, function() {
		CacheService.set('item.stateList', $scope.states);
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.item);
	};

	$scope.update = function() {
		
		item.$update(function (){
			
			//$scope.uploadFile();
			
			$location.path('/item');
		}, function (error) {
			console.log(error.data.error.message);
		});
	};
	
	//注释 和 注释掉的代码不要删啊  by 朱念
//	$scope.onFileSelect=function($files,lang)
//	{		
//		if($files.length>1) return;
//		else
//		{
//			switch(lang)
//			{
//				case "zn":
//					uploadFile_zn=$files[0];
//				break;
//				case "en":
//					uploadFile_en=$files[0];
//				break;
//				case "fr":
//					uploadFile_fr=$files[0];
//				break;
//				case "gm":
//					uploadFile_gm=$files[0];
//				break;
//				case "it":
//					uploadFile_it=$files[0];
//				break;
//				case "jp":
//					uploadFile_jp=$files[0];
//				break;
//				case "pt":
//					uploadFile_pt=$files[0];
//				break;
//				case "sp":
//					uploadFile_sp=$files[0];
//				break;	
//			}				
//		}
//	}
////	
//	$scope.uploadFile=function(){
//		for(var lang in $scope.item.instructions_languge)
//		{
//			var otherInfo={};
//			var sendFile;
//			switch(lang)
//			{
//				case "zn":
//					otherInfo.lang="中";
//					sendFile=uploadFile_zn;
//				break;
//				case "en":
//					otherInfo.lang="英";
//					sendFile=uploadFile_en;
//				break;
//				case "fr":
//					otherInfo.lang="法";
//					sendFile=uploadFile_fr;
//				break;
//				case "gm":
//					otherInfo.lang="德";
//					sendFile=uploadFile_gm;
//				break;
//				case "it":
//					otherInfo.lang="意";
//					sendFile=uploadFile_it;
//				break;
//				case "jp":
//					otherInfo.lang="日";
//					sendFile=uploadFile_jp;
//				break;
//				case "pt":
//					otherInfo.lang="莆";
//					sendFile=uploadFile_pt;
//				break;
//				case "sp":
//					otherInfo.lang="西";
//					sendFile=uploadFile_sp;
//				break;			
//			}
//			 $upload.upload({
//					url: '/api/item/instructions_lang_detail/'+id,
//					file: sendFile,
//					data: otherInfo,
//				}).progress(function(event) {
//					// console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
//				}).success(function(data, status, headers, config) {
//					console.log(data);
//					//$location.path('/api/item/image_detail/'+$scope.id);
//				});
//		}
//	}

	$scope.destroy = function () {
		item.$remove(function () {
			$location.path('/item');
		}, function (error) {
			console.log(error.data.error.message);
		});	
	}
}]);

erp.controller('ItemImageCtrl', ['$scope','$upload','Paginator','MetaService','ItemService', function ($scope, $upload,Paginator,MetaService,ItemService) {
        $scope.skus = MetaService.itemList();
    	var fetchFunction = function(offset, limit, callback) {
		ItemService.imageQueues.query({offset: offset, limit: limit}, function(queues) {
			callback(queues);
		});
	};

	$scope.paginator = Paginator(fetchFunction, MetaService.config.page.size);

	$scope.refresh = function() {$scope.paginator._load();};

	$scope.showError = function(item) {
		$scope.error_display = item;
		jQuery('#error_modal').modal();
	};
  	$scope.onFileSelect = function($files) {
		for (var i = 0; i < $files.length; i++) {
			var file = $files[i];
			$scope.upload = $upload.upload({
				url: '/api/item/imageUpload',
				file: file,
			}).progress(function(event) {
				// console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
			}).success(function(data, status, headers, config) {
				if(data=="only support zip"){
						$scope.normal_error = data;
		               jQuery('#normal_error').modal();

					 
				}else{
					
					//window.location.reload();
					}
				 
			});
		}
	};

	$scope.images = ItemService.imageStore.query();
}]);

erp.controller('ItemCateCtrl', ['$scope', 'ItemService', function ($scope, ItemService) {
	$scope.categories = ItemService.cateStore.query();

}]);

erp.controller('ItemCateNewCtrl', ['$scope', '$location', 'ItemService', function ($scope, $location, ItemService) {
	$scope.update = function() {
		ItemService.cateStore.save($scope.category, function() {
			$location.path('/item/category');
		});
	};
}]);

erp.controller('ItemCateDetailCtrl', ['$scope', '$routeParams', '$location', 'ItemService', function ($scope, $routeParams, $location, ItemService) {

	var category = ItemService.cateStore.get({id: $routeParams.id}, function() {
		$scope.category = category;
		$scope.remote = angular.copy(category);
		$scope.category.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.category);
	};

	$scope.update = function() {
		category.$update(function (){
			$location.path('/item/category');
		}, function (error) {
			console.log(error.data.error.message);
		});
	};

	$scope.destroy = function () {
		category.$remove(function () {
			$location.path('/item/category');
		}, function (error) {
			console.log(error.data.error.message);
		});
	}
}]);

erp.controller('ItemLangCtrl', ['$scope', 'ItemService', function ($scope, ItemService) {

	$scope.languages = ItemService.langStore.query();

}]);

erp.controller('ItemLangNewCtrl', ['$scope', '$location', 'ItemService', function ($scope, $location, ItemService) {
	$scope.update = function() {
		ItemService.langStore.save($scope.language, function() {
			$location.path('/item/language');
		});
	};
}]);

erp.controller('ItemLangDetailCtrl', ['$scope', '$routeParams', '$location', 'ItemService', function ($scope, $routeParams, $location, ItemService) {

	var language = ItemService.langStore.get({id: $routeParams.id}, function() {
		$scope.language = language;
		$scope.remote = angular.copy(language);
		$scope.language.$id = $routeParams.id;
	});

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.language);
	};

	$scope.update = function() {
		language.$update(function (){
			$location.path('/item/language');
		}, function (error) {
			console.log(error.data.error.message);
		});
	};

	$scope.destroy = function () {
		language.$remove(function () {
			$location.path('/item/language');
		}, function (error) {
			console.log(error.data.error.message);
		});
		
	}
}]);

erp.controller('ItemAttributeCtrl', ['$scope', 'ItemService', function ($scope, ItemService) {

	$scope.attributes = ItemService.attributeStore.query();

}]);

erp.controller('ItemAttributeNewCtrl', ['$scope', '$location', 'ItemService', function ($scope, $location, ItemService) {

	$scope.categories = ItemService.cateStore.query();

	$scope.update = function() {
		ItemService.attributeStore.save($scope.attribute, function() {
			$location.path('/item/attribute');
		});
	};
}]);

erp.controller('ItemAttributeDetailCtrl', ['$scope', '$routeParams', '$location', 'ItemService', function ($scope, $routeParams, $location, ItemService) {

	var attribute = ItemService.attributeStore.get({id: $routeParams.id}, function() {
		$scope.attribute = attribute;
		$scope.remote = angular.copy(attribute);
		$scope.attribute.$id = $routeParams.id;
	});

	$scope.categories = ItemService.cateStore.query();

	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.attribute);
	};

	$scope.update = function() {
		attribute.$update(function (){
			$location.path('/item/attribute');
		}, function (error) {
			console.log(error.data.error.message);
		});
	};

	$scope.destroy = function () {
		attribute.$remove(function () {
			$location.path('/item/attribute');
		}, function (error) {
			console.log(error.data.error.message);
		});
		
	}
}]);


erp.controller('ItemCustomCtrl',['$scope','ItemService','MetaService',function($scope,ItemService,MetaService){
	$scope.countries=[{id:'US',name:'美国'},{id:'UK',name:'英国'},{id:'DE',name:'德国'},{id:'CN',name:'中国'},{id:'FR',name:'美国'}];
	$scope.skus=MetaService.itemList();
	$scope.customs = ItemService.customStore.query();
	
	$scope.toFilter=function()
	{
		var params={};
		params.invoice=$scope.searchModel.invoice?$scope.searchModel.invoice:"";
		params.sku = $scope.searchModel.sku ? $scope.searchModel.sku.id : '';
		params.country = $scope.searchModel.country?$scope.searchModel.country:"";
		
		if(! params.sku)
		{
			params.skuLike=jQuery(".form-control#sku").val();
		}
		
		var list = ItemService.customStore.query(params, function() {
			$scope.customs = list;
		});
	}
	
	$scope.destroy=function(id){
		ItemService.customStore.remove({id:id}, function() {
			$scope.customs =ItemService.customStore.query();
		});
	};
	
}]);


erp.controller('ItemCustomUpdateCtrl', ['$scope', '$routeParams', '$location', 'ItemService', 'MetaService', function ($scope, $routeParams, $location, ItemService, MetaService) {
	
	var brand = ($routeParams.id == 'new');
	$scope.skus=MetaService.itemList();
	
	$scope.countries=[{id:'US',name:'美国'},{id:'UK',name:'英国'},{id:'DE',name:'德国'},{id:'CN',name:'中国'},{id:'FR',name:'美国'}];
	
	$scope.persisted = ! brand;

	$scope.custom = {};

	var custom =ItemService.customStore.get({id: $routeParams.id}, function() {
		
		$scope.custom = custom;
		$scope.remote = angular.copy(custom);
		$scope.custom.$id = $routeParams.id;
	});


	$scope.isClean = function() {
		return angular.equals($scope.remote, $scope.custom);
	};


	$scope.update = brand ? function() {

		ItemService.customStore.save($scope.custom, function(data) {
			if(data.id)
			{
				$location.path('/item/customs/update/'+data.id);
			}
			else
			{
				location.href="#/item/customs";
			}
		});

	} : function() {
		ItemService.customStore.update($scope.custom, function() {
			window.location.reload(); 
			//$location.path('/purchase/request/edit/'+$routeParams.id);
		});
	};

	$scope.destroy=brand ?function(){return;}:function(){
		
		ItemService.customStore.remove({id:$routeParams.id}, function() {
			$location.path('/item/customs');
		});
	};
	
	
}]);
