(function($){
	"use strict";
	
	$.fn.ajaxwishlist = function(userOptions){
		var self = this;
		
		var options = $.extend({
			globalContext: document,
			onfinish     : false
		}, userOptions);
		
		var data = {
			onfinish : function showModal(response){
				$(response).on("shown.bs.modal", function(){
					// Przeładowanie ilości produktów w schowku
					$("[data-type=wishlist-quantity]").text(
						$("[data-type=wishlist-quantity]", response).text()
					);
					
					// Przeładowanie boxu schowka
					$("[data-type=wishlist-box]").html(
						$("[data-type=wishlist-box]", response).html()
					);
					
					if (options.onfinish && typeof options.onfinish === "function"){
						options.onfinish(response);
					}
				}).modal({
					backdrop: "static",
					show    : true
				});
			}
		};
		/* Dodawanie produktu do koszyka AJAX */
		$(self, options.globalContext).ajaxsend(data);
		
		$(document).ajaxComplete(function(event, xhr){
			$(self.selector, xhr.responseHTML).ajaxsend(data);
		});
	};
})(window.jQuery);