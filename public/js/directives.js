app.filter('money', function () { 

	return function (amount) { 

		return (amount / 100); 
	}

});

app.directive('backImg', function(){
    return function(scope, element, attrs){
        attrs.$observe('backImg', function(value) {
            element.css({
                'background-image': 'url(' + value +')',
                'background-size' : 'cover'
            });
        });
    };
});


app.directive('hoverCard', ['$compile', '$window', 'Product', '$filter', function($compile, $window, Product, $filter) {

	return {

		restrict : 'E',

		scope : true,

		link : function($scope, element, attrs) {

			$scope.product = {};

			var moneyFilter = $filter('money');
			var thisElement = angular.element(element[0]);
			var template = '<div class="hover-card">' + 
			'<h2>{{ product.name }}</h2>' + 
			'<div class="hover-card-image-container" ng-class="{ \'pole\' : product.type.slug === \'pole\' }"><img ng-src="{{ product.thumb }}"></div>' +
			'<div class="hover-card-actions"><a ng-href="/product/'+ attrs.slug +'" target="_blank"><div class="button success-bg">See This Product</div></a></div>' +
			'<div class="hover-card-price">${{ product.price | money }}</div>' + 
			'<div class="clear"></div>' +
			'<div class="hover-card-carot shadowed"></div>'+
			'<div class="hover-card-carot"></div>'+
			'</div>';
			var body = angular.element($window.document.getElementsByTagName('body')[0]);
			var hoverCard = $compile(template)($scope);

			$scope.productFetched = false;

			$scope.init = function() {

				if ($window.innerWidth > 750) {

					body.append(hoverCard);

					$scope.positionCard();

					$scope.fetchProduct();

				}

			}

			$scope.fetchProduct = function() {

				Product.getBySlug(attrs.slug).success(function(response) {

					$scope.product = response.data;

					$scope.productFetched = true;

					$scope.positionCard();

				}).error(function(response) {

					console.log(response.message);

				});

			}

			$scope.positionCard = function() {

				var offsetTop = $scope.getRootOffsetTop(thisElement[0], 0);
				var offsetLeft = $scope.getRootOffsetLeft(thisElement[0], 0);
				var width = thisElement[0].offsetWidth;
				var cardHeight = hoverCard[0].offsetHeight;
				var top = offsetTop - (cardHeight / 2);
				var left = offsetLeft + width;

				hoverCard.css({ top : top + 'px', left : left + 'px'});

			}

			$scope.getRootOffsetTop = function(elem, val){

				if (elem.offsetParent === null){

					return val + elem.offsetTop;

				}

				return $scope.getRootOffsetTop(elem.offsetParent, val + elem.offsetTop);

			};

			$scope.getRootOffsetLeft = function(elem, val){

			if (elem.offsetParent === null) {

				return val + elem.offsetLeft;

			}

			return $scope.getRootOffsetLeft(elem.offsetParent, val + elem.offsetLeft);

			};

			thisElement.bind('mouseover', function show() {

				if (!$scope.productFetched) {

					$scope.fetchProduct();

				} 

				hoverCard.addClass('visible');

			});

			thisElement.bind('mouseleave', function hide() {

				hoverCard.removeClass('visible');

			});

			hoverCard.bind('mouseover', function show() {

				hoverCard.addClass('visible');

			});

			hoverCard.bind('mouseleave', function hide() {

				hoverCard.removeClass('visible');
				
			});

			angular.element($window).bind('resize', function onResize() {

				$scope.positionCard();

			});

			$scope.init();
			

		}

	}

}]);


