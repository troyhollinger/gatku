app.controller('ProductController', ['$scope', 'Product', 'CartService', 'Size', function($scope, Product, CartService, Size) {

	$scope.fullSize = true;

	$scope.loaded = false;

	$scope.product = {};

	if (layoutType === 'pole' || layoutType === 'extra') {

		$scope.attached = true;

	} else {

		$scope.attached = false;

	}

	$scope.init = function() {

		$scope.getProduct();

	}

	$scope.getProduct = function() {

		Product.get(productId).success(function(response) {

			$scope.product = response.data;

			parseSizeableAddons();

			$scope.loaded = true;

		}).error(function(response) {

			console.log(response.message);

		});

	}


	$scope.addToCart = function() {

		if ($scope.product.sizeable) {

			var size = verifySizeIsChecked();

			if (size) {

				$scope.sizedProduct = angular.copy($scope.product);

				$scope.sizedProduct.name = size.name;
				$scope.sizedProduct.price = size.price;
				$scope.sizedProduct.shortName = size.shortName;
				$scope.sizedProduct.sizeId = size.id;

				CartService.addItem($scope.sizedProduct);

			} else {

				return false;

			}

		} else {

			CartService.addItem($scope.product);

		}

		reset();

	}



	$scope.poleScrollInit = function() {

		PoleScroll.init();

	}

	$scope.goFullSize = function() {

		setTimeout(function() {

			PoleScroll.init();

		}, 20);
		
	}

	function verifySizeIsChecked() {

		for(var i = 0; i < $scope.product.sizes.length; i++) {

			if ($scope.product.sizes[i].checked) {

				return $scope.product.sizes[i];

			}

		}

		return false;

	}

	function parseSizeableAddons() {

		for(var i = 0; i < $scope.product.addons.length; i++) {

			var addon = $scope.product.addons[i];

			if (addon.product.sizeable && addon.product.slug === 'bands') {

				var slug = $scope.product.slug + '-band';

				Size.getBySlug(slug).success(function(response) {

					addon.product.price = response.data.price;

				}).error(function(response) {

					$scope.product.addons.splice(i, 1);

				});

			}

		}

	}

	function reset() {

		if ($scope.product.sizeable) {

			for(var i = 0; i < $scope.product.sizes.length; i++) {

				$scope.product.sizes[i].checked = false;

			}

		} else {

			for(var i = 0; i < $scope.product.addons.length; i++) {

				$scope.product.addons[i].checked = false;

			}

		}

		

	}

	$scope.init();

}]);