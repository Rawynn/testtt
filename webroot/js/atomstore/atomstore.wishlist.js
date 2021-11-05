var Wishlist = (function(){
	var options;
	var row = {
		elm: null,
		key: null
	};
	
	function attachEvents(){
		/* Zmiana kombinacji */
		$("[data-type=change-combination]").on("change.cart", function(){
			initCurrentRow(this);
			
			getWishlistData(url_wishlists_change_combination + "/" + row.id + "/" + $(this).val() + "?current_combination_id=" + row.elm.attr("data-combination-id"));
		});
	}
	
	function initCurrentRow(element){
		var id             = $(element).parents("[data-type=product-row]").attr("data-product-id");
		var combination_id = $(element).parents("[data-type=product-row]").attr("data-combination-id");
		
		row.elm = $("[data-type=product-row][data-product-id=" + id + "][data-combination-id=" + combination_id + "]");
		row.id  = id;
	}
	
	/* Pobranie danych schowka */
	function getWishlistData(url){
		$.ajax({
			url    : App.getAjaxUrl(url),
			success: function(data){
				updateWishlist($.parseJSON(data));
			}
		});
	}
	
	function updateWishlist(data){
		/* Uaktualnienie kombinacji */
		if (data.combination != undefined){
			updateProductCombination(data.combination);
		}
	}
	
	function updateProductCombination(data){
		if (data.attributes != undefined){
			$.each(data.attributes, function(id, value){
				$("[data-type=product-row-attributes] [data-attribute-id=" + id + "]", row.elm).html(value);
			});
		}
		
		if (data.image != undefined){
			$("[data-type=product-row-image]", row.elm).html(data.image);
		}
		
		if (data.price != undefined){
			$("[data-type=product-row-price]", row.elm).html(data.price);
		}
		
		if (options.onCombinationUpdate && typeof options.onCombinationUpdate === "function"){
			options.onCombinationUpdate(data);
		}
		
		row.elm.attr("data-combination-id", data.id);
	}
	
	return {
		init: function(userOptions){
			options = $.extend({
				onCombinationUpdate: false
			}, userOptions);
			
			attachEvents();
		}
	};
}());