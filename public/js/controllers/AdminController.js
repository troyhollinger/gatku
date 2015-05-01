app.controller('AdminController', ['$scope', 'Image', 'Product', 'Order', 'YouImage', function($scope, Image, Product, Order, YouImage) {

	$scope.init = function() {

		// $scope.showProducts = true;
		$scope.show('you');
		getOrders();
		getProducts();
		getTypes();
		getYouImages();

	}

	$scope.orders = [];

	$scope.types = [];

	$scope.products = [];

	$scope.newProduct = {};

	$scope.youImages = [];
	
	$scope.newYouImage = {};

	$scope.editState = false;

	$scope.editingNew = true;

	$scope.show = function(section) {

		$scope.showOrders = false;
		$scope.showProducts = false;
		$scope.showYou = false;
		$scope.showVideos = false;
		$scope.reset();

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

	function getProducts() {

		Product.all().success(function(response) {

			$scope.products = response.data;
			
		}).error(function(response) {

			console.log("Sorry, there was an error retrieving the products");

		});

	}

	$scope.saveProduct = function() {

		var nanobar = new Nanobar({ bg : '#fff' });

		nanobar.go(60);

		Product.store($scope.newProduct).success(function(response) {

			getProducts();
			$scope.reset();
			nanobar.go(100);

		}).error(function(response) {

			nanobar.go(100);
			console.log("Sorry, something went wrong");

		});

	}

	$scope.createProduct = function() {

		$scope.newProduct = {};
		$scope.editState = true;
		$scope.editingNew = true;

		registerAddons();

	}


	$scope.editProduct = function(product) {

		$scope.newProduct = product;
		$scope.editState = true;
		$scope.editingNew = false;

		registerAddons();

	}

	$scope.updateProduct = function() {

		var nanobar = new Nanobar({ bg : '#fff' });
		var data = $scope.newProduct;

		nanobar.go(65);

		Product.update(data.id, data).success(function(response) {

			getProducts();
			$scope.reset();
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

	
	$scope.reset = function() {

		$scope.newProduct = {};
		$scope.newYouImage = {};
		$scope.editState = false;
		$scope.editingNew = true;

	}

	function getTypes() {

		Product.getTypes().success(function(response) {

			$scope.types = response.data;

			// console.log(response.data);

		}).error(function(response) {

			console.log("Sorry, types could not be retrieved");

		});

	}



	function registerAddons() {

		$scope.newProduct.addonSelection = [];

		for(var i = 0; i < $scope.products.length; i++) {

			var addon = {};

			addon.id = $scope.products[i].id;
			addon.name = $scope.products[i].name;

			// If creating a new product, it has no addons obviously...
			if (!$scope.editingNew) {

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

			} else {

				addon.isAddon = false;

			}
			
			$scope.newProduct.addonSelection.push(addon);

		}

	}

	//Orders
	function getOrders() {

		Order.all().success(function(response) {

			$scope.orders = response.data;

		}).error(function(response) {

			console.log(response.message);

		});

	}


	// You

	$scope.youImages = [];
	$scope.newYouImage = {};

	function getYouImages() {

		YouImage.all().success(function(response) {

			$scope.youImages = response.data;

			Squares.init();

			// console.log($scope.youImages);

		}).error(function(response) {

			console.log("There was an error getting the You images");

		});

	}

	$scope.uploadYouImage = function($files) {

		

		var file = $files[0];

		if (!file) return false;

		var data = {

			url : '/you-image/upload',
			file : file

		}

		// console.log("still uploading image");

		$scope.editState = true;
		// $scope.editNew = true;

		Image.upload(data).success(function(response) {

			$scope.newYouImage.image = response.data;

		}).error(function(response) {

			console.log(response.message);

		});


	}

	$scope.saveYouImage = function() {

		var nanobar = new Nanobar({ bg : '#fff' });
		nanobar.go(40);

		YouImage.save($scope.newYouImage).success(function() {

			getYouImages();
			$scope.reset();

			nanobar.go(100);

		}).error(function(response) {

			console.log(response.message);

		});

	}

	$scope.clearNewYouImage = function() {


		$scope.newYouImage = false;

	}

	$scope.init();

}]);



