'use strict';


(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] 
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }
 
    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
 
    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

var BlurbSlider = {

	init : function() {

		$(".slideshow").skippr({

			// autoPlay : true,
			// autoPlayDuration : 4000
			// navType : 'bubble'

		})

	}

}

var Mast = {

	init : function() {

		requestAnimationFrame(Mast.track);

	},

	element : $(".mast"),

	track : function() {

		var distance = $(document).scrollTop();
		var height = Mast.element.height();
		var windowHeight = $(window).height();

		if (distance > (windowHeight - height)) {

			Mast.element.addClass('below-fold');

		} else {

			Mast.element.removeClass('below-fold');

		}

		requestAnimationFrame(Mast.track);

	}

}

// var ResponsiveVideo = {

// 	init : function() {

// 		this.responsive();

// 	},

// 	responsive : function() {

// 		$(".active-video-container").fitVids();

// 		requestAnimationFrame(ResponsiveVideo.responsive);

// 	}

// }

// var You = {

// 	init : function() {

// 		$(".you-panel-slider").skippr({

// 			hidePrevious : true,
// 			theme : 'dark'

// 		});

// 	}

// }

var Squares = {

	init : function() {

		Squares.squarify();

		// setTimeout(function(){ Squares.init() }, 5);
		setTimeout(function(){ Squares.init() }, 100);

	},

	squarify : function(){

		var squares = $(".square");

		squares.each(function() {

			var width = $(this).width();

			$(this).height(width);

		});

		squares = null;

	}

}

var PurchaseColumn = {

	init : function() {

		if ($(window).width() > 1300) {

			this.parent = this.element.parent();
			this.parentHeight = this.parent.height();
			this.initialOffsetTop = this.element.offset().top;
			this.elementHeight = this.element.height();

			requestAnimationFrame(PurchaseColumn.stick);
				
		}

	},

	element : $(".product-column-right"),

	parent : null,

	parentHeight : null,

	initialOffsetTop : 0,

	elementHeight : null,

	stick : function() {

		var distance = $(document).scrollTop();
		var offset = PurchaseColumn.initialOffsetTop;
		var height = PurchaseColumn.elementHeight;
		var parentHeight = PurchaseColumn.parentHeight;
		var amount = (distance - offset) + 70;

		if (distance > offset - 70 && distance < ((offset - 70) + (parentHeight - height)) ) {

			PurchaseColumn.element.css('top', amount + 'px');

		} else if (distance >= ((offset - 70) + (parentHeight - height)) ) {

			PurchaseColumn.element.css('top', (parentHeight - height) + 'px');

		} else {

			PurchaseColumn.element.css('top', '0px');

		}

		requestAnimationFrame(PurchaseColumn.stick);

	}

}

var PoleScroll = {

	init : function() {

		this.scrollPosition();

	},

	element : $(".scroller"),

	scrollPosition : function() {

		var scroller = $(".scroller");

		if (layoutType === 'head') {

			if ($(window).width() < 1000) {

				scroller.scrollLeft($(".scroller-image.visible").width() - 600);

			} else {

				scroller.scrollLeft($(".scroller-image.visible").width());

			}

		} else if(layoutType === 'shrinker') {

			scroller.scrollLeft($(".scroller-image").width() - 3100);			

		}

		scroller = null;

	}

}

var ApparelRotator = {

	init : function(slug) {

		var images;

		if (slug === 'niner-tshirt') {

			images = this.photos.niner;

		} else if (slug === 'superhero-tshirt') {

			images = this.photos.superhero;

		} else if (slug === 'comfort-hoodie') {

			images = this.photos.comfort;

		}

		$(".apparel-container").rollerblade({

			imageArray : images

		});

	},

	photos : {

		niner : [
			CONFIG.base + '/img/apparel/niner/niner-1.jpg',
			CONFIG.base + '/img/apparel/niner/niner-2.jpg',
			CONFIG.base + '/img/apparel/niner/niner-3.jpg',
			CONFIG.base + '/img/apparel/niner/niner-4.jpg',
			CONFIG.base + '/img/apparel/niner/niner-5.jpg',
			CONFIG.base + '/img/apparel/niner/niner-6.jpg',
			CONFIG.base + '/img/apparel/niner/niner-7.jpg',
			CONFIG.base + '/img/apparel/niner/niner-8.jpg'
			
		],
		superhero : [
			CONFIG.base + '/img/apparel/superhero/superhero-1.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-2.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-3.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-4.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-5.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-6.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-7.jpg',
			CONFIG.base + '/img/apparel/superhero/superhero-8.jpg'
		],
		comfort : [
			CONFIG.base + '/img/apparel/comfort/comfort-1.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-2.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-3.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-4.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-5.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-6.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-7.jpg',
			CONFIG.base + '/img/apparel/comfort/comfort-8.jpg'
		]
		
		

	}

}

$(document).ready(function() {

	Squares.init();

	if (currentRoute === 'home') {

		Mast.init();
		// You.init();
		BlurbSlider.init();

	}

	if (currentRoute === 'product.show') {

		PurchaseColumn.init();

	}

	if (layoutType === 'apparel' && slug !== null) {

		ApparelRotator.init(slug);

	}

	// Smooth scrolling to anchor tag
	$('a[href*=#]:not([href=#])').on('click', function() {

	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

			var target = $(this.hash);

			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

			if (target.length) {

				$('html,body').animate({ scrollTop: target.offset().top }, 400);

	        	return false;

			}

	    }

	});

});



$(window).resize(function() {

	Squares.init();

});
