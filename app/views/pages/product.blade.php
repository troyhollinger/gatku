@extends('layouts.master')

@section('title')
{{ strtoupper($product->name) }} | GATKU Polespears
@stop

@section('description')
{{ $product->metaDescription }}
@stop


@section('content')

@if($product->type->slug != 'apparel' && $product->type->slug != 'glass')
<div class="scroller {{ $product->slug === 'budk' ? 'knife-scroller no-attached-state' : '' }} {{ $product->slug === 'bands' ? 'band-scroller' : '' }} {{ $product->slug === 'g-string' ? 'g-string-scroller' : '' }}">

	@if($product->attachedImage || $product->detachedImage)

	@if($product->attachedImage)
	<img class="scroller-image {{ $product->slug === 'budk' ? 'no-attached-state' : '' }}" ng-if="attached" src="{{ $product->attachedImage }}" ng-class="{'fit' : fullSize === false, 'visible' : attached }" ng-cloak loaded="poleScrollInit()">
	@endif
	<img class="scroller-image {{ $product->slug === 'inshore-shrinker' ? 'shrinker' : '' }} " ng-if="!attached" src="{{ $product->detachedImage }}" ng-class="{'fit' : fullSize === false, 'visible' : attached === false }" ng-cloak loaded="poleScrollInit()">
	@endif

</div>
@endif

@if($product->attachedImage && $product->detachedImage)
<div class="arrows">
	<div class="left-arrow"></div>
	<div class="right-arrow"></div>

	<div class="clear"></div>
</div>
@endif

