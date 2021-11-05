function AddressForm(userOptions){
	this.options = $.extend({
		form                  : null,
		container             : null,
		autoCheckNipRow       : false,
		onChangeHeightCallback: false,
		rowSelector           : ".form-row",
		errorMessageSelector  : "[data-type=ketchup-error-message].error-message",
		errorInputClass       : "invalid",
		rowErrorInputClass    : "invalid-row"
	}, userOptions);
	
	if (this.options.container.length == 0 && this.options.form.length == 0){
		return false;
	}
	
	if (this.options.autoCheckNipRow){
		this.toggleNipRow($("[data-type=invoice]", this.options.container).prop("checked"));
	}
	
	this.attachEvents();
}

AddressForm.prototype = new Form();

AddressForm.prototype.attachEvents = function(){
	var self = this;
	
	$("[data-type=invoice]", this.options.container).on("change.address-form", function(){
		self.toggleNipRow($(this).prop("checked"));
	});
	
	$("[data-type=selected-user-type]", this.options.container).on("change.address-form", function(){
		self.toggleSelectedUserType($(this).val());
		self.checkNameCompanyValidation($(this).val());
	});
	
	$("[data-type=country]", this.options.container).on("change.address-form", function(){
		self.changeCountry($(this).val(), this);
	});
	
	$("[data-type=scroll-to-login-page]").click(function(){
		$("html, body").animate({
			scrollTop: $("[data-type=scroll-login-page]").offset().top
		}, 500);
	});
	
	/* Dodanie walidacji na pozostałe pola, jeśli w panelu jest wybrana faktura na życzenie */
	$("[data-type=add-vat]", this.options.container).on("change.address-form", function(){
		self.changeValidateAddressToVat($(this).is(":checked"));
		if($(this).is(":checked")){
			$('#UserAddressSelectUserTypeF').trigger('click');
			$('#VatAddressSelectUserTypeF').trigger('click');
		}
		else{
			$('#UserAddressSelectUserTypeP').trigger('click');
			$('#VatAddressSelectUserTypeP').trigger('click');
		}
	});
	
	if ($("[data-type=add-vat]:checkbox", this.options.container).is(":enabled")){
		$("[data-type=add-vat]", this.options.container).trigger("change.address-form");
	}
};

AddressForm.prototype.changeValidateAddressToVat = function(checked){
	if ($("[data-validate-vat=false]").length > 0){
		if (checked){
			$("[data-validate-vat=false]", this.options.container).attr("data-validate-pattern", "validate(required)");
			$("[data-validate-vat=false]", this.options.container).attr("data-validate", "validate(required)");
		}else{
			$("[data-validate-vat=false]", this.options.container).attr("data-validate-pattern", "");
			$("[data-validate-vat=false]", this.options.container).attr("data-validate", "");
		}
		
		this.reinitFormValidation();
		this.triggerChangeHeightCallback();
	}
};

AddressForm.prototype.toggleNipRow = function(checked){
	if (checked){
		$("[data-type=nip-row]", this.options.container).removeClass("hide");
		$("[data-type=nip]", this.options.container).prop("disabled", false);
	}else{
		$("[data-type=nip-row]", this.options.container).addClass("hide");
		$("[data-type=nip]", this.options.container).prop("disabled", true);
	}
	
	this.triggerChangeHeightCallback();
};

