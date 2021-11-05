(function($) {
	$.prettyLoader = function(settings) {
		var totalAjaxCount = 0;

		settings = $.extend({
			animationSpeed : "fast", /* fast/normal/slow/integer */
			bindToAjax     : true,   /* true/false */
			bindToCursor   : true,   /* true/false */
			delay          : false,  /* false OR time in milliseconds (ms) */
			offsetTop      : 15,     /* integer */
			offsetLeft     : 10      /* integer */
		}, settings);

		scrollPos = getScroll();

		$(window).scroll(function() {
			scrollPos = getScroll();

			$(document).triggerHandler("mousemove");
		});

		var cursorX = 0;
		var cursorY = 0;

		if (settings.bindToCursor) {
			$(document).on("mousemove.pretty-loader", function(e) {
				$.prettyLoader.positionLoader(e);
			});
		}

		if (settings.bindToAjax){
			$(document).ajaxStart(function() {
				if (totalAjaxCount == 0) {
					$.prettyLoader.show();
				}

				totalAjaxCount++;
			}).ajaxStop(function() {
				if (totalAjaxCount > 0){
					totalAjaxCount--;
				}
				
				if (totalAjaxCount == 0) {
					$.prettyLoader.hide();
				}
			});
		}

		$.prettyLoader.positionLoader = function(e) {
			e = e ? e : window.event;

			cursorX = (e.clientX) ? e.clientX : cursorX;
			cursorY = (e.clientY) ? e.clientY : cursorY;

			positionLeft = cursorX + settings.offsetLeft + scrollPos["scrollLeft"];
			positionTop  = cursorY + settings.offsetTop + scrollPos["scrollTop"];

			$(".pretty-loader").css({
				"top"  : positionTop,
				"left" : positionLeft
			});
		};

		$.prettyLoader.show = function(delay) {
			scrollPos = getScroll();

			$(".pretty-loader").fadeIn(settings.animationSpeed);

			delay = (delay) ? delay : settings.delay;

			if (delay){
				setTimeout(function() {
					$.prettyLoader.hide();
				}, delay);
			}
		};

		$.prettyLoader.hide = function() {
			$(".pretty-loader").fadeOut(settings.animation_speed);
		};

		function getScroll() {
			if (self.pageYOffset) {
				return {
					scrollTop  : self.pageYOffset,
					scrollLeft : self.pageXOffset
				};
			} else if (document.body) {
				return {
					scrollTop  : document.body.scrollTop,
					scrollLeft : document.body.scrollLeft
				};
			};
		};

		return this;
	};
})(jQuery);