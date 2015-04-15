app.factory('Image', ['$http', '$upload', function($http, $upload) {

	return {

		upload : function(data) {

			return $upload.upload(data);

		}

	}

}]);


app.factory('Product', ['$http', function($http) {

	return  {

		all : function() {

			return $http.get('/product');

		},

		get : function(productId) {

			return $http.get('/product/get/' + productId)

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

		}



	}

}]);


app.factory('Order', ['$http', function($http) {


	return {

		store : function(data) {

			return $http.post('/order', data);

		}

	}

}]);