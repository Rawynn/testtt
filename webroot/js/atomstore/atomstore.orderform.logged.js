function OrderFormLogged(userOptions){
	this.options = $.extend({
		form                  : null,
		vatAddress            : null,
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
	
	this.options.vatAddress = new AddressForm({
		form                  : this.options.form,
		container             : $("[data-type=new-vat-address]"),
		onChangeHeightCallback: this.options.onChangeHeightCallback
	});
	
	this.options.shippingAddress = new AddressForm({
		form                  : this.options.form,
		container             : $("[data-type=new-shipping-address]"),
		onChangeHeightCallback: this.options.onChangeHeightCallback
	});
	
	this.attachEvents();
	this.updateTitle();
}

OrderFormLogged.prototype = new Form();

OrderFormLogged.prototype.attachEvents = function(){
	var self = this;
	
	/* Adres do faktury/rachunku */
	$("[data-type=change-vat-address]").on("click.orderform.logged", function(e){
		e.preventDefault();
		
		self.changeVatAddress($(this).attr("data-address-id"));
		self.triggerChangeAddress();
	});
	
	$("[data-type=vat-address-invoice-container]").on(
		"change.orderform.logged", "[data-type=change-vat-address-invoice]",
		function(){
			self.toggleInvoice($(this).prop("checked"));
		}
	);
	
	$("[data-type=toggle-new-vat-address]").on("change.orderform.logged", function(){
		self.toggleNewVatAddressForm($(this).prop("checked"));
	});
	
	/* Adres do wysyłki */
	$("[data-type=toggle-different-shipping]").on("change.orderform.logged", function(){
		self.toggleDifferentShipping($(this).prop("checked"));
	});
	
	$("[data-type=shipping-addresses-container]").on(
		"click.orderform.logged", "[data-type=change-shipping-address]",
		function(e){
			e.preventDefault();
			
			self.changeShippingAddress($(this).attr("data-address-id"));
			self.triggerChangeAddress();
		}
	);
	
	$("[data-type=toggle-new-shipping-address]").on("change.orderform.logged", function(){
		self.toggleNewShippingAddressForm($(this).prop("checked"));
	});
	
	/* Pobranie danych z GUS */
	$("[data-type=nip][data-gus=true]").unbind("change.nip").on("change.nip", function(){
		var self = $(this);
		
		$.get(
			url_gus_get_raport + "?nip=" + $(this).val(),
			function (json){
				console.log(json);
				var prefix = self.attr("data-prefix");
				console.log(prefix);
				for (x in json){
//					if ($("[data-type=" + x + "][data-prefix=" + prefix + "]").val() == ""){
						$("[data-type=" + x + "][data-prefix=" + prefix + "]").val();
						$("[data-type=" + x + "][data-prefix=" + prefix + "]").val(json[x]);
//					}
				}
			}
		);
		
		self.addClass('gus-loader');
		
		setTimeout(function(){
			self.removeClass('gus-loader');
		}, 2000);
	});

	/* Sprawdzenie ostatniego zamówienia - #17126 */
	self.addCheckUserValidation();
};

OrderFormLogged.prototype.changeVatAddress = function(id){
	var self = this;
	
	$("[data-type=selected-vat-address]").val(id);
	$("[data-type=vat-address]").addClass("hide");
	$("[data-type=vat-address][data-address-id=" + id + "]").removeClass("hide");
	
	$.post(
		App.getAjaxUrl(url_user_carts_change_main_address + "/" + id + "/" + $("[data-type=selected-shipping-address]").val()),
		this.options.form.serialize(),
		function(data){
			var data = $.parseJSON(data);
			
			if (data.invoice != undefined){
				$("[data-type=vat-address-invoice-container]").html(data.invoice);
			}
			
			if (data.shipping != undefined){
				$("[data-type=shipping-addresses-container]").html(data.shipping);
			}
			
			$("[data-type=selected-shipping-address]").val(data.current_shipping_address);
			
			if (data.current_shipping_address != data.current_vat_address){
				self.toggleDifferentShipping(true);
				
				if ($("[data-type=toggle-new-shipping-address]").prop("checked")){
					self.toggleShippingAddress(true);
				}
			}else{
				if ($("[data-type=toggle-new-shipping-address]").prop("checked")){
					self.toggleDifferentShipping(true);
				}else{
					self.toggleDifferentShipping(false);
				}
			}
		}
	);
	
	this.triggerChangeHeightCallback();
	this.toggleNewVatAddressForm(false);
};

OrderFormLogged.prototype.toggleVatAddress = function(value){
	if (value){
		$("[data-type=vat-address] address").addClass("disabled");
		
		$("[data-type=vat-address-invoice-container]").addClass("disabled");
		$("[data-type=change-vat-address-invoice]").prop("disabled", true).trigger("toggle-disabled");
		$("[data-type=vat-address-invoice]").prop("disabled", true);
		
		$("[data-type=selected-user-type][data-prefix=vataddress]:checked").trigger("change.address-form");
		
	}else{
		$("[data-type=vat-address] address").removeClass("disabled");
		
		$("[data-type=vat-address-invoice-container]").removeClass("disabled");
		$("[data-type=change-vat-address-invoice]").prop("disabled", false).trigger("toggle-disabled");
		$("[data-type=vat-address-invoice]").prop("disabled", false);
	}
};

OrderFormLogged.prototype.toggleInvoice = function(value){
	if (value){
		$("[data-type=vat-address-invoice-toggle]").removeClass("hide");
		var options = {
			'translation': {
				Z: {pattern: /[A-Za-z0-9]/}
			},
			onInvalid: function(val, e, f, invalid, options){
				var error = invalid[0];

				if ($("[data-type=vat-address-invoice-toggle]").find(".nip-info").length == 0){
					$("[data-type=vat-address-invoice-toggle]").append("<div class='nip-info'>Poprawny format nr NIP to: 5482643867 lub PL5482643867</div>");
				}
			}
		};
	
		$("[data-type=vat-address-invoice-toggle] input").mask('ZZ000000000000000', options);
	}else{
		$("[data-type=vat-address-invoice-toggle]").addClass("hide");
	}
	
	this.triggerChangeHeightCallback();
	this.updateTitle();
};

OrderFormLogged.prototype.toggleNewVatAddressForm = function(value){
	$("[data-type=toggle-new-vat-address]").prop("checked", value).trigger("update-state");
	
	this.triggerStartActivateForm();
	
	if (value){
		$("[data-type=new-vat-address]").addClass("mobile-show");
		this.options.vatAddress.enable();
		this.options.vatAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=vataddress]:checked").val());
		this.toggleVatAddress(true);
	}else{
		$("[data-type=new-vat-address]").removeClass("mobile-show");
		this.options.vatAddress.disable();
		this.toggleVatAddress(false);
	}
	
	this.reinitFormValidation();
	this.updateTitle();
	this.triggerEndActivateForm();
	
	/* Sprawdzenie ostatniego zamówienia - #17126 */
	this.addCheckUserValidation();
};

OrderFormLogged.prototype.toggleDifferentShipping = function(value){
	this.triggerStartActivateForm();
	
	$("[data-type=toggle-different-shipping]").prop("checked", value).trigger("update-state");
	
	var toggleNewShipping = false;
	
	if ($("[type=hidden][data-type=toggle-new-shipping-address]").val()){
		toggleNewShipping = true;
	}
	
	if ($("[data-type=shipping-address]:visible").length == 0){
		toggleNewShipping = true;
	}
	
	if (value && toggleNewShipping){
		$("[data-type=toggle-new-shipping-address]").prop("checked", true).trigger("update-state").trigger("change.orderform.logged");
		$("[type=hidden][data-type=toggle-new-shipping-address]").val(1);
		
		this.options.shippingAddress.enable();
		this.options.shippingAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=shippingaddress]:checked").val());
	}else if (!value){
		$("[data-type=toggle-new-shipping-address]").prop("checked", false).trigger("update-state").trigger("change.orderform.logged");
		$("[type=hidden][data-type=toggle-new-shipping-address]").val(0);
		
		$("[data-type=shipping-address] address").addClass("disabled");
		
		this.options.shippingAddress.disable();
	}else if (value){
		$("[data-type=shipping-address] address").removeClass("disabled");
	}
	
	if (value){
		$("[data-type=toggle-new-shipping-address]").prop("disabled", false).trigger("toggle-disabled");
		$("[data-type=new-shipping-address]").addClass("mobile-show");
	}else{
		$("[data-type=toggle-new-shipping-address]").prop("disabled", true).trigger("toggle-disabled");
		$("[data-type=new-shipping-address]").removeClass("mobile-show");
	}
	
	this.reinitFormValidation();
	this.updateTitle();
	this.triggerEndActivateForm();
	
	/* Sprawdzenie ostatniego zamówienia - #17126 */
	this.addCheckUserValidation();
};

