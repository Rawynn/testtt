var Partners = (function(){
	function attachEvents(){
		$("[data-type=delete-baner-link]").on("click", function(){
			$("[data-type=delete-baner-link-target]").attr("href", $(this).attr("data-target-url"));
		});
		
		$("[data-type=load-payment-list]").on("change", function(){
			changePartnerPaymentFiltrType($(this).attr("data-load-el"), $(this).val());
		});
		
		$("[data-type=change-partner-add-link] input[type=radio]").on("change", function(){
			$("[data-type=change-partner-add-link] input[type=text], [data-type=change-partner-add-link] input[type=file]").attr("disabled", true);
			$(this).closest("[data-type=change-partner-add-link]").find("input[type=file], input[type=text]").attr("disabled", false);
		});
		
		$("[data-type=change-partner-add-content] input[type=radio]").on("click", function(){
			$("[data-type=change-partner-add-content] input[type=text], [data-type=change-partner-add-content] input[type=file]").attr("disabled", true);
			$(this).closest("[data-type=change-partner-add-content]").find("input[type=file], input[type=text]").attr("disabled", false);
			
			if ($(this).closest("[data-type=change-partner-add-content]").attr("data-container-set")){
				if ($(this).closest("[data-type=change-partner-add-content]").attr("data-container-set") == "html"){
					$("[data-container-get=json]").addClass("hide");
					$("[data-container-get=html]").removeClass("hide");
					$("[data-activate]").attr("disabled", false);
					
					$("[data-type=partner-ad-nofollow]").attr("disabled", false).trigger("toggle-disabled");
				}else{
					$("[data-container-get=json]").removeClass("hide");
					$("[data-container-get=html]").addClass("hide");
					$("[data-activate]").attr("disabled", true);
					
					$("[data-type=partner-ad-nofollow]").attr("disabled", true).trigger("toggle-disabled");
				}
			}
		});
		
		$("[data-trigger-autocomplete=autocomplete-select-append]").on("autocomplete-select-append", function(e, ui){
			var input = $(this);
			if (ui.ui_.item.id){
				$("#JSONCategoriesAdd").append(
					'<div class="category-json-append">' + ui.ui_.item.full_name + ' <i class="fa fa-times" data-type="remove-json-row"></i><input type="hidden" name="data[JSON][category_id][]" id="JSONCategoryId' + ui.ui_.item.id + '" value="' + ui.ui_.item.id + '"></div>'
				);
				
				$("[data-type=remove-json-row]").unbind("click");
				
				$("[data-type=remove-json-row]").click(function(){
					$(this).closest(".category-json-append").remove();
				});
			}
			
			setTimeout(function(){
				input.val("");
			}, 10);
		});
		
		$("[data-tooltip-set]").tooltip();
		
		$("[data-type=remove-json-row]").click(function(){
			$(this).closest(".category-json-append").remove();
		});
		
		/* Wywołanie triggerów */
		$("[data-type=change-partner-add-content] input[type=radio]:checked").click();
	}
	
	function changePartnerPaymentFiltrType(element_target, type){
		$("#"+element_target).load(App.getAjaxUrl(url_partners_update_payments_list + "/" + type));
	}
	
	return {
		init: function(userOptions){
			attachEvents();
		}
	};
}());