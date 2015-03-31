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

app.controller('AdminController', ['$scope', 'Image', 'Product', function($scope, Image, Product) {

	$scope.init = function() {

		$scope.showProducts = true;
		$scope.getTypes();
		$scope.getProducts();

	}

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
		console.log($scope.newProduct);

	}

	$scope.updateProduct = function() {

		var data = $scope.newProduct;

		Product.update(data.id, data).success(function(response) {

			$scope.getProducts();
			$scope.clearNewProduct();

		}).error(function(response) {

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

			console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);

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

			console.log(response.data);

		}).error(function(response) {

			console.log("Sorry, types could not be retrieved");

		});

	}

	$scope.init();

}]);







app.controller('ProductController', ['$scope', 'Product', function($scope, Product) {

	$scope.fullSize = true;

	$scope.product = {};

	$scope.init = function() {

		$scope.getProduct();

	}

	$scope.getProduct = function() {

		Product.get(productId).success(function(response) {

			$scope.product = response.data;

		}).error(function(response) {

			console.log(response.message);

		});

	}

	$scope.init();

}]);


app.controller('VideoController', ['$scope', '$sce', function($scope, $sce) {

	$scope.videos = [

		{
			link : '//www.youtube.com/embed/qRm0BheSR_Q',
			title : 'Spearfishing with GATKU Polespears',
			shortTitle : 'At the Bahamas',
			description : 'Video blog by Ted from Ted\'s Holdover about a hunting trip to the Bahama\'s using a GATKU Polespear.'
		},
		{
			link : '//www.youtube.com/embed/aspLQ0hPoo0',
			title : 'Break Away Setup',
			shortTitle : 'Break Away Setup',
			description : 'How to rig your own SLIP-TIP with break away system -'
		},
		{
			link : '//www.youtube.com/embed/xxbnO8oa72k',
			title : 'Carp Killers',
			shortTitle : 'Carp Killers',
			description : 'Michael Dong and Dustin McIntyre tour Lake Mead to exterminate the invasive carp. The local ecosystem thanks them. All fish were killed with GAT-KU hybrid polespears.'
		},
		{
			link : '//www.youtube.com/embed/CvRSkoTYq3s',
			title : 'GATKU Gen-2 Polespears go to Baja',
			shortTitle : 'GATKU Gone Baja',
			description : 'Ryan Gattoni takes GATKU hybrid polespears south of the border in this short video.'
		},
		{
			link : '//www.youtube.com/embed/8-eQhtrsdu8',
			title : 'Nautilus Review',
			shortTitle : 'Nautilus Review',
			description : 'Video review of the GATKU Gen 2 Hybrid Polespear by Nautilus Spearfishing.'
		},
		{
			link : '//www.youtube.com/embed/F3FEIE7rFsw',
			title : 'Spearfishing in the Exumas',
			shortTitle : 'In the Exumas',
			description : 'Hunting Tiger Groupers and a close encounter with a shark. Video by Eric Poeltl. GATKU Polespear + Slip-Tip head used.'
		}
	];

	$scope.activeVideo = {};

	$scope.init = function() {

		$scope.setActiveVideo(0);
		ResponsiveVideo.init();	

	}

	$scope.setActiveVideo = function(index) {

		var embedToBeTrusted = String($scope.videos[index].link);

		$scope.activeVideo = $scope.videos[index];
		$scope.activeVideo.link = $sce.trustAsResourceUrl(embedToBeTrusted);

	}

	$scope.init();

}]);