OrderFormLogged.prototype.changeShippingAddress = function(id){
	this.triggerStartActivateForm();
	
	$("[data-type=selected-shipping-address]").val(id);
	$("[data-type=shipping-address]").addClass("hide");
	$("[data-type=shipping-address][data-address-id=" + id + "]").removeClass("hide");
	
	$("[data-type=change-shipping-address-button]").text(
		$("[data-type=change-shipping-address-button]").attr("data-title")
	).removeClass("left").addClass("right");
	
	this.toggleDifferentShipping(true);
	this.toggleNewShippingAddressForm(false);
	
	this.triggerEndActivateForm();
};

OrderFormLogged.prototype.toggleShippingAddress = function(value){
	if (value){
		$("[data-type=shipping-address] address").addClass("disabled");
	}else{
		$("[data-type=shipping-address] address").removeClass("disabled");
	}
};

OrderFormLogged.prototype.toggleNewShippingAddressForm = function(value){
	$("[data-type=toggle-new-shipping-address]").prop("checked", value).trigger("update-state");
	
	this.triggerStartActivateForm();
	
	if (value){
		this.options.shippingAddress.enable();
		this.options.shippingAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=shippingaddress]:checked").val());
		this.toggleShippingAddress(true);
	}else{
		this.options.shippingAddress.disable();
		this.toggleShippingAddress(false);
	}
	
	this.reinitFormValidation();
	this.updateTitle();
	this.triggerEndActivateForm();
	
	/* Sprawdzenie ostatniego zamówienia - #17126 */
	this.addCheckUserValidation();
};

