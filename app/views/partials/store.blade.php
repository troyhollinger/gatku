<div class="store-container" ng-controller="StoreController">

	<div class="heads-row product-row">

		<div class="product-thumb-container" ng-repeat="head in heads"><a href="{{ route('product.show', ['']) }}/@{{ head.slug }}"><img ng-src="@{{ head.thumb }}"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="heads-links links">
		<div class="product-link-container" ng-repeat="head in heads"><a href="{{ route('product.show', ['']) }}/@{{ head.slug }}">@{{ head.name }}{{-- <span class="detail">/Paralyzer</span> --}}</a></div>

		<div class="clear"></div>
	</div>

	<h2 class="store-label">Detachable Heads</h2>

	<div class="tails-row product-row">

		<div class="product-thumb-container" ng-repeat="pole in poles"><a href="{{ route('product.show', ['']) }}/@{{ pole.slug }}"><img ng-src="@{{ pole.thumb }}"></a></div>
		

		<div class="clear"></div>

	</div>

	<div class="tails-links links">

		<div class="product-link-container" ng-repeat="pole in poles"><a href="{{ route('product.show', ['']) }}/@{{ pole.slug }}">@{{ pole.shortName }}<span class="unbold">'ER</span> {{-- <span class="detail">/152<span class="uncaps">cm</span></span> --}}</a></div>

		<div class="clear"></div>

	</div>

	<h2 class="store-label">Gen 2 Hybrid Polespears</h2>

	<div class="extras-row product-row">

		<div class="product-thumb-container" ng-repeat="shrinkerItem in shrinker"><a href="{{ route('product.show', ['']) }}/@{{ shrinkerItem.slug }}"><img ng-src="@{{ shrinkerItem.thumb }}"></a></div>

		<div class="product-thumb-container" ng-repeat="extra in extras"><a href="{{ route('product.show', ['']) }}/@{{ extra.slug }}"><img ng-src="@{{ extra.thumb }}" ng-class="{ 'knife-thumb' : extra.slug == 'budk' }"></a></div>
		

		<div class="clear"></div>

	</div>

	<div class="extras-links links">

		<div class="product-link-container" ng-repeat="shrinkerItem in shrinker"><a href="{{ route('product.show', ['']) }}/@{{ shrinkerItem.slug }}">@{{ shrinkerItem.name }}</a></div>

		<div class="product-link-container" ng-repeat="extra in extras"><a href="{{ route('product.show', ['']) }}/@{{ extra.slug }}">@{{ extra.name }}</a></div>
		
		<div class="clear"></div>

	</div>

	<h2 class="store-label">Accessories</h2>

	{{-- <div class="apparel-row product-row">

		<div class="product-thumb-container"><img src="{{ asset('img/thumbs/shirt1-thumb.jpg') }}"></div>
		<div class="product-thumb-container"><img src="{{ asset('img/thumbs/shirt2-thumb.jpg') }}"></div>
		<div class="product-thumb-container"><img src="{{ asset('img/thumbs/jacket1-thumb.jpg') }}"></div>

		<div class="clear"></div>

	</div>

	<div class="apparel-links links">

		<div class="product-link-container"><a href="">9'ER</a></div>
		<div class="product-link-container"><a href="">Superhero</a></div>
		<div class="product-link-container"><a href="">Comfort Hoody</a></div>

		<div class="clear"></div>

	</div>

	<h2 class="store-label">Apparel</h2> --}}

</div>
