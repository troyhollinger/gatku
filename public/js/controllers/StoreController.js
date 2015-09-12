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

			console.log(response.data);

			$scope.heads = response.data['heads'];
			$scope.poles = response.data['poles'];
			$scope.shrinker = response.data['shrinker'];
			$scope.extras1 = response.data['extras'].slice(0,3);
			$scope.extras2 = response.data['extras'].slice(3,7);
			$scope.apparel = response.data['apparel'];
			$scope.glasses = response.data['glasses'];

			console.log($scope.extras1);
			console.log($scope.extras2);

		}).error(function(response) {

			console.log("Something went wrong getting the store data");

		})

	}

	$scope.init();

}]);