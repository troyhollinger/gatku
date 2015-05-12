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
			{{-- <li><a href="#videos">Videos</a></li> --}}
			{{-- <li><a href="#you">You</a></li> --}}
			<li>Contact</li>
			<li ng-controller="CartCountController" ng-click="showCart()">Cart <div class="cart-amount-indicator" ng-show="count > 0"><span>@{{ count }}</span></div> </li>
		</ul>

		<div class="clear"></div>

	</div>

</div>

<hamburger></hamburger>

<div class="mobile-mast">
	
	{{-- <i class="fa fa-shopping-cart cart-icon"></i> --}}
	<cart-icon></cart-icon>

	<div class="clear"></div>

</div>

<div class="mobile-navigation" ng-controller="MobileNavigationController" ng-class="{ 'open' : open }">

	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="#store">Store</a>
			{{-- <ul>
				<li><a href="#store">Heads</a>
					<ul>
						<li ng-repeat="head in heads"><a ng-href="/product/@{{ head.slug }}">@{{ head.name }}</a></li>
					</ul>
				</li>
				<li><a href="#store">Poles</a>
					<ul>
						<li ng-repeat="pole in poles"><a ng-href="/product/@{{ pole.slug }}">@{{ pole.name }}</a></li>
					</ul>
				</li>
				<li><a href="#store">Extras</a>
					<ul>
						<li ng-repeat="shrinkerItem in shrinker"><a ng-href="/product/@{{ shrinkerItem.slug }}">@{{ shrinkerItem.name }}</a></li>
						<li ng-repeat="extra in extras"><a ng-href="/product/@{{ extra.slug }}">@{{ extra.name }}</a></li>
					</ul>
				</li>
				<li><a href="#store">Apparel</a>
					<ul>
						<li ng-repeat="apparelItem in apparel"><a ng-href="/product/@{{ apparelItem.slug }}">@{{ apparelItem.name }}</a></li>				
					</ul>
				</li>
			</ul> --}}
		</li>
		<li><a href="#contact">Contact</a></li>
	</ul>

</div>








