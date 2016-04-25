'use strict';

erp.filter('warehouse', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.whList(), {id: id})  || {}).name || id;
	}
}]);

erp.filter('item_category', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.item.categories(), {id: id}) || {}).name || id;
	}
}]);

erp.filter('stock_status', [function() {
	return function(status) {
		switch(status)
		{
		case 0:
		    return "not stocked";
		  break;
		case 1:
		   return "stocked";
		   break;
		default:
		   return "booked";
		}

	}
}]);

erp.filter('inventory_status', [function() {
	return function(status) {
		switch(status)
		{
		case '0':
		    return "onroad";
		  break;
		case '1':
		   return "stocked";
		   break
		}


	}
}]);


erp.filter('inv_type', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.invTypeList(), {id: id}) || {}).name || id;
	}
}]);

erp.filter('io_type', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.ioTypeList(), {id: id}) || {}).name || id;
	}
}]);

erp.filter('user', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.userList(), {id: id}) || {}).name || id;
	}
}]);

erp.filter('vendor', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.vendorList(), {id: id}) || {}).name || id;
	}
}]);

erp.filter('userChannel',['MetaService',function(MetaService){
	return function(id){
		return (_.findWhere(MetaService.chanelList(), {id: id}) || {}).name || id;
	}
}]);

erp.filter('sku', ['MetaService', function(MetaService) {
	return function(id) {
		return (_.findWhere(MetaService.itemList(), {id: id}) || {}).sku || id;
	}
}]);

erp.filter('country',[function(){
	return function(key)
	{
		var countries=[{id:'US',name:'美国'},{id:'UK',name:'英国'},{id:'DE',name:'德国'},{id:'CN',name:'中国'},{id:'FR',name:'美国'}];
		
		for(var i in countries)
		{
			if(countries[i].id==key) return countries[i].name;
			else if(countries[i].name==key) return countries[i].id; 
		}
		return '';
	}
}]);

erp.filter('floatNum',[function(){
	return function(num,median)
	{		
		median=median||"2";
		median = parseInt(median);
		if(isNaN(median)) median=2;
		
		var accuracy=Math.pow(10,median);//精度
		var holdNum=num;
		if(isNaN(parseFloat(num))) return holdNum;
		else
			holdNum=parseFloat(num);
		var tmpNum=Math.round(holdNum*accuracy);//四舍五入取整
		return tmpNum/accuracy;
	}
}]);

erp.filter('localDateTimeFilter',[function(){
	return function(dateStr,dateRegExp)
	{		
		if(angular.isDate(dateStr)) return dateStr;
		
		if(angular.isString(dateRegExp))
		{
			dateRegExp=new RegExp(dateRegExp);
		}
		
		if(toString.call(dateRegExp) !== '[object RegExp]')
		{	
			dateRegExp=/^([\d]{4})[\-\/]([\d]{1,2})[\-\/]([\d]{1,2})\s+[\d]{1,2}[\:][\d]{1,2}[\:][\d]{1,2}$/;
		}		
		
		
		if(dateRegExp.test(dateStr))
		{
			var dateArr=dateRegExp.exec(dateStr);
			var returnValue;
			if(dateArr.length>3)
			{
				returnValue=new Date(dateArr[1],dateArr[2],dateArr[3]);
				
				if(angular.isDate(returnValue)) return returnValue;
				else return new Date();
			}
			else return new Date();
		}
		else
		{
			return new Date();
		}
	}
}]);