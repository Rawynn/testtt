(function($){
	"use strict";
	
	$.fn.ajaxcart = function(userOptions){
		var self    = this;
		var options = $.extend({
			globalContext: document,
			onfinish     : false
		}, userOptions);
		
		var data = {
			onfinish: function showModal(response){
				var init = function(context){
					$(self.selector, context).ajaxsend({
						onfinish: function(response){
							show(response);
						}
					});
				};
				
				var show = function(response){
					$(response).on("shown.bs.modal", function(){
						init(this);
						
						// Przeładowanie ceny całościowej koszyka
						$("[data-type=cart-sum-quantity]").text(
							$("[data-type=cart-sum-quantity]", response).text()
						);
						
						// Przeładowanie ilości produktów w koszyku
						$("[data-type=cart-price]").text(
							$($("[data-type=cart-price]", response).get(0)).text()
						);
						
						// Przeładowanie boxu koszyka
						$($("[data-type=cart-box]")).html(
							$("[data-type=cart-box]", response)
						);
						
						// Usługi
						$("[data-type=cart-add-product-services]").on("change.product", "[data-type=change-service]", function(){
							Product.changeService(this);
						});
						
						if (options.onfinish && typeof options.onfinish === "function"){
							options.onfinish(response);
						}
					}).on("show.bs.modal", function(){
						$(".add-cart-modal").fadeOut(120, function(){
							$(this).remove();
						});
						
						$(".modal-backdrop").fadeOut(120, function(){
							$(this).remove();
						});
					}).on("hidden.bs.modal", function(){
						ProductVariants.init({
							form          : $("[data-type=product-form]"),
							updateFields  : true,
							updateServices: true
						});
						
						$(this).remove();
					}).modal({
						backdrop: "static",
						show    : true
					});
				};
				
				show(response);
			}
		};
		
		/* Dodawanie produktu do koszyka AJAX */
		$(self, options.globalContext).ajaxsend(data);
		
		$(document).ajaxComplete(function(event, xhr){
			$(self.selector, xhr.responseHTML).ajaxsend(data);
		});
	};
})(window.jQuery);