app.controller('ProductController', ['$scope', 'Product', 'CartService', function($scope, Product, CartService) {

	$scope.fullSize = true;

	$scope.loaded = false;

	$scope.product = {};

	$scope.init = function() {

		$scope.getProduct();

	}

	$scope.getProduct = function() {

		Product.get(productId).success(function(response) {

			$scope.product = response.data;

			$scope.loaded = true;

		}).error(function(response) {

			console.log(response.message);

		});

	}


	$scope.addToCart = function() {

		CartService.addItem($scope.product);

	}

	$scope.init();

}]);