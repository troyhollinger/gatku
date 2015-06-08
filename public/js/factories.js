app.factory('Image', ['$http', '$upload', function($http, $upload) {

	return {

		upload : function(data) {

			return $upload.upload(data);

		}

	}

}]);


app.factory('Product', ['$http', function($http) {

	return {

		all : function() {

			return $http.get('/product');

		},

		get : function(productId) {

			return $http.get('/product/get/' + productId)

		},
 	
 		getBySlug : function(slug) {

 			return $http.get('/product/by/slug/' + slug);

 		},

		store : function(data) {

			return $http.post('/product', data);

		},

		update : function(id, data) {

			return $http.put('/product/' + id, data);

		},

		getTypes : function() {

			return $http.get('/product/types');

		},

		getByType : function() {

			return $http.get('/product/by/type');

		},

		customerPhotos : function(productId) {

			return $http.get('/product/photos/' + productId);

		}

	}

}]);


app.factory('Order', ['$http', function($http) {


	return {

		all : function() {

			return $http.get('/order');

		},

		store : function(data) {

			return $http.post('/order', data);

		}

	}

}]);

app.factory('YouImage', ['$http', function($http) {

	return {

		all : function() {

			return $http.get('/you-image');

		},

		save : function(data) {

			return $http.post('/you-image', data);

		}

	}

}]);



app.factory('Size', ['$http', function($http) {

	return {

		getBySlug : function(slug) {

			return $http.get('/size/by/slug/' + slug);

		}

	}

}]);


