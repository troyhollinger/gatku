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
		item.slug = data.slug;
		item.type = {};
		item.type.shippingPrice = data.type.shippingPrice;
		item.type.slug = data.type.slug;
		item.sizeable = data.sizeable;
		item.sizeId = data.sizeId;
		item.addons = [];
		item.quantity = 1;

		// Grab selected addons from the user action,
		// dump them in the item.addons array
		for(var i = 0; i < data.addons.length; i++) {

			var addon = data.addons[i];
			var addonToCart = {};

			if (addon.checked) {

				addonToCart.id = addon.product.id;
				addonToCart.price = addon.product.price;
				addonToCart.name = addon.product.name;
				addonToCart.sizeable = addon.product.sizeable;
				if (addon.product.sizeId) {

					addonToCart.sizeId = addon.product.sizeId;

				}
				addonToCart.quantity = 1;

				item.addons.push(addonToCart);

			}

		}

		cart.push(item);

		Cookie('items', cart, { path : '/' });

		$rootScope.$broadcast('update');

		$rootScope.$broadcast('itemAdded');

	}
	

	CartService.removeItem = function(index) {

		var cart = CartService.getItems();

		if (!cart.length) return false;

		cart.splice(index,1);

		Cookie('items', cart, { path : '/' });

		$rootScope.$broadcast('update');

	}

	CartService.increaseItemQuantity = function(itemIndex) {

		var cart = Cookie('items') || [];

		cart[itemIndex].quantity++;

		Cookie('items', cart, { path : '/' });

		$rootScope.$broadcast('update');

	}

	CartService.decreaseItemQuantity = function(itemIndex) {

		var cart = Cookie('items') || [];

		cart[itemIndex].quantity--;

		if (cart[itemIndex].quantity == 0) {

			cart.splice(itemIndex, 1);

		} 

		Cookie('items', cart, { path : '/' });

		$rootScope.$broadcast('update');

	}

	CartService.increaseAddonQuantity = function(itemIndex, addonIndex) {

		var cart = Cookie('items') || [];

		cart[itemIndex].addons[addonIndex].quantity++;

		Cookie('items', cart, { path : '/' });

		$rootScope.$broadcast('update');

	}

	CartService.decreaseAddonQuantity = function(itemIndex, addonIndex) {

		var cart = Cookie('items') || [];

		cart[itemIndex].addons[addonIndex].quantity--;

		if (cart[itemIndex].addons[addonIndex].quantity == 0) {

			cart[itemIndex].addons.splice(addonIndex, 1);

		}

		Cookie('items', cart, { path : '/' });

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