<?php 


	$headsRow = '<div class="heads-row product-row">

		<div class="product-thumb-container" ng-repeat="head in heads"><a href="' . route('product.show', ['']) . '/{{ head.slug }}"><img ng-src="{{ head.thumb }}"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="heads-links links">
		<div class="product-link-container" ng-repeat="head in heads"><a href="' . route('product.show', ['']) . '/{{ head.slug }}">{{ head.shortName }}<span class="detail" ng-if="head.slug === \'signature-paralyzer\' || head.slug === \'barbed-paralyzer\'"> /{{ head.length }}</span></a></div>

		<div class="clear"></div>
	</div>

	<h2 class="store-label">Detachable Heads</h2>';


	$tailsRow = '<div class="tails-row product-row">

		<div class="product-thumb-container" ng-repeat="pole in poles"><a href="' . route('product.show', ['']) . '/{{ pole.slug }}"><img ng-src="{{ pole.thumb }}"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="tails-links links">

		<div class="product-link-container" ng-repeat="pole in poles" ng-cloak><a href="' . route('product.show', ['']) . '/{{ pole.slug }}"><span class="default-product-name">{{ pole.shortName }}<span class="unbold">\'ER</span> <span class="detail uncaps">/{{ pole.length }}</span></span><span class="mobile-product-name">{{ $index + 6 }}\'ER</span></a></div>

		<div class="clear"></div>

	</div>

	<h2 class="store-label">Gen 2 Hybrid Polespears</h2>';

	$extras1Row = '<div class="extras-row product-row">

		<div class="product-thumb-container" ng-repeat="shrinkerItem in shrinker"><a href="' . route('product.show', ['']) . '/{{ shrinkerItem.slug }}"><img ng-src="{{ shrinkerItem.thumb }}"></a></div>

		<div class="product-thumb-container" ng-repeat="extra in extras1"><a href="' . route('product.show', ['']) . '/{{ extra.slug }}"><img ng-src="{{ extra.thumb }}" ng-class="{ \'knife-thumb\' : extra.slug == \'budk\', \'bands-thumb\' : extra.slug == \'bands\' || extra.slug == \'hardcore-bands\'}"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="extras-links links">

		<div class="product-link-container" ng-repeat="shrinkerItem in shrinker"><a href="' . route('product.show', ['']) . '/{{ shrinkerItem.slug }}">{{ shrinkerItem.name }}</a></div>

		<div class="product-link-container" ng-repeat="extra in extras1"><a href="' . route('product.show', ['']) . '/{{ extra.slug }}">{{ extra.name }}</a></div>
		
		<div class="clear"></div>

	</div>

	<h2 class="store-label">Accessories</h2>';

	$extras2Row = '<div class="extras-row product-row">

		<div class="product-thumb-container" ng-repeat="extra in extras2"><a href="' . route('product.show', ['']) . '/{{ extra.slug }}"><img ng-src="{{ extra.thumb }}" ng-class="{ \'knife-thumb\' : extra.slug == \'budk\', \'bands-thumb\' : extra.slug == \'bands\', \'bands-thumb-large\' : extra.slug == \'hardcore-bands\', \'monty-thumb\' : extra.slug == \'full-monty\', \'big-game-thumb\' : extra.slug == \'big-game\', \'cable-w-tip-thumb\' : extra.slug == \'cable-w-tip\' }"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="extras-links links">

		<div class="product-link-container" ng-repeat="extra in extras2"><a href="' . route('product.show', ['']) . '/{{ extra.slug }}">{{ extra.name }}</a></div>
		
		<div class="clear"></div>

	</div>

	<h2 class="store-label">Accessories</h2>';

	$extras3Row = '<div class="extras-row product-row">

		<div class="product-thumb-container" ng-repeat="extra in extras3"><a href="' . route('product.show', ['']) . '/{{ extra.slug }}"><img ng-src="{{ extra.thumb }}" ng-class="{ \'knife-thumb\' : extra.slug == \'budk\', \'bands-thumb\' : extra.slug == \'bands\' || extra.slug == \'hardcore-bands\', \'monty-thumb\' : extra.slug == \'full-monty\', \'big-game-thumb\' : extra.slug == \'big-game\', \'cable-w-tip-thumb\' : extra.slug == \'cable-w-tip\' || \'cable\' || \'tips\' }"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="extras-links links">

		<div class="product-link-container" ng-repeat="extra in extras3"><a href="' . route('product.show', ['']) . '/{{ extra.slug }}">{{ extra.name }}</a></div>
		
		<div class="clear"></div>

	</div>

	<h2 class="store-label">Accessories</h2>';


	$apparelRow = '<div class="apparel-row product-row">

		<div class="product-thumb-container" ng-repeat="apparelItem in apparel"><a href="' . route('product.show', ['']) . '/{{ apparelItem.slug }}"><img ng-src="{{ apparelItem.thumb }}"></a></div>
		
		<div class="clear"></div>

	</div>

	<div class="apparel-links links">

		<div class="product-link-container" ng-repeat="apparelItem in apparel"><a href="' . route('product.show', ['']) . '/{{ apparelItem.slug }}">{{ apparelItem.name }}</a></div>

		<div class="clear"></div>

	</div>

	<h2 class="store-label">Apparel</h2>';

	$glassRow = '<div class="product-row glass-row">
		<div class="product-thumb-container" ng-repeat="glass in glasses"><a href="' . route('product.show', ['']) . '/{{ glass.slug }}"><img ng-src="{{ glass.thumb }}"></a></div>
	</div>

	<div class="links glass-links">
		<div class="product-link-container" ng-repeat="glass in glasses"><a href="' . route('product.show', ['']) . '/{{ glass.slug }}">{{ glass.shortName }} <span class="detail"> /{{ glass.length }}</span></a></div>

		<div class="clear"></div>
	</div>
	<h2 class="store-label">Glasses</h2>';

 ?>


<div class="store-container" ng-controller="StoreController">



	@if(isset($product))

		@if($product->type->slug === 'head')

		{{ $headsRow . $tailsRow . $extras1Row . $extras2Row . $extras3Row . $apparelRow . $glassRow  }}		

		@elseif($product->type->slug === 'pole')

		{{ $tailsRow . $headsRow . $extras1Row . $extras2Row . $extras3Row . $apparelRow . $glassRow }}		

		@elseif($product->type->slug === 'extra' || $product->type->slug === 'shrinker')

		{{ $extras1Row . $extras2Row . $extras3Row . $headsRow . $tailsRow . $apparelRow . $glassRow }}		

		@elseif($product->type->slug === 'apparel')

		{{ $apparelRow . $headsRow . $tailsRow . $extras1Row . $extras2Row . $extras3Row . $glassRow }}

		@elseif($product->type->slug === 'glass')

		{{ $glassRow . $headsRow . $tailsRow . $extras1Row . $extras2Row . $extras3Row . $apparelRow}}

		@else
		
		{{ $headsRow . $tailsRow . $extras1Row . $extras2Row . $extras3Row . $apparelRow . $glassRow }}

		@endif

	@else

	{{ $headsRow . $tailsRow . $extras1Row . $extras2Row . $extras3Row . $apparelRow . $glassRow}}

	@endif

	

</div>
