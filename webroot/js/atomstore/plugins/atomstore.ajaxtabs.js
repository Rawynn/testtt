(function($, app){
	"use strict";
	
	if (!$.fn.tab){
		throw new Error("Ajaxtabs requires Bootstrap tabs");
	}
	
	// AJAXTABS INIT
	// =============
	
	$.fn.ajaxtabs = function(options){
		options = $.extend({
			onshow: false,
			onload: false
		}, options);
		
		this.each(function(){
			$("a", this).not('.more').click(function(e){
				e.preventDefault();
				$(this).tab("show");
				var hrefTab = $(this).attr("href").split("#");
				$('.mainpage-tabs .more').addClass('hide');
				$(this).parents('.mainpage-tabs').find('#more_' + hrefTab[1]).removeClass('hide');
				
				if (options.onshow && typeof options.onshow === "function"){
					options.onshow(this);
				}
			});
			
			$(this).on("shown.bs.tab", function(e){
				var targetTab = $($(e.target).attr("href"));
				var url       = App.getAjaxUrl($(targetTab).attr("data-target"));
				
				if ($(targetTab).attr("data-loaded") == "false"){
					$(targetTab).load(url, function(){
						$(targetTab).attr("data-loaded", "true");
						
						if (options.onload && typeof options.onload === "function"){
							options.onload(e.target);
						}
					});
				}
			});
		});
	};
})(window.jQuery);