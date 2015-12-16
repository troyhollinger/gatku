@extends('layouts.master')

@section('title')
GATKU Polespears
@stop

@section('description')
Producing the highest quality polespears, heads, and accessories. Locally built in San Diego, used and loved worldwide.
@stop

@section('content')

<div class="hero" style="background-image:url({{ asset('img/diver.jpg') }})">

	<div class="slideshow">
		<div><p class="hero-blurb">Internationally recognized, <br>Locally produced. <span class="detail">/San Diego, CA</span></p></div>
		<div><p class="hero-blurb">Acclaimed to be the best the industry has to offer -</p></div>
		<div><p class="hero-blurb">We strive to provide our user the most exceptional spearfishing products in the world.</p></div>
		<div><p class="hero-blurb">Made in America by Americans. We touch every pole that has the GATKU name on it. <span class="detail">In House MFG</span></p></div>
		<div><p class="hero-blurb">The #1 Trusted Name in the Industry. Since 2005.</p></div>
		<div><p class="hero-blurb">We’ve finessed &amp; perfected the stick-n-rubberband approach to killing fish.</p></div>
		<div><p class="hero-blurb smaller">Expect the highest quality-innovation the market has to offer. Then expect to be served with the most principled business practices practiced.</p></div>
	</div>

</div>

<div class="store-section home-section" id="store">

	<div class="home-container">

		@include('partials.store')

	</div>

</div>

@include('partials.contact')

@stop