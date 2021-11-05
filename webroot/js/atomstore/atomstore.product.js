var Product = (function(){
	var options;
	
	function attachEvents(){
		/* Zmiana ilości */
		$("[data-type=product-change-quantity-input]").on("product.change.quantity", function(){
			changeProductQuantity($(this));
		});
		
		$("[data-type=product-form]").on("change.product", "[data-type=change-service]", function(){
			changeService(this);
		});
		
		$("[data-type=change-rating]").on("click.product-rating", "a", function(e){
			e.preventDefault();
			
			changeRating($(this).attr("data-rating"));
		});
		
		$("[data-type=change-rating] a").hover(
			function(){
				hoverRating(true, this);
			},
			function(){
				hoverRating(false, this);
			}
		);
		
		$("[data-type=opinion-list-container]").on("click.product-opinion-rating", "[data-type=opinion-rate]", function(e){
			e.preventDefault();
			
			changeOpinionRating($(this).attr("data-product-opinion-id"), $(this).attr("data-rate"));
		});
		
		/* Przy zmianie zakładek (jeśli są), zmieniam typ dodawany do koszyka za punkty lub kasę */
		$("[data-type=add-to-cart-loyalty]").on("shown.bs.tab", function(e){
			if (e.target.hash == "#zakup-za-punkty"){
				$("[data-type=add-to-cart-by-loyalty]").val(1);
			}else{
				$("[data-type=add-to-cart-by-loyalty]").val(0);
			}
		});
		
		/* Podmiana wariantu przy dodawaniu do schowka */
		$("[data-type=add-to-wishlist][data-combination-id]").on("click", function(){
			$(this).attr("href", $(this).attr("data-href") + "/" + $(this).attr("data-combination-id"));
		});
		
		
		/* Zaznaczone atrybuty na zestawie - wymuszam przeliczenie cen */
		$(function(){
			var last_select = $("[data-type=product-variant-container] [data-type=change-product-variant]").last();
			
			if (last_select.length == 1 && last_select.val()){
				last_select.change();
			}
		});
	}
	
	function initComponents(){
		if (options.initGallery != undefined && typeof options.initGallery == "function"){
			options.initGallery();
		}
		
		if (options.initTabs != undefined && typeof options.initTabs == "function"){
			options.initTabs();
		}
	}
	
	/**
	 * Zmiana ilości sztuk na karcie produktu
	 */
	function changeProductQuantity(element){
		if (element.attr("data-url")){
			$.ajax({
				url    : element.attr("data-url"),
				data   : $.param({
					"product_id"    : element.attr("data-product-id"),
					"combination_id": element.attr("data-combination-id"),
					"quantity"      : element.val().replace(",", ".")
				}),
				success: function(response){
					$("[data-type=product-availability]").html(response);
				}
			});
		}
	}
	
	function changeService(element){
		var key = "[data-type=change-service-quantity][data-service-key=" + $(element).attr("data-service-key") + "]";
		
		var prefix = typeof $(element).attr("data-prefix") != "undefined" ? $(element).attr("data-prefix") : "";
		
		if ($(element).prop("checked")){
			$(key).prop("disabled", true);
			$(key + "[data-service-id=" + $(element).val() + "]").prop("disabled", false);
		}else{
			$(key + "[data-service-id=" + $(element).val() + "]").prop("disabled", true);
		}
		
		/* Wyświetlenie komentarzy do usług */
		$("[data-type=service-product-custom-description][data-prefix=" + prefix + "]").addClass("hide").find(".form-control").prop("disabled", true);
		
		$("[data-type=change-service][data-prefix=" + prefix + "]:checked").each(function(){
			$("[data-type=service-product-custom-description][data-prefix=" + prefix + "][data-product-id=" + $(this).val() + "]").removeClass("hide").find(".form-control").prop("disabled", false);
		});
	}
	
	function changeRating(note){
		$("[data-type=change-rating] [data-type=rating-item]").removeClass("selected");
		
		for (var i = 0; i < note; i++){
			$("[data-type=change-rating] [data-type=rating-item]").eq(i).addClass("selected");
		}
		
		$("[data-type=rating]").val(note).trigger("change");
	}
	
	function hoverRating(hover, element){
		if (hover){
			var note = $(element).attr("data-rating");
			
			for (var i = 0; i < note; i++){
				$("[data-type=change-rating] [data-type=rating-item]").eq(i).addClass("hover");
			}
		}else{
			$("[data-type=change-rating] [data-type=rating-item]").removeClass("hover");
		}
	}
	
	function changeOpinionRating(id, rate){
		$("[data-type=opinion-list-container]").load(
			App.getAjaxUrl(url_product_opinions_add_rating + "/" + id + "/" + rate)
		);
	}
	
	return {
		init: function(userOptions){
			options = $.extend({
				initGallery: false,
				initTabs   : false
			}, userOptions);
			
			attachEvents();
			initComponents();
			changeRating($("[data-type=rating]").val());
			
			/* Pionowa galeria miniaturek */
			if ($(".carousel-inited").length > 0){
				$(".thin li:first-child").addClass('active');
				
				if ($(window).width() > 976){
					$(".thin").carousel2({
						vertical: true
					});
				}
				
				if ($(window).width() > 976 && $(window).width() < 1303){
					var heightmain = $(".carousel-box.carousel-indicators-true").height();
					
					$(".thin > .window").height(heightmain);
					$(".thin").height(heightmain);
					
					$(window).resize(function(){
						var heightmain2 = $(".carousel-box.carousel-indicators-true").height();
						
						$(".thin > .window").height(heightmain2);
						$(".thin").height(heightmain2);
					});
				}
				
				$(".carousel-inited > a").on("click", function(){
					/* b-lazy script */
					bLazy.revalidate();
				});
			}
			
			/* Otwarcie odpowiedniej zakładki */
			var hash = window.location.hash.substr(1);
			
			if (hash){
				try{
					if ($("[data-type=slidemenu][data-target=" + hash + "]").length == 1){
						$("[data-type=slidemenu][data-target=" + hash + "]").click();
					}
				}catch (err){}
			}
			
			/* Loading zdjęć w galerii */
			$(".carousel-control").on("click", function(){
				ImageLoader.load();
			});
			
			$(".carousel-indicators li").on("click", function(){
				ImageLoader.load();
			});
		},
		changeService: function(element){
			changeService(element);
		}
	};
}());