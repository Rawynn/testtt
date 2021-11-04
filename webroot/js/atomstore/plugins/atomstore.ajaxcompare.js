(function($){
	"use strict";
	
	$.fn.ajaxcompare = function(userOptions){
		var self = this;
		
		var options = $.extend({
			globalContext: document,
			onfinish     : false
		}, userOptions);
		
		var data = {
			onfinish : function showModal(response){
				$(response).on("shown.bs.modal", function(){
					// Przeładowanie ilości produktów w porównywarce
					$("[data-type=compare-products-count]").text(
						$("[data-type=compare-products-count]", response).text()
					);
					
					if (options.onfinish && typeof options.onfinish === "function"){
						options.onfinish(response);
					}
				}).on("hidden.bs.modal", function(){
					$("#AddProductToCompare").remove();
				}).modal({
					backdrop: "static",
					show    : true
				});
				
				setTimeout(
					function(){
						$("[data-type=show-comparison-table]").on("click", function(){
							$("#AddProductToCompare").modal("hide");
						});
					},
					250
				);
			}
		};
		/* Dodawanie produktu do porónywarki AJAX */
		$(self, options.globalContext).ajaxsend(data);
		
		$(document).ajaxComplete(function(event, xhr){
			$(self.selector, xhr.responseHTML).ajaxsend(data);
		});
	};
})(window.jQuery);