(function($){
	"use strict";
	
	// MESSAGES INIT
	// =============
	
	$.messages = function(options){
		options = $.extend({
			animationSpeed: "fast"
		}, options);
		
		$(".message").on("click", "span.close", function(){
			$(this).parent().fadeOut(options.animationSpeed);
		});
	};
})(window.jQuery);