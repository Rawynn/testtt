function Form(){};

Form.prototype.addValidationEvents = function(elements){
	$(elements).each(function(i, element){
		$(element).attr("data-validate", $(element).attr("data-validate-pattern"));
	});
};

Form.prototype.removeValidationEvents = function(elements){
	$(elements).off("blur").off("focus").off("keyup").off("change.ketchup").removeClass(this.options.errorInputClass).removeAttr("data-validate");
	
	$(elements).parents(this.options.rowSelector).removeClass(this.options.rowErrorInputClass);
};

Form.prototype.reinitFormValidation = function(){
	$(this.options.errorMessageSelector, this.options.form).hide();
	
	$("input, select, checkbox, radio", this.options.form).removeClass(this.options.errorInputClass);
	$("input, select, checkbox, radio", this.options.form).parents(this.options.rowSelector).removeClass(this.options.rowErrorInputClass);
	
	$(this.options.form).off("submit");
	$(this.options.form).ketchup();
	
	if (this.options.form.attr("data-submit") == "once"){
		this.options.form.on("submit.form", function(e){
			if ($(this).ketchup("isValid") == null || $(this).ketchup("isValid")){
				$("input[type=submit]:not([data-submit=no-disable]), .form-submit, .disable-on-submit", this).addClass("disabled").prop("disabled", true);
			}
		});
	}
};

Form.prototype.triggerChangeHeightCallback = function(){
	if (this.options.onChangeHeightCallback && typeof this.options.onChangeHeightCallback === "function"){
		this.options.onChangeHeightCallback(this);
	}
};

Form.prototype.triggerStartActivateForm = function(){
	if (this.options.onStartActivateSubform && typeof this.options.onStartActivateSubform === "function"){
		this.options.onStartActivateSubform(this);
	}
};

Form.prototype.triggerEndActivateForm = function(){
	if (this.options.onEndActivateSubform && typeof this.options.onEndActivateSubform === "function"){
		this.options.onEndActivateSubform(this);
	}
};