var Orders = (function(){
	function attachEvents(){
		/* Filtry na liście zamówień */
		$("[data-type=orders-list-search-form]").on("submit.order-list", function(e){
			submitFilterForm(e, this);
		});
		
		/* Dodawanie produktu do zamówienia */
		$("[data-type=order-add-product-product-id-container] [data-type=autocomplete]").on("autocomplete-select", function(e){
			$.ajax({
				url    : App.getAjaxUrl(url_orders_change_product + "/" + $("[data-type=order-add-product-product-id]").val() + "/" + $("[data-type=order-add-product-user-id]").val()),
				success: function(data){
					updateCombination($.parseJSON(data));
				}
			});
		});
		
		/* Wybór że klient chce dostać fakturę */
		$("[data-type=order-change-payment-data]").on("click", function(e){
			var order_id = $(this).attr("data-order-id");
			
			$("#ChangeOrderPaymentData" + order_id).modal("show");
		});
		
		/* Zapisanie danych do faktury */
		$("[data-type=change-order-payment-data-form]").ajaxsend({
			onfinish : function(response){
				$(".modal").modal("hide");
				
				$(response).modal();
			}
		});
		
		/* Utworzenie oferty z zamówienia */
		$("[data-type=order-reorder-offer-save]").on("click", function(){
			$("[data-type=order-reorder-offer-form-" + $(this).attr("data-order-id") + "]").submit();
			
			return false;
		});
	}
	
	function submitFilterForm(event, form){
		$(getFields(form, true)).prop("disabled", true).trigger("toggle-disabled");
		$("input[data-send!=submit], select[data-send!=submit]", form).prop("disabled", true);
	}
	
	function updateCombination(data){
		if (data.combinations){
			for (x in data.combinations){
				var div = $("<div>", {
					class: "radio"
				});
				
				var id = "OrderCombinationId" + data.product_id + "_" + x;
				
				$("<input>", {
					type : "radio",
					name : "data[Order][combination_id]",
					id   : id,
					value: x
				}).appendTo(div);
				
				$("<label>", {
					for: id
				}).text(data.combinations[x]).appendTo(div);
				
				div.appendTo($("[data-type=order-add-product-combinations]"));
			}
			
			$("[data-type=order-add-product-combinations-container]").removeClass("hide");
		}else{
			$("[data-type=order-add-product-combinations] > div").remove();
			$("[data-type=order-add-product-combinations-container]").addClass("hide");
		}
		
		$("[data-type=order-add-product-price]").val(data.price);
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
	
	return {
		init: function(){
			attachEvents();
		}
	};
}());