var Surveys = (function(){
	function attachEvents(){
		$("[data-type=survey-form]").on("change.survey", "[data-type=survey-combo-input]", function(){
			toggleExplication();
		});
		
		$("[data-type=survey-form]").on("change.survey", "[data-type=survey-row-input] [data-multiplication=true]", function(){
			multipleField(this, "[data-type=survey-row-input]");
		});
		
		$("[data-type=survey-form]").on(
			"change.survey", "[data-type=survey-row-combo][data-multiplication=true] [data-type=survey-combo-input]",
			function(){
				multipleComboField(this);
			}
		);
	}
	
	function toggleExplication(element){
		$("[data-type=survey-checkbox], [data-type=survey-combo-input]").each(function(i, elm){
			var id    = $(this).attr("data-id");
			var input = $("[data-type=survey-explication][data-id=" + id + "]");
			
			if ($(this).prop("checked")){
				input.parents("[data-type=survey-explication-toggle]").removeClass("hide");
				input.prop("disabled", false);
			}else{
				input.parents("[data-type=survey-explication-toggle]").addClass("hide");
				input.prop("disabled", true);
			}
		});
	}
	
	function extendAutocomplete(container){
		$("[data-type=survey-autocomplete]", container).each(function(i, elm){
			$(elm).on("autocompleteselect", function(event, ui){
				if ($(elm).attr("data-multiplication") == "true"){
					multipleField(elm, "[data-type=survey-row-product]");
				}
			});
		});
	}
	
	function multipleField(element, parent){
		if (!$(element).val() || ($(element).attr("data-validate") != undefined && !$(element).ketchup("isValid"))){
			return false;
		}
		
		$.get(
			$(element).attr("data-url"),
			function(response){
				$(response).insertAfter($(element).parents(parent));
				extendAutocomplete($("[data-type=survey-form]"));
			}
		);
		
		$(element).attr("data-multiplication", "false");
	}
	
	function multipleComboField(element){
		var row = $(element).parents("[data-type=survey-row-combo]");
		
		$.get(
			row.attr("data-url"),
			function(response){
				$(response).insertAfter(row);
			}
		);
		
		row.attr("data-multiplication", "false");
	}
	
	return {
		init: function(){
			attachEvents();
			extendAutocomplete($("[data-type=survey-form]"));
		}
	};
}());