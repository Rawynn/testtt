var User = (function(){
	function attachEvents(){
		/* Handlowiec - zmiana konfiguracja konta SMTP do wysyłki ofert */
		$("[data-type=user-salesrep-custom-smtp]").on("change", function(){
			if ($(this).val() == 1){
				$("[data-type=salesrep-smtp-configuration] input").prop("disabled", true).trigger("toggle-disabled");
			}else{
				$("[data-type=salesrep-smtp-configuration] input").prop("disabled", false).trigger("toggle-disabled");
			}
		});
		
		$("[data-type=user-salesrep-custom-smtp]:checked").trigger("change");
	}
	return {
		init: function(){
			attachEvents();
		}
	};
}());