app.controller('StoreController', ['$scope', 'Product', function($scope, Product) {

	$scope.heads = [];

	$scope.poles = [];

	$scope.extras = [];

	$scope.apparel = [];

	$scope.init = function() {

		$scope.getStore();

	}

	$scope.getStore = function() {

		Product.getByType().success(function(response) {

			$scope.heads = response.data['heads'];
			$scope.poles = response.data['poles'];

		}).error(function(response) {

			console.log("Something went wrong getting the store data");

		})

	}

	$scope.init();

}]);