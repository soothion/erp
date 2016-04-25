'use strict';

erp.factory('factoryPaging', function () {
	return function (func, size) {
		var result = {
			curPage: 1,
			data: {},

			hasNextPage: function () {
				return this.data.length === size + 1;
			},

			hasPrePage: function () {
				return this.curPage > 1;
			},

			goNextPage: function () {
				this.curPage += 1;
				return this.fetch();
			},

			goPrePage: function () {
				this.curPage -= 1;
				return this.fetch();
			},

			first: function () {
				this.curPage = 1;
				return this.fetch();
			},

			fetch: function () {
				this.data = func(this.curPage, size);
				if (this.hasNextPage()) {
					return this.data.slice(0, size);
				}
				return this.data;
			}
		};

		result.fetch();
		return result;
	};
});