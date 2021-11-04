var Opinions = (function(){
	function attachEvents(){
		$("[data-type=opinion-container]").on("click.product-opinion-rating", "[data-type=opinion-rate]", function(e){
			e.preventDefault();
			
			changeOpinionRating($(this).attr("data-product-opinion-id"), $(this).attr("data-rate"));
		});
	}
	
	function changeOpinionRating(id, rate){
		$.get(
			App.getAjaxUrl(url_product_opinions_add_rating + "/" + id + "/" + rate + "?type=index"),
			function(response){
				$("[data-type=opinion-container][data-product-opinion-id=" + id + "]").html($("[data-type=opinion-container][data-product-opinion-id=" + id + "]", response).html());
			}
		);
	}
	
	return {
		init: function(userOptions){
			attachEvents();
		}
	};
}());