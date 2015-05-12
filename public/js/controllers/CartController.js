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
app.controller('CartController', ['$scope', 'CartService', 'StripeService', 'Order', function($scope, CartService, StripeService, Order) {

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

	$scope.total = function() {

		var total = 0;

		angular.forEach($scope.items, function(value, key) {

			total += $scope.items[key].price;

			for(var i = 0; i < $scope.items[key].addons.length; i++) {

				total += $scope.items[key].addons[i].price;

			}

		});

		// TODO calculate Shipping

		return total + 2000;

	}

	$scope.submit = function() {

		var card = extractCardDetails();

		StripeService.createToken(card).then(function(token) {

			var data = {

				items : $scope.items,
				form : $scope.form,
				token : token

			}
 
			Order.store(data).success(function(response) {

				console.log("Order was a success!");

				$scope.show = false;

				$scope.emptyCart();

				window.location.replace("/thankyou");

			}).error(function(response) {

				console.log("There was an error");

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
				return false;

			}

			if (!$scope.form.lastName) {

				$scope.status = 'Please enter a last name.';
				return false;

			}

			if (!$scope.form.email) {

				$scope.status = 'Please enter an email address.';
				return false;

			}

			if (!$scope.form.phone) {

				$scope.status = 'Please enter phone number.';
				return false;

			}

			if (!$scope.form.address) {

				$scope.status = 'Please enter phone number.';
				return false;

			}

			if (!$scope.form.city) {

				$scope.status = 'Please enter a city';
				return false;

			}

			if (!$scope.form.state) {

				$scope.status = 'Please enter a state';
				return false

			}

			if (!$scope.form.country) {

				$scope.status = 'Please enter a country';
				return false;

			}

			if (!$scope.form.useBillingForShipping) {


				if (!$scope.form.shippingAddress) {

					$scope.status = 'Please enter a shipping address';
					return false;

				}

				if (!$scope.form.shippingCity) {

					$scope.status = 'Please enter a shipping city';
					return false;

				}

				if (!$scope.form.shippingState) {

					$scope.status = 'Please enter a shippingState';
					return false;

				}

				if (!$scope.form.shippingZip) {

					$scope.status = 'Please enter a shipping zip code';
					return false;

				}

				if (!$scope.form.shippingCountry) {

					$scope.status = 'Please enter a shipping country';
					return false;

				}


			}

			return true;

		}

		if (index == 3) {

			var card = extractCardDetails();

			var validation = StripeService.validate(card)

			if (validation.response === false) {

				$scope.status = validation.message;

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




