var Users = (function(){
	var options;
	
	function attachEvents(){
		/* Filtry na liście klientów */
		$("[data-type=users-list-search-form]").on("submit.user-list", function(e){
			submitFilterForm(e, this);
		});
		
		$("[data-type=users-list-search-form]").on("mouseenter", "label", function(){
			var $this = $(this);
			
			if (this.offsetWidth < this.scrollWidth && !$this.attr("title")){
				$this.tooltip({
					title: $this.text(),
					placement: "top"
				});
				
				$this.tooltip("show");
			}
		});
	}
	
	function initComponents(){
		if (options.initTabs != undefined && typeof options.initTabs == "function"){
			options.initTabs();
		}
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
		init: function(userOptions){
			options = $.extend({
				initTabs: false
			}, userOptions);
			
			attachEvents();
			initComponents();
		}
	};
}());