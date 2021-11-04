(function($){
	"use strict";
	
	/* Radio */
	$.fn.radio = function(){
		return this.each(function(){
			if (!$(this).hasClass("transform-hide")){
				var self = $(this);
				
				var transformWrap  = $("<span>", {
					"class": "transform-radio-wrapper transform-wrapper"
				});
				
				var transformInput = $("<a>", {
					"class": "transform-radio transform-input",
					"href" : "#"
				});
				
				transformInput.addClass(self.attr("class"));
				
				if (self.attr("data-img")){
					/* Radio obrazki - dla banków w koszyku */
					transformInput.addClass("transform-radio-img").attr("title", self.attr("data-name")).append(
						$("<img>", {
							"src"  : self.attr("data-img"),
							"title": self.attr("data-name")
						})
					);
					
					transformWrap.addClass("transform-radio-img-wrapper");
					
					/* Chowam etykietę */
					var next = self.next();
					
					if (next.is("label") && next.attr("for") == self.attr("id")){
						next.addClass("hide");
					}
				}
				
				self.addClass("transform-hide").wrap(transformWrap).parent().prepend(transformInput);
				
				self.on("update-state", function(){
					self.prop("checked") && transformInput.addClass("checked") || transformInput.removeClass("checked");
				});
				
				self.on("toggle-disabled", function(){
					self.prop("disabled") && transformInput.parent().addClass("disabled") || transformInput.parent().removeClass("disabled");
				});
				
				self.on("change", function(){
					$("input[name=\"" + $(this).attr("name") + "\"]", self.form).each(function(){
						$(this).attr("type") == "radio" && $(this).trigger("update-state");
					});
				});
				
				transformInput.on("click", function(e){
					e.preventDefault();
					
					if (!self.prop("disabled")){
						self.trigger("click");
						
						$("input[name=\"" + self.attr("name") + "\"]", self.form).not(self).each(function(){
							$(this).attr("type") == "radio" && $(this).trigger("update-state");
						});
					}
				});
				
				self.trigger("update-state");
				self.trigger("toggle-disabled");
			}
		});
	};
	
	/* Checkboxes */
	$.fn.checkbox = function(){
		return this.each(function(){
			if (!$(this).hasClass("transform-hide")){
				var self = $(this);
				
				var transformWrap  = $("<span>", {
					"class": "transform-checkbox-wrapper transform-wrapper"
				});
				
				var transformInput = $("<a>", {
					"class": "transform-checkbox transform-input",
					"href" : "#"
				});
				
				transformInput.addClass(self.attr("class"));
				
				self.addClass("transform-hide").wrap(transformWrap).parent().prepend(transformInput);
				
				self.on("update-state", function(){
					self.prop("checked") && transformInput.addClass("checked") || transformInput.removeClass("checked");
				});
				
				self.on("toggle-disabled", function(){
					self.prop("disabled") && transformInput.parent().addClass("disabled") || transformInput.parent().removeClass("disabled");
				});
				
				self.on("change", function(){
					self.trigger("update-state");
				});
				
				transformInput.on("click", function(e){
					e.preventDefault();
					
					if (!self.prop("disabled")){
						self.trigger("click");
					}
				});
				
				self.trigger("update-state");
				self.trigger("toggle-disabled");
			}
		});
	};
	
	/* Select */
	$.fn.select = function(){
		return this.each(function(index){
			if (!$(this).hasClass("transform-hide")){
				var self  = this;
				var $self = $(self);
				
				var transformList = $("<ul>", {
					"class": "transform-select-list"
				});
				
				var transformInput = $("<div>", {
					"class": "transform-select transform-input"
				}).append(
					$("<span>", {
						"class": "transform-value"
					})
				).append(
					$("<a>", {
						"class": "transform-open",
						"href" : "#"
					})
				);
				
				var transformWrap  = $("<div>", {
					"class": "transform-select-wrapper transform-wrapper"
				});
				
				transformInput.addClass($self.attr("class"));
				
				$self.addClass("transform-hide");
				
				var tranformSearchBox;
				
				if ($("option", this).length > 8){
					tranformSearchBox = $("<div>", {
						"class": "transform-search-box"
					}).append(
						$("<input>", {
							"type"       : "text",
							"placeholder": App.getSetting("search-label"),
							"class"      : "form-control disable-on-submit",
							"data-type"  : "select-search-input"
						}).on("keydown", function(event){
							if (event.which == 13){
								/* Enter */
								event.preventDefault();
								
								return false;
							}
						}).on("keyup", function(event){
							if (event.which == 13){
								/* Enter */
								event.preventDefault();
								
								return false;
							}
							
							if ($(this).val() != ""){
								var pattern = $.trim($(this).val().toLowerCase());
								
								if (pattern.indexOf(App.getSetting("select-search-pattern")) == -1){
									$("li", transformList).show();
								}
								
								$("li:visible", transformList).each(function(){
									var self = $(this);
									
									if (self.children(":first").attr("data-value").toLowerCase().indexOf(pattern) == -1){
										self.hide();
									}
								});
								
								App.setSetting("select-search-pattern", pattern);
							}else{
								$("li", transformList).show();
								App.setSetting("select-search-pattern", "");
							}
						}).on("change", function(e){
							e.stopPropagation();
							
							return false;
						})
					);
					
					transformList.addClass("transform-search-box-true");
				}
				
				$self.wrap(transformWrap).parent().append(transformInput).append(tranformSearchBox).append(transformList);
				
				$self.on("update-state", function(){
					transformList.empty();
					
					$("option", this).each(function(i){
						var element;
						
						if ($(this).prop("disabled")){
							element = $("<span>", {
								"data-index": i,
								"data-value": $(this).html()
							}).html($(this).html());
						}else{
							element = $("<a>", {
								"data-index": i,
								"href"      : "#",
								"class"     : !$(this).val() ? "empty" : "",
								"data-value": $(this).html()
							}).html($(this).html());
						}
						
						transformList.append(
							$("<li>").append(element)
						);
					});
					
					var index = this.selectedIndex;
					var value = $("a[data-index=" + index + "]", transformList);
					
					$("a", transformList).removeClass("selected");
					
					value.addClass("selected");
					
					$(".transform-value", transformInput).html(value.html());
				});
				
				$self.on("toggle-disabled", function(){
					$self.prop("disabled") && transformInput.parent().addClass("disabled") || transformInput.parent().removeClass("disabled");
				});
				
				$self.on("close", function(){
					transformList.removeClass("open");
					transformList.parent().find(".transform-search-box").removeClass("open").find(".form-control").val("");
					
					App.setSetting("select-search-pattern", "");
				});
				
				$self.on("change", function(){
					$self.trigger("update-state");
				});
				
				transformList.on("click", "a", function(e){
					e.preventDefault();
					
					if (self.selectedIndex != $(this).attr("data-index")){
						self.selectedIndex = $(this).attr("data-index");
						
						$self.trigger("change");
					}
					
					transformList.removeClass("open");
					transformList.parent().find(".transform-search-box").removeClass("open").find(".form-control").val("");
					
					App.setSetting("select-search-pattern", "");
				});
				
				transformInput.on("click", ".transform-open, .transform-value", function(e){
					e.preventDefault();
					
					if (!$self.prop("disabled")){
						if (!transformList.hasClass("open")){
							transformList.addClass("open").find("li").show();
							transformList.parent().find(".transform-search-box").addClass("open");
							transformList.parent().find(".transform-search-box").find(".form-control").focus().removeClass("disabled").prop("disabled", false);
							
							var selected = $("a.selected", transformList).parent();
							
							if (selected.length){
								transformList.scrollTop(selected.position().top + transformList.scrollTop() - selected.prev().outerHeight(true));
							}
						}else{
							transformList.removeClass("open");
							transformList.parent().find(".transform-search-box").removeClass("open").find(".form-control").val("");
							
							App.setSetting("select-search-pattern", "");
						}
					}
				});
				
				$self.trigger("update-state");
				$self.trigger("toggle-disabled");
			}
		});
	};
	$.fn.transform = function(){
		$("input:checkbox", this).checkbox();
		$("input:radio", this).radio();
		$("select:not([multiple])", this).select();
		
		$("form", this).on("reset", function(){
			var self = this;
			
			setTimeout(function(){
				$("input:checkbox, input:radio, select:not([multiple])", self).trigger("update-state");
			}, 1);
		});
		
		$(document).off("mousedown.transform");
		
		$(document).on("mousedown.transform", function(e){
			$(".transform-select-wrapper").not($(e.target).parents(".transform-select-wrapper")).find("select").trigger("close");
		});
	};
})(jQuery);