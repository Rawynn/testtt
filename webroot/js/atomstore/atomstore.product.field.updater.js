var ProductFieldUpdater = (function(){
	var options;
	var fields;
	
	var initialized = false;
	var running     = false;
	var products    = {
		data: {
			Product: {
				id: new Array()
			}
		}
	};
	
	function getProductsToUpdate(){
		$("[data-type=product]").each(function(){
			if ($(this).attr("data-product-id") !== undefined && $(this).attr("data-updated") != "true"){
				products.data.Product.id.push($(this).attr("data-product-id"));
			}
		});
		
		$("[data-toggle=tooltip]").tooltip();
	}
	
	function getFieldsFromServer(){
		$.post(
			options.url,
			getSerializeProducts(),
			function(data){
				fields = $.parseJSON(data);
				
				if (fields.length != 0){
					updateFields();
				}
				
				setTimeout(
					function(){
						running = false;
					},
					500
				);
			}
		);
	}
	
	function getSerializeProducts(){
		return $.param(products);
	}
	
	function updateFields(){
		$.each(fields, function(index, field){
			var product = $("[data-type=product][data-product-id=" + index + "]");
			
			$.each(field, function(key, value){
				var container = $("[data-type=field-" + key + "]", product);
				
				if (container.length != 0){
					if (container.attr("data-update") == "inject"){
						container.text(value);
					}else if (container.attr("data-update") == "toggle" && value){
						container.removeClass("hide");
					}else if (container.attr("data-update") == "toggle" && !value){
						container.addClass("hide");
					}
				}
				
				if (key == "sellable" && !value){
					$("[data-type=add-to-cart]", product).remove();
					$("*[id='" + $("[data-type=cart-group-checkbox]", product).attr("name") + "_']").remove();
					$("[data-type=cart-group-checkbox]", product).closest("span.transform-wrapper").addClass("disabled");
					$("[data-type=cart-group-checkbox], [data-type=cart-group-quantity]", product).remove();
				}
			});
			
			$(product).attr("data-updated", "true");
		});
		
		products.data.Product.id = new Array();
	}
	
	return {
		init  : function(userOptions){
			options = $.extend({
				url       : App.getAjaxUrl(url_products_get_prices),
				bindToAjax: true
			}, userOptions);
			
			initialized = true;
			
			if (options.bindToAjax){
				$(document).ajaxComplete(function(){
					if (!running){
						ProductFieldUpdater.update();
					}
				});
			}
		},
		update: function(){
			if (!initialized){
				ProductFieldUpdater.init();
			}
			
			running = true;
			
			getProductsToUpdate();
			
			if (products.data.Product.id.length != 0){
				getFieldsFromServer();
			}else{
				running = false;
			}
		},
		getRuning: function(){
			return running;
		}
	};
}());