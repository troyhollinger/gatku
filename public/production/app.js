// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.

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

var ResponsiveVideo = {

	init : function() {

		this.responsive();

	},

	responsive : function() {

		$(".active-video-container").fitVids();

		requestAnimationFrame(ResponsiveVideo.responsive);

	}

}

var You = {

	init : function() {

		$(".you-panel-slider").skippr({

			hidePrevious : true,
			theme : 'dark'

		});

	}

}

var Squares = {

	init : function() {

		Squares.squarify();

	},

	elements : $(".square"),

	squarify : function(){

		Squares.elements.each(function() {

			var width = $(this).width();

			$(this).height(width);

		});

	}

}

var PurchaseColumn = {

	init : function() {

		this.parent = this.element.parent();
		this.parentHeight = this.parent.height();
		this.initialOffsetTop = this.element.offset().top;
		this.elementHeight = this.element.height();

		requestAnimationFrame(PurchaseColumn.stick);

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

$(document).ready(function() {

	BlurbSlider.init();
	Squares.init();

	if (currentRoute === 'home') {

		Mast.init();
		You.init();

	}

	if (currentRoute === 'product') {

		PurchaseColumn.init();

	}

});



$(window).resize(function() {

	Squares.init();

});
