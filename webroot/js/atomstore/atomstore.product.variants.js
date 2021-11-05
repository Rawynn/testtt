var ProductVariants = (function(){
	var options;
	
	function attachEvents(){
		options.form.off("change.product", "[data-type=change-product-variant]").on("change.product", "[data-type=change-product-variant]", function(){
			changeVariant(this);
		});
		
		options.form.off("change.product", "[data-type=kit-product-product-selector]").on("change.product", "[data-type=kit-product-product-selector]", function(){
			changeVariant(this);
		});
		
		$("[data-type=change-product-unavailable-variant]").on("change.product", function(){
			changeUnavailableVariant(this);
		});
		
		/* Automatyczne zaznaczenie zdjęcia wariantu (gdy wybrany wariant na podglądzie) */
		var $_GET = [];
		
		window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value){
			$_GET[name] = value;
		});
		
		for (x in $_GET){
			if (x == 'combination_id'){
				changeCombinationPhoto($_GET[x]);
				
				break;
			}
		}
	}
	
	function changeVariant(element){
		var index = $(element).attr("data-index");
		
		if ($(element).val()){
			index++;
		}
		
		var parent = $(element).parents("[data-type=product-kit-variant-container]").get(0);
		
		$("[data-type=product-variant-step]", parent ? parent : options.form).val(index);
		
		$.post(
			App.getAjaxUrl(url_products_change_combination_attribute_value + "/" + options.form.attr("data-product-id")),
			options.form.serialize(),
			function(data){
				var data = $.parseJSON(data);
				
				if (data.variants != undefined){
					$("[data-type=product-variant-container]", options.form).replaceWith(data.variants);
					disableVariantOptions();
				}
				
				if (data.services != undefined && options.updateServices){
					$("[data-type=product-services-container]", options.form).html(data.services);
				}
				
				if (data.fields != undefined && options.updateFields){
					udpateProductFields(data.fields);
				}
				
				if (data.inputs != undefined){
					udpateProductInputs(data.inputs);
				}
				
				if (parseInt(data.combination_id) > 0){
					changeCombinationPhoto(data.combination_id);
				}
				
				/* Zaznaczenie wariantu do dodawania do schowka */
				$("[data-type=add-to-wishlist][data-combination-id]").attr("data-combination-id", data.combination_id);
				
				/* Aktualizacja cen */
				$("[data-type=zagiel]").attr("data-zagiel-price", data.price);
				$("[data-type=bgz-bnp-paribas]").attr("data-bgz-bnp-paribas-price", data.price);
				$("[data-type=platforma-finansowa]").attr("data-platforma-finansowa-price", data.price);
			}
		);
	}
	
	function changeUnavailableVariant(element){
		var index = $(element).attr("data-index");
		
		if ($(element).val()){
			index++;
		}
		
		var parent = $(element).parents("[data-type=roduct-unavailable-variants]").get(0);
		var form   = $("[data-type=product-unavailable-form]");
		
		$("[data-type=product-variant-step]", parent ? parent : form).val(index);
		
		$.post(
			App.getAjaxUrl(url_products_change_combination_attribute_value + "/" + form.attr("data-product-id") + "?type=unavailable"),
			form.serialize(),
			function(data){
				var data = $.parseJSON(data);
				
				if (data.variants != undefined){
					$("[data-type=product-unavailable-variants]", form).replaceWith(data.variants);
				}
				
				attachEvents();
			}
		);
	}
	
	function disableVariantOptions(){
		$("[data-type=change-product-variant]", options.form).each(function(i, element){
			var disabledOptions = $.parseJSON($(element).attr("data-disabled-options"));
			
			if (disabledOptions != undefined){
				$.each(disabledOptions, function(key, value){
					$("option[value=" + value + "]", element).prop("disabled", true);
				});
			}
			
			$(element).trigger("update-state");
		});
	}
	
	function udpateProductFields(data){
		$.each(data, function(field, value){
			$("[data-type=" + field + "]").html(value);
		});
	}
	
	/**
	 * Aktualizacja ustawień inputa z ilością
	 */
	function udpateProductInputs(data){
		$.each(data, function(input, values){
			$.each(values, function(field, value){
				$("[data-type=" + input + "]").attr("data-" + field, value);
			});
		});
	}
	
	/**
	 * Wybór zdjęcia wariantu
	 */
	function changeCombinationPhoto(combination_id){
		var photo_changed = false;
		var indicators = $("#blueimp-image-carousel").is(":visible") ? $("#blueimp-image-carousel .indicator li") : $("[data-target=#ProductGallery]");
		
		$(indicators).each(function(){
			if (photo_changed){
				return false;
			}
			
			var photo_combinations = $(this).attr("data-combinations").split(",");
			
			for (x in photo_combinations){
				var photo_combination_id = photo_combinations[x];
				
				if (photo_combination_id && photo_combination_id == combination_id){
					$(this).trigger("click");
					
					photo_changed = true;
					
					break;
				}
			}
		});
	}
	
	return {
		init: function(userOptions){
			options = $.extend({
				form          : false,
				updateFields  : true,
				updateServices: true
			}, userOptions);
			
			attachEvents();
			disableVariantOptions();
		}
	};
}());