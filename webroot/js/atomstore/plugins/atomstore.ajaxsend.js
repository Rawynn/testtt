(function($){
	"use strict";
	
	// AJAXSEND INIT
	// =============
	
	$.fn.ajaxsend = function(options){
		options = $.extend({
			onfinish: false
		}, options);
		
		function sendRequest(request, object){
			if (typeof object != "undefined"){
				/* Aktualizacja adresu */
				if (object.tagName == "FORM"){
					request.url = App.getAjaxUrl($(object).attr("action"));
				}else if (object.tagName == "A"){
					request.url = App.getAjaxUrl($(object).attr("href"));
				}
			}
			
			request.success = function(data){
				if (options.onfinish && typeof options.onfinish === "function"){
					options.onfinish(data);
				}
			};
			
			if (typeof request.form !== undefined){
				request.data = $(request.form).serialize();
			}
			
			$.ajax(request);
		}
		
		this.each(function(){
			var request = {};
			
			if (this.tagName == "FORM"){
				request = {
					event: "submit.atomajax",
					form : this,
					type : $(this).attr("method") || "GET",
					url  : App.getAjaxUrl($(this).attr("action"))
				};
			}else if (this.tagName == "A"){
				request = {
					event: "click.atomajax",
					type : "GET",
					url  : App.getAjaxUrl($(this).attr("href"))
				};
			}
			
			if (request !== undefined){
				$(this).off(request.event);
				
				$(this).on(request.event, function(e){
					e.preventDefault();
					
					sendRequest(request, this);
				});
			}
		});
	};
})(window.jQuery);