function Complaint(userOptions){
	this.options = $.extend({
		form           : null,
		shippingAddress: null,
		receiveAddress : null
	}, userOptions);
	
	if (this.options.form){
		this.options.shippingAddress = new AddressForm({
			form     : this.options.form,
			container: $("[data-type=shipping-address]")
		});
		
		this.options.receiveAddress = new AddressForm({
			form     : this.options.form,
			container: $("[data-type=receive-address]")
		});
	}
	
	this.attachEvents();
	
	/* Zmiana rodzaju */
	$("[data-type=complaint-kind-radio]:checked").trigger("click.complaint");
	
	/* Zmiana adresu doręczenia */
	$("[data-type=complaint-change-address]:checked").trigger("click.complaint");
	
	/* Zmiana adresu odbioru */
	$("[data-type=complaint-change-receive-address]:checked").trigger("click.complaint");
}

Complaint.prototype = new Form();

Complaint.prototype.attachEvents = function(){
	var self = this;
	
	/* Zmiana produktu */
	$("[data-type=complaint-product-radio]").unbind("click.complaint").on("click.complaint", function(){
		self.changeProduct(this);
	});
	
	/* Zmiana rodzaju */
	$("[data-type=complaint-kind-radio]").unbind("click.complaint").on("click.complaint", function(){
		self.changeKind(this);
	});
	
	/* Zmiana typu */
	$("[data-type=complaint-type]").unbind("click.complaint").on("click.complaint", function(){
		self.changeType(this);
	});
	
	/* Zmiana adresu doręczenia */
	$("[data-type=complaint-change-address]").unbind("click.complaint").on("click.complaint", function(){
		self.changeAddress(this);
	});
	
	/* Zmiana adresu odbioru */
	$("[data-type=complaint-change-receive-address]").unbind("click.complaint").on("click.complaint", function(){
		self.changeReceiveAddress(this);
	});
	
	/* Zmiana adresu */
	$("[data-type=complaint-change-address-submit]").unbind("click.complaint").on("click.complaint", function(){
		$("#ComplaintChangeAddressForm").submit();
		
		return false;
	});
	
	/* Wybór faktury */
	$("[data-type=invoice-number-autocompleter-container] [data-type=autocomplete]").on("autocomplete-select", function(e, ui){
		$("[data-type=complaint-order-id]").val(ui.ui_.item.order_id);
		
		$.ajax({
			url    : App.getAjaxUrl(url_invoices_select_invoice + "/" + ui.ui_.item.id),
			success: function(data){
				$("[data-type=complaint-add-products]").html(data.products);
				
				/* Zmiana produktu */
				$("[data-type=complaint-product-radio]").on("click.complaint", function(){
					self.changeProduct(this);
				});
				
				$("[data-type=complaint-product-radio]:checked").click();
			}
		});
	});
	
	/* Autocomplete produktu */
	$("[data-type=complaint-product-autocompleter-toggle] [data-type=autocomplete]").on("select-product", function(e, ui){
		var producer_id = parseInt(ui.ui_.item.producer_id);
		
		if (!isNaN(producer_id) && producer_id > 0){
			$("[data-type=complatins-producer-autocomplete-id]").val(producer_id);
			$("[data-type=complatins-producer-autocomplete-name]").val(ui.ui_.item.producer_name);
		}
	});
	
	/* Zmiana zamówienia */
	if ($("[data-type=complaint-order-id]").attr("data-user-id")){
		$("[data-type=complaint-order-id]").on("change.complaint", function(){
			$.ajax({
				url    : App.getAjaxUrl(url_complaints_change_order + "/" + $(this).val()),
				success: function(data){
					if (data.products){
						$("[data-type=complaint-add-products]").html(data.products);
						
						/* Zmiana produktu */
						$("[data-type=complaint-product-radio]").on("click.complaint", function(){
							self.changeProduct(this);
						});
						
						$("[data-type=complaint-product-radio]:checked").click();
					}
					
					if (data.receive_user_address){
						$("[data-type=receive-address-list]").html(data.receive_user_address);
					}
					
					if (data.user_address){
						$("[data-type=shipping-address-list]").html(data.user_address);
					}
					
					if (data.receive_user_address || data.user_address || data.order){
						var complaint = new Complaint({
							form: $("#ComplaintAddForm")
						});
						
						if (data.order.Order.shipping_user_address_id > 0){
							$("#ReceiveUserAddressId" + data.order.Order.shipping_user_address_id).click();
						}else{
							$("#ReceiveUserAddressIdNew").click();
						}
						
						$("#UserAddressIdReceive").click();
					}
				}
			});
		});
	}
	
	$("[data-type=complaint-product-radio]:checked").click();
	$("[data-type=complaint-kind-radio]:checked").click();
	$("[data-type=complaint-type-radio]:checked").click();
};