OrderFormLogged.prototype.updateTitle = function(){
	//TODO update titles
};

OrderFormLogged.prototype.triggerChangeAddress = function(){
	if (this.options.onChangeAddress && typeof this.options.onChangeAddress === "function"){
		this.options.onChangeAddress(this);
	}
};

OrderFormLogged.prototype.addCheckUserValidation = function(){
	/* Sprawdzenie ostatniego zamówienia - #17126 */
	if (App.getSetting("check-user-last-order") > 0){
		$("#OrderFormLogged").unbind("submit.check_user").on("submit.check_user", function(event){
			if ($("#OrderFormLogged").ketchup("isValid") === null || $("#OrderFormLogged").ketchup("isValid") === true){
				event.stopPropagation();
				
				$.get(
					App.getAjaxUrl(url_user_carts_check_last_order),
					function (response){
						if (response.message == "ok"){
							$("#OrderFormLogged").unbind("submit.check_user").submit();
						}else if (response.message == "error"){
							$("[data-type=check-last-order-warning-products]").html(response.products);
							
							$("[data-type=check-last-order-warning]").modal("show");
						}
					}
				);
				
				return false;
			}
		});
		
		$("[data-type=check-last-order-warning-confirmation]").unbind("click").on("click", function(){
			$("#OrderFormLogged").unbind("submit.check_user").submit();
			
			$(this).prop("disabled", true).addClass("disabled");
			
			return false;
		});
	}
}
