(function($){
	"use strict";
	
	// TOGGLE CLASS DEFINITION
	// =======================
	
	var Toggle = function(){
		//TODO: constructor
	};
	
	Toggle.prototype.toggle = function(e){
		e.preventDefault();
		
		var self        = this;
		var hide_others = $(this).attr("data-toggle-extended");
		
		if (($(this).attr("href") == "#UserAccountMenu") && $($(this).attr("href")).hasClass("salerep-menu")){
			$($(this).attr("href")).toggleClass("active");
			$(self).toggleClass("open active");
		} else {
			$($(this).attr("href")).slideToggle("fast", function(){
				$(self).toggleClass("open active");
			});
		}
		
		if (typeof hide_others !== typeof undefined && hide_others !== false){
			$("[data-toggle-extended-elements=" + hide_others + "]").not($($(this).attr("href"))).slideUp("fast", function(){
				$(self).removeClass("open active");
			});
		}
	};
	
	$.fn.toggleElement = function(){
		//TODO: init by standard way $().foo();
		//TODO: options
		//TODO: callbacks
	};
	
	$.fn.toggleElement.Constructor = Toggle;
	
	// APPLY TO STANDARD TOGGLE ELEMENTS
	// =================================
	$(document).on("click.as.toggle.data-api", "[data-type=toggle]", Toggle.prototype.toggle);
})(window.jQuery);