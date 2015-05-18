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

			count+= (1 * items[i].quantity);

			for(var ii = 0; ii < items[i].addons.length; ii++) {

				count+= (1 * items[i].addons[ii].quantity);

			}

		}

		$scope.count = count;

	}

	countItems();


}]);