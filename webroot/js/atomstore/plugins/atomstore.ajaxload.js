(function($){
	"use strict";
	
	// TOGGLE CLASS DEFINITION
	// =======================
	
	var AjaxLoad = function(element, options){
		this.element = element;
		this.options = options;
		
		this.init();
	};
	
	AjaxLoad.prototype.init = function(){
		var self = this;
		
		switch (this.options.type){
			case "onload":
				setTimeout(function(){
					self.load();
				}, self.options.offset);
				
				break;
			case "onscroll":
				$(window).scroll(function(){
					if (self.isElementVisible()){
						self.load();
					}
				});
				
				break;
		}
	};
	
	AjaxLoad.prototype.load = function(){
		var self = this;
		
		self.load = function(){};
		
		$(this.element).load(this.options.url, function(){
			$(self.element).attr("data-loaded", "true");
			
			if (self.options.onLoad && typeof self.options.onLoad === "function"){
				self.options.onLoad();
			}
		});
	};
	
	AjaxLoad.prototype.isElementVisible = function(){
		var documentTop    = $(window).scrollTop();
		var documentBottom = documentTop + $(window).height();
		var elementTop     = $(this.element).offset().top;
		
		return ((elementTop - this.options.offset <= documentBottom) && (elementTop + this.options.offset >= documentTop));
	};
	
	$.fn.ajaxload = function(options){
		var ajaxLoadElement = new AjaxLoad(this, options);
	};
	
	$.fn.ajaxload.Constructor = AjaxLoad;
	
	// APPLY TO STANDARD AJAXLOAD ELEMENTS
	// ===================================
	
	$(function(){
		$("[data-type=ajax-load][data-loaded=false]").each(function(i, element){
			var self = $(element);
			
			self.ajaxload({
				url   : App.getAjaxUrl(self.attr("data-load-url")),
				type  : self.attr("data-load-type"),
				offset: self.attr("data-load-offset")
			});
		});
	});
})(window.jQuery);