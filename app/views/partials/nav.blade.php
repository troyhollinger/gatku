@if (Route::currentRouteName() === 'home')
<div class="mast">
@else
<div class="mast below-fold">
@endif

	<div class="container navigation-container">

		<a href="{{ route('home') }}"><img id="logo-above" src="{{ asset('img/logo-white.png') }}"></a>

		<a href="{{ route('home') }}"><img id="logo-below" src="{{ asset('img/logo-white-bg.png') }}"></a>

		<ul class="navigation">
			<li><a href="#store">Store</a></li>
			<li><a href="#contact">Contact</a></li>
			<li ng-controller="CartCountController" ng-click="showCart()" ng-cloak>Cart <div class="cart-amount-indicator" ng-show="count > 0"><span>@{{ count }}</span></div> </li>
		</ul>

		<div class="clear"></div>

	</div>

</div>

<hamburger></hamburger>

<div class="mobile-mast">
	
	<cart-icon></cart-icon>

	<div class="clear"></div>

</div>

<div class="mobile-navigation" ng-controller="MobileNavigationController" ng-class="{ 'open' : open }">

	<ul>
		<li><a href="{{ route('home') }}" @if(Route::currentRouteName() === 'home') class="faded" @endif>Home</a></li>
		<li><smooth-link text="Store" destination="store"></smooth-link></li>
		<li><smooth-link text="Contact" destination="contact"></smooth-link></li>
		<li><a href="{{ route('quote') }}">Int'l Shipping?</a></li>
	</ul>

</div>








