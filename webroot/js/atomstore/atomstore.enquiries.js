var Enquiries = (function(){
	function attachEvents(){
		/* Filtry na liście zamówień */
		$("[data-type=b2b-enquiries-list-search-form]").on("submit.invoice-list", function(e){
			submitFilterForm(e, this);
		});
		
		/* Wysłanie formularza do utworzenia oferty */
		$("[data-type=b2b-enquiries-create-offer]").on("click", function(){
			$("[data-type=b2b-enquiries-create-offer-form-" + $(this).attr("data-b2b-enquire-id") + "]").submit();
			
			return false;
		});
	}
	
	function submitFilterForm(event, form){
		$(getFields(form, true)).prop("disabled", true).trigger("toggle-disabled");
		
		$("input[data-send!=submit], select[data-send!=submit]", form).prop("disabled", true);
	}
	
	function getFields(container, empty){
		return $("input, select", container).map(function(index, element){
			if (empty){
				if (!hasValue(element)){
					return element;
				}
			}else{
				if (hasValue(element)){
					return element;
				}
			}
		});
	}
	
	function hasValue(element){
		if (element.type == "radio" || element.type == "checkbox"){
			return $(element).prop("checked");
		}else{
			return $(element).val() ? true : false;
		}
	}
	
	return {
		init: function(){
			attachEvents();
		}
	};
}());