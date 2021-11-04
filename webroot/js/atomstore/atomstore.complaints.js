var Complaints = (function(){
	function attachEvents(){
		/* Filtry na liście reklamacji */
		$("[data-type=complaints-list-search-form]").on("submit.order-list", function(e){
			submitFilterForm(e, this);
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