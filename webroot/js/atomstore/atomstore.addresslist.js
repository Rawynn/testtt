var AddressList = (function(){
	function attachEvents(){
		$("[data-type=set-address-default]").on("change.user-address-list", function(){
			userAddressChangeField("default", $(this).val());
		});
		
		$("[data-type=set-address-invoice]").on("change.user-address-list", function(){
			userAddressChangeField("invoice", $(this).val());
		});
		
		$("[data-type=delete-address]").on("click.user-address-list", function(){
			$("[data-type=delete-address-target]").attr("href", $(this).attr("data-target-url"));
		});
	}
	
	function userAddressChangeField(field, value){
		$.get(App.getAjaxUrl(url_user_addresses_change_field + "/" + field + "/" + value));
	}
	
	return {
		init: function(userOptions){
			attachEvents();
		}
	};
}());