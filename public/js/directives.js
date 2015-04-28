app.filter('money', function () { 

	return function (amount) { 

		return (amount / 100); 
	}

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
			'<div class="hover-card-image-container"><img ng-src="{{ product.thumb }}"></div>' +
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

				body.append(hoverCard);

				$scope.positionCard();

				$scope.fetchProduct();

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
				console.log(cardHeight);
				var top = offsetTop - (cardHeight / 2);
				var left = offsetLeft + width;

				hoverCard.css({ top : top + 'px', left : left + 'px'});

			}

			$scope.getRootOffsetTop = function getRootOffsetTop (elem, val){

				if (elem.offsetParent === null){

					return val + elem.offsetTop;

				}

				return $scope.getRootOffsetTop(elem.offsetParent, val + elem.offsetTop);

			};

			$scope.getRootOffsetLeft = function getRootOffsetLeft (elem, val){

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