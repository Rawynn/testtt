var ProductList = (function(){
	var options;
	
	function attachEvents(){
		$("[data-toggle=tooltip]").tooltip();
		
		$("[data-type=product-limit]").on("change.product-list", "select", function(){
			var url = $(this).attr("data-url").replace("#show#", $(this).val());
			
			var textarea = $("<textarea>").get(0);
			
			textarea.innerHTML = url;
			
			url = $(textarea).val();
			
			if (options.ajaxPaging){
				getProducts({
					url      : url,
					clear    : true,
					updateUrl: true
				});
			}else{
				window.location.href = url;
			}
		});
		
		$("[data-type=product-sort]").on("change.product-list", "select", function(){
			var url = $(this).val();
			
			if (url != ""){
				if (options.ajaxPaging){
					getProducts({
						url      : url,
						clear    : true,
						updateUrl: true
					});
				}else{
					window.location.href = url;
				}
			}
		});
		
		groupAddListener();
		
		/* Grupowe dodanie produktów do schowka */
		$("[data-type=wishlist-group-submit]").on("click.product-list", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": App.getAjaxUrl(url_wishlists_add)
			});
			
			form.append($("[data-type=cart-group-checkbox]:checked").closest("[data-type=product]").find("[data-type=cart-group-quantity]").clone());
			form.append($("[data-type=cart-group-checkbox]:checked").clone());
			
			if (App.getSetting("add-wishlist-ajax")){
				$.ajax({
					url    : form.attr("action"),
					data   : form.serialize(),
					type   : "POST",
					success: function(data){
						var init = function(context){
							$(self.selector, context).ajaxsend({
								onfinish : function(response){
									show(response);
								}
							});
						};
						
						var show = function(response){
							$(response).on("shown.bs.modal", function(){
								$("[data-type=wishlist-add-group-more]").unbind("click").click(function(e){
									e.preventDefault();
									
									$("[data-type=wishlist-add-group-table] tr").show("slow");
									
									$("[data-type=wishlist-add-group-more]").hide().unbind("click");
								});
							}).on("show.bs.modal", function(){
								$(".add-cart-modal").fadeOut(120, function(){
									$(this).remove();
								});
								
								$(".modal-backdrop").fadeOut(120, function(){
									$(this).remove();
								});
							}).modal({
								backdrop: "static",
								show    : true
							});
						};
						
						show(data);
					}
				});
			}else{
				form.appendTo($("body")).submit();
			}
		});
		
		/* Grupowe dodanie produktów do koszyka */
		$("[data-type=cart-group-submit]").on("click.product-list", function(){
			var form = $("<form>", {
				"method": "POST",
				"action": App.getAjaxUrl(url_user_carts_add_group)
			});
			
			form.append($("[data-type=cart-group-checkbox]:checked").closest("[data-type=product]").find("[data-type=cart-group-quantity]").clone());
			form.append($("[data-type=cart-group-checkbox]:checked").clone());
			
			if (App.getSetting("add-cart-ajax")){
				$.ajax({
					url    : form.attr("action"),
					data   : form.serialize(),
					type   : "POST",
					success: function(data){
						var init = function(context){
							$(self.selector, context).ajaxsend({
								onfinish : function(response){
									show(response);
								}
							});
						};
						
						var show = function(response){
							$(response).on("shown.bs.modal", function(){
								init(this);
								
								$("[data-type=cart-sum-quantity]").text(
									$("[data-type=cart-sum-quantity]", response).text()
								);
								
								$("[data-type=cart-price]").text(
									$($("[data-type=cart-price]", response).get(0)).text()
								);
								
								$($("[data-type=cart-box]")).html(
									$("[data-type=cart-box]", response)
								);
								
								$("[data-type=add-group-more]").unbind("click");
								
								$("[data-type=add-group-more]").click(function(e){
									e.preventDefault();
									
									$("[data-type=add-group-table] tr").show("slow");
									
									$("[data-type=add-group-more]").hide().unbind("click");
								});
								
								ImageLoader.load();
							}).on("show.bs.modal", function(){
								$(".add-cart-modal").fadeOut(120, function(){
									$(this).remove();
								});
								
								$(".modal-backdrop").fadeOut(120, function(){
									$(this).remove();
								});
							}).modal({
								backdrop: "static",
								show    : true
							});
						};
						
						show(data);
					}
				});
			}else{
				form.appendTo($("body")).submit();
			}
		});
		
		if (options.ajaxPaging){
			// Paginator
			$("[data-type=product-list-paginator]").on("click.product-list", "a", function(e){
				e.preventDefault();
				
				if ($(this).attr("data-loaded") == "true"){
					return false;
				}
				
				$(this).attr("data-loaded", "true");
				
				getProducts({
					url      : $(this).attr("href"),
					updateUrl: true
				});
				
				return false;
			});
			$("[data-type=product-list-paginator-top]").on("click.product-list", "a", function(e){
				e.preventDefault();
				
				if ($(this).attr("data-loaded") == "true"){
					return false;
				}
				
				$(this).attr("data-loaded", "true");
				
				getProducts({
					url      : $(this).attr("href"),
					updateUrl: true
				});
				
				return false;
			});
			
			// Wybrane filtry
			$("[data-type=current-filters]").on("click.product-list", "a", function(e){
				e.preventDefault();
				
				// Usunięcie getów z kategorii po lewej stronie jeśli jest getów zgodnie z wyklikanymi filtrami
				if ($("[data-type=categories-box]").length > 0 ){
					var get_params = $(this).attr("href").split("?");
					
					if (get_params.length == 1){
						$("[data-type=categories-box] a[data-category-id]").each(function(index, el){
							var link = $(el).attr("href").split("?");
							
							$(el).attr("href", link[0]);
						});
					}else if(get_params.length == 2){
						$("[data-type=categories-box] a[data-category-id]").each(function(index, el){
							var link = $(el).attr("href").split("?");
							
							$(el).attr("href", link[0] + get_params[1]);
						});
					}
				}
				
				getProducts({
					url      : $(this).attr("href"),
					clear    : true,
					updateUrl: true
				});
			});
			
			// Doładowywanie przy scrollu
			if (options.ajaxLoadOnScroll){
				$(window).on("scroll", function(){
					if ($("[data-type=load-next]").length){
						if ($(window).scrollTop() > Math.round($("[data-type=load-next]").offset().top - ($("[data-type=load-next]").offset().top * 0.5))){
							if ($("[data-type=load-next]").parents("[data-type=product-list-paginator]").attr("data-loaded") != "false"){
								$("[data-type=load-next]").click();
							}
						}
					}
				});
			}
		}
		// Filtry na liście produktów
		$("[data-type=product-listing-filters]").on("change.filter-item", function(e){
			$("[data-type=product-listing-filters]").submit();
		});
		
		$("[data-type=product-listing-filters]").on("submit.product-list", function(e){
			submitFilterForm(e, this);
		});
		
		$("[data-type=product-listing-filters]").on("change.product-list", "input[data-send=reload], select[data-send=reload]", function(){
			window.location.href = $(this).val();
		});
		
		if (options.submitFiltersOnChange){
			$("[data-type=product-listing-filters]").on("change.product-list", "input[data-send=submit], select[data-send=submit]", function(){
				$("[data-type=product-listing-filters]").submit();
			});
		}
		
		// Filtry na pasku bocznym
		runSidebarFilters();
		
		if (options.ajaxPaging){
			$("[data-type=product-sidebar-filters]").on("click.product-list", "[data-type=price-range-filters] a", function(e){
				e.preventDefault();
				getProducts({
					url      : $(this).attr("href"),
					clear    : true,
					updateUrl: true
				});
			});
		}
		
		if (options.submitFiltersOnChange){
			$("[data-type=product-sidebar-filters]").on("change.product-list", "input[data-send=submit], select[data-send=submit]", function(){
				$("[data-type=product-sidebar-filters]").submit();
			});
		}
	}
	
	function submitFilterForm(event, form){
		$(getFields(form, true)).prop("disabled", true).trigger("toggle-disabled");
		
		$("input[data-send!=submit], select[data-send!=submit]", form).prop("disabled", true);
		
		if (options.ajaxPaging){
			event.preventDefault();
			getProducts({
				url      : $(form).attr("action"),
				data     : $(form).serialize(),
				clear    : true,
				updateUrl: true
			});
		}
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
	
	function setupListingFilters(){
		if (getFields($("[data-type=hidden-filters]"), false).length){
			$("[data-type=toggle][href='#HiddenFilters']").click();
		}
	}
	
	function groupAddListener(){
		$("[data-type=cart-group-checkbox]").on("change.product-list", function(){
			var count_selected_products = $("[data-type=cart-group-checkbox]:checked").length;
			
			$("[data-type=add-group-counter]").text(count_selected_products);
			
			if (count_selected_products > 0){
				$("[data-type=cart-group-submit], [data-type=wishlist-group-submit]").attr("disabled", false);
			}else{
				$("[data-type=cart-group-submit], [data-type=wishlist-group-submit]").attr("disabled", true);
			}
		});
	}
	
	// Ustawienia filtrów pasku bocznego
	function setupSidebarFilters(){
		// Wybieram wszytskie zaznaczone
		$("input[type=checkbox]:checked", "[data-type=product-sidebar-filters]").each(function(i, element){
			//var container = $(element).parents("[data-type=filter-row]");
			//var element   = $(element).parents(".input").detach();
			
			//$("[data-type=selected-filters]", container).append(element);
			//sortSidebarFilters($("[data-type=selected-filters]", container));
			$(element).parent().parent().addClass('checked');
		});
		
		checkSidebarFilters();
	}
	
	// Sortowanie filtrów według domyślnego kryterium
	function sortSidebarFilters(container){
		$("input[type=checkbox]", container).parents(".input").sort(function(a, b){
			return $(a).attr("data-order") > $(b).attr("data-order");
		}).prependTo(container);
	}
	
	// Sprawdzenie które filtry wyświetlić
	function checkSidebarFilters(){
		$("[data-type=orderable-filters]", "[data-type=product-sidebar-filters]").each(function(i, container){
			var toggle = $(container).attr("data-collapsed") == "true" ? false : true;
			
			toggleSidebarFilters(toggle, container);
		});
	}
	
	// Wyświetlanie/ukrywanie filtrów
	function toggleSidebarFilters(toggle, container){
		if (toggle){
			$(container).attr("data-collapsed", "false");
			
			$("input[type=checkbox]", container).parents(".input").removeClass("hide");
			
			if ($("input[type=checkbox]", container).length <= options.maxFilterEntries){
				toggleFilterExpander(false, container);
			}else{
				toggleFilterExpander(true, container, "expanded");
			}
		}else{
			$(container).attr("data-collapsed", "true");
			
			$("input[type=checkbox]", container).parents(".input").removeClass("hide");
			$("input[type=checkbox]:gt(" + parseInt(options.maxFilterEntries - 1) + ")", container).parents(".input").addClass("hide");
			
			if ($("input[type=checkbox]", container).length > options.maxFilterEntries){
				toggleFilterExpander(true, container, "collapsed");
			}else{
				toggleFilterExpander(false, container);
			}
		}
	}
	
	// Wyświetlanie/ukrywanie przycisku "więcej"
	function toggleFilterExpander(toggle, container, text){
		if (toggle){
			$("[data-type=filter-expander]", container).removeClass("hide");
		}else{
			$("[data-type=filter-expander]", container).addClass("hide");
		}
		
		if (text != undefined){
			$("[data-type=filter-expander]", container).text(
				$("[data-type=filter-expander]", container).attr("data-text-" + text)
			);
		}
	}
	
	/* Uruchomienie sidebar filtrów */
	function runSidebarFilters(){
		$("[data-type=product-sidebar-filters]").on("submit.product-list", function(e){
			submitFilterForm(e, this);
		});
		
		$("[data-type=product-sidebar-filters]").on("click.product-list", "[data-type=filter-row] a", function(e){
			e.preventDefault();
			
			$(this).parent().click();
		});
		
		$("[data-type=product-sidebar-filters]").on("change.product-list", "input[type=checkbox]", "[data-type=product-sidebar-filters]", function(){
			//var container = $(this).parents("[data-type=filter-row]");
			//var element   = $(this).parents(".input").detach();
			
			if ($(this).prop("checked")){
				//$("[data-type=selected-filters]", container).append(element);
				//sortSidebarFilters($("[data-type=selected-filters]", container));
			}else{
				//$("[data-type=orderable-filters]", container).append(element);
				//sortSidebarFilters($("[data-type=orderable-filters]", container));
			}
			
			checkSidebarFilters();
		});
		
		$("[data-type=product-sidebar-filters]").on("click.product-list", "[data-type=filter-expander]", function(e){
			e.preventDefault();
			
			var container = $(this).parents("[data-type=orderable-filters]");
			var toggle    = container.attr("data-collapsed") == "true" ? true : false;
			
			toggleSidebarFilters(toggle, container);
		});
	}
	
	function getProducts(ajaxOptions){
		$.ajax({
			type      : "GET",
			data      : ajaxOptions.data || {},
			url       : App.getAjaxUrl(ajaxOptions.url),
			beforeSend: function(){
				$("[data-type=product-list-paginator]").attr("data-loaded", "false");
				$("[data-type=product-list-paginator-top]").attr("data-loaded", "false");
				
				if (!options.ajaxAppend){
					$("[data-type=product-list]").attr("data-loaded", "false");
				}
			},
			complete  : function(response){
				// Przeładowanie paginatora
				$("[data-type=product-list-paginator]").attr("data-loaded", "true").html(
					$("[data-type=product-list-paginator] > *", response.responseText)
				);
				
				$("[data-type=product-list-paginator-top]").attr("data-loaded", "true").html(
						$("[data-type=product-list-paginator] > *", response.responseText)
					);
				
				$("[data-type=product-list-paginator-info]").text(
					$("[data-type=product-list-paginator-info]", response.responseText).text()
				);
				
				// Przeładowanie filtrów
				$("[data-type=product-listing-filters]").empty().html(
					$("[data-type=product-listing-filters] > *", response.responseText)
				);
				
				$("[data-type=product-sidebar-filters]").empty().html(
					$("[data-type=product-sidebar-filters] > *", response.responseText)
				);
				
				// Przeładowanie wybranych filtrów
				$("[data-type=current-filters]").empty().html(
					$("[data-type=current-filters] > *", response.responseText)
				);
				
				// Przeładowanie zmiany sortowania
				$("[data-type=product-sort]").empty().html(
					$("[data-type=product-sort] > *", response.responseText)
				);
				
				// Przeładowanie zmiany ilości
				$("[data-type=product-limit]").empty().html(
					$("[data-type=product-limit] > *", response.responseText)
				);
				
				/* Przeładowanie linków do zmiany widoków */
				$("[data-type=product-listing-view-type]").empty().html(
					$("[data-type=product-listing-view-type] > *", response.responseText)
				);
				
				if (options.ajaxAppend){
					if (ajaxOptions.clear){
						$("[data-type=product-list]").empty();
					}
					
					$("[data-type=product-list]").append(
						$("[data-type=product-list] > *", response.responseText)
					).attr("data-loaded", "true");
				}else{
					$("[data-type=product-list]").empty().html(
						$("[data-type=product-list] > *", response.responseText)
					).attr("data-loaded", "true");
					
					/* Wyliczam pozycję scrollowania -> domyślne - na początek listy */
					setTimeout(
						function(){
							var scroll_position = $("[data-type=product-listing-filters]").offset().top - 10;
							
							/* Jeżeli był kliknięty produkt -> scrolluję do tego produktu */
							var product_id = null;
							
							/* Aktualny hash - szukam ID produktu */
							var hash = window.location.hash.substr(1).split("|");
							
							for (i in hash){
								var item = hash[i];
								
								if (item.indexOf("product-id") == 0){
									product = item.split(":");
									
									product_id = product[1];
									
									break;
								}
							}
							
							if (product_id != null){
								var product_container = $("[data-type=product][data-product-id=" + product_id + "]");
								
								if (product_container.length > 0){
									scroll_position = product_container.offset().top;
								}
							}
							
							$("html, body").animate({
								scrollTop: scroll_position
							}, 1000);
						},
						500
					);
				}
				
				if (ajaxOptions.updateUrl){
					updateUrl($("[data-type=current-ajax-url]", response.responseText));
				}
				
				setupListingFilters();
				setupSidebarFilters();
				groupAddListener();
				
				if (ProductFieldUpdater.getRuning()){
					/* Wymuszenie aktualizacji cen */
					ProductFieldUpdater.update();
				}
				
				/* b-lazy script */
				bLazy.revalidate();
			}
		});
	}
	
	function updateUrl(data){
		history.pushState({}, data.attr("title"), data.attr("data-current-url"));
	}
	
	function logClicks(){
		$("[data-type=product-list]").on("click.landing-page", "a", function(e){
			e.preventDefault();
			
			var self       = this;
			var productUrl = $(self).parents("li").find("a[data-type=product-url]").attr("href");
			var currentUrl = $(self).attr("href");
			
			$.get(
				$("[data-type=product-list]").attr("data-url") + "?href=" + productUrl,
				function(){
					if (App.getSetting("add-cart-ajax") && $(self).hasClass("btn-add-cart")){
						return false;
					}
					
					if (App.getSetting("add-wishlist-ajax") && $(self).hasClass("btn-add-wishlist")){
						return false;
					}
					
					document.location.href = currentUrl;
				}
			);
		});
	}
	
	/* Dodanie parametrów GET do linków */
	function addProductLinkParams(){
		/* Dodanie parametrów */
		var fields = ["from", "campaign-id", "q"];
		
		for (i in fields){
			var field = fields[i];
			
			$(".product-list[data-" + field + "] > li a").each(function(){
				var $this      = $(this);
				var fieldValue = $this.parents("ul.product-list[data-" + field + "]").attr("data-" + field).replace(" ", "+");
				
				if (fieldValue != "" && fieldValue != "0"){
					var href = $this.attr("href");
					
					if (href.indexOf(field + "=") == -1){
						if (href.indexOf("?") >= 0){
							href += "&";
						}else{
							href += "?";
						}
						
						$this.attr("href", href + field + "=" + fieldValue);
					}
				}
			});
			
			/* Dodaję do URL'a który produkt został kliknięty */
			$("[data-type=product-list] .product-list[data-" + field + "] > li a[data-type=product-url]").unbind("click.product").on("click.product", function(){
				/* Aktualny hash */
				var hash = window.location.hash ? window.location.hash.substr(1).split("|") : [];
				
				/* ID produktu */
				var product_id = $($(this).parents("[data-type=product]").get(0)).attr("data-product-id");
				
				/* Czy ID zostało dodane */
				var product_id_added = false;
				
				/* Sprawdzam aktualny HASH - jeżeli jest już fragment z product-id -> aktualizuję */
				for (i in hash){
					var item = hash[i];
					
					if (item.indexOf("product-id") == 0){
						hash[i] = "product-id:" + product_id;
						
						product_id_added = true;
					}
				}
				
				/* Nie było fragmentu z product-id -> dodaję*/
				if (!product_id_added){
					hash.push("product-id:" + product_id);
				}
				
				window.location.hash = hash.join("|");
			});
		}
	}
	
	return{
		init : function(userOptions){
			options = $.extend({
				ajaxPaging: false,
				ajaxAppend: false,
				logClicks : false,
				submitFiltersOnChange : false
			}, userOptions);
			
			attachEvents();
			setupListingFilters();
			setupSidebarFilters();
			
			if (options.logClicks){
				logClicks();
			}
			
			/* Przeskrolowanie do produktu */
			
			/* Jeżeli był kliknięty produkt -> scrolluję do tego produktu */
			var product_id = null;
			
			/* Aktualny hash - szukam ID produktu */
			var hash = window.location.hash.substr(1).split("|");
			
			for (i in hash){
				var item = hash[i];
				
				if (item.indexOf("product-id") == 0){
					product = item.split(":");
					
					product_id = product[1];
					
					if (product_id != null){
						var product_container = $("[data-type=product][data-product-id=" + product_id + "]");
						
						if (product_container.length > 0){
							$("html, body").animate({
								scrollTop: product_container.offset().top
							}, 1000);
						}
					}
					
					break;
				}
			}
		},
		addProductLinkParams: function(){
			/* Dodanie parametrów GET do linków */
			addProductLinkParams();
			
			$(document).ajaxComplete(function(){
				setTimeout(
					function(){
						addProductLinkParams();
					},
					500
				);
			});
		},
		setupSidebarFilters: function(){
			setupSidebarFilters();
		},
		runSidebarFilters: function(){
			runSidebarFilters();
		}
	};
}());