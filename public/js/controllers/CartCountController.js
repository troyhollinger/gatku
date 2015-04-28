app.controller('CartCountController', ['$scope', 'CartService', function($scope, CartService) {

	$scope.count = CartService.getItems().length; 

	$scope.$on('update', function() {

		$scope.count = CartService.getItems().length; 

	});

	$scope.showCart = function() {

		CartService.show();

	}


}]);