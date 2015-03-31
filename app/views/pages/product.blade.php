@extends('layouts.master')

@section('title')
Product Name Goes Here
@stop

@section('description')
Product Description goes here.
@stop


@section('content')


<div class="scroller">

	<img class="scroller-image" ng-src="@{{ product.attachedImage }}" ng-class="{'fit' : fullSize === false }" ng-cloak>

</div>

<div class="arrows">
	<div class="left-arrow"></div>
	<div class="right-arrow"></div>

	<div class="clear"></div>
</div>

<div class="container">

	<div class="product-column-left">

		<h1 class="product-title"><span class="bold uppercase">@{{ product.name }}</span>{{-- 'ER <span class="detail"><span class="detail">/256cm</span></span> --}}</h1>

		<div class="product-description">
			@{{ product.description }}
			{{-- <p>Our 10 foot pole <span class="bold">breaks down into two sections</span>. The <span class="bold">all aluminum rear section</span> which is <span class="bold">60 inches</span>, and the <span class="bold">carbon graphite front end</span> section which is <span class="bold">42 inches</span>. Heads are sold separately. Usually the TEN'ER is paired with our <span class="bold highlight-product">SlipTip</span>.</p>
			<p class="faded"><span class="bold">Watch FAQ Video</span> about this Polespear</p>
			<p>More for <span class="bold">experienced</span> divers.</p>
			<p>Traditionally an open-water only spear, now our <span class="bold highlight-inshore">InshoreShrinker</span> can be attached to make it more of a "reef hunter". Go for such fishas Yellowtail, Wahoo, Amberjack, White Seabass, and Dorado, etc.</p> --}}

		</div>

		<p class="product-performance-header bold">Buy a GATKU for its:</p>

		<div class="product-performance">

			<img class="product-performance-icon" src="{{ asset('img/movement.jpg') }}">
			<h3 class="product-performance-title bold">Maneuverability</h3>
			<p class="product-performance-description">@{{ product.maneuverability }}</p>

			<img class="product-performance-icon" src="{{ asset('img/crosshairs.jpg') }}">
			<h3 class="product-performance-title bold">Trajectory</h3>
			<p class="product-performance-description">@{{ product.trajectory }}</p>

			<img class="product-performance-icon" src="{{ asset('img/balance.jpg') }}">
			<h3 class="product-performance-title bold">Balance</h3>
			<p class="product-performance-description">@{{ product.balance }}}</p>

			<img class="product-performance-icon" src="{{ asset('img/diver-shadow.jpg') }}">
			<h3 class="product-performance-title bold">Stealth</h3>
			<p class="product-performance-description">@{{ product.stealth }}</p>

		</div>

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

		<p class="product-price"><span class="product-price-amount">$@{{ product.price | money }}</span> /+ $20 Shipping within USA <br><span class="bold">Int’l</span> Rates Vary <span class="bold">Request Quote</span></p>

		<p class="addon-title right">Click to add to order</p>

		<div class="clear"></div>

		<div class="addon-container">

			<input type="checkbox" name="addon-1" id="addon-1">
			<label for="addon-1"><span class="addon-name">SlipTip -</span>  <span class="addon-price">$45</span></label>

			<input type="checkbox" name="addon-2" id="addon-2">
			<label for="addon-2"><span class="addon-name">Inshore Shrinker -</span>  <span class="addon-price">$49</span></label>

			<input type="checkbox" name="addon-3" id="addon-3">
			<label for="addon-3"><span class="addon-name">Barbed Paralyzer -</span>  <span class="addon-price">$45</span></label>

			<input type="checkbox" name="addon-4" id="addon-4">
			<label for="addon-4"><span class="addon-name">Extra Band -</span>  <span class="addon-price">$16</span></label>

			<input type="checkbox" name="addon-5" id="addon-5">
			<label for="addon-5"><span class="addon-name">Shrink Wrap Grip -</span>  <span class="addon-price">$10</span></label>

			<input type="checkbox" name="addon-6" id="addon-6">
			<label for="addon-6"><span class="addon-name">BUDK Knife -</span>  <span class="addon-price">$17</span></label>

			<input type="checkbox" name="addon-7" id="addon-7">
			<label for="addon-7"><span class="addon-name">Signature Paralyzer -</span>  <span class="addon-price">$45</span></label>

		</div>

		<div class="submit-button">Add to Cart</div>

	</div>

	<div class="clear"></div>

</div>

<div class="home-container product-store-section">

	@include('partials.store')

</div>

@include('partials.contact')


@stop