AddressForm.prototype.toggleSelectedUserType = function(value){
	var vat_input = $("[data-type=add-vat]", this.options.container);
	
	switch (value){
		/* Osoba prywatna */
		case "p":
			$("[data-type=company-row], [data-type=nip-row]", this.options.container).addClass("hide");
			$("[data-type=company], [data-type=nip]", this.options.container).prop("disabled", true);
			
			$("[data-type=firstname-row], [data-type=lastname-row]", this.options.container).removeClass("hide");
			$("[data-type=firstname], [data-type=lastname]", this.options.container).prop("disabled", false);
			
			if (vat_input.length > 0){
				/*vat_input.prev().removeClass("checked");
				vat_input.prop("checked", false);*/
				vat_input.prop("disabled", false).trigger("toggle-disabled");
				
				$("[data-type=add-vat-hidden]", this.options.container).remove();
				
				if (!$("[data-type=add-vat]", this.options.container).is(":checked")){
					this.changeValidateAddressToVat(false);
				}else{
					this.changeValidateAddressToVat(true);
				}
			}
			
			break;
		
		/* Firma */
		case "f":
			$("[data-type=company-row], [data-type=nip-row]", this.options.container).removeClass("hide");
			$("[data-type=company], [data-type=nip]", this.options.container).prop("disabled", false);
			
			$("[data-type=firstname-row], [data-type=lastname-row]", this.options.container).addClass("hide");
			$("[data-type=firstname], [data-type=lastname]", this.options.container).prop("disabled", true);
			
			this.changeValidateAddressToVat(true);
			
			if (vat_input.length > 0){
				vat_input.prop("checked", true).prev().addClass("checked");
				vat_input.prop("checked", true);
				//vat_input.prop("disabled", true).trigger("toggle-disabled");
				
				$("<input>", {
					"type"      : "hidden",
					"data-type" : "add-vat-hidden",
					"name"      : vat_input.attr("name")
				}).val(1).appendTo(this.options.container);
			}
			
			break;
		
		this.triggerChangeHeightCallback();
	}
};

AddressForm.prototype.checkNameCompanyValidation = function(value){
	if (value == "p"){
		value = false;
	}else{
		value = true;
	}
	
	if (value){
		this.toggleNameValidation(false);
		this.toggleCompanyValidation(true);
	}else{
		this.toggleNameValidation(true);
		this.toggleCompanyValidation(false);
	}
	
	this.reinitFormValidation();
};

AddressForm.prototype.toggleNameValidation = function(validate){
	if (validate){
		$("[data-type=firstname], [data-type=lastname]", this.options.container).attr("data-validate", $("[data-type=firstname], [data-type=lastname]").attr("data-validate-pattern"));
	}else{
		this.removeValidationEvents($("[data-type=firstname], [data-type=lastname]", this.options.container));
	}
};

AddressForm.prototype.toggleCompanyValidation = function(validate){
	if (validate){
		$("[data-type=company], [data-type=nip]", this.options.container).attr("data-validate", $("[data-type=company], [data-type=nip]").attr("data-validate-pattern"));
	}else{
		this.removeValidationEvents($("[data-type=company], [data-type=nip]", this.options.container));
	}
};

AddressForm.prototype.changeCountry = function(countryId, select){
	if (!$(select).prop("disabled")){
		$("[data-state-id]", this.options.container).addClass("hide");
		$("[data-state-id] select", this.options.container).prop("disabled", true).trigger("toggle-disabled");
		
		$("[data-state-id=" + countryId + "]", this.options.container).removeClass("hide");
		
		if ($("[data-state-id=" + countryId + "] select option", this.options.container).length > 1){
			$("[data-state-id=" + countryId + "] select", this.options.container).prop("disabled", false).trigger("toggle-disabled");
		}
		
		/* Obsługa kodu pocztowego */
		if ($("[data-type=postcode]", this.options.container).length >= 1){
			var codesList = JSON.parse($(select).attr("data-codes-list"));
			
			$("[data-type=postcode]", this.options.container).each(function(){
				$(this).attr("data-validate", $(this).attr("data-validate-pattern").replace("{code}", codesList[countryId]));
			});
			
			this.reinitFormValidation();
		}
	}
};

AddressForm.prototype.show = function(){
	this.options.container.removeClass("hide");
};

AddressForm.prototype.hide = function(){
	this.options.container.addClass("hide");
};

AddressForm.prototype.enable = function(){
	$("input, select, checkbox, radio", this.options.container).prop("disabled", false).trigger("toggle-disabled");
	this.addValidationEvents($("input, select, checkbox, radio", this.options.container));
	
	/* Dodatkowo kraj (dla kodów pocztowych) */
	$("[data-type=country]", this.options.container).trigger("change.address-form");
};

AddressForm.prototype.disable = function(){
	$("input, select, checkbox, radio", this.options.container).prop("disabled", true).trigger("toggle-disabled");
	this.removeValidationEvents($("input, select, checkbox, radio", this.options.container).not("[data-type=select-search-input]"));
};