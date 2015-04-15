app.factory('CartService', ['$rootScope', '$http', '$cookies', '$cookieStore', 'ipCookie', function($rootScope, $http, $cookies, $cookieStore, ipCookie) {

	var CartService = {};
	var Cookie = ipCookie;

	CartService.getItems = function() {

		var cookies = Cookie('items') || [];

		return cookies;

	}

	CartService.addItem = function(data) {

		var cart = CartService.getItems();
		var item = {};

		item.id = data.item.id;
		item.name = data.item.name;
		item.price = data.item.price;
		item.thumb = data.item.thumb;

		cart.push(item);

		Cookie('items', cart, { path : '/' });

		$rootScope.$broadcast('update');

	}
	

	CartService.removeItem = function(id) {

		$rootScope.$broadcast('update');

	}

	CartService.update = function() {

		$rootScope.$broadcast('update');

	}

	CartService.empty = function() {

	    Cookie.remove('items', { path : '/' });
		
		$rootScope.$broadcast('update');

	}

	CartService.show = function() {

		$rootScope.$broadcast('show');

	}

	CartService.hide = function() {

		$rootScope.$broadcast('hide');

	}

	
	return CartService;

}]);