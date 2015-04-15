@extends('layouts.master')

@section('title')
{{ strtoupper($product->name) }} | GATKU Polespears
@stop

@section('description')
{{ $product->metaDescription }}
@stop


@section('content')


<div class="scroller">

	<img class="scroller-image" ng-src="{{ $product->attachedImage }}" ng-class="{'fit' : fullSize === false }" ng-cloak>

</div>

<div class="arrows">
	<div class="left-arrow"></div>
	<div class="right-arrow"></div>

	<div class="clear"></div>
</div>

<div class="container">

	<div class="product-column-left">

		<h1 class="product-title"><span class="bold uppercase">{{ $product->shortName }}</span>{{ $product->type->slug === 'pole' ? "'ER" : '' }} <span class="detail"><span class="detail">/{{ $product->length }}</span></span></h1>

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
			<p class="product-performance-description">{{ $product->balance }}}</p>

			<img class="product-performance-icon" src="{{ asset('img/diver-shadow.jpg') }}">
			<h3 class="product-performance-title bold">Stealth</h3>
			<p class="product-performance-description">{{ $product->stealth }}</p>

		</div>

		@endif

		<p class="product-buyers-header bold">Others who have bought this product:</p>

		<div class="product-buyers-container">

			<div class="product-buyer square"></div>
			<div class="product-buyer square"></div>
			<div class="product-buyer square"></div>

			<div class="clear"></div>

		</div>

	</div>

	<div class="product-column-right">
		<!-- Increase the width of this element to increase margin between children -->
		<div class="pole-view-actions">

			<p class="attachment-button faded">TAKE APART</p>

			<div class="zoom-out-button zoom-button" ng-class="{'selected' : fullSize === false}" ng-click="fullSize = false; console.log('hello')"></div>
			<div class="zoom-in-button zoom-button" ng-class="{'selected' : fullSize === true}" ng-click="fullSize = true"></div>

		</div>
		
		
		<div class="clear"></div>

		<p class="product-price" ng-cloak><span class="product-price-amount" ng-cloak>$@{{ product.price | money }}</span> /+ $20 Shipping within USA <br><span class="bold">Int’l</span> Rates Vary <span class="bold">Request Quote</span></p>

		<p class="addon-title right">Click to add to order</p>

		<div class="clear"></div>

		<div class="addon-container">

			<div ng-repeat="addon in product.addons" ng-cloak>
				<input type="checkbox"  name="addon-@{{ $index }}" id="addon-@{{ $index }}">
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