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

		item.id = data.id;
		item.name = data.name;
		item.price = data.price;
		item.thumb = data.thumb;
		item.addons = [];

		// Grab selected addons from the user action,
		// dump them in the item.addons array
		for(var i = 0; i < data.addons.length; i++) {

			var addon = data.addons[i];
			var addonToCart = {};

			if (addon.checked) {

				addonToCart.id = addon.product.id;
				addonToCart.price = addon.product.price;
				addonToCart.name = addon.product.name;

				item.addons.push(addonToCart);

			}

		}

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