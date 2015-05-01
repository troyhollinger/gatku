@extends('layouts.master')

@section('title')
{{ strtoupper($product->name) }} | GATKU Polespears
@stop

@section('description')
{{ $product->metaDescription }}
@stop


@section('content')


<div class="scroller {{ $product->slug === 'budk' ? 'knife-scroller' : '' }}">

	@if($product->attachedImage)
	<img class="scroller-image" ng-show="attached" src="{{ $product->attachedImage }}" ng-class="{'fit' : fullSize === false, 'visible' : attached }" ng-cloak loaded="poleScrollInit()">
	<img class="scroller-image" ng-hide="attached" src="{{ $product->detachedImage }}" ng-class="{'fit' : fullSize === false, 'visible' : attached === false }" ng-cloak loaded="poleScrollInit()">
	@endif

</div>

@if($product->attachedImage)
<div class="arrows">
	<div class="left-arrow"></div>
	<div class="right-arrow"></div>

	<div class="clear"></div>
</div>
@endif

<div class="container">

	<div class="product-column-left">

		<h1 class="product-title"><span class="bold uppercase">{{ $product->shortName }}</span>{{ $product->type->slug === 'pole' ? "'ER" : '' }} @if($product->type->slug !== 'shrinker' && $product->slug !== 'bands') <span class="detail"><span class="detail">/{{ $product->length }}</span></span> @endif</h1>

		<div class="product-description">

			{{ $product->description }}
			
		</div>

		@if($product->type->slug === 'pole')

		<p class="product-performance-header bold">Buy a GATKU for its:</p>

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

		<p class="product-buyers-header bold">Others who have bought this product:</p>

		<product-buyers product-id="{{ $product->id }}"></product-buyers>

	</div>

	<div class="product-column-right">
		<!-- Increase the width of this element to increase margin between children -->
		@if($product->attachedImage)
		<div class="pole-view-actions">

			<p class="attachment-button faded" ng-click="attached = !attached">
				<span ng-show="attached">TAKE POLE APART</span>
				<span ng-show="attached === false">PUT POLE TOGETHER</span>
			</p>


			<div class="zoom-out-button zoom-button" ng-class="{'selected' : fullSize === false}" ng-click="fullSize = false; poleScrollInit()"></div>
			<div class="zoom-in-button zoom-button" ng-class="{'selected' : fullSize === true}" ng-click="fullSize = true; goFullSize();"></div>

		</div>
		<div class="clear"></div>
		@endif

		<p class="product-price" ng-cloak><span class="product-price-amount" ng-cloak>${{ $product->price / 100 }}</span> /+ $20 Shipping within USA <br><span class="bold">Int’l</span> Rates Vary <span class="bold">Request Quote</span></p>

		<p class="addon-title right">Click to add to order</p>

		<div class="clear"></div>

		<div class="addon-container">

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

		</div>

		<div class="submit-button" ng-click="addToCart();">Add to Cart</div>

	</div>

	<div class="clear"></div>

</div>

<div class="home-container product-store-section">

	@include('partials.store')

</div>

@include('partials.contact')


@stop