app.controller('MobileNavigationController', ['$scope', 'Product', function($scope, Product) {

	$scope.open = false;

	$scope.$on('open', function() {

		$scope.open = true;

	});

	$scope.$on('close', function() {

		$scope.open = false;

	});

}]); 