<div class="container {{ $product->type->slug === 'apparel' ? 'apparel-height' : ''}} {{ $product->type->slug === 'glass' ? 'glass-height' : '' }}">

	@if($product->type->slug === 'apparel')
	<div class="apparel-container">
		<img class="rollerblade-img" src="{{ $product->attachedImage}}">

		<span class="drag-indicator"><-- Drag to rotate --></span>
	</div>
	@endif

	@if($product->type->slug === 'glass')
	<div class="apparel-container">
		<img class="rollerblade-img" src="{{ $product->attachedImage }}">
	</div>
	@endif

	<div class="product-column-left {{ $product->type->slug === 'apparel' || $product->type->slug === 'glass' ? 'apparel-column' : ''}}">

		<h1 class="product-title {{ $product->slug === 'inshore-shrinker' ? 'shrinker-title' : '' }}"><span class="bold {{ $product->type->slug === 'pole' ? 'uppercase' : '' }}">{{ $product->type->slug === 'apparel' ? $product->name : $product->shortName }}</span>{{ $product->type->slug === 'pole' ? "'ER" : '' }} @if($product->length) <span class="detail"><span class="detail">/{{ $product->length }}</span></span> @endif</h1>

		<div class="product-description {{ $product->type->slug === 'apparel' ? 'apparel-description' : '' }} {{ $product->type->slug === 'glass' ? 'glass-description' : '' }}">

			{{ $product->description }}
			
		</div>

		@if($product->type->slug === 'pole')

		<div class="product-performance">

			<img class="product-performance-icon" src="{{ asset('img/movement.jpg') }}">
			<h3 class="product-performance-title bold">Maneuverability</h3>
			<p class="product-performance-description">{{ $product->maneuverability }}</p>

			<img class="product-performance-icon" src="{{ asset('img/crosshairs.jpg') }}">
			<h3 class="product-performance-title bold">Trajectory</h3>
			<p class="product-performance-description">{{ $product->trajectory }}</p>

			<img class="product-performance-icon" src="{{ asset('img/balance.jpg') }}">
			<h3 class="product-performance-title bold">Balance</h3>
			<p class="product-performance-description">{{ $product->balance }}</p>

			<img class="product-performance-icon" src="{{ asset('img/diver-shadow.jpg') }}">
			<h3 class="product-performance-title bold">Stealth</h3>
			<p class="product-performance-description">{{ $product->stealth }}</p>

		</div>

		@endif

		<product-buyers product-id="{{ $product->id }}"></product-buyers>

	</div>

	<div class="product-column-right {{ $product->type->slug === 'apparel' || $product->type->slug === 'glass' ? 'apparel-column' : ''}}">
		<!-- Increase the width of this element to increase margin between children -->
		@if($product->attachedImage && $product->detachedImage)
		<div class="pole-view-actions">

			<p class="attachment-button faded" ng-click="attached = !attached; scrollAcross();">
				<span ng-show="attached">@if($product->slug === 'g-string') OFF POLE @else TAKE POLE APART @endif</span>
				<span ng-show="attached === false">@if($product->slug === 'g-string') ON POLE @else PUT POLE TOGETHER @endif</span>
			</p>


			<div class="zoom-out-button zoom-button" ng-class="{'selected' : fullSize === false}" ng-click="fullSize = false; poleScrollInit()"></div>
			<div class="zoom-in-button zoom-button" ng-class="{'selected' : fullSize === true}" ng-click="fullSize = true; goFullSize();"></div>

		</div>
		<div class="clear"></div>
		@endif

		
		<p class="product-price" ng-cloak>
			@if(!$product->sizeable)
			<span class="product-price-amount" ng-cloak>${{ $product->price / 100 }}</span> / 
			@endif
			@if($product->type->slug === 'pole')
			+ <span style="font-size:18px;">$20 Shipping w/in USA <span class="brand">+ <a href="{{ route('australia') }}" class="bold">AU</a></span></span> <br><span class="bold">Int’l</span> Rates Vary <a href="{{ route('quote') }}" target="_blank"><span class="bold">Request Quote</span></a></p>
			@else
			Ships Free w/ Pole Purchase
			@endif

		@if($product->availability->slug === 'available')

			<p class="addon-title right">Click to add to order</p>

			<div class="clear"></div>

			<div class="addon-container">
		
				@if($product->sizeable)

				<div ng-repeat="size in product.sizes" ng-cloak>
					<input type="checkbox"  name="size-@{{ $index }}" id="size-@{{ $index }}" ng-model="size.checked" ng-disabled="!size.available">
					<label for="size-@{{ $index }}" ng-class="{ 'faded' : !size.available }"><span class="addon-name">@{{ size.shortName }} -</span>  <span class="addon-price">$@{{ size.price | money }}</span></label>
				</div>

				@foreach($product->sizes as $size)
				<div ng-hide="loaded">
					<input type="checkbox">
					<label><span class="addon-name">Loading-</span>  <span class="addon-price">...</span></label>
				</div>
				@endforeach
				@else

				<div ng-repeat="addon in product.addons" ng-cloak>
					<input type="checkbox"  name="addon-@{{ $index }}" id="addon-@{{ $index }}" ng-model="addon.checked">
					<label for="addon-@{{ $index }}"><span class="addon-name">@{{ addon.product.name }} -</span>  <span class="addon-price">$@{{ addon.product.price | money }}</span></label>
				</div>

				@foreach($product->addons as $addon)
				<div ng-hide="loaded">
					<input type="checkbox">
					<label><span class="addon-name">Loading-</span>  <span class="addon-price">...</span></label>
				</div>
				@endforeach
				@endif

			</div>

			<div class="submit-button" ng-click="addToCart();" ng-bind="productAddedText" ng-class="{ 'post-added-state' : productAdded }"></div>
			<div class="checkout-button" ng-click="openCart();" ng-class="{ 'post-added-state' : productAdded }" ng-show="productAdded">Checkout</div>

			<div class="clear"></div>

			<p class="special-message"><span class="bold">Free Shipping</span> on orders over <span class="bold">$300</span> <span class="detail bold">USA + <span class="brand"><a href="{{ route('australia') }}">AU</a></span> ONLY</span></p>

		@endif

		@if($product->availability->slug === 'preorder')

			<preorder-button></preorder-button>

		@endif

	</div>

	<div class="clear"></div>

</div>

<div class="home-container product-store-section" id="store">

	@include('partials.store')

</div>

@include('partials.contact')


@stop