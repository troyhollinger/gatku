app.factory('CartService', ['$rootScope', '$http', '$cookies', '$cookieStore', 'ipCookie', 'AlertService', function($rootScope, $http, $cookies, $cookieStore, ipCookie, AlertService) {

	var CartService = {};
	var Cookie = ipCookie;

	CartService.getItems = function() {

		var cookies = Cookie('items') || [];

		return cookies;

	}

	/**
	 * This method defines what pieces of data 
	 * you want to use in all of the CartController logic.
	 *
	 */
	CartService.addItem = function(data) {

		var cart = CartService.getItems();
		var item = {};

		item.id = data.id;
		item.name = data.name;
		item.shortName = data.shortName;
		item.length = data.length;
		item.price = data.price;
		item.thumb = data.thumb;
		item.type = {};
		item.type.shippingPrice = data.type.shippingPrice;
		item.type.slug = data.type.slug;
		item.sizeable = data.sizeable;
		item.sizeId = data.sizeId;
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

		AlertService.broadcast('Item added to cart!', 'success');

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

	CartService.productInCart = function(productId) {

		var cookies = Cookie('items') || [];

		if (cookies.length) {

			for(var i = 0; i < cookies.length; i++) {

				if (cookies[i].id === productId) return true;

			}

		}

		return false;		

	}
	
	return CartService;

}]);