app.directive('productBuyers', ['Product', function(Product) {

	return {

		restrict : 'E',

		scope : false,

		template : '<div>' +
			'<p class="product-buyers-header bold" ng-show="photos.length">Others who have bought this product:</p>' +
			'<div class="product-buyers-container">' +
			'<div class="product-buyer placeholder square" ng-hide="photos.length"></div>' + 
			'<div class="product-buyer square" ng-repeat="photo in photos | limitTo:3" ng-style="{\'background-image\':\'url(\' + photo.image + \')\'}"></div>' + 
			'<div class="clear"></div>' +
			'</div>' +
			'</div>',

		link : function($scope, element, attrs) {

			$scope.photos = [];

			function getImages() {

				Product.customerPhotos(attrs.productId).success(function(response) {

					$scope.photos = response.data;

					Squares.init();

				}).error(function(response) {

					console.log("There was a problem getting the product images");

				});

			}

			getImages();

		}

	}

}]);

app.directive('loaded', ['$parse', function ($parse) {

    return {

		restrict: 'A',

		link: function (scope, elem, attrs) {

			var fn = $parse(attrs.loaded);

			elem.on('load', function (event) {

				scope.$apply(function() {

					fn(scope, { $event: event });

				});

			});

		}

    };

}]);



app.directive('alerter', ['$window', '$timeout', 'AlertService', function($window, $timeout, AlertService) {

	return {

		restrict : 'E',

		template : '<div class="alert-container slide-up" ng-show="show">' +
		'<div ng-class="{\'success-alert\' : alertType === \'success\', \'info-alert\' : alertType === \'info\', \'error-alert\' : alertType === \'error\'}">' +
			'{{ message }}' +
		'</div>' +
        '<i class="fa fa-close" ng-click="show = false"></i>' +
        '</div>',

        scope : false,

		link : function($scope, element, attrs) {

			$scope.message = '';
			$scope.show = false;
			$scope.alertType = 'success';

			console.log("is this happening?");

			$scope.$on('successAlert', function() {

				$scope.alertType = 'success';	
				display();

			});

			$scope.$on('infoAlert', function() {

				$scope.alertType = 'info';
				display();

			});

			$scope.$on('errorAlert', function() {

				$scope.alertType = 'error';
				display();

			});

			function display() {

				$scope.message = AlertService.message;
				$scope.show = true;

				$timeout(function() {

					$scope.show = false;

				}, 4000)

			}

		}


	}

}]);

app.directive('hamburger', ['NavigationService', function(NavigationService) {

	return {

		restrict : 'E',

		template : '<div class="hamburger" ng-click="action()" ng-class="{ \'open\' : open }">' +
		'<div class="patty"></div>' +
		'<div class="patty"></div>' +
		'<div class="patty"></div>' +
		'<span class="status">{{ status }}</span>' +
		'</div>',

		link : function($scope, element, attrs) {

			$scope.open = false;

			$scope.status = 'Menu';

			$scope.action = function() {

				if ($scope.open) {

					NavigationService.close();

				} else {

					NavigationService.open();

				}

			}

			$scope.$on('open', function() {

				$scope.open = true;

				$scope.status = 'Back';

			});

			$scope.$on('close', function() {

				$scope.open = false;

				$scope.status = 'Menu';

			});

		}

	}

}]);

app.directive('cartIcon', ['CartService', function(CartService) {

	return {

		restrict : 'E',

		template : '<div class="cart-icon" ng-click="showCart()">' + 
		'<span class="mobile-cart-indicator" ng-class="{ \'attention\' : count > 0 }">{{ count }}</span>' +
		'<i class="fa fa-shopping-cart"></i>' + 
		'</div>',

		link : function($scope, element, attrs) {

			$scope.count = CartService.getItems().length; 

			$scope.$on('update', function() {

				$scope.count = CartService.getItems().length; 

			});

			$scope.showCart = function() {

				CartService.show();

			}

		}

	}

}]);



app.directive('bodyFreeze', ['CartService', function(CartService) {

	return {

		restrict : 'A',

		link : function($scope, element, attrs) {

			$scope.$on('show', function() {

				element.addClass('frozen');

			});

			$scope.$on('hide', function() {

				element.removeClass('frozen');

			});

		}

	}

}]);









