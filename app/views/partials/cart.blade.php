<div class="cart-blinder slide" ng-controller="CartBlinderController" ng-show="show" ng-click="hide()" ng-cloak>

	<p>Return To Store</p>

</div>

<div class="cart slide" ng-controller="CartController" ng-show="show" ng-cloak>

	<h2 ng-hide="items.length">Cart</h2>
	<span class="cart-exit" ng-click="hide()">Close<i class="fa fa-close"></i></span>

	<p class="cart-empty-message" ng-hide="items.length">Your cart is empty. Put something in it!</p>

	<div class="cart-stage-1" ng-show="currentStage === 'cart' && items.length">

		<h2>Cart</h2>

		<ul>	
			<li ng-repeat="item in items" class="cart-item" ng-class="{ 'apparel-cart-item' : item.type.slug === 'apparel' }">

				<div class="cart-item-column">

					<h3>@{{ item.name }}</h3>

					<div class="cart-item-image-container" ng-class="{ 'apparel-cart-item-image-container' : item.type.slug === 'apparel' }">

						<img ng-src="@{{ item.thumb }}">

					</div>

				</div>
				
				<div class="cart-price-column">
					<p>$@{{ item.price | money }}</p>
				</div>

				<div class="clear"></div>

				<span class="cart-item-addon-title" ng-if="item.addons.length">Addons</span>

				<div class="cart-item-addon-container" ng-repeat="addon in item.addons" ng-if="item.addons.length">

					<div class="cart-item-column">

						<h3>- @{{ addon.name }}</h3>

					</div>

					<div class="cart-price-column">

						<p>$@{{ addon.price | money }}</p>

					</div>

					<div class="clear"></div>

				</div>

			</li>

		</ul>	

		<div class="cart-details">

			<div class="cart-details-row">
				<span class="cart-item-column">Shipping</span>
				<span class="cart-price-column shipping-column" ng-bind="'$' + (shipping() | money)"></span>

				<div class="clear"></div>

			</div>

			<div class="cart-details-row">
				<span class="cart-item-column"><h3>Total</h3></span>
				<span class="cart-price-column" ng-bind="'$' + (total() | money)"></span>

				<div class="clear"></div>

			</div>

		</div>

		<div class="cart-actions">

			<div class="button success-bg" ng-click="toStage(1)">Checkout</div>
			<div class="button info-bg" ng-click="emptyCart()">Empty Cart</div>

		</div>

	</div>


	<div class="cart-stage-2" ng-show="currentStage === 'checkout' && items.length">

		<h2>Checkout</h2> <span class="cart-status-message">@{{ status }}</span>

		<div class="checkout-form">

			<label for="first-name">First Name</label>
			<input type="text" name="first-name" id="first-name" ng-model="form.firstName">

			<label for="last-name">Last Name</label>
			<input type="text" name="last-name" id="last-name" ng-model="form.lastName">

			<label for="email">Email Address</label>
			<input type="text" name="email" id="email" ng-model="form.email">

			<label for="phone">Phone</label>
			<input type="text" name="phone" id="phone" ng-model="form.phone">

			<label for="address">Billing Address</label>
			<input type="text" name="address" id="address" ng-model="form.address">

			<label for="city">City</label>
			<input type="text" name="city" id="city" ng-model="form.city">

			<label for="state">State / Province</label>
			<input type="text" name="state" id="state" ng-model="form.state">

			<label for="zip">Zip Code</label>
			<input type="text" name="zip" id="zip" ng-model="form.zip">

			<label for="country">Country</label>
			<input type="text" name="country" id="country" ng-model="form.country">

			<label for="use-billing-for-shipping">Ship to above address?</label>
			<input type="checkbox" name="use-billing-for-shipping" id="use-billing-for-shipping" ng-model="form.useBillingForShipping" checked>

			<div ng-hide="form.useBillingForShipping">

				<label for="shipping-address">Shipping Address</label>
				<input type="text" name="shipping-address" id="shipping-address" ng-model="form.shippingAddress">

				<label for="shipping-city">Shipping City</label>
				<input type="text" name="shipping-city" id="shipping-city" ng-model="form.shippingCity">

				<label for="shipping-state">Shipping State / Province</label>
				<input type="text" name="shipping-state" id="shipping-state" ng-model="form.shippingState">

				<label for="shipping-zip">Shipping Zip Code</label>
				<input type="text" name="shipping-zip" id="shipping-zip" ng-model="form.shippingZip">

				<label for="shipping-country">Shipping Country</label>
				<input type="text" name="shipping-country" id="shipping-country" ng-model="form.shippingCountry">

			</div>


		</div>

		<div class="cart-actions">

			<div class="button success-bg" ng-click="toStage(2)">To Payment</div>
			<div class="button info-bg" ng-click="toStage(0)">Go Back</div>

		</div>

	</div>

	<div class="cart-stage-3" ng-show="currentStage === 'payment' && items.length">

		<h2>Payment</h2>@{{ status }}

		<div class="checkout-form">

			<label for="card-number">Card Number</label>
			<input type="text" name="card-number" id="card-number" ng-model="card.number" placeholder="xxxxxxxxxxxxxxxx">

			<span class="left">
				<label for="card-expiry-month">Expires</label>
				<input type="text" class="native" name="card-expiry-month" size="3" id="expire-month" ng-model="card.expiryMonth" placeholder="MM">
				<input type="text" class="native" name="card-expiry-year" size="5" id="expire-year" ng-model="card.expiryYear" placeholder="YYYY">
			</span>
			
			<span class="left" style="margin-left:15px">
				<label for="card-security-code">CVC</label>
				<input type="text" class="native" size="5" name="card-security-code" id="card-secutiry-code" ng-model="card.securityCode" placeholder="000">
			</span>
			
			<div class="clear"></div>

		</div>


		<div class="cart-actions">

			<div class="button success-bg" ng-click="toStage(3)">To Confirmation</div>
			<div class="button info-bg" ng-click="toStage(1)">Go Back</div>

		</div>

	</div>

	<div class="cart-stage-4" ng-show="currentStage === 'confirmation' && items.length">

		<h2>Confirmation</h2>

		<ul>	
			<li ng-repeat="item in items" class="cart-item">

				<div class="cart-item-column">

					<h3>@{{ item.name }}</h3>

					<div class="cart-item-image-container">

						<img ng-src="@{{ item.thumb }}">

					</div>

				</div>
				
				<div class="cart-price-column">
					<p>$@{{ item.price | money }}</p>
				</div>

				<div class="clear"></div>

				<span class="cart-item-addon-title" ng-if="item.addons.length">Addons</span>

				<div class="cart-item-addon-container" ng-repeat="addon in item.addons" ng-if="item.addons.length">

					<div class="cart-item-column">

						<h3>- @{{ addon.name }}</h3>

					</div>

					<div class="cart-price-column">

						<p>$@{{ addon.price | money }}</p>

					</div>

					<div class="clear"></div>

				</div>

			</li>
		</ul>	

		<div class="cart-details">

			<div class="cart-details-row">
				<span class="cart-item-column">Shipping</span>
				<span class="cart-price-column shipping-column">$20</span>

				<div class="clear"></div>

			</div>

			<div class="cart-details-row">
				<span class="cart-item-column"><h3>Total</h3></span>
				<span class="cart-price-column" ng-bind="'$' + (total() | money)"></span>

				<div class="clear"></div>

			</div>

			<div class="cart-details-row">

				<h3 class="bold">Ship To :</h3>
				<div ng-if="form.useBillingForShipping">
					
					<p>@{{ form.name }}</p>
					<p>@{{ form.address }}</p>
					<p>@{{ form.city }}, @{{ form.state }}</p>
					<p>@{{ form.country }}</p>

				</div>

				<div ng-if="!form.useBillingForShipping">

					<p>@{{ form.name }}</p>
					<p>@{{ form.shippingAddress }}</p>
					<p>@{{ form.shippingCity }}, @{{ form.shippingState }}</p>
					<p>@{{ form.shippingCountry }}</p>

				</div>


			</div>	

		</div>

		<p>By Clicking finish, your card will be charged.</p>

		<div class="cart-actions">

			<div class="button success-bg" ng-click="submit()">Finish</div>
			<div class="button info-bg" ng-click="toStage(2)">Go Back</div>

		</div>

	</div>
	

</div>

