function OrderFormUnlogged(userOptions){
	this.options = $.extend({
		form                  : null,
		vatAddress            : null,
		shippingAddress       : null,
		onChangeHeightCallback: false,
		onStartActivateSubform: false,
		onEndActivateSubform  : false,
		errorMessageSelector  : "[data-type=ketchup-error-message].error-message",
		errorInputClass       : "form-error"
	}, userOptions);
	
	if (this.options.form.length == 0){
		return false;
	}
	
	this.options.vatAddress = new AddressForm({
		form                  : this.options.form,
		container             : $("[data-type=vat-address]"),
		onChangeHeightCallback: this.options.onChangeHeightCallback
	});
	
	this.options.shippingAddress = new AddressForm({
		form                  : this.options.form,
		container             : $("[data-type=shipping-address]"),
		onChangeHeightCallback: this.options.onChangeHeightCallback
	});
	changePhonePrefix($('select[data-type=country]').val(), $('input[data-type=phone]'));
	this.attachEvents();
	
	$("#OrderFormUnlogged").ketchup();
}

OrderFormUnlogged.prototype = new Form();

OrderFormUnlogged.prototype.attachEvents = function(){
	var self = this;
	
	$("[data-type=toggle-register-user]").on("change.orderform.unlogged", function(){
		self.triggerStartActivateForm();
		
		var container = $("[data-type=register-user]");
		
		if ($(this).prop("checked")){
			container.removeClass("hide");
			self.addValidationEvents($("input", container));
			
			$("[data-type=loyalty-user]").removeClass("hide");
			$("[data-type=loyalty-user] input").prop("disabled", false).trigger("toggle-disabled");
		}else{
			container.addClass("hide");
			self.removeValidationEvents($("input", container));
			
			$("[data-type=loyalty-user]").addClass("hide");
			$("[data-type=loyalty-user] input").prop("disabled", true).trigger("toggle-disabled");
		}
		
		self.reinitFormValidation();
		self.triggerChangeHeightCallback();
		self.triggerEndActivateForm();
	});
	
	$("[data-type=toggle-shipping-address]").on("change.orderform.unlogged", function(){
		self.triggerStartActivateForm();
		
		if ($(this).prop("checked")){
			self.options.shippingAddress.show();
			self.options.shippingAddress.enable();
			self.options.shippingAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=shippingaddress]:checked").val());
		}else{
			self.options.shippingAddress.hide();
			self.options.shippingAddress.disable();
		}
		
		self.reinitFormValidation();
		self.triggerChangeHeightCallback();
		self.triggerEndActivateForm();
	});
	
	/* Sprawdzenie adresu e-mail */
	$("[data-type=new-user-email]").on("change.email", function(){
		if ($(this).val() != ""){
			var form = $("<form>", {
				"method": "POST",
				"action": url_users_check_email
			});
			
			$("<input>", {
				"type": "hidden",
				"name": "data[User][email]"
			}).val($(this).val()).appendTo(form);
			
			$.post(
				App.getAjaxUrl(url_users_check_email),
				form.serialize(),
				function(response){
					$(response).modal();
				}
			);
		}
	});
};