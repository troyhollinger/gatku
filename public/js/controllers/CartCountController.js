app.controller('CartCountController', ['$scope', 'CartService', function($scope, CartService) {

	$scope.$on('update', function() {

		countItems();

	});

	$scope.showCart = function() {

		CartService.show();

	}

	function countItems() {

		var items = CartService.getItems();
		var count = 0;

		for(var i = 0; i < items.length; i++) {

			count++;

			for(var ii = 0; ii < items[i].addons.length; ii++) {

				count++;

			}

		}

		$scope.count = count;

	}

	countItems();


}]);