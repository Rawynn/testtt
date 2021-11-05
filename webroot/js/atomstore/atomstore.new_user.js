function NewUser(userOptions){
	this.options = $.extend({
		form                  : null,
		userAddress           : null,
		shippingAddress       : null,
		onChangeHeightCallback: false,
		onStartActivateSubform: false,
		onEndActivateSubform  : false,
		onChangeAddress       : false,
		errorMessageSelector  : "[data-type=ketchup-error-message].error-message",
		errorInputClass       : "form-error"
	}, userOptions);
	
	if (this.options.form.length == 0){
		return false;
	}
	
	this.options.userAddress = new AddressForm({
		form                  : this.options.form,
		container             : $("[data-type=new-user-address]"),
		onChangeHeightCallback: this.options.onChangeHeightCallback
	});
	
	this.options.shippingAddress = new AddressForm({
		form                  : this.options.form,
		container             : $("[data-type=new-shipping-address]"),
		onChangeHeightCallback: this.options.onChangeHeightCallback
	});
	
	this.attachEvents();
}

NewUser.prototype = new Form();

NewUser.prototype.attachEvents = function(){
	var self = this;
	
	$("[data-type=user-add-register-toggle]").on("change.user", function(){
		var value = $(this).val();
		
		if (value == 1){
			$("[data-type=user-add-password-row]").removeClass("hide");
			
			$("[data-type=user-add-password-input]").each(function(){
				var self = $(this);
				
				self.attr("data-validate", self.attr("data-validate-pattern"));
			});
		}else if (value == 0){
			$("[data-type=user-add-password-row]").addClass("hide");
			
			$("[data-type=user-add-password-input]").each(function(){
				var self = $(this);
				
				self.attr("data-validate", "");
			});
		}
		
		$("#UserAddForm").ketchup();
	});
	
	/* Po wyborze użytkownika w autocompleterze */
	$("[data-type=new-user-form] [data-type=new-user-autocompleter]").on("select-user", function(event, ui){
		var item = ui.ui_.item;
		
		if (item.b2b_lead_id > 0){
			/* B2B Lead */
			$("[data-type=new-user-b2b-lead-id]").val(item.b2b_lead_id);
			$("[data-type=new-user-user-address-id]").val(item.user_address_id);
			
			$("#UserFirstName").val(item.firstname).trigger("change");
			$("#UserLastName").val(item.lastname).trigger("change");
			$("#UserCompanyName").val(item.company).trigger("change");
			$("#UserPhone").val(item.phone).trigger("change");
			$("#UserEmail, #UserEmail2").val(item.email).trigger("change");
			
			$("#UserAddressNip").val(item.nip).trigger("change");
			$("#UserAddressStreet").val(item.street).trigger("change");
			$("#UserAddressStreetNumber1").val(item.street_number_1).trigger("change");
			$("#UserAddressStreetNumber2").val(item.street_number_2).trigger("change");
			$("#UserAddressPostcode").val(item.postcode).trigger("change");
			$("#UserAddressCity").val(item.city).trigger("change");
			$("#UserAddressCountryId").val(item.country_id).trigger("change");
			$("[data-type=state]").val(item.state_id).trigger("change");
		}else if (item.id > 0){
			$("[data-type=new-user-b2b-lead-id]").val(0);
			$("[data-type=new-user-user-address-id]").val(0);
			
			$.get(
				App.getAjaxUrl(url_salesreps_select_user + "/" + item.id),
				function (response){
					$(response).modal();
				}
			);
		}
		
		return false;
	});
	
	/* Adres do wysyłki */
	$("[data-type=toggle-different-shipping]").on("change.shipping_address", function(){
		self.triggerStartActivateForm();
		
		var checked = $(this).prop("checked");
		
		if (checked){
			$("[data-type=new-shipping-address]").removeClass("hide");
			
			self.options.shippingAddress.enable();
			self.options.shippingAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=shippingaddress]:checked").val());
		}else{
			$("[data-type=new-shipping-address]").addClass("hide");
			
			self.options.shippingAddress.disable();
		}
		
		self.reinitFormValidation();
		self.triggerEndActivateForm();
	});
}