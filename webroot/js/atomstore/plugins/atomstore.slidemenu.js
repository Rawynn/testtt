(function($){
	"use strict";
	
	// SLIDEMENU CLASS DEFINITION
	// ==========================
	
	var Slidemenu = function(){
		//TODO: constructor
	};
	
	Slidemenu.prototype.toggle = function(){
		var $this   = $(this);
		var $target = $("[data-id=" + $this.attr("data-target") + "]");
		var $group  = $(".open[data-group=" + $target.attr("data-group") + "]");
		
		//TODO: is group exist ?
		
		var isActive = $target.hasClass("open");
		
		Slidemenu.prototype.clear(false);
		
		$target.on("click", function(e) {
			e.stopPropagation();
		});
		
		if (!isActive){
			$this.trigger("show.as.slidemenu");
			
			$this.parent().addClass("active");
			
			if ($target.hasClass("animate")){
				$target.addClass("open").slideDown("slow");
			} else if ($group.length){
				$target.addClass("open").show();
			}else{
				$target.addClass("open").slideDown("fast");
			}
			
			$this.trigger("shown.as.slidemenu");
			
			/* scrollbar in header cart */
			var cartBoxMaxHeight = $('.cart-box-max-height');
			
			if (cartBoxMaxHeight.height() > 350){
				cartBoxMaxHeight.height(350).customScrollbar();
			}
			
			ImageLoader.load();
		}
		
		return false;
	};
	
	Slidemenu.prototype.clear = function(animate){
		$("[data-type=slidemenu]").each(function(){
			var $this   = $(this);
			var $target = $("[data-id=" + $this.attr("data-target") + "]");
			
			$this.trigger("hide.as.slidemenu");
			
			if ($target.hasClass("open")){
				if ($target.hasClass("animate")){
					$target.stop(true, true).slideUp("slow", function(){
						$this.parent().removeClass("active");
						$(this).removeClass("open");
						$this.trigger("hidden.as.slidemenu");
					});
				} else if (animate){
					$target.stop(true, true).slideUp("fast", function(){
						$this.parent().removeClass("active");
						$(this).removeClass("open");
						$this.trigger("hidden.as.slidemenu");
					});
				}else{
					$this.parent().removeClass("active");
					$target.hide().removeClass("open");
					$this.trigger("hidden.as.slidemenu");
				}
			}
		});
	};
	
	$.fn.slidemenu = function(){
		//TODO: init by standard way $().foo();
		//TODO: options
		//TODO: callbacks
	};
	
	$.fn.slidemenu.Constructor = Slidemenu;
	
	// APPLY TO STANDARD SLIDEMENU ELEMENTS
	// ===================================
	$(document).on("click.as.slidemenu.data-api", function(){
		Slidemenu.prototype.clear(true);
	}).on("click.as.slidemenu.data-api", "[data-type=slidemenu]", Slidemenu.prototype.toggle);
})(window.jQuery);