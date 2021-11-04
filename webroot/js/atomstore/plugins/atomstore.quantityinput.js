(function($){
	"use strict";
	
	var QuantityInput = function(element){
		this.element = $(element);
		
		this.options = {
			precision   : parseInt(this.element.attr("data-precision")),
			min         : this.element.attr("data-min") || (parseFloat(this.element.attr("data-step")) || 1),
			max         : parseFloat(this.element.attr("data-max")) || false,
			showControls: parseInt(this.element.attr("data-show-controls")) || 0,
			unit        : this.element.attr("data-unit") || false,
			trigger     : this.element.attr("data-trigger") || false,
			multiplier  : 1000000
		};
		
		if (!this.element.data("quantity-input-done")){
			var self = this;
			
			this.element.on("change.quantity-input", function(){
				self.changeQuantity(false);
			});
			
			if (this.options.unit){
				var unit = $("<span>", {
					"class": "quantity-unit",
				}).text(this.options.unit);
				
				this.element.after(unit);
			}
			
			if (this.options.showControls){
				var quantityUp = $("<a>", {
					"class": "quantity-control add",
					"href" : "#"
				}).on("click.quantity-input", function(e){
					e.preventDefault();
					self.changeQuantity("add");
				});
				
				var quantityDown = $("<a>", {
					"class": "quantity-control subtract",
					"href" : "#"
				}).on("click.quantity-input", function(e){
					e.preventDefault();
					self.changeQuantity("subtract");
				});
				
				var quantityControls = $("<span>", {
					"class": "quantity-controls",
				});
				
				$(quantityControls).append(quantityDown);
				$(quantityControls).append(quantityUp);
				
				
				this.element.after(quantityControls);
			}
			
			this.element.data("quantity-input-done", true);
		}
	};
	
	QuantityInput.prototype.changeQuantity = function(modifier){
		if (!this.element.prop("disabled")){
			var step  = parseFloat(this.element.attr("data-step")) || 1;
			var value = parseFloat(this.element.val().replace(",", "."));
			
			if (modifier){
				switch (modifier){
					case "add":
						value = value + step;
						
						break;
					case "subtract":
						value = value - step;
						
						break;
				}
			}
			
			this.element.val(this.validate(value, step).replace(".", ","));
			
			if (this.options.trigger){
				this.element.trigger(this.options.trigger);
			}
		}
	};
	
	QuantityInput.prototype.validate = function(value, step){
		if (value < this.options.min || isNaN(value)){
			value = this.options.min;
		}
		
		if (step){
			/* Sprawdzenie precyzji */
			if (this.modulo(value, step) != 0){
				var value_step = 1 / (Math.pow(10, this.options.precision));
				
				while (this.modulo(value, step) != 0){
					value = parseFloat((value + value_step).toFixed(this.options.precision));
					
					if (this.options.max){
						/* Przekroczenie maksymalnego stanu */
						if (value >= this.options.max){
							break;
						}
					}
				}
			}
		}
		
		if (this.options.max){
			if (value > this.options.max){
				value = this.options.max;
			}
		}
		
		if (this.options.precision){
			value = value.toFixed(this.options.precision);
		}
		
		return value.toString();
	};
	
	QuantityInput.prototype.modulo = function(x, y){
		return ((x.toFixed(this.options.precision) * this.options.multiplier) % (y.toFixed(this.options.precision) * this.options.multiplier) / this.options.multiplier).toFixed(this.options.precision);
	};
	
	$.fn.quantityInput = function(){
		return this.each(function(i, element){
			return new QuantityInput(element);
		});
	}
})(jQuery);