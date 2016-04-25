'use strict';

erp.directive('tokenInput', ['$parse', function ($parse) {
	return {
		restrict: 'A',
		require: ['?ngModel'],
		// replace: true,
		// template: '<input type="text" />',
		// scope: {ngModel: '='},
		link: function (scope, iElement, iAttrs) {
			var options = {
				theme: iAttrs.tokenTheme || "facebook",
				tokenLimit: iAttrs.tokenLimit || 3,
				hintText: iAttrs.hintText || 'type to search',
				noResultsText: iAttrs.noResultsText || 'nothing found.',
				searchingText: iAttrs.searchingText || 'searchig...',
				searchDelay: 0,
				preventDuplicates: true
			};

			
			var reflect = function (results) {
				if (iAttrs.ngModel) {
					scope.$$phase || scope.$apply(function () {
						$parse(iAttrs.ngModel).assign(scope, iElement.tokenInput("get").length ? iElement.tokenInput("get") : '');
					});
				};
			};
			options.onAdd = reflect;
			options.onDelete = reflect;

			scope.$watch(iAttrs.inputSuggest, function () {
				var getter = $parse(iAttrs.inputSuggest);
				var suggestList = getter(scope);

				iElement.tokenInput(suggestList, options);
			});

			scope.$watch(iAttrs.ngModel, function() {
				iElement.tokenInput('clear');
				angular.forEach($parse(iAttrs.ngModel)(scope), function(v) {
					iElement.tokenInput('add', v);
				});
			});

		}
	};
}])