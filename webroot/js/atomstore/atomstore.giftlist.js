var Giftlist = (function(){
	var options;
	var row = {
		elm: null,
		key: null
	};
	
	function attachEvents(){
		$("[data-type=autocomplete]").on("autocompleteselect", function(event, ui){
			addProduct($(this));
		});
		
		$("[data-type=delete-product]").on("click.giftslist", function(event, ui){
			event.preventDefault();
			
			deleteProduct($(this));
		});
		
		$("[data-type=change-combination]").on("change.cart", function(){
			initCurrentRow(this);
			
			getGiftsListData(url_gifts_lists_change_combination + "/" + row.id + "/" + $(this).val());
		});
	}
	
	function addProduct(element){
		var container = element.parent();
		
		$(".delete-product", container).removeClass("hide");
		
		$.ajax({
			url    : App.getAjaxUrl(container.attr("data-next")),
			success: function(data){
				var next = $(data);
				
				$("[data-type=autocomplete]", next).on("autocompleteselect", function(event, ui){
					addNextProduct($(this));
				});
				
				container.after(next);
			}
		});
	}
	
	function deleteProduct(element){
		element.parent().remove();
	}
	
	function initCurrentRow(element){
		var id = $(element).parents("[data-type=product-row]").attr("data-product-id");
		
		row.elm = $("[data-type=product-row][data-product-id=" + id + "]");
		row.id  = id;
	}
	
	/* Pobranie danych listy życzeń */
	function getGiftsListData(url){
		$.ajax({
			url    : App.getAjaxUrl(url),
			success: function(data){
				updateGiftsList($.parseJSON(data));
			}
		});
	}
	
	function updateGiftsList(data){
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
	}
	
	return {
		init: function(userOptions){
			options = $.extend({
				onCombinationUpdate : false
			}, userOptions);
			
			attachEvents();
		}
	};
}());