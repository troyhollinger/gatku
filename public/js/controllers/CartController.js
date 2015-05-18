/*
|--------------------------------------------------------------------------
| Cart Controller
|--------------------------------------------------------------------------
|
| All of the form fields are defined in the view cart.blade.php. This 
| controller simply passes the data on to the backend. 
| NOTE: if a field is added or subtracted, you will have to update the  
| $scope.validate method to reflect the changes.
|
*/
app.controller('CartController', ['$scope', 'CartService', 'StripeService', 'Order', 'AlertService', function($scope, CartService, StripeService, Order, AlertService) {

	$scope.items = [];

	$scope.show = false;

	$scope.form = {};

	$scope.form.useBillingForShipping = true;

	$scope.status = '';

	$scope.stages = ['cart', 'checkout', 'payment', 'confirmation'];

	$scope.currentStage = $scope.stages[0];

	$scope.toStage = function(index) {

		if ($scope.validate(index) === false) return false;

		$scope.currentStage = $scope.stages[index];

	}

	$scope.getItems = function() {

		var items = CartService.getItems();

		$scope.items = items;

	}

	$scope.removeItem = function(index) {

		CartService.removeItem(index);

	}

	$scope.increaseItemQuantity = function(itemIndex) {

		CartService.increaseItemQuantity(itemIndex);

	}

	$scope.decreaseItemQuantity = function(itemIndex) {

		CartService.decreaseItemQuantity(itemIndex);

	}

	$scope.increaseAddonQuantity = function(itemIndex, addonIndex) {

		CartService.increaseAddonQuantity(itemIndex, addonIndex);

	}

	$scope.decreaseAddonQuantity = function(itemIndex, addonIndex) {

		CartService.decreaseAddonQuantity(itemIndex, addonIndex);

	}

	$scope.shipping = function() {

		var shipping = 0;
		var poles = [];
		var heads = [];
		var others = [];

		for(var i = 0; i < $scope.items.length; i++) {

			var item = $scope.items[i];

			if (item.type.slug === 'pole') {

				poles.push(item);

			} else if (item.type.slug === 'head') {

				heads.push(item);

			} else {

				others.push(item);

			}

		};

		if (poles.length > 0) {

			var poleShippingPrice = poles[0].type.shippingPrice;

			if (poles.length > 1) {

				shipping = poleShippingPrice * poles.length;

			} else {

				shipping = poleShippingPrice;

			}

		} else if (heads.length > 0) {

			var headShippingPrice = heads[0].type.shippingPrice;

			if (heads.length > 1) {

				shipping = headShippingPrice * (Math.ceil(heads.length / 2));

			} else {

				shipping = headShippingPrice;

			}

		} else if (others.length > 0) {

			shipping = others[0].type.shippingPrice;

		}

		return shipping;

	}

	$scope.total = function() {

		var total = 0;
		var shipping = 0;

		angular.forEach($scope.items, function(value, key) {

			total += $scope.items[key].price * $scope.items[key].quantity;

			for(var i = 0; i < $scope.items[key].addons.length; i++) {

				total += $scope.items[key].addons[i].price * $scope.items[key].addons[i].quantity;

			}

		});

		shipping = $scope.shipping();

		return total + shipping;

	}

	$scope.submit = function() {

		var card = extractCardDetails();

		AlertService.broadcast('Processing...', 'info');

		StripeService.createToken(card).then(function(token) {

			var data = {

				items : $scope.items,
				form : $scope.form,
				token : token

			}
 
			Order.store(data).success(function(response) {

				AlertService.broadcast('Success! Redirecting...', 'success');

				$scope.show = false;

				$scope.emptyCart();

				window.location.replace("/thankyou");

			}).error(function(response) {

				AlertService.broadcast('Sorry, there was an error creating your order. Please try again later', 'error');

			});

		});

	}

	$scope.hide = function() {

		CartService.hide();

	}

	$scope.emptyCart = function() {

		CartService.empty();

		$scope.getItems();

	}

	$scope.validate = function(index) {

		$scope.status = '';

		if (index == 1) {

			return true;

		}

		if (index == 2) {

			if (!$scope.form.firstName) {

				$scope.status = 'Please enter a first name.';
				AlertService.broadcast('Please enter a first name', 'error');

				return false;

			}

			if (!$scope.form.lastName) {

				$scope.status = 'Please enter a last name.';
				AlertService.broadcast('Please enter a last name', 'error');
				return false;

			}

			if (!$scope.form.email) {

				$scope.status = 'Please enter an email address.';
				AlertService.broadcast('Please enter an email address', 'error');
				return false;

			}

			if (!$scope.form.phone) {

				$scope.status = 'Please enter phone number.';
				AlertService.broadcast('Please enter a phone number', 'error');
				return false;

			}

			if (!$scope.form.address) {

				$scope.status = 'Please enter a street address.';
				AlertService.broadcast('Please enter a street address', 'error');
				return false;

			}

			if (!$scope.form.city) {

				$scope.status = 'Please enter a city';
				AlertService.broadcast('Please enter a city', 'error');
				return false;

			}

			if (!$scope.form.state) {

				$scope.status = 'Please enter a state';
				AlertService.broadcast('Please enter a state', 'error');
				return false

			}

			if (!$scope.form.country) {

				$scope.status = 'Please enter a country';
				AlertService.broadcast('Please enter a country', 'error');
				return false;

			}

			return true;

		}

		if (index == 3) {

			var card = extractCardDetails();

			var validation = StripeService.validate(card)

			if (validation.response === false) {

				$scope.status = validation.message;
				AlertService.broadcast(validation.messsage, 'error');

				return false;

			} else if (validation.response) {

				$scope.status = '';

				return true;

			}

		}

	}

	function extractCardDetails() {

		var card = {};

		card.number = $scope.card.number;
		card.exp_month = $scope.card.expiryMonth;
		card.exp_year = $scope.card.expiryYear;
		card.cvc = $scope.card.securityCode;
		card.name = $scope.form.firstName + ' ' + $scope.form.lastName;

		return card;

	}

	$scope.$on('update', function() {

		$scope.getItems();

	});

	$scope.$on('show', function() {

		$scope.show = true;

	});

	$scope.$on('hide', function() {

		$scope.show = false;

	});

	$scope.getItems();

}]);