/* Zmiana produktu */
Complaint.prototype.changeProduct = function(el){
	if ($(el).val() == -1){
		$("[data-type=complaint-product-autocompleter-toggle]").removeClass("hide").find("[data-type=autocomplete]").prop("disabled", false);
	}else{
		$("[data-type=complaint-product-autocompleter-toggle]").addClass("hide").find("[data-type=autocomplete]").prop("disabled", true);
	}
	
	var producer_id = parseInt($(el).attr("data-product-producer-id"));
	
	if (!isNaN(producer_id) && producer_id > 0){
		$("[data-type=complatins-producer-autocomplete-id]").val(producer_id);
		$("[data-type=complatins-producer-autocomplete-name]").val($(el).attr("data-product-producer-name"));
	}
};

/* Zmiana typu */
Complaint.prototype.changeType = function(el){
	$("[data-type^=complaint-type-description]").addClass("hide");
	$("[data-type=complaint-type-description-" + $(el).val() + "]").removeClass("hide");
};

/* Zmiana rodzaju */
Complaint.prototype.changeKind = function(el){
	/* Wyłączenie wszystkich typów */
	$("[data-type=complaint-type]").prop("disabled", true).trigger("toggle-disabled");
	
	/* Włączenie wybranych typów */
	$("[data-type=complaint-type][data-kind=" + $(el).val() + "]").prop("disabled", false).trigger("toggle-disabled");
	
	if ($("[data-type=complaint-type]:checked").prop("disabled")){
		$("[data-type=complaint-type]:checked").removeAttr("checked").trigger("update-state");
		
		$("[data-type^=complaint-type-description]").addClass("hide");
	}
	
	/* Czy opis wymagany */
	var description_required = JSON.parse($(el).attr("data-desctiption-required"));
	
	if (description_required[$(el).val()] == "1"){
		$("[data-type=complaint-description]").attr("data-validate", "validate(required-textarea)");
	}else{
		$("[data-type=complaint-description]").attr("data-validate", "");
	}
	
	/* Wyświetlenie / schowanie pól dodatkowych */
	
	/* Chowam wszystkie pola */
	$("[data-type=complaint-fields]").addClass("hide").find("input, textarea").prop("disabled", true).attr("data-validate", "").trigger("toggle-disabled");
	
	/* Wyświetlam pola dla wybranego rodzaju */
	$("[data-type=complaint-fields][data-kind-" + $(el).val() + "=1]").removeClass("hide").find("input, textarea").prop("disabled", false).each(function(){
		var self = $(this);
		
		self.attr("data-validate", self.attr("data-validate-pattern")).trigger("toggle-disabled");
	});
	
	/* Ponowna walidacja formularza */
	$("[data-type=ketchup-error-message].error-message", $("#ComplaintAddForm")).hide();
	
	$(".form-row", $("#ComplaintAddForm")).removeClass("required").removeClass("invalid-row");
	
	$("#ComplaintAddForm").ketchup();
};

/* Zmiana adresu doręczenia */
Complaint.prototype.changeAddress = function(el){
	if ($(el).val() == "new"){
		this.options.shippingAddress.enable();
		this.options.shippingAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=useraddress]:checked").val());
		
		$(el).parents().find("[data-type=shipping-address]").removeClass("hide");
	}else{
		$(el).parents().find("[data-type=shipping-address]").addClass("hide");
		
		this.options.shippingAddress.disable();
	}
	
	this.reinitFormValidation();
};

/* Zmiana adresu odbioru*/
Complaint.prototype.changeReceiveAddress = function(el){
	if ($(el).val() == "new"){
		this.options.receiveAddress.enable();
		this.options.receiveAddress.checkNameCompanyValidation($("[data-type=selected-user-type][data-prefix=receiveuseraddress]:checked").val());
	}else{
		this.options.receiveAddress.disable();
	}
	
	this.reinitFormValidation();
};