var Cart = (function(){
	var options;
	var row = {
		elm: null,
		key: null
	};
	
	function attachEvents(){
		/* Zmiana ilości */
		$("[data-type=change-quantity-input]").on("cart.change.quantity", function(){
			initCurrentRow(this);
			changeProductQuantity($(this));
		});
		
		/* Obsługa Entera w inpucie z ilością */
		$("[data-type=change-quantity-input]").on("keydown", function(e){
			if (e.keyCode == 13){
				$(this).trigger("change");
				
				e.stopPropagation();
				
				return false;
			}
		});
		
		/* Zmiana ceny */
		$("[data-type=change-single-price-input]").on("change.price", function(){
			initCurrentRow(this);
			changeProductPrice($(this));
		});
		
		/* Zmiana tawki VAT */
		$("[data-type=change-tax-value-select]").on("change.tax_id", function(){
			initCurrentRow(this);
			changeProductTaxValue($(this));
		});
		
		/* Zmiana marży */
		$("[data-type=change-margin-input]").on("change.margin", function(){
			initCurrentRow(this);
			changeProductMargin($(this));
		});
		
		/* Zmiana rabatu */
		$("[data-type=change-rabat-input]").on("change.rabat", function(){
			initCurrentRow(this);
			changeProductRabat($(this));
		});
		
		/* Zmiana ceny katalogowej */
		$("[data-type=change-suggested-price-input]").on("change.suggested_price", function(){
			initCurrentRow(this);
			changeSuggestedPrice($(this));
		});
		
		/* Zmiana ceny zakupu */
		$("[data-type=change-purchase-price-input]").on("change.purchase_price", function(){
			initCurrentRow(this);
			changePurchasePrice($(this));
		});
		
		/* Zmiana numeru */
		$("[data-type=change-number-input]").on("change.number", function(){
			initCurrentRow(this);
			changeProductNumber($(this));
		});
		
		/* Zmiana kombinacji */
		$("[data-type=change-combination]").on("change.cart", function(){
			initCurrentRow(this);
			
			getCartData(url_user_carts_change_combination + "/" + row.key + "/" + $(this).val());
		});
		
		/* Zmiana kombinacji watiantu */
		$("[data-type=change-kit-combination]").on("click.cart", function(){
			initCurrentRow(this);
			
			var values = new Array();
			
			$("[data-type=kit-combination-select][data-product-key=" + row.key + "]").each(function(){
				values.push($(this).attr("data-kit-product-id") + "-" + $(this).val());
			});
			
			getCartData(url_user_carts_change_combination + "/" + row.key + "/" + values.join(";"));
			
			return false;
		});
		
		/* Wymiana punktów programu partnerskiego */
		$("[data-type=change-loyalty-price]").on("change.cart", function(){
			initCurrentRow(this);
			
			getCartData(url_user_carts_change_product_loyalty_points + "/" + row.key + "/" + ($(this).prop("checked") ? 1 : 0));
		});
		
		/* Zmiana sposobu dostawy */
		$("[data-type=change-shipping]").on("change.cart", function(){
			var value = $(this).val();
			
			getCartData(url_user_carts_change_shipping_method + "/" + value, function(){
				updateShippingMethodOptions(value);
			});
		});
		
		/* Zmiana sposobu dostawy - kraj dostawy */
		$("[data-type=change-country]").on("change.cart", function(){
			cartSubmitReload();
		});
		
		/* Zmiana sposobu dostawy - różne terminy dostawy */
		$("[data-type=change-shipping-portion-type]").on("change.cart", function(){
			getCartData(url_user_carts_change_portion_type + "/" + $(this).val());
		});
		
		/* Zmiana sposobu dostawy - lista życzeń */
		$("[data-type=change-use-gift-list]").on("change.cart", function(){
			getCartData(url_user_carts_change_use_gifts_list + "/" + $(this).val());
		});
		
		/* Zmiana sposobu dostawy - sms */
		$("[data-type=change-shipping-sms]").on("change.cart", function(){
			getCartData(url_user_carts_change_sms + "/" + $(this).val());
		});
		
		/* Zmiana sposobu dostawy - punkty programu lojalnościowego */
		$("[data-type=change-shipping-loyalty-price]").on("change.cart", function(){
			$.get(
				App.getAjaxUrl(url_user_carts_change_shipping_loyalty_points + "/" + $(this).val()),
				function(){
					window.location.reload(true);
				}
			);
		});
		
		/* Zmiana sposobu płatności */
		$("[data-type=change-payment]").on("change.cart", function(){
			getCartData(url_user_carts_change_payment_method + "/" + $(this).val());
			
			$("[data-type=payment-term]").prop("disabled", true);
			$("[data-payment-term-for=" + $(this).val() + "] [data-type=payment-term]").prop("disabled", false);
			
			$("[data-type=payment-method-options]").addClass("hide").find("input").prop("disabled", true).trigger("toggle-disabled");
			$("[data-type=payment-method-options][data-payment-method-id=" + $(this).val() + "]").removeClass("hide").find("input").prop("disabled", false).trigger("toggle-disabled");
			
			$("[data-type=payment-method-blue-media-pay-for-me]").addClass("hide").find("input, textarea").prop("disabled", true);
			
			$("[data-type=payment-method-blue-media-pay-for-me][data-payment-method-id=" + $(this).val() + "]").removeClass("hide").find("input, textarea").prop("disabled", false);
		});
		
		$("[data-type=change-payment-option]").on("change", function(e){
			getCartData(url_user_carts_change_payment_method_option + "/" + $(this).val());
		});
		
		/* Wybór gratisu */
		$("[data-type=gratis-product]").on("click.cart", function(e){
			e.preventDefault();
			
			var self = $(this);
			
			if (self.hasClass("selected")){
				/* Odznaczenie */
				self.removeClass("selected");
				$("[data-type=selected-gratis-product]").val("");
				
				/* Obsługa wariantów */
				$("select[data-type=gratis-combination]").prop("disabled", true).trigger("toggle-disabled");
			}else{
				/* Zaznaczenie */
				$("[data-type=gratis-product]").removeClass("selected");
				$("[data-type=selected-gratis-product]").val($(this).attr("data-product-id"));
				
				self.addClass("selected");
				
				/* Obsługa wariantów */
				$("select[data-type=gratis-combination]").prop("disabled", true).trigger("toggle-disabled");
				$("select[data-type=gratis-combination][data-product-id=" + self.attr("data-product-id") + "]").prop("disabled", false).trigger("toggle-disabled");
			}
		});
		
		/* Wybór gratisu */
		$("[data-type=select-gratis]").on("click.cart", function(e){
			e.preventDefault();
			
			var product_id = $(this).attr("data-product-id");
			
			/* Zaznaczam wybrany produkt */
			if (!$("[data-type=gratis-product][data-product-id=" + product_id + "]").hasClass("selected")){
				$("[data-type=gratis-product][data-product-id=" + product_id + "]").click();
			}
			
			/* Wyłączam wszystkie dotychczasowe zaznaczone warianty */
			$("[data-type=gratis-combination]").prop("disabled", true).trigger("toggle-disabled");
			
			/* Włączam warianty dla wybranego produktu */
			$("[data-type=gratis-combination][data-product-id=" + product_id + "]").prop("disabled", false).trigger("toggle-disabled");
			
			/* Kopiuję zaznaczone warianty */
			$("[data-type=gratis-for-amount-combinations-select][data-product-id=" + product_id + "]").each(function(){
				var self = $(this);
				
				if (App.getSetting("kit-combination-for-every-kit-product-item") == "1"){
					var quantity = parseInt(self.attr("data-quantity"));
					
					for (i = 1; i <= quantity; i++){
						var selector = "[data-type=gratis-combination][data-product-id=" + product_id + "]";
						
						if (self.attr("data-kit-product-id")){
							selector += "[data-kit-product-id=" + self.attr("data-kit-product-id") + "]";
						}
						
						selector += "[data-i=" + i + "]";
						
						$(selector).val(self.val());
					}
				}else{
					var selector = "[data-type=gratis-combination][data-product-id=" + product_id + "]";
					
					if (self.attr("data-kit-product-id")){
						selector += "[data-kit-product-id=" + self.attr("data-kit-product-id") + "]";
					}
					
					$(selector).val(self.val());
				}
			});
			
			$(".modal").modal("hide");
			
			/* Wysłanie Ajax'a */
			var form = $("<form>", {
				"method": "POST",
				"action": App.getAjaxUrl(url_user_carts_change_gratis_for_amount)
			});
			
			/* Produkt */
			$("<input>", {
				"type": "hidden",
				"name": "data[GratisForAmount][product_id]"
			}).val(product_id).appendTo(form);
			
			/* Warianty */
			$("[data-type=gratis-for-amount-combinations-select][data-product-id=" + product_id + "]").each(function(){
				var self = $(this);
				
				if (App.getSetting("kit-combination-for-every-kit-product-item") == "1"){
					var quantity = parseInt(self.attr("data-quantity"));
					
					for (i = 1; i <= quantity; i++){
						var selector = "[data-type=gratis-combination][data-product-id=" + product_id + "]";
						
						if (self.attr("data-kit-product-id")){
							selector += "[data-kit-product-id=" + self.attr("data-kit-product-id") + "]";
						}
						
						selector += "[data-i=" + i + "]";
						
						$("<input>", {
							"type": "hidden",
							"name": $(selector).attr("name")
						}).val(self.val()).appendTo(form);
					}
				}else{
					var selector = "[data-type=gratis-combination][data-product-id=" + product_id + "]";
					
					if (self.attr("data-kit-product-id")){
						selector += "[data-kit-product-id=" + self.attr("data-kit-product-id") + "]";
					}
					
					$("<input>", {
						"type": "hidden",
						"name": $(selector).attr("name")
					}).val(self.val()).appendTo(form);
				}
			});
			
			$.post(
				form.attr("action"),
				form.serialize(),
				function(data){
					updateCart($.parseJSON(data));
				}
			);
		});
		
		/* Wybór usługi */
		$("[data-type=change-service]").on("change.cart", function(){
			$("[data-type=change-service-quantity][data-service-id=" + $(this).val() + "][data-product-key=" + $(this).attr("data-product-key") + "]").prop("disabled", true);
			cartSubmitReload();
		});
		
		/* Usuwanie usługi */
		$("[data-type=delete-service]").on("click.cart", function(e){
			e.preventDefault();
			
			$("[data-type=change-service][data-product-key=" + $(this).attr("data-product-key") + "][value=" + $(this).attr("data-service-id") + "]").prop("checked", false).trigger("update-state");
			$("[data-type=change-service-quantity][data-service-id=" + $(this).attr("data-service-id") + "][data-product-key=" + $(this).attr("data-product-key") + "]").prop("disabled", true);
			
			cartSubmitReload();
		});
		
		/* Zmiana dropshippingu */
		$("[data-type=change-dropshipping]").on("change.cart", function(){
			document.location.href = url_user_carts_change_dropshipping + "/" + $(this).val();
		});
		
		/* Zmiana ilości usługi */
		$("[data-type=change-service-quantity]").on("cart.change.service.quantity", function(){
			cartSubmitReload();
		});
		
		/* Grupowe usunięcie produktów*/
		$("[data-type=product-delete-checked-button]").on("click.cart", function(){
			$("#UserCartIndexForm").attr("action", url_user_carts_delete_checked).unbind("submit").find("input, select").removeAttr("data-validate");
			
			$("#UserCartIndexForm").submit();
			
			return false;
		});
		
		/* Filtry na liście zapisanych koszyków */
		$("[data-type=carts-list-search-form]").on("submit.cart-list", function(e){
			submitFilterForm(e, this);
		});
		
		/* Filtry na liście zapisanych ofert */
		$("[data-type=offers-list-search-form]").on("submit.offer-list", function(e){
			submitFilterForm(e, this);
		});
		
		/* Aktywacja koszyka */
		$("[data-type=user-cart-activate]").on("click", function(e){
			$("[data-type=user-cart-activate-form-" + $(this).attr("data-user-cart-id") + "]").submit();
			
			return false;
		});
		
		/* Skopiowanie oferty */
		$("[data-type=user-cart-copy-offer]").on("click", function(e){
			var type = "data-type=user-cart-copy-offer-form-" + $(this).attr("data-user-cart-id");
			
			if ($(this).attr("data-user-cart-offer-id")){
				type += "-" + $(this).attr("data-user-cart-offer-id");
			}
			
			$("[" + type + "]").submit();
			
			return false;
		});
		
		/* Wysłanie oferty */
		$("[data-type=user-cart-send-offer]").on("click", function(e){
			var self           = $(this);
			var form_data_type = "user-cart-send-offer-form-" + self.attr("data-user-cart-id");
			
			if (self.attr("data-user-cart-offer-id")){
				form_data_type += "-" + self.attr("data-user-cart-offer-id");
			}
			
			$("[data-type=" + form_data_type +"]").submit();
			
			return false;
		});
		
		/* Wysłanie oferty ponownie */
		$("[data-type=user-cart-send-offer-again]").on("click", function(e){
			var self           = $(this);
			var form_data_type = "user-cart-send-offer-again-form-" + self.attr("data-user-cart-id");
			
			if (self.attr("data-user-cart-offer-id")){
				form_data_type += "-" + self.attr("data-user-cart-offer-id");
			}
			
			$("[data-type=" + form_data_type +"]").submit();
			
			return false;
		});
		
		/* Zapisanie oferty */
		$("[data-type=user-cart-save-offer]").on("click", function(e){
			var self           = $(this);
			var form_data_type = "user-cart-save-offer-form-" + self.attr("data-user-cart-id");
			
			if (self.attr("data-user-cart-offer-id")){
				form_data_type += "-" + self.attr("data-user-cart-offer-id");
			}
			
			$("[data-type=" + form_data_type +"]").submit();
			
			return false;
		});
		
		/* Zmiana typu wysyłki oferty */
		$("[data-type=change-send-offer-type]").on("click", function(e){
			var offer_id = $(this).attr("data-offer-id");
			var fields   = [
				"username", "email", "phone", "street", "street-number-1", "street-number-2", "postcode", "city", "country-id"
			];
			
			if ($(this).val() == 1){
				$(".show-goup-data").hide();
				$(".show-client-data").slideDown();
				
				$.each(fields, function(key, field){
					$("[data-type=user-cart-send-offer-" + field + "-" + offer_id + "]").prop("disabled", false).trigger("toggle-disabled");
				});
				
				$("[data-type=send-offer-client-group-id-" + offer_id + "]").prop("disabled", true).trigger("toggle-disabled");
			}else{
				$(".show-client-data").hide();
				$(".show-goup-data").slideDown();
				
				$.each(fields, function(key, field){
					$("[data-type=user-cart-send-offer-" + field + "-" + offer_id + "]").prop("disabled", true).trigger("toggle-disabled");
				});
				
				$("[data-type=send-offer-client-group-id-" + offer_id + "]").prop("disabled", false).trigger("toggle-disabled");
			}
		});
		
		/* Mapa dla ups'a */
		$(window).on("hashchange", function(){
			var ups_hash_data = window.location.hash;
			
			if (ups_hash_data.indexOf("postal") != -1 && ups_hash_data.indexOf("lat") != -1 && ups_hash_data.indexOf("long") != -1){
				$.post(
					url_ups_shipping_method_option,
					ups_hash_data.replace("#?action=", ""),
					function(data){
						remote_data = $.parseJSON(data);
						
						if (remote_data.Status.error == false && remote_data.ShippingMethodOption.id > 0){
							$("[data-type=shipping-options-toggle]:visible").find("[data-type=shipping-options]").val(remote_data.ShippingMethodOption.id);
							$("[data-type=shipping-options-toggle]:visible").find("[data-type=shiping-method-option-address]").html(remote_data.ShippingMethodOption.name);
							
							getCartData(url_user_carts_change_payment_method + "/ups_accessspoint_recalculate");
						}
					}
				);
				
				return false;
			}
		});
		
		/* Obsługa bonu */
		$("[data-type=change-voucher]").click(function(){
			if ($(this).prop("checked")){
				$("[data-type=voucher-code-container], [data-type=voucher-error-message]").removeClass("hide");
			}else{
				$("[data-type=voucher-code-container], [data-type=voucher-error-message]").addClass("hide");
			}
		});
		
		if (App.getSetting("offer-alow-not-exists-products")){
			$("[data-type=user-cart-add-product-id-container] [data-type=autocomplete]").on("keyup", function(){
				if ($(this).val() != ""){
					$("[data-type=user-cart-add-product-button]").removeAttr("disabled");
				}else{
					$("[data-type=user-cart-add-product-button]").attr("disabled", "disabled");
				}
			});
		}
		
		/* Po wyborze produktu przy dodawaniu produktu do koszyka */
		$("[data-type=user-cart-add-product-id-container] [data-type=autocomplete]").on("keyup", function(){
			$("[data-type=user-cart-add-product-id]").val(0);
			
			$("[data-type=user-cart-add-product-price], [data-type=user-cart-add-product-tax-id]").prop("disabled", false);
			$("[data-type=user-cart-add-product-tax-id]").trigger("toggle-disabled");
			
			if ($(this).attr("data-allow-not-exists") == "false"){
				$("[data-type=user-cart-add-product-button]").prop("disabled", true);
			}
		}).on("autocomplete-select", function(event, ui){
			$("[data-type=user-cart-add-product-price], [data-type=user-cart-add-product-tax-id]").prop("disabled", true);
			$("[data-type=user-cart-add-product-tax-id]").trigger("toggle-disabled");
			$("[data-type=user-cart-add-product-quantity]").val(ui.ui_.item.min_order).attr("data-step", ui.ui_.item.step);
			
			$("[data-type=user-cart-add-product-button]").prop("disabled", false);
		});
		
		$("[data-type=user-cart-add-product-form]").on("submit", function(){
			return false;
		});
		
		/* Dodawanie produktów do oferty - etap 1 */
		$("[data-type=user-cart-add-product-button]").on("click.add-product", function(){
			$.post(
				App.getAjaxUrl(url_user_carts_add_to_offer),
				$("[data-type=user-cart-add-product-form]").serialize(),
				function(html){
					$("[data-type=cart-add-product-products-list]").html(html).removeClass("hide");
					$("[data-type=user-cart-add-product-submit]").removeAttr("disabled");
					
					$("[data-type=user-cart-add-product-form] [data-type][type=text]").val("");
					$("[data-type=user-cart-add-product-price]").val("0,00");
					$("[data-type=user-cart-add-product-quantity]").val("1");
					
					if ($("[data-type=user-cart-add-product-tax-id]").length){
						$("[data-type=user-cart-add-product-tax-id]").val($("[data-type=user-cart-add-product-tax-id]").attr("data-default")).trigger("update-state");
					}
					
					$("[data-type=user-cart-add-product-price], [data-type=user-cart-add-product-tax-id]").attr("disabled", "disabled").trigger("toggle-disabled");
					
					$("[data-type=user-cart-add-product-button]").attr("disabled", "disabled");
					
					/* Usunięcie produktu z dodawania do koszyka */
					$("[data-type=delete-offer-tmp-product]").unbind("click").on("click", function(){
						$.get(App.getAjaxUrl(url_user_carts_remove_product_from_offer_products + "/" + $(this).attr("data-offer-product-key")));
						
						/* Usunięcie wiersza */
						var parent = $($(this).parents("tr").get(0));
						
						var next = parent.next();
						
						if (next.hasClass("hr")){
							next.remove();
						}
						
						parent.remove();
						
						if ($("[data-type=cart-add-product-products-list] tr").length == 0){
							$("[data-type=cart-add-product-products-list] table").remove();
							$("[data-type=cart-add-product-products-list]").addClass("hide");
							$("[data-type=user-cart-add-product-submit]").prop("disabled", true);
						}
						
						return false;
					});
				}
			);
		});
		
		/* Dodawanie produktów do oferty - etap 2 */
		$("[data-type=user-cart-add-product-submit]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"class" : "hide",
				"action": url_user_carts_add_group
			});
			
			$("[data-type=user-cart-add-product-form] input:hidden").each(function(){
				var self = $(this);
				
				$("<input>", {
					"type": "hidden",
					"name": self.attr("name")
				}).val(self.val()).appendTo(form);
			});
			
			form.appendTo($("body")).submit();
			
			return false;
		});
		
		/* Zmiana zdjęcia produktu na ofercie */
		if (App.getSetting("offer-edit-mode")){
			$("[data-type=product-row-image]").on("click", function(){
				if ($(this).attr("data-kit-id") == "0"){
					$("#EditProductImage" + $(this).attr("data-product-key")).modal("show");
					
					return false;
				}
				
				return true;
			});
		}
		
		/* Automatyczne zaznaczanie inputów przy otwieraniu dialogów */
		$("#AddProductToCart").on("shown.bs.modal", function(){
			$("[data-type=user-cart-add-product-id-container] [data-type=autocomplete]").focus();
		});
		
		$("#CartSave").on("shown.bs.modal", function(){
			$("#UserCartName").focus();
		});
		
		$("#SaveOffer").on("shown.bs.modal", function(){
			$("#UserCartOfferName").focus();
		});
		
		/* Zmiana kolejności produktów */
		if (App.getSetting("offer-edit-mode")){
			updateProductMoveIcons();
			
			$("[data-type=product-row-move-down]").unbind("click").on("click", function(){
				startMovingProducts();
				
				var $self  = $(this);
				var parent = $($self.parents("[data-type=product-row]").get(0));
				
				parent.insertAfter(parent.next());
				
				updateProductMoveIcons();
				
				return false;
			});
			
			$("[data-type=product-row-move-up]").unbind("click").on("click", function(){
				startMovingProducts();
				
				var $self  = $(this);
				var parent = $($self.parents("[data-type=product-row]").get(0));
				
				parent.insertBefore(parent.prev());
				
				updateProductMoveIcons();
				
				return false;
			});
		}
		
		/* Grupowe usuwanie produktów */
		$("[data-type=cart-delete-product-checkbox]").on("click", function(){
			if ($("[data-type=cart-delete-product-checkbox]:checked").length == 0){
				$("[data-type=cart-delete-product-button]").attr("disabled", "disabled");
				
				if ($("[data-type=cart-group-actions-select]").length){
					$("[data-type=cart-group-actions-select]").val("").trigger("update-state").attr("disabled", "disabled").trigger("toggle-disabled");
					$("[data-type=cart-group-actions-submit]").addClass("hide");
					
					$(".cart-group-options").addClass("hide").find("input").prop("disabled", true).trigger("toggle-disabled");
				}
			}else{
				$("[data-type=cart-delete-product-button]").removeAttr("disabled");
				
				if ($("[data-type=cart-group-actions-select]").length){
					$("[data-type=cart-group-actions-select]").removeAttr("disabled").trigger("toggle-disabled");
				}
			}
		});
		
		/* Zmiana cechy oferty */
		$("[data-type=user-cart-field]").on("change.user-cart-field", function(){
			changeUserCartField(this);
		});
		
		/* Wybór operacji grupowej */
		$("[data-type=cart-group-actions-select]").on("change.group_action", function(){
			$(".cart-group-options").addClass("hide").find("input, select").prop("disabled", true).trigger("toogle-disabled");
			
			if ($(this).val() != ""){
				if ($(this).val() == "offer_union"){
					$("#CartOfferUnionModal").modal("show");
					
					$("[data-type=cart-group-actions-submit]").addClass("hide");
				}else if ($(this).val() == "label"){
					$("#CartLabelModal").modal("show");
					
					$("[data-type=cart-group-actions-submit]").addClass("hide");
				}else if ($(this).val() == "update_price"){
					$("#CartUpdatePriceModal").modal("show");
					
					$("[data-type=cart-group-actions-submit]").addClass("hide");
				}else{
					$("[data-type=cart-group-options-" + $(this).val() + "]").removeClass("hide").find("input, select").prop("disabled", false).trigger("toogle-disabled");;
					
					$("[data-type=cart-group-actions-submit]").removeClass("hide");
				}
			}else{
				$("[data-type=cart-group-actions-submit]").addClass("hide");
			}
		});
		
		/* Wykonanie operacji grupowej */
		$("[data-type=cart-group-actions-submit]").on("click.submit", function(){
			var action = App.getAjaxUrl(url_user_carts_group_actions + "/" + $("[data-type=cart-group-actions-select]").val());
			var value  = "";
			
			if ($("[data-type=cart-group-options-" + $("[data-type=cart-group-actions-select]").val() + "] input").length){
				value  = $("[data-type=cart-group-options-" + $("[data-type=cart-group-actions-select]").val() + "] input").val().replace(",", ".").replace("%", "");
			}
			
			if ($("[data-type=cart-group-actions-select]").val() == "price"){
				/* Zmiana ceny - dodaję wartość ujemną */
				if ($("[data-type=cart-group-options-produce-change-type]").val() == "-"){
					value = "-" + value;
				}
			}
			
			if ($("[data-type=cart-group-options-" + $("[data-type=cart-group-actions-select]").val() + "] input").length){
				action += "/" + value;
			}
			
			var form = $("<form>", {
				"method": "POST",
				"action": action
			});
			
			$("[data-type=cart-delete-product-checkbox]:checked").each(function(){
				var key = $(this).attr("data-key");
				
				$("<input>", {
					"type": "hidden",
					"name": "data[UserCart][key][]"
				}).val(key).appendTo(form);
				
				if ($("[data-type=cart-group-actions-select]").val() != "delete" && $("[data-type=cart-group-actions-select]").val() != "description"){
					$("#UserCart" + key + "Margin, #UserCart" + key + "Rabat, #UserCart" + key + "SinglePrice, #UserCart" + key + "SuggestedPrice, #UserCart" + key + "PurchasePrice").addClass("invalid");
					$("#UserCart" + key + "TaxId").next(".transform-select").addClass("invalid");
				}
			});
			
			$.post(
				form.attr("action"),
				form.serialize(),
				function(data){
					updateCart($.parseJSON(data));
				}
			);
			
			return false;
		});
		
		/* Zapis możliwości wyboru produktów w ofercie */
		$("[data-type=save-user-cart-offer-union]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_offer_union
			});
			
			$("[data-type=cart-delete-product-checkbox]:checked").each(function(){
				var key = $(this).attr("data-key");
				
				$("<input>", {
					"type": "hidden",
					"name": "data[UserCart][key][]"
				}).val(key).appendTo(form);
			});
			
			$("<input>", {
				"type": "hidden",
				"name": "data[UserCart][offer_union_name]"
			}).val($("#CartOfferUnionName").val()).appendTo(form);
			
			form.appendTo($("body")).submit();
		});
		
		/* Zapis nagłówka / etykiety produktów */
		$("[data-type=save-user-cart-label]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_create_product_label
			});
			
			$("[data-type=cart-delete-product-checkbox]:checked").each(function(){
				var key = $(this).attr("data-key");
				
				$("<input>", {
					"type": "hidden",
					"name": "data[UserCart][key][]"
				}).val(key).appendTo(form);
			});
			
			$("<input>", {
				"type": "hidden",
				"name": "data[UserCart][label]"
			}).val($("#CartLabel").val()).appendTo(form);
			
			form.appendTo($("body")).submit();
		});
		
		/* Zmiana nagłówka / etykiety produktów */
		$("[data-type=change-user-cart-label]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_change_product_label + "/" + $(this).attr("data-key")
			});
			
			$("<input>", {
				"type": "hidden",
				"name": "data[UserCart][label]"
			}).val($("#CartLabel" + $(this).attr("data-key")).val()).appendTo(form);
			
			form.appendTo($("body")).submit();
		});
		
		/* Usunięcie nagłówka / etykiety produktów */
		$("[data-type=delete-user-cart-label]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_delete_product_label + "/" + $(this).attr("data-key")
			});
			
			form.appendTo($("body")).submit();
		});
		
		/* Zmiana nagłówka do wyboru produktów w ofercie */
		$("[data-type=change-user-cart-union-label]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_change_offer_union + "/" + $(this).attr("data-union")
			});
			
			$("<input>", {
				"type": "hidden",
				"name": "data[UserCart][union_name]"
			}).val($("#CartUnionLabel" + $(this).attr("data-union")).val()).appendTo(form);
			
			form.appendTo($("body")).submit();
		});
		
		/* Usunięcie możliwości wyboru produktu w ofercie */
		$("[data-type=delete-user-cart-union-label]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_delete_offer_union + "/" + $(this).attr("data-union")
			});
			
			form.appendTo($("body")).submit();
		});
		
		/* Aktualizacja cen */
		$("[data-type=save-user-cart-upate-price]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": url_user_carts_update_prices
			});
			
			$("[data-type=cart-delete-product-checkbox]:checked").each(function(){
				var key = $(this).attr("data-key");
				
				$("<input>", {
					"type": "hidden",
					"name": "data[UserCart][key][]"
				}).val(key).appendTo(form);
			});
			
			$("#CartUpdatePriceModal input").each(function(){
				var clone = $(this).clone();
				
				clone.appendTo(form);
			});
			
			form.appendTo($("body")).submit();
		});
		
		$("[data-type=user-cart-change-update-price-type]").click(function(){
			if ($(this).val() == 2){
				$("[data-type=user-cart-change-update-price-type-2] input").prop("disabled", false).trigger("toggle-disabled");
			}else{
				$("[data-type=user-cart-change-update-price-type-2] input").prop("disabled", true).trigger("toggle-disabled");
			}
		});
		
		/* Zmiana indywidualnego opisu produktu w koszyku */
		$("[data-type=change-cart-product-custom-description]").on("submit", function(){
			var self = $(this);
			
			$.post(
				App.getAjaxUrl(url_user_carts_change_product_custom_description + "/" + self.attr("data-key")),
				self.serialize(),
				function(){
					$("#EditProductCustomDescription" + self.attr("data-key")).modal("hide");
				}
			);
			
			return false;
		});
		
		/* Zaznaczenie / odznaczenie wszystkich checkboksów do usuwanie produktów */
		$("[data-type=cart-delete-product-checkbox-all]").click(function(){
			var checked = true;
			
			if ($(this).attr("data-checked")){
				checked = false;
				
				$(this).removeAttr("data-checked");
			}else{
				$(this).attr("data-checked", "true");
			}
			
			$("[data-type=cart-delete-product-checkbox]").each(function(){
				if ($(this).prop("checked") != checked){
					$(this).click();
				}
			});
		});
		
		/* Zaznaczenie / odznaczenie wszystkich atrybutów koszyka */
		$("[data-type=cart-attributes-check-uncheck-all]").click(function(){
			var checked = true;
			
			if ($(this).attr("data-checked")){
				checked = false;
				
				$(this).removeAttr("data-checked");
			}else{
				$(this).attr("data-checked", "true");
			}
			
			$("[data-type=cart-attributes] input[type=checkbox]").each(function(){
				var self = $(this);
				
				if (self.prop("checked") != checked){
					if (checked){
						self.prop("checked", true);
					}else{
						self.prop("checked", false);
					}
					
					self.trigger("update-state");
				}
			});
		});
		
		/* Usunięcie produktu z dodawania do koszyka */
		$("[data-type=delete-offer-tmp-product]").on("click", function(){
			$.get(App.getAjaxUrl(url_user_carts_remove_product_from_offer_products + "/" + $(this).attr("data-offer-product-key")));
			
			/* Usunięcie wiersza */
			var parent = $($(this).parents("tr").get(0));
			
			var next = parent.next();
			
			if (next.hasClass("hr")){
				next.remove();
			}
			
			parent.remove();
			
			if ($("[data-type=cart-add-product-products-list] tr").length == 0){
				$("[data-type=cart-add-product-products-list] table").remove();
				$("[data-type=cart-add-product-products-list]").addClass("hide");
				$("[data-type=user-cart-add-product-submit]").prop("disabled", true);
			}
			
			return false;
		});
		
		/* Zmiana statusu zamówienia w koszyku */
		$("[data-type=cart-order-status]").on("change.order-status", function(){
			changeOrderStatus(this);
		});
		
		/* Zmiana kosztów dostawy */
		$("[data-type=cart-shipping-price-input]").on("change.shipping_method_price", function(){
			getCartData(url_user_carts_change_shipping_price + "/" + $(this).val());
		});
		
		/* Zmiana kosztów płatności */
		$("[data-type=cart-payment-price-input]").on("change.payment_method_price", function(){
			getCartData(url_user_carts_change_payment_price + "/" + $(this).val());
		});
		
		/* Zamknięcie koszyka */
		$("[data-type=user-cart-close-button]").on("click.close", function(){
			$("[data-type=user-cart-close-form]").submit();
			
			return false;
		});
		
		/* Usunięcie produktu z koszyka */
		$("[data-type=delete-product-from-cart]").on("click", function(){
			if (App.getSetting("analytics-enhanced-ecommerce") && typeof ga == "function"){
				var self = $(this);
				
				ga("ec:addProduct", {
					"id"      : self.attr("data-product-id"),
					"name"    : self.attr("data-product-name"),
					"category": self.attr("data-product-category"),
					"brand"   : self.attr("data-product-brand"),
					"variant" : self.attr("data-product-variant"),
					"price"   : self.attr("data-product-price"),
					"quantity": self.attr("data-product-quantity")
				});
				
				ga("ec:setAction", "remove");
				
				ga("send", "event", "cart", "click", "remove product");
			}
		});
		
		/* Wybór szablonu uwag do oferty */
		$("[data-type=user-cart-offer-comments-template-select]").on("change", function(){
			var self = $(this);
			var id   = self.val();
			
			if (id != ""){
				var textarea_id = self.attr("data-textarea-id");
				
				if (textarea_id != "" && $("#" + textarea_id).length > 0){
					$.ajax({
						url    : App.getAjaxUrl(url_user_cart_offer_comments_templates_select_template + "/" + id),
						success: function(data){
							$("#" + textarea_id).val($("<div>").html(data.content).text());
						}
					});
				}
			}
		});
		
		/* Zmiana opcji 'Wyślij ofertę do klienta' */
		$("[data-type=offer-send-email-checkbox]").on("click", function(){
			var self     = $(this);
			var input_id = self.attr("data-input-id");
			
			if (self.prop("checked")){
				$("#UserCartEmailSubject" + input_id).prop("disabled", false);
			}else{
				$("#UserCartEmailSubject" + input_id).prop("disabled", true);
			}
		});
		
		/* Udostępnienie koszyka */
		$("[data-type=share-cart]").on("click.share", function(){
			$.get(
				App.getAjaxUrl(url_user_carts_share),
				function(data){
					if (data.url != undefined){
						$("[data-type=share-cart-url]").val(data.url);
						
						$("[data-type=share-cart-ok]").removeClass("hide");
						$("[data-type=share-cart-error]").addClass("hide");
						
						$("#CartURL").modal("show");
					}else{
						$("[data-type=share-cart-url]").val("");
						
						$("[data-type=share-cart-ok]").addClass("hide");
						$("[data-type=share-cart-error]").removeClass("hide");
						
						$("#CartURL").modal("show");
					}
				}
			);
			
			return false;
		});
		
		/* Wybór produktu w ofercie */
		$("[data-type=cart-active-product-radio]").on("change", function(){
			getCartData(url_user_carts_select_product + "/" + $(this).attr("data-key"));
		});
		
		/* Obsługa Entera w inputach */
		$("#UserCartIndexForm input[type=text]").keypress(function(event){
			if (event.keyCode == 13){
				event.preventDefault();
				
				$(this).trigger("change");
				
				return false;
			}
		});
		
		/* Zmiana nazwy produktu w koszyku*/
		$("[data-type=change-cart-product-name-submit]").on("click", function(){
			var self = $(this);
			
			var form = $("<form>", {
				"method": "POST"
			});
			
			form.append(
				$("<input>", {
					"type": "hidden",
					"name": "data[UserCart][product_name]"
				}).val($("[data-type=user-cart-product-name-" + self.attr("data-key") + "]").val())
			);
			
			$.post(
				App.getAjaxUrl(url_user_carts_change_product_name + "/" + self.attr("data-key")),
				form.serialize(),
				function(data){
					$("#EditProductName" + self.attr("data-key")).modal("hide");
					
					$("[data-type=product-name][data-key=" + self.attr("data-key") + "]").html(data.name);
				}
			);
			
			return false;
		});
		
		/* Łączenie ofert */
		$("[data-type=join-offers]").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": App.getAjaxUrl(url_user_carts_join_offers)
			});
			
			$("[data-type=cart-offer-list-checkbox]:checked").each(function(){
				form.append($(this).clone());
			});
			
			$.post(
				form.attr("action"),
				form.serialize(),
				function(response){
					$(response).appendTo($("body"));
					
					$("#UserCartJoinOffersModal").modal().modal("show").on("hidden.bs.modal", function(){
						$("#UserCartJoinOffersModal").data("bs.modal", null).remove();
					});
					
					/* Zmiana typu produktu */
					$("[data-type=change-join-offers-product-action]").unbind("change.product").on("change.product", function(){
						var i = $(this).attr("data-i");
						
						if ($(this).val() == "all"){
							$("[data-type=join-offers-product-label-row][data-i=" + i + "]").addClass("hide").find(".form-control").prop("disabled", true);
							
							$("[data-type=join-offers-duplicated-products-row][data-i=" + i + "]").addClass("no-products-label");
						}else if ($(this).val() == "select"){
							$("[data-type=join-offers-product-label-row][data-i=" + i + "]").removeClass("hide").find(".form-control").prop("disabled", false);
							
							$("[data-type=join-offers-duplicated-products-row][data-i=" + i + "]").removeClass("no-products-label");
						}
					});
					
					$("[data-type=change-join-offers-product-action]").trigger("change.product");
					
					/* Zmiana zaznaczenia produktu przy łączeniu ofert */
					$("[data-type=join-offers-products-select]").unbind("change.product").on("change.product", function(){
						var product_id = $(this).attr("data-product-id");
						
						if ($(this).is(":checked")){
							$("[data-type=join-offers-products-quantity][data-product-id=" + product_id + "], [data-type=join-offers-products-price][data-product-id=" + product_id + "]").prop("disabled", false);
						}else{
							$("[data-type=join-offers-products-quantity][data-product-id=" + product_id + "], [data-type=join-offers-products-price][data-product-id=" + product_id + "]").prop("disabled", true);
						}
					});
				}
			);
			
			return false;
		});
		
		/* Zmiana zapłaty koszyka punktami programu lojalnościowego  */
		$("[data-type=cart-loyalty-price]").on("change.cart", function(){
			getCartData(url_user_carts_change_loyalty_price + "/" + ($(this).prop("checked") ? 1 : 0));
		});
		
		/* Akceptacja oferty bez klienta - #18359 */
		$("[data-type=user-cart-accept-offer-submit]").on("click", function(){
			$("#UserCartAcceptOfferForm" + $(this).attr("data-id")).submit();
			
			return false;
		});
		
		$("[data-type=user-cart-accept-offer-new-user-submit]").on("click", function(){
			$("[data-type=user-cart-accept-offer-user-id-" + $(this).attr("data-id") + "]").val(0);
			$("[data-type=user-cart-accept-offer-new-user-" + $(this).attr("data-id") + "]").val(1);
			
			$("#UserCartAcceptOfferForm" + $(this).attr("data-id")).submit();
			
			return false;
		});
		
		$("[data-tooltip-set]").tooltip();
	}
	
	function initCurrentRow(element){
		var key = $(element).parents("[data-type=product-row]").attr("data-product-key");
		
		row.elm = $("[data-type=product-row][data-product-key=" + key + "]");
		row.key = key;
	}
	
	function changeProductQuantity(input){
		getCartData(url_user_carts_change_quantity + "/" + row.key + "/" + input.val().replace(",", "."));
	}
	
	/* Zmiana ceny produktu */
	function changeProductPrice(input){
		var self = $(input);
		
		if (self.attr("data-purchase-price")){
			var purchase_price = parseFloat(self.attr("data-purchase-price").replace(",", "."));
			
			if (!isNaN(purchase_price) && purchase_price > 0){
				var price = parseFloat(self.val().replace(",", "."));
				
				if (!isNaN(price) && price < purchase_price){
					self.val(purchase_price.toFixed(2).replace(".", ","));
				}
			}
		}
		
		self.addClass("invalid");
		
		/* Input z VAT'em */
		$("#" + self.attr("id").replace("SinglePrice", "TaxId")).next(".transform-select").addClass("invalid");
		
		/* Input z marżą */
		$("#" + self.attr("id").replace("SinglePrice", "Margin")).addClass("invalid");
		
		/* Input z rabatem */
		$("#" + self.attr("id").replace("SinglePrice", "Rabat")).addClass("invalid");
		
		/* Input z ceną katalogową */
		$("#" + self.attr("id").replace("SinglePrice", "SuggestedPrice")).addClass("invalid");
		
		/* Input z ceną zakupu */
		$("#" + self.attr("id").replace("SinglePrice", "PurchasePrice")).addClass("invalid");
		
		getCartData(url_user_carts_change_price + "/" + row.key + "/" + self.val().replace(",", "."));
	}
	
	/* Zmiana marży produktu */
	function changeProductMargin(input){
		var self = $(input);
		
		self.addClass("invalid");
		
		/* Input z ceną */
		$("#" + self.attr("id").replace("Margin", "SinglePrice")).addClass("invalid");
		
		/* Input z VAT'em */
		$("#" + self.attr("id").replace("Margin", "TaxId")).next(".transform-select").addClass("invalid");
		
		/* Input z rabatem */
		$("#" + self.attr("id").replace("Margin", "Rabat")).addClass("invalid");
		
		/* Input z ceną katalogową */
		$("#" + self.attr("id").replace("Margin", "SuggestedPrice")).addClass("invalid");
		
		/* Input z ceną zakupu */
		$("#" + self.attr("id").replace("Margin", "PurchasePrice")).addClass("invalid");
		
		getCartData(url_user_carts_change_margin + "/" + row.key + "/" + self.val().replace("%", "").replace(",", "."));
	}
	
	/* Zmiana rabatu produktu */
	function changeProductRabat(input){
		var self = $(input);
		
		self.addClass("invalid");
		
		/* Input z ceną */
		$("#" + self.attr("id").replace("Rabat", "SinglePrice")).addClass("invalid");
		
		/* Input z VAT'em */
		$("#" + self.attr("id").replace("Rabat", "TaxId")).next(".transform-select").addClass("invalid");
		
		/* Input z marżą */
		$("#" + self.attr("id").replace("Rabat", "Margin")).addClass("invalid");
		
		/* Input z ceną katalogową */
		$("#" + self.attr("id").replace("Rabat", "SuggestedPrice")).addClass("invalid");
		
		/* Input z ceną zakupu */
		$("#" + self.attr("id").replace("Rabat", "PurchasePrice")).addClass("invalid");
		
		getCartData(url_user_carts_change_rabat + "/" + row.key + "/" + self.val().replace("%", "").replace(",", "."));
	}
	
	/* Zmiana ceny katalogowej produktu */
	function changeSuggestedPrice(input){
		getCartData(url_user_carts_change_suggested_price + "/" + row.key + "/" + $(input).val().replace(",", "."));
	}
	
	/* Zmiana ceny zakupu produktu */
	function changePurchasePrice(input){
		getCartData(url_user_carts_change_purchase_price + "/" + row.key + "/" + $(input).val().replace(",", "."));
	}
	
	/* Zmiana numeru produktu */
	function changeProductNumber(input){
		getCartData(url_user_carts_change_product_number + "/" + row.key + "/" + $(input).val().replace(",", "."));
	}
	
	/* Zmiana stawki podatkowej produktu */
	function changeProductTaxValue(select){
		var self = $(select);
		
		self.next(".transform-select").addClass("invalid");
		
		/* Input z ceną */
		$("#" + self.attr("id").replace("TaxId", "SinglePrice")).addClass("invalid");
		
		/* Input z marżą */
		$("#" + self.attr("id").replace("TaxId", "Margin")).addClass("invalid");
		
		/* Input z rabatem */
		$("#" + self.attr("id").replace("TaxId", "Rabat")).addClass("invalid");
		
		/* Input z ceną katalogową */
		$("#" + self.attr("id").replace("TaxId", "SuggestedPrice")).addClass("invalid");
		
		/* Input z ceną zakupu */
		$("#" + self.attr("id").replace("TaxId", "PurchasePrice")).addClass("invalid");
		
		getCartData(url_user_carts_change_tax_id + "/" + row.key + "/" + self.val());
	}
	
	/* Pobranie danych koszyka */
	function getCartData(url, callback){
		$.ajax({
			url    : App.getAjaxUrl(url),
			success: function(data){
				updateCart($.parseJSON(data));
				
				if (callback != undefined && typeof callback == "function"){
					callback();
				}
			}
		});
	}
	
	function updateCart(data){
		/* Przeładowanie strony */
		if (data.reload != undefined){
			document.location.href = data.reload;
		}
		
		/* Uaktualnienie produktu */
		if (data.product != undefined){
			updateProduct(data.product);
		}
		
		/* Uaktualnienie kombinacji */
		if (data.combination != undefined){
			updateProductCombination(data.combination);
		}
		
		/* Uaktualnienie kosztów dostawy/płatności/kuponu itd. koszyka */
		if (data.costs != undefined){
			updateCosts(data.costs);
		}
		
		/* Uaktualnienie form dostawy */
		if (data.shipping != undefined){
			updateShipping(data.shipping);
		}
		
		/* Uaktualnienie form płatności */
		if (data.payment != undefined){
			updatePayment(data.payment);
		}
		
		/* Uaktualnienie zniżek całych opakowań */
		if (data.discount != undefined){
			updateFullPackageDiscount(data.discount);
		}
		
		/* Uaktualnienie opcji dostawy */
		if (data.cod != undefined && data.cod != $("[data-type=cart-cod]").val()){
			refreshShippingMethodOptions(data.cod);
		}
		
		/* Promocje wiązane */
		$("[data-type=bound-specials-info-toggle]").replaceWith(data.bound_specials);
		
		/* Reset cen */
		if (data.reset_prices){
			$("[data-type=reset-prices-toggle]").removeClass("hide");
		}else{
			$("[data-type=reset-prices-toggle]").addClass("hide");
		}
		
		/* Ostrzeżenie przed bonem */
		$("[data-type=voucher-error-message]").replaceWith(data.voucher_message);
		
		/* Produkty do darmowej dostawy */
		$("[data-type=free-shipping-products-toggle]").empty().append(data.shipping ? data.shipping.free_products : "");
		
		if ($("[data-type=free-shipping-products-toggle] .product-box").length > 0){
			$("[data-type=free-shipping-products-toggle]").removeClass("hide");
		}else{
			$("[data-type=free-shipping-products-toggle]").addClass("hide");
		}
		
		/* Kredyt kupiecki */
		var credit_payment = false;
		
		for (x in data.costs){
			var cost = data.costs[x];
			
			if (cost.field == "cart-credit-payment"){
				if (cost.value != ""){
					credit_payment = true;
				}
				
				break;
			}
		}
		
		if (credit_payment){
			$("[data-type=cart-credit-payment-toogle]").removeClass("hide");
		}else{
			$("[data-type=cart-credit-payment-toogle]").addClass("hide");
		}
		
		/* PayPal Express Checout */
		if (data.paypal_express_checkout){
			$("[data-type=paypal-express-checkout-true]").removeClass("hide");
			$("[data-type=paypal-express-checkout-false]").addClass("hide");
		}else{
			$("[data-type=paypal-express-checkout-true]").addClass("hide");
			$("[data-type=paypal-express-checkout-false]").removeClass("hide");
		}
		
		/* Boks koszyka */
		if (data.cart_box){
			$("[data-type=cart-box]").empty().html($(data.cart_box));
		}
	}
	
	function updateProduct(products){
		for (key in products){
			data = products[key];
			
			row.elm = $("[data-type=product-row][data-product-key=" + key + "]");
			row.key = key;
			
			if (data.fields != undefined){
				$.each(data.fields, function(field, value){
					if ($("[data-type=change-" + field + "-input]", row.elm).length > 0){
						$("[data-type=change-" + field + "-input]", row.elm).val(value);
					}else if ($("[data-type=product-" + field + "-" + key + "]").length > 0){
						$("[data-type=product-" + field + "-" + key + "]").val(value);
					}else{
						$("[data-type=product-row-" + field + "]", row.elm).html(value);
					}
					
					if (field == "purchase-price"){
						$(".product-purchase-price", row.elm).text(value);
						
						$("[data-type=change-single-price-input]", row.elm).attr("data-purchase-price", value);
					}
				});
			}
			
			if (data.loyalty != undefined){
				if (data.loyalty.hide){
					var input = $("[data-type=change-loyalty-price]", row.elm);
					
					input.prop("disabled", true).trigger("toggle-disabled");
					input.parents("[data-type=loyalty-price-toggle]").addClass("hide");
				}else{
					var input = $("[data-type=change-loyalty-price]", row.elm);
					
					input.prop("disabled", false).trigger("toggle-disabled");
					input.parents("[data-type=loyalty-price-toggle]").removeClass("hide");
				}
				
				if (data.loyalty.selected){
					$("[data-type=change-loyalty-price]", row.elm).prop("checked", true).trigger("update-state");
				}
				
				if (data.loyalty.points){
					var id = $("[data-type=change-loyalty-price]", row.elm).attr("id");
					
					$("label[for=" + id + "]", row.elm).html(data.loyalty.points);
				}
			}
			
			if (data.warnings != undefined){
				$.each(data.warnings, function(field, value){
					$("[data-type=change-" + field + "-input]", row.elm).addClass("invalid").prop("title", value).tooltip("destroy").tooltip().tooltip("show");
					
					setTimeout(
						function(){
							$("[data-type=change-" + field + "-input]", row.elm).prop("title", "").tooltip("hide").tooltip("destroy");
						},
						5000
					);
				});
			}
			
			if (options.onProductUpdate && typeof options.onProductUpdate === "function"){
				options.onProductUpdate(data);
			}
		}
	}
	
	function updateProductCombination(combinations){
		for (key in combinations){
			data = combinations[key];
			
			row.elm = $("[data-type=product-row][data-product-key=" + key + "]");
			row.key = key;
			
			if (data.attributes != undefined){
				$.each(data.attributes, function(id, value){
					$("[data-type=product-row-attributes] [data-attribute-id=" + id + "]", row.elm).html(value);
				});
			}
			
			if (data.kit_combinations != undefined){
				$.each(data.kit_combinations, function(id, value){
					if (typeof value == "object"){
						for (item_number in value){
							$("[data-type=product-row-attributes] [data-kit-product-id=" + id + "][data-kit-item-number=" + item_number + "]", row.elm).html(value[item_number]);
						}
					}else{
						$("[data-type=product-row-attributes] [data-kit-product-id=" + id + "]", row.elm).html(value);
					}
				});
			}
			
			if (data.image != undefined){
				$("[data-type=product-row-image]", row.elm).html(data.image);
			}
			
			if (options.onCombinationUpdate && typeof options.onCombinationUpdate === "function"){
				options.onCombinationUpdate(data);
			}
		}
	}
	
	function updateShipping(data){
		if (data.id){
			$("[data-type=change-shipping][value=" + data.id + "]").prop("checked", true);
			
			$("[data-type=change-shipping]").trigger("update-state");
		}
		
		if (data.labels != undefined){
			$.each(data.labels, function(id, label){
				var id = $("[data-type=change-shipping][value=" + id + "]").attr("id");
				
				$("label[for=" + id + "]").html(label);
			});
		}
		
		$("[data-type=change-shipping]").prop("disabled", false).trigger("toggle-disabled").parents(".radio").removeClass("hide");
		
		if (data.exclusion != undefined){
			$.each(data.exclusion, function(i, id){
				var input = $("[data-type=change-shipping][value=" + id + "]");
				
				if (input.prop("checked")){
					input.prop("checked", false).trigger("update-state");
					$("[data-type=change-shipping]").html("-");
				}
				
				input.prop("disabled", true).trigger("toggle-disabled");
				input.parents(".radio").addClass("hide");
			});
		}
		
		if (data.loyalty != undefined){
			$("[data-type=change-shipping-loyalty-price]").prop("checked", false).trigger("update-state");
			
			$("[data-type=change-shipping-loyalty-price][value=" + data.loyalty + "]").prop("checked", true).trigger("update-state");
		}
		
		if (data.free != undefined){
			if (data.free){
				$("[data-type=free-shipping-info-toggle]").removeClass("hide");
				$("[data-type=free-shipping-info]").html(data.free);
			}else{
				$("[data-type=free-shipping-info-toggle]").addClass("hide");
				$("[data-type=free-shipping-info]").html(data.free);
			}
		}
		
		if (data.sms != undefined){
			if (data.sms.show){
				$("[data-type=shipping-sms-toggle]").removeClass("hide");
			}else{
				$("[data-type=shipping-sms-toggle]").addClass("hide");
			}
			
			$("[data-type=change-shipping-sms][value=" + data.sms.select + "]").prop("checked", true).trigger("update-state");
		}
		
		if (options.onShippingUpdate && typeof options.onShippingUpdate === "function"){
			options.onShippingUpdate(data);
		}
	}
	
	function updateShippingMethodOptions(id){
		if (id == undefined){
			var id = $("[data-type=change-shipping]:checked").attr("value");
		}
		
		$("[data-type=shipping-options]").prop("disabled", true).trigger("toggle-disabled");
		$("[data-type=shipping-options-toggle]").addClass("hide");
		
		if ($("[data-type=shipping-options-toggle][data-options-for=" + id + "]").length > 0){
			$("[data-type=shipping-options-toggle][data-options-for=" + id + "]:not(:empty)").removeClass("hide");
			$("[data-type=shipping-options][data-options-for=" + id + "]").prop("disabled", false).trigger("toggle-disabled");
		}else if ($("[data-type=change-shipping]").length > 0){
			if ($("#ShippingMethodId" + id).attr("data-has-options") == "true"){
				$.get(
					App.getAjaxUrl(url_user_carts_shipping_method_options),
					function (options){
						$(options).insertAfter($("[data-type=change-shipping][value=" + id + "]").parents(".radio").get(0));
						
						$("[data-type=shipping-options]").on("change", function(e){
							getCartData(url_user_carts_set_shipping_method_option_id + "/" + $(this).val());
						});
					}
				);
			}
		}
	}
	
	function refreshShippingMethodOptions(cod){
		$("[data-type=shipping-options-toggle]").each(function(){
			var self = this;
			var prop = {
				id      : $(self).attr("data-options-for"),
				show    : $(self).is(":visible"),
				disabled: $("[data-type=shipping-options]", self).prop("disabled"),
				value   : $("[data-type=shipping-options]", self).val()
			};
			
			if ($("#ShippingMethodId" + prop.id).attr("data-has-options") == "true"){
				$.get(
					App.getAjaxUrl(url_user_carts_shipping_method_options + "/" + prop.id),
					function(response){
						$(self).remove();
						
						var option = $(response).insertAfter($("[data-type=change-shipping][value=" + prop.id + "]").parents(".radio"));
						
						if (prop.show){
							option.removeClass("hide");
						}else{
							option.addClass("hide");
						}
						
						if (prop.disabled != undefined){
							$("[data-type=shipping-options]", option).prop("disabled", prop.disabled).trigger("toggle-disabled");
						}
						
						if (prop.value != undefined){
							$("[data-type=shipping-options]", option).val(prop.value);
						}
					}
				);
			}
		});
		
		$("[data-type=cart-cod]").val(cod);
	}
	
	function updatePayment(data){
		$("[data-type=change-payment]").closest(".radio").removeClass("hide");

		if (data.id){
			var checked = $("[data-type=change-payment][value=" + data.id + "]").prop("checked");
			
			if (!checked){
				$("[data-type=change-payment][value=" + data.id + "]").prop("checked", true);
				
				$("[data-type=change-payment]").trigger("update-state");
				
				$("[data-type=change-payment][value=" + data.id + "]").trigger("change");
			}
		}
		
		if (data.labels != undefined){
			$.each(data.labels, function(id, label){
				var id = $("[data-type=change-payment][value=" + id + "]").attr("id");
				
				$("label[for=" + id + "]").html(label);
			});
		}
		
		$("[data-type=change-payment]").prop("disabled", false).trigger("toggle-disabled").parents(".radio");
		
		if (data.exclusion != undefined){
			$.each(data.exclusion, function(i, id){
				var input = $("[data-type=change-payment][value=" + id + "]");
				
				if (input.prop("checked")){
					input.prop("checked", false).trigger("update-state");
					$("[data-type=cart-payment-price]").html("-");
				}
				
				input.prop("disabled", true).trigger("toggle-disabled");
				input.closest(".radio").addClass("hide");
			});
		}
		
		if (data.zagiel != undefined){
			if (data.zagiel.show){
				$("[data-type=zagiel-toggle]").removeClass("hide");
			}else{
				$("[data-type=zagiel-toggle]").addClass("hide");
			}
			
			$("[data-type=zagiel-toggle] [data-type=zagiel]").attr("data-zagiel-price", data.zagiel.price);
		}
		
		if (data.paribas != undefined){
			if (data.paribas.show){
				$("[data-type=bgz-bnp-paribas-toggle]").removeClass("hide");
			}else{
				$("[data-type=bgz-bnp-paribas-toggle]").addClass("hide");
			}
			
			$("[data-type=bgz-bnp-paribas-toggle] [data-type=bgz-bnp-paribas]").attr("data-bgz-bnp-paribas-price", data.paribas.price);
		}
		
		if (data.platforma_finansowa != undefined){
			if (data.platforma_finansowa.show){
				$("[data-type=platforma-finansowa-toggle]").removeClass("hide");
			}else{
				$("[data-type=platforma-finansowa-toggle]").addClass("hide");
			}
			
			$("[data-type=platforma-finansowa-toggle] [data-type=platforma-finansowa]").attr("data-platforma-finansowa-price", data.platforma_finansowa.price);
		}
		
		if (data.credit_agricole != undefined){
			if (data.credit_agricole.show){
				$("[data-type=credit-agricole-toggle]").removeClass("hide");
			}else{
				$("[data-type=credit-agricole-toggle]").addClass("hide");
			}
			
			$("[data-type=credit-agricole-toggle] [data-type=credit-agricole]").attr("data-credit-agricole-price", data.credit_agricole.price);
		}
		
		if (data.dropshipping_cod_value != undefined){
			if (data.dropshipping_cod_value.show){
				$("[data-type=dropshipping-cod-value-toggle]").removeClass("hide");
			}else{
				$("[data-type=dropshipping-cod-value-toggle]").addClass("hide");
			}
		}
		
		if (options.onPaymentUpdate && typeof options.onPaymentUpdate === "function"){
			options.onPaymentUpdate(data);
		}
	}
	
	function updateCosts(data){
		$.each(data, function(i, element){
			if ($("[data-type=" + element.field + "]").is("input")){
				$("[data-type=" + element.field + "]").val(element.value);
			}else{
				$("[data-type=" + element.field + "]").html(element.value);
			}
			
			if (element.toggle != undefined){
				if (element.toggle){
					$("[data-type=" + element.field + "]").parents("[data-type=" + element.field + "-toggle]").removeClass("hide");
				}else{
					$("[data-type=" + element.field + "]").parents("[data-type=" + element.field + "-toggle]").addClass("hide");
				}
			}
		});
	}
	
	function updateFullPackageDiscount(data){
		if (data.show){
			$("[data-type=full-package-discount-toggle]").removeClass("hide");
			$("[data-type=full-package-discount-price]").html(data.price);
			$("[data-type=full-package-discount-products]").html(data.products);
		}else{
			$("[data-type=full-package-discount-toggle]").addClass("hide");
			$("[data-type=full-package-discount-price]").html(data.price);
			$("[data-type=full-package-discount-products]").html(data.products);
		}
	}
	
	function cartSubmitReload(){
		var redirect = $("[data-type=cart-reload]");
		
		redirect.parents("form").unbind("submit").find("input, select").removeAttr("data-validate");
		
		redirect.prop("disabled", false);
		redirect.parents("form").submit();
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
	
	/**
	 * Wyświetlenie / schowanie ikonek do zmiany kolejności produktów
	 * @author TB
	 */
	function updateProductMoveIcons(){
		var products = $("#UserCartIndexForm [data-type=product-row].product-row");
		var length   = products.length;
		
		$("[data-type=product-row-move-up], [data-type=product-row-move-down]").removeClass("hide");
		
		if (length > 0){
			$("[data-type=product-row-move-up]", products.get(0)).addClass("hide");
			$("[data-type=product-row-move-down]", products.get(length - 1)).addClass("hide");
		}
	}
	
	/**
	 * Rozpoczęcie procesu przenoszenia produktów w koszyku
	 * @author TB
	 */
	function startMovingProducts(){
		/* Usuwam wiersze z usługami (nie są potrzebne) */
		$(".service-row").remove();
		
		/* Wyłączam wszystkie inputy */
		$("input:enabled, select:enabled", "#UserCartIndexForm").prop("disabled", true).trigger("toggle-disabled");
		
		/* Wyłączam wszystkie przyciski */
		$("button:enabled, a.btn-primary, a[role=button]", "#UserCartIndexForm").attr("disabled", "disabled").addClass("disabled").on("click", function(){
			return false;
		});
		
		/* Wyłączenie przycisków w boksie handlowca */
		$(".salesrep-cart-box a").attr("disabled", "disabled").addClass("disabled").on("click", function(){
			return false;
		});
		
		/* Wyłączam wysyłkę formularza */
		$("#UserCartIndexForm").on("submit", function(){
			return false;
		});
		
		/* Wyświetlam przycisk do zapisu kolejności */
		$("[data-type=cart-save-products-order]").removeAttr("disabled").removeClass("disabled").removeClass("hide").unbind("click").on("click", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": App.getAjaxUrl(url_user_carts_move_products)
			});
			
			$("input:hidden", "#UserCartIndexForm").prop("disabled", false).each(function(){
				$("<input>", {
					"type": "hidde",
					"name": $(this).attr("name")
				}).val($(this).val()).appendTo(form);
			});
			
			form.appendTo($("body")).submit();
			
			return false;
		});
	}
	
	/**
	 * Zmiana cechy oferty
	 * @param select - Object - select
	 */
	function changeUserCartField(select){
		var self = $(select);
		
		var value              = self.val();
		var user_cart_field_id = self.attr("data-user-cart-field-id");
		
		if (value == "new"){
			$("#NewUserCartFieldValue" + user_cart_field_id).modal("show");
		}else{
			$.get(App.getAjaxUrl(url_user_carts_change_user_cart_field + "/" + user_cart_field_id + "/" + value));
		}
	}
	
	/**
	 * Zmiana statusu zamówienia
	 * @param select - Object - select
	 */
	function changeOrderStatus(select){
		$.get(App.getAjaxUrl(url_user_carts_change_order_status + "/" + $(select).val()));
	}
	
	/**
	 * Wyliczenie kosztów dostawy
	 */
	function calculateShippingCosts(){
		getCartData(url_user_carts_calculate_shipping_costs);
	}
	
	return {
		init: function(userOptions){
			options = $.extend({
				onProductUpdate    : false,
				onCombinationUpdate: false,
				onShippingUpdate   : false,
				onPaymentUpdate    : false
			}, userOptions);
			
			attachEvents();
			updateShippingMethodOptions();
			
			if (App.getSetting("cart-calculate-shipping-costs")){
				calculateShippingCosts();
			}
		}
	};
}());
