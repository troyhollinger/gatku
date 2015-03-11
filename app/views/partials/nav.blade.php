@if (Route::currentRouteName() === 'home')
<div class="mast">
@else
<div class="mast below-fold">
@endif

	<div class="container navigation-container">

		<img id="logo-above" src="{{ asset('img/logo-white.png') }}">

		<img id="logo-below" src="{{ asset('img/logo-white-bg.png') }}">

		<ul class="navigation">
			<li><a href="#store">Store</a></li>
			<li><a href="#videos">Videos</a></li>
			<li><a href="#you">You</a></li>
			<li>Contact</li>
			<li>Cart</li>
		</ul>

		<div class="clear"></div>

	</div>
	

</div>