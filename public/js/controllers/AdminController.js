app.controller('AdminController', ['$scope', 'Image', 'Product', 'Order', function($scope, Image, Product, Order) {

	$scope.init = function() {

		// $scope.showProducts = true;
		$scope.show('orders');
		$scope.getOrders();
		$scope.getTypes();
		$scope.getProducts();

	}

	$scope.orders = [];

	$scope.types = [];

	$scope.products = [];

	$scope.newProduct = {};

	$scope.editState = false;

	$scope.editingNew = true;

	$scope.show = function(section) {

		$scope.showOrders = false;
		$scope.showProducts = false;
		$scope.showYou = false;
		$scope.showVideos = false;

		switch(section) {

			case 'orders' :
				$scope.showOrders = true;
				break;
			case 'products' : 
				$scope.showProducts = true;
				break;
			case 'you' :
				$scope.showYou = true;
				break;
			case 'videos' : 
				$scope.showVideos = true;
				break;

		}

	}

	$scope.getProducts = function() {

		Product.all().success(function(response) {

			$scope.products = response.data;
			
		}).error(function(response) {

			console.log("Sorry, there was an error retrieving the products");

		});

	}

	$scope.createProduct = function() {

		var nanobar = new Nanobar({ bg : '#fff' });

		nanobar.go(60);

		Product.store($scope.newProduct).success(function(response) {

			$scope.getProducts();
			$scope.clearNewProduct();
			nanobar.go(100);

		}).error(function(response) {

			nanobar.go(100);
			console.log("Sorry, something went wrong");

		});

	}

	$scope.editProduct = function(product) {

		$scope.newProduct = product;
		$scope.editState = true;
		$scope.editingNew = false;

		$scope.registerAddons();

	}

	$scope.updateProduct = function() {

		var nanobar = new Nanobar({ bg : '#fff' });
		var data = $scope.newProduct;

		nanobar.go(65);

		Product.update(data.id, data).success(function(response) {

			$scope.getProducts();
			$scope.clearNewProduct();
			nanobar.go(100);

		}).error(function(response) {

			nanobar.go(100);
			console.log("Sorry, something went wrong");

		});

	}

	$scope.upload = function($files, model) {

		var nanobar = new Nanobar({ bg : '#fff' });
		var file = $files[0];

		if (!file) return false;

		var data = {

			url : '/product/image',
			file : file

		}

		nanobar.go(40);

		Image.upload(data).progress(function(evt) {

			var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);

			// console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);

		}).success(function(response) {

			$scope.newProduct[model] = response.data;

			nanobar.go(100);

		}).error(function(response) {

			nanobar.go(100);

		});

	}

	$scope.clearNewProduct = function() {

		$scope.newProduct = {};
		$scope.editState = false;
		$scope.editingNew = true;

	}

	$scope.getTypes = function() {

		Product.getTypes().success(function(response) {

			$scope.types = response.data;

			// console.log(response.data);

		}).error(function(response) {

			console.log("Sorry, types could not be retrieved");

		});

	}



	$scope.registerAddons = function() {

		$scope.newProduct.addonSelection = [];

		for(var i = 0; i < $scope.products.length; i++) {

			var addon = {};

			addon.id = $scope.products[i].id;
			addon.name = $scope.products[i].name;

			// If selected products has addons
			if ($scope.newProduct.addons.length) {

				for(var e = 0; e < $scope.newProduct.addons.length; e++) {

					if ($scope.newProduct.addons[e].childId == $scope.products[i].id) {

						addon.isAddon = true;
						break;

					} else {

						addon.isAddon = false;
					}

				}

			} else {

				addon.isAddon = false;

			}

			$scope.newProduct.addonSelection.push(addon);

		}

	}

	//Orders
	$scope.getOrders = function() {

		Order.all().success(function(response) {

			$scope.orders = response.data;
			console.log($scope.orders);

		}).error(function(response) {

			console.log(response.message);

		});

	}

	$scope.init();

}]);



