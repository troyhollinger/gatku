app.filter('money', function () { 

	return function (amount) { 

		return (amount / 100); 
	}

});


// app.directive('addonSelector', function() {

// 	return {

// 		link : function (scope, element, attrs) {

// 			scope.$watch(attrs.currentProduct, function(value) {



// 			});

// 		},

// 		template : '<div class="new-product-checkbox-container" ng-repeat="product in products">
// 						<input type="checkbox" value="{{ product.id }}" ng-checked="checkAddonsForMatch(product.id)">&nbsp;<span class="uppercase">@{{ product.name }}</span>
// 					</div>',


// 	}

	

// });