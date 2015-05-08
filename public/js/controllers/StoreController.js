app.controller('StoreController', ['$scope', 'Product', function($scope, Product) {

	$scope.heads = [];

	$scope.poles = [];

	$scope.shrinker = [];

	$scope.extras = [];

	$scope.apparel = [];

	$scope.init = function() {

		$scope.getStore();

	}

	$scope.getStore = function() {

		Product.getByType().success(function(response) {

			$scope.heads = response.data['heads'];
			$scope.poles = response.data['poles'];
			$scope.shrinker = response.data['shrinker'];
			$scope.extras = response.data['extras'];
			$scope.apparel = response.data['apparel'];

		}).error(function(response) {

			console.log("Something went wrong getting the store data");

		})

	}

	$scope.init();

}]);