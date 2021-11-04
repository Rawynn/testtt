var Categories = (function(){
	var container;
	var options;
	
	function makeTree(targetContainer){
		if (options.isAjax){
			$("a", targetContainer).each(function(i, element){
				var $element = $(element);
				
				if (!parseInt($element.attr("data-category-leaf"))){
					if ($element.next().length){
						var ajaxToggle = $("<span>",{
							"class"        : "category-ajax-link active",
							"data-type"    : "category-toggle",
							"data-id"      : $element.attr("data-category-id"),
							"data-finished": "true",
							"href"         : "#"
						});
					}else{
						var ajaxToggle = $("<span>",{
							"class"        : "category-ajax-link",
							"data-type"    : "category-toggle",
							"data-id"      : $element.attr("data-category-id"),
							"data-finished": "false",
							"href"         : "#"
						});
					}
					
					$(element).append(ajaxToggle);
				}
			});
		}
	}
	
	function attachEvents(){
		container.on("click.categories", "[data-type=category-toggle]", function(e){
			e.stopPropagation();
			e.preventDefault();
			
			var self = $(this);
			
			if (self.attr("data-finished") == "false"){
				$.ajax({
					url    : App.getAjaxUrl(options.url),
					data   : {
						"category_id": self.attr("data-id")
					},
					type   : "POST",
					success: function(data){
						self.attr("data-finished", "true");
						self.addClass("active");
						
						self.parent().after(data);
						
						makeTree(self.parent().next());
					}
				});
			}else{
				self.toggleClass("active");
				self.parent().next().toggle();
			}
		});
	}
	
	return {
		init: function(userOptions){
			options = $.extend({
				isAjax : false,
				url    : ""
			}, userOptions);
			
			container = $("[data-type=categories-box]");
			
			makeTree(container);
			attachEvents();
		}
	};
}());