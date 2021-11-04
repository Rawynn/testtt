var App = {
	ajaxDomainUrl: "",
	appPath      : "",
	settings     : {},
	onready      : function(){
		$.ajaxSetup({
			cache    : false,
			xhrFields: {
				withCredentials: true
			},
			headers: {
				"User-Hash": App.getSetting("user-hash")
			}
		});
		
		this.initComponents();
		this.attachEvents();
	},
	onload       : function(){
		var date    = new Date();
		var minutes = 30;
		
		date.setTime(date.getTime() + (minutes * 60 * 1000));
		
		$.cookie("window_size", $(window).width() + "x" + $(window).height(), {expires: date});
	},
	attachEvents : function(){
		/* Wysyłanie formularzy */
		$("[data-submit=once]").on("submit.form", function(e){
			if ($(this).ketchup("isValid") == null || $(this).ketchup("isValid")){
				$("input[type=submit]:not([data-submit=no-disable]), .form-submit, .disable-on-submit", this).addClass("disabled").prop("disabled", true);
			}
		});
		
		$(".js-submit").click(function(e){
			e.preventDefault();
			
			if (!$(this).hasClass("disabled")){
				$(this).parents("form").submit();
			}
		});
		
		/* Otwierania kalkulatora Żagiel */
		$("[data-type=zagiel]").on("click", function(e){
			e.preventDefault();
			
			var url = "https://" + "wniosek.eraty.pl/symulator/oblicz/numerSklepu/" + $(this).attr("data-zagiel-shop-nr") + "/wariantSklepu/" + $(this).attr("data-zagiel-shop-type") + "/typProduktu/0/wartoscTowarow/" + $(this).attr("data-zagiel-price");
			
			window.open(url, "Zagiel", "width=650, height=600, directories=no, location=no, menubar=no, resizable=yes, scrollbars=no, status=no, toolbar=no");
		});
		
		/* Otwierania kalkulatora BGŻ BNP Paribas */
		$("[data-type=bgz-bnp-paribas]").on("click", function(e){
			e.preventDefault();
			
			var url = "https://" + "irata.bgzbnpparibas.pl/eshop-form/calc?RequestedAmount=" + $(this).attr("data-bgz-bnp-paribas-price") + "&AgreementNo=" + $(this).attr("data-bgz-bnp-paribas-agreement-no") + "&CreditType=" + $(this).attr("data-bgz-bnp-paribas-credit-type");
			
			window.open(url, "BGŻ BNP Paribas", "width=550, height=410, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no");
		});
		
		/* Otwierania kalkulatora PlatformaFinansowa */
		$("[data-type=platforma-finansowa]").on("click", function(e){
			$(this).attr("href", $(this).attr("data-main-url") + $(this).attr("data-platforma-finansowa-price"));
		});
		
		/* Otwierania kalkulatora Credit Agricole */
		$("[data-type=credit-agricole]").on("click", function(e){
			e.preventDefault();
			
			var url = "https://" + "ewniosek.credit-agricole.pl/eWniosek/simulator.jsp?PARAM_TYPE=RAT&PARAM_PROFILE=" + $(this).attr("data-credit-agricole-parner-id") + "&PARAM_CREDIT_AMOUNT=" + $(this).attr("data-credit-agricole-price");
			
			window.open(url, "CreditAgricole", "width=784, height=732, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no");
		});
		
		/* Zmiana producenta - pasek boczny */
		$("[data-type=producer-select]").on("change.producers", function(){
			window.location.href = $(this).val();
		});
		
		/* Lista zamówień - eksport zamówień do XLS'a */
		$("[data-type=orders-xls-export]").on("click.orders", function(){
			$("[data-type=orders-list-search-form] input, [data-type=orders-list-search-form] select").each(function(){
				if ($(this).val() == ""){
					$(this).prop("disabled", true);
				}
			});
			
			var data = $("[data-type=orders-list-search-form]").serialize();
			
			$("[data-type=orders-list-search-form] input, [data-type=orders-list-search-form] select").prop("disabled", false);
			
			window.location.href = url_orders_xls + "?" + data;
			
			return false;
		});
		
		/* Wybór klienta przez handlowca w nagłówku */
		present_user_id = $("[data-type=salesrep-user-select-header]").val();
		
		$("[data-type=salesrep-user-select-header]").on("change.user", function(){
			if ($(this).val() == "new"){
				window.location.href = url_users_add_and_select;
			} else {
				$("[data-type=salesrep-user-id-header]").val($(this).val());
				
				$("#ChangeSalesrepsClient").on("shown.bs.modal", function(){
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
				}).on("hide.bs.modal", function (e) {
					$("[data-type=salesrep-user-select-header]").val(present_user_id).change();
				});
			}
		});
		
		/* Wybór klienta przez handlowca */
		$("[data-type=salesrep-user-select]").on("change.user", function(){
			if ($(this).val() == "new"){
				window.location.href = url_users_add_and_select;
			}
		});
		
		/* Wybór klienta przez handlowca w panelu handlowca */
		$("[data-type^=salesrep-user-select-list-]").on('click', function(){
			$("[data-type=salesrep-user-id-header]").val($(this).attr("data-id"));
			
			$("#ChangeSalesrepsClient").on("shown.bs.modal", function(){
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
		});
	},
	initComponents: function(){
		/* Komunikaty */
		$.messages();
		
		/* Pretty Loader */
		$.prettyLoader();
		
		/* Preładowanie obrazków */
		ImageLoader.load();
		
		$(document).ajaxStop(function(){
			ImageLoader.load();
		});
		
		/* Formularze, graficzne inputy */
		var initTransform = function(){
			$(document).transform();
			$(".quantity-input").quantityInput();
			
			$(".modal").on("shown.bs.modal", function(){
				$(document).transform();
				$(".quantity-input").quantityInput();
			});
		};
		
		$(document).ajaxComplete(function(event, xhr, settings){
			initTransform();
		});
		
		initTransform();
		
		/* Carousel */
		$(".carousel").each(function(index, element){
			var interval = $(element).attr("data-interval");
			
			$(element).carousel({
				interval : interval == "false" ? false : interval
			});
		});
		
		$(".show-3 .carousel .item").each(function(){
			next = $(this).next();
			prev = $(this).prev();
			
			if (prev.length > 0){
				prev.children(":nth-child(2)").clone().prependTo($(this));
			}else{
				$(this).siblings(":last").children(":first-child").clone().prependTo($(this));
			}
			
			if (next.length > 0) {
				next.children(":first-child").clone().appendTo($(this));
			}else{
				$(this).siblings(":first").children(":nth-child(2)").clone().appendTo($(this));
			}
		});
		
		/* Inicjalizacja walidacji formularzy */
		$("form[data-validate=true]").each(function(index, form){
			$(form).find("input[type=submit]:not(#CouponCartSubmit)").click(function(){
				$(form).ketchup({
					validateEvents: "change.ketchup blur.ketchup"
				});
			});
		});
		
		/* Formularze wysyłane AJAX"em */
		$(".ajax-modal-form").ajaxsend({
			onfinish : function(response){
				$(response).on("show.bs.modal", function(){
					$(document.body).addClass("modal-open");
				}).modal();
			}
		});
		
		/* Autocomplete */
		var initAutocomplete = function(context){
			$("[data-ac=true]").each(function(index, element){
				var self = $(element);
				
				self.unbind("autocompleteopen").unbind("autocompleteselect").unbind("change");
				
				var acInst = self.autocomplete({
					source   : App.getAjaxUrl(self.attr("data-ac-url")),
					appendTo : self.attr("data-ac-handler"),
					minLength: 3,
					delay    : 300
				}).data("ui-autocomplete");
				
				if (self.attr("data-ac-extended") == "true"){
					acInst._renderItem = function(ul, item){
						return $("<li>").append($("<a>" ).html(item.label)).appendTo(ul);
					};
					
					self.on("autocompleteopen", function(event, ui){
						$(".ui-autocomplete").addClass("ui-autocomplete-extended product-list small");
					});
					
					self.on("autocompleteselect", function(event, ui){
						window.location.href = ui.item.url;
					});
				};
				
				if (self.attr("data-ac-copy")){
					self.on("autocompleteselect", function(event, ui){
						$(self.attr("data-ac-copy")).val(ui.item.id);
					});
					
					self.on("change", function(){
						if ($(this).val() == ""){
							$(self.attr("data-ac-copy")).val("");
						}
					});
					
					if (self.attr("data-ac-copy-clear") == "true"){
						self.on("keyup", function(){
							$(self.attr("data-ac-copy")).val("");
						});
					}
				};
				
				if (self.attr("data-ac-copy-fields")){
					self.on("autocompleteselect", function(event, ui){
						$.each(JSON.parse(self.attr("data-ac-copy-fields")), function(field, selector){
							if (ui.item[field] != undefined){
								var value = $(selector).val();
								
								if ($(selector).is("select")){
									if ($("option[value=" + ui.item[field] + "]", $(selector)).length == 1){
										$(selector).val(ui.item[field]).trigger("update-state");
									}
								}else{
									$(selector).val(ui.item[field]).trigger("update-state");
								}
								
								if ($(selector).val() != value){
									$(selector).trigger("change");
								}
							}
						});
					});
					
					$.each(JSON.parse(self.attr("data-ac-copy-fields")), function(field, selector){
						self.on("change", function(){
							if ($(this).val() == ""){
								$(selector).val("");
							}
						});
					});
				}
				
				if (self.attr("data-trigger")){
					self.on("autocompleteselect", function(event, ui){
						self.trigger(self.attr("data-trigger"));
					});
				}
				
				if (self.attr("data-trigger-autocomplete")){
					self.on("autocompleteselect", function(event, ui){
						self.trigger(self.attr("data-trigger-autocomplete"), {event_: event, ui_: ui});
					});
				}
				
				if (self.attr("data-render-html")){
					acInst._renderItem = function(ul, item){
						return $("<li></li>")
							.data("item.autocomplete", item)
							.append("<a>" + item.label + "</a>")
							.appendTo(ul);
					};
					
					self.on("autocompleteselect", function(event, ui){
						self.val(ui.item.full_name ? ui.item.full_name : ui.item.name);
						
						return false;
					});
				}
				
				if (self.attr("data-ac-field")){
					self.on("autocompleteselect", function(event, ui){
						self.val(ui.item[self.attr("data-ac-field")]);
						
						return false;
					});
				}
			});
		};
		
		initAutocomplete(document);
		
		$(document).ajaxComplete(function(event, xhr, settings){
			initAutocomplete(xhr.responseHTML);
		});
		
		/* Datepicker */
		$(".datepicker").datepicker({
			dateFormat: "yy-mm-dd"
		});
		
		/* Zakładki ładowane AJAX"em */
		$(".mainpage-tabs").ajaxtabs();
		
		/* Dodawanie produktu do koszyka AJAX */
		if (this.getSetting("add-cart-ajax")){
			$("[data-type=add-to-cart], [data-type=product-form], [data-type=product-modal-form]").ajaxcart({
				onfinish : function(response){
					if ($("[data-type=product-modal-form]").length){
						ProductVariants.init({
							form          : $("[data-type=product-modal-form]"),
							updateFields  : false,
							updateServices: false
						});
					}
					
					initTransform();
					
					$(document.body).addClass("modal-open");
					
					ImageLoader.load();
				}
			});
		}
		
		/* Dodawanie produktu do schowka AJAX */
		if (this.getSetting("add-wishlist-ajax")){
			$("[data-type=add-to-wishlist]").ajaxwishlist({
				onfinish : function(){
					$(document.body).addClass("modal-open");
					
					ImageLoader.load();
				}
			});
		}
		
		/* Dodawanie produktu do porównania AJAX */
		if (this.getSetting("add-cart-ajax") || this.getSetting("add-wishlist-ajax")){
			$("[data-type=add-to-compare]").ajaxcompare({
				onfinish : function(){
					$(document.body).addClass("modal-open");
					
					ImageLoader.load();
				}
			});
		}
		
		/* Aktualizacja danych produktu */
		ProductFieldUpdater.update();
		
		/* Dodanie parametrów GET linkom */
		ProductList.addProductLinkParams();
		
		/* Ankiety/formularze */
		Surveys.init();
		
		/* Porównywarka */
		Comparison.init();
		
		/* Drzewko kategorii */
		Categories.init({
			isAjax: App.getSetting("categories-box-ajax"),
			url   : App.getSetting("categories-ajax-url")
		});
		
		/* PopUp Newslettera */
		if (App.getSetting("newsletter-popup-delay")){
			setTimeout(
				function(){
					$("[data-type=newsletter-popup]").modal();
					
					if ($("[data-type=newsletter-popup]").length > 0){
						/* Ping o otwarciu */
						$.get(App.getAjaxUrl(url_newsletter_subscribers_popup_open));
					}
				},
				App.getSetting("newsletter-popup-delay") * 1000
			);
		}else{
			$("[data-type=newsletter-popup]").modal();
			
			if ($("[data-type=newsletter-popup]").length > 0){
				/* Ping o otwarciu */
				$.get(App.getAjaxUrl(url_newsletter_subscribers_popup_open));
			}
		}
		
		$("[data-type=newsletter-popup] form").ajaxsend({
			onfinish: function(response){
				$("[data-type=newsletter-popup]").modal("hide");
				
				$(response).modal();
			}
		});
		
		/* Informacje o ciasteczkach */
		$(".cookie-message-inner a.close").click(function(){
			$.get($(this).attr("href"));
			
			$(".cookie-message").remove();
			
			return false;
		});
		
		switch(this.getAppPath()){
			case "products/index":
			case "landing_pages/show":
			case "static_pages/show":
			case "news/show":
				/* Lista produktów */
				ProductList.init({
					ajaxPaging           : this.getSetting("ajax-paging"),
					ajaxAppend           : this.getSetting("ajax-preloading"),
					ajaxLoadOnScroll     : false,
					maxFilterEntries     : this.getSetting("max-filter-entries"),
					submitFiltersOnChange: false,
					logClicks            : this.getAppPath() == "landing_pages/show" ? true : false
				});
				
				Product.init({
					initGallery: function(){
						var galleryOptions = {
							container          : "#modal-gallery",
							displayClass       : "modal-gallery-display",
							controlsClass      : "modal-gallery-controls",
							singleClass        : "modal-gallery-single",
							leftEdgeClass      : "modal-gallery-left",
							rightEdgeClass     : "modal-gallery-right",
							playingClass       : "modal-gallery-playing",
							closeOnSlideClick  : false,
							toggleControls     : false,
							hidePageScrollbars : false,
							thumbnailIndicators: true,
							slideMargin        : 30,
							onslide            : function(){
								$(".hide-on-slide").fadeOut(100);
								
								if (typeof window.yt !== "undefined"){
									if (typeof window.yt.players !== "undefined"){
										$.each(window.yt.players, function(i, player){
											player.pauseVideo();
										});
									}
								}
							},
							onclose            : function(){
								if (typeof window.yt !== "undefined"){
									if (typeof window.yt.players !== "undefined"){
										window.yt.players = new Array();
									}
								}
								//dla win8 nie chował się ten kontener
								setTimeout(function(){
									if ($(".modal-gallery").is(":visible")){
										$(".modal-gallery").hide();
									}
								}, 500);
							},
							onslideend         : function(){
								$(".hide-on-slide").fadeIn(100);
							}
						};
						
						$("[data-type=landing-gallery], [data-type=static-page-gallery], [data-type=news-gallery]").on("click.product", function(e){
							e.preventDefault();
							
							var galleryParts = new Array();
							
							$("[data-type=" + $(this).attr("data-type") + "] img").each(function(index, img){
								galleryParts.push({
									title    : $(img).attr("alt"),
									href     : $(img).attr("data-url"),
									thumbnail: $(img).attr("data-thumb")
								});
							});
							
							var gallery = blueimp.Gallery(galleryParts, $.extend(galleryOptions, {
								container: "#modal-gallery",
								onslide  : function(index, slide){
									$(".modal-gallery").find("img").each(function(){
										$(this).attr("title", $("<div>").html($(this).attr("title")).text());
									});
									
									var carousel_gallery = $("#modal-gallery");
									var all_elements     = this.list.length;
									var height_carousel  = carousel_gallery.height()-80;
									var on_page_elements = Math.floor((height_carousel/65));
									
									if (all_elements > on_page_elements){
										if (index == 0){
											$(".indicator [data-index]", carousel_gallery).show();
											
											for (var i = 0 ; i < all_elements ; i++){
												if (i >= parseInt(on_page_elements)){
													$(".indicator [data-index=" + i + "]", carousel_gallery).hide();
												}
											}
										}else if(parseInt(index) == parseInt((all_elements-1))){
											var showed_ = 0;
											
											$(".indicator [data-index]", carousel_gallery).hide();
											
											for (var i = parseInt((all_elements-1)) ; i >= 0 ; i--){
												if (showed_ < on_page_elements){
													$(".indicator [data-index=" + i + "]", carousel_gallery).show();
													showed_++;
												}
											}
										}else{
											var next_el = $(".indicator [data-index=" + parseInt(index + 1) + "]", carousel_gallery);
											var prev_el = $(".indicator [data-index=" + parseInt(index - 1) + "]", carousel_gallery);
											
											if (next_el.length && !next_el.is(":visible")){
												next_el.show();
												
												$(".indicator [data-index]:visible:eq(0)", carousel_gallery).hide();
											}
											
											if (prev_el.length && !prev_el.is(":visible")){
												prev_el.show();
												
												$(".indicator [data-index]:visible:last", carousel_gallery).hide();
											}
										}
									}
								}
							}));
							
							gallery.slide(parseInt($(this).attr("data-medium-id")));
						});
					}
				});
				
				break;
			case "products/show":
			case "products/admin_preview":
				/* Karta produktu */
				Product.init({
					initGallery: function(){
						var galleryOptions = {
							container          : "#modal-gallery",
							displayClass       : "modal-gallery-display",
							controlsClass      : "modal-gallery-controls",
							singleClass        : "modal-gallery-single",
							leftEdgeClass      : "modal-gallery-left",
							rightEdgeClass     : "modal-gallery-right",
							playingClass       : "modal-gallery-playing",
							closeOnSlideClick  : false,
							toggleControls     : false,
							hidePageScrollbars : false,
							thumbnailIndicators: true,
							slideMargin        : 30,
							onslide            : function(){
								$(".hide-on-slide").fadeOut(100);
								
								if (typeof window.yt !== "undefined"){
									if (typeof window.yt.players !== "undefined"){
										$.each(window.yt.players, function(i, player){
											player.pauseVideo();
										});
									}
								}
							},
							onclose            : function(){
								if (typeof window.yt !== "undefined"){
									if (typeof window.yt.players !== "undefined"){
										window.yt.players = new Array();
									}
								}
								//dla win8 nie chował się ten kontener
								setTimeout(function(){
									if ($(".modal-gallery").is(":visible")){
										$(".modal-gallery").hide();
									}
								}, 500);
							},
							onslideend         : function(){
								$(".hide-on-slide").fadeIn(100);
							}
						};
						
						$("[data-type=product-gallery]").on("click.product", function(e){
							e.preventDefault();
							
							var galleryParts = new Array();
							
							$("[data-type=product-gallery] img").each(function(index, img){
								galleryParts.push({
									title    : $(img).attr("alt"),
									href     : $(img).attr("data-url"),
									thumbnail: $(img).attr("data-thumb")
								});
							});
							
							var gallery = blueimp.Gallery(galleryParts, $.extend(galleryOptions, {
								container: "#modal-gallery",
								onslide  : function(index, slide){
									$(".modal-gallery").find("img").each(function(){
										$(this).attr("title", $("<div>").html($(this).attr("title")).text());
									});
									
									var carousel_gallery = $("#modal-gallery");
									var all_elements     = this.list.length;
									var height_carousel  = carousel_gallery.height() - 80;
									var on_page_elements = Math.floor((height_carousel / 65));
									
									if (all_elements > on_page_elements){
										if (index == 0){
											$(".indicator [data-index]", carousel_gallery).show();
											
											for (var i = 0 ; i < all_elements ; i++){
												if (i >= parseInt(on_page_elements)){
													$(".indicator [data-index=" + i + "]", carousel_gallery).hide();
												}
											}
										}else if(parseInt(index) == parseInt((all_elements-1))){
											var showed_ = 0;
											
											$(".indicator [data-index]", carousel_gallery).hide();
											
											for (var i = parseInt((all_elements-1)) ; i >= 0 ; i--){
												if (showed_ < on_page_elements){
													$(".indicator [data-index=" + i + "]", carousel_gallery).show();
													showed_++;
												}
											}
										}else{
											var next_el = $(".indicator [data-index=" + parseInt(index + 1) + "]", carousel_gallery);
											var prev_el = $(".indicator [data-index=" + parseInt(index - 1) + "]", carousel_gallery);
											
											if (next_el.length && !next_el.is(":visible")){
												next_el.show();
												
												$(".indicator [data-index]:visible:eq(0)", carousel_gallery).hide();
											}
											
											if (prev_el.length && !prev_el.is(":visible")){
												prev_el.show();
												
												$(".indicator [data-index]:visible:last", carousel_gallery).hide();
											}
										}
									}
								}
							}));
							
							gallery.slide(parseInt($(this).attr("data-medium-id")));
						});
						
						$("[data-type=product-youtube-gallery]").on("click.product", function(e){
							e.preventDefault();
							
							var youtube = blueimp.Gallery($.parseJSON($(this).attr("data-yt")), $.extend(galleryOptions, {
								container        : "#modal-video-gallery",
								youTubePlayerVars: {
									wmode: "transparent"
								}
							}));
						});
						
						//odpalenie galerii dla mobile'a
						setTimeout(function(){
							var carouselMobileImages = new Array();
							
							$("[data-type=product-gallery] img").each(function(index, img){
								carouselMobileImages.push({
									title    : $(img).attr("alt"),
									href     : $(img).attr("data-url"),
									thumbnail: $(img).attr("data-thumb")
								});
							});
							
							 blueimp.Gallery(carouselMobileImages, {
								hidePageScrollbars : false,
								thumbnailIndicators: false,
								slideMargin        : 0,
								container          : "#blueimp-image-carousel",
								carousel           : true,
								startSlideshow     : false,
								clearSlides        : false,
								onslide            : function(){
									/* problem z odświeżeniem indicatorów po slidzie */
									this.container.trigger("click");
								}
							});
							
							// indicatory mobile - zmiana zdjęć wariantów
							$("[data-target=#ProductGallery]").each(function(index, indicator){
								var indicatorComb = $(indicator).attr("data-combinations");
								
								$("#blueimp-image-carousel .indicator [data-index=" + index + "]").attr("data-combinations", indicatorComb.length ? indicatorComb : "");
							});
						}, 1);
					},
					initTabs: function(){
						$(".product-tabs").on("click.product-tabs", "a", function(e){
							e.preventDefault();
							
							$(this).tab("show");
						});
						
						$(".product-tabs").on("shown", "a", function(e){
							window.location.hash = "#!" + $(e.target).attr("href");
						});
						
						$(function(){
							if (window.location.hash){
								var tab = decodeURIComponent(window.location.hash).replace(/^#!/, "");
								
								$(".product-tabs a[href=" + tab + "]").click();
							}
						});
						
						$("[data-type=open-tab]").on("click", function(e){
							e.preventDefault();
							
							$(".product-tabs a[href=" + $(this).attr("href") + "]").click();
							
							$("html, body").animate({
								scrollTop: $(".product-tabs").offset().top
							}, 1000);
						});
					}
				});
				
				ProductVariants.init({
					form          : $("[data-type=product-form]"),
					updateFields  : true,
					updateServices: true
				});
				
				break;
			case "user_carts/index":
			case "user_carts/index/1":
			case "user_carts/my_carts":
			case "user_carts/offers_list":
			case "user_carts/preview":
			case "user_carts/preview_offer":
				/* Koszyk */
				Cart.init({
					onCombinationUpdate: function(){
						$(".change-combination, .change-kit-combination").modal("hide");
					}
				});
				
				break;
			case "user_carts/index/2":
				/* Formularz zamówienia dla uzytkownika niezalogowanego */
				var orderFormUnlogged = new OrderFormUnlogged({
					form                  : $("#OrderFormUnlogged"),
					onStartActivateSubform: function(){
						$.prettyLoader.show();
					},
					onEndActivateSubform  : function(){
						$.prettyLoader.hide();
					}
				});
				
				break;
			case "user_carts/index/3":
				/* Formularz zamówienia dla uzytkownika zalogowanego */
				var orderFormLogged = new OrderFormLogged({
					form                  : $("#OrderFormLogged"),
					onStartActivateSubform: function(){
						$.prettyLoader.show();
					},
					onEndActivateSubform  : function(){
						$.prettyLoader.hide();
					},
					onChangeAddress       : function(){
						$(".address-change-modal").modal("hide");
					}
				});
				
				break;
			case "user_addresses/index":
				/* Lista adresów */
				AddressList.init();
				
				break;
			case "user_addresses/edit":
				/* Formularz adresowy - edycja adresów w panelu użytkownika */
				var userAddressEditForm = new AddressForm({
					form           : $("#UserAddressEditForm"),
					container      : $("#UserAddressEditForm"),
					autoCheckNipRow: true
				});
				
				$("[data-type=selected-user-type]:checked").trigger("change");
				
				break;
			case "users/add":
				/* Formularz adresowy - dodawanie klienta */
				var newUser = new NewUser({
					form                  : $("[data-type=new-user-form]"),
					onStartActivateSubform: function(){
						$.prettyLoader.show();
					},
					onEndActivateSubform  : function(){
						$.prettyLoader.hide();
					}
				});
				
				break;
			case "users/edit":
				/* Edycja klienta */
				User.init();
				
				break;
			case "users/index":
			case "users/details":
				/* Lista klientów */
				Users.init({
					initTabs: function(){
						$(".user-detail-tabs").on("click.user-detail-tabs", "a", function(e){
							e.preventDefault();
							
							$(this).tab("show");
						});
						
						$(".user-detail-tabs").on("shown", "a", function(e){
							window.location.hash = "#!" + $(e.target).attr("href");
						});
						
						$(function(){
							if (window.location.hash){
								var tab = decodeURIComponent(window.location.hash).replace(/^#!/, "");
								
								$(".user-detail-tabs a[href=" + tab + "]").click();
							}
						});
						
						$("[data-type=open-tab]").on("click", function(e){
							e.preventDefault();
							
							$(".user-detail-tabs a[href=" + $(this).attr("href") + "]").click();
							
							$("html, body").animate({
								scrollTop: $(".user-detail-tabs").offset().top
							}, 1000);
						});
					}
				});
				
				break;
			case "users/register":
				var userRegisterForm = new AddressForm({
					form     : $("#UserRegisterForm"),
					container: $("#UserRegisterForm")
				});
				
				$("[data-type=selected-user-type]:checked").trigger("change");
				
				break;
			case "wishlists/index":
				/* Schowek */
				Wishlist.init({
					onCombinationUpdate: function(){
						$(".change-combination-modal").modal("hide");
					}
				});
				
				break;
			case "gifts_lists/edit":
			case "gifts_lists/show":
				/* Lista zyczeń */
				Giftlist.init({
					onCombinationUpdate: function(){
						$(".change-combination-modal").modal("hide");
					}
				});
				
				break;
			case "complaints/add":
				/* Reklamacje */
				var complaint = new Complaint({
					form: $("#ComplaintAddForm")
				});
				
				break;
			case "complaints/show":
				/* Reklamacje */
				var complaint = new Complaint({
					form: $("#ComplaintChangeAddressForm")
				});
				
				break;
			case "complaints/index":
				/* Reklamacji */
				Complaints.init();
				
				break;
			case "orders/index":
				/* Zamówienia */
				Orders.init();
				
				break;
			case "invoices/index":
				/* Lista faktur */
				Invoices.init();
				
				break;
			case "payments/index":
				/* Lista faktur */
				Payments.init();
				
				break;
			case "orders/show":
			case "orders/add":
				/* Edycja zamówienia */
				Orders.init();
				
				var userAddressEditForm = new AddressForm({
					form     : $("#OrdersShippingAddressEditForm"),
					container: $("#OrdersShippingAddressEditForm")
				});
				
				$("[data-type=change-order-payment-data-modal]").each(function(){
					var id = $(this).attr("data-order-id");
					
					new AddressForm({
						form     : $("#OrderChangePaymentDataForm" + id),
						container: $("#OrderChangePaymentDataForm" + id)
					});
				});
				
				break;
			case "orders/pay":
				/* Zmiana formy płatności */
				$("[data-type=change-order-payment-method-id]").on("change.payment_method", function(){
					var self = $(this);
					
					var payment_method_id = self.val();
					var prices            = JSON.parse(self.attr("data-prices"));
					
					/* Podmiana ceny */
					$("[data-type=order-price]").html(prices[payment_method_id]);
					
					/* Wyswietlenie ostrzeżenia */
					$("[data-type=order-change-payment-method-notice]").addClass("hide");
					$("[data-type=order-change-payment-method-notice][data-payment-method-id=" + payment_method_id + "]").removeClass("hide");
					
					/* Wysłanie formularza */
					$("[data-type=change-order-payment-method-submit]").on("click", function(){
						$("[data-type=change-order-payment-method-form]").submit();
						
						return false;
					});
				});
				
				break;
			case "partners/index":
			case "partner_ads/add":
			case "partner_ads/edit":
				/* Program partnerski */
				Partners.init();
				
				break;
			case "product_opinions/index":
				/* Opinie */
				Opinions.init();
				
				break;
			case "b2b_enquiries/index":
				/* Zapytania do ofert */
				Enquiries.init();
				
				break;
			case "poczta/ezwrot":
				/* E-zwrot */
				$("#OrderEzwrotForm").ketchup();
				
				break;
		}
		
		/* Tooltipy */
		$("[data-tooltip]").each(function(){
			var self = $(this);
			
			self.tooltip({
				"title"  : self.attr("data-tooltip"),
				"trigger": "manual"
			}).tooltip("show");
			
			var timeout = parseInt(self.attr("data-tooltip-timeout")) || 0;
			
			if (timeout > 0){
				setTimeout(
					function(){
						self.tooltip("hide").tooltip("destroy");
					},
					timeout * 1000
				);
			}
		});
		
		/* Czyszczenie wartości */
		$("[data-change-clear]").on("change", function(){
			$($(this).attr("data-change-clear")).val("").trigger("update-state");
		});
		
		/* Do góry strony */
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100){
				$(".go-to-top").fadeIn();
			} else {
				$(".go-to-top").fadeOut();
			}
		});
		
		$(".go-to-top").click(function(){
			$("html, body").animate({scrollTop : 0}, 800);
			
			return false;
		});
		
		$("[data-type=show-menu-mobile]").on("click", function(){
			var body = $("body");
			var wrapNavbar = $(".wrap-navbar");
			
			if (body.hasClass("show-menu-mobile")){
				body.animate({
					left: 0
				}, 400, function(){
					$(this).removeClass("show-menu-mobile");
				});
				
				wrapNavbar.animate({
					left: -300
				}, 400);
				
				$("#MainNav").find(".open").each(function(){
					$(this).click();
				});
				
				$(".modal-backdrop").fadeOut(120, function(){
					$(this).remove();
				});
			}else{
				body.addClass("show-menu-mobile").animate({
					left: 300
				}, 400);
				
				$("<div>", {
					"class": "modal-backdrop fade in"
				}).appendTo(body);
				
				wrapNavbar.animate({
					left: 0
				}, 400);
				
				$("#MainNav .sub-categories > a:not(.only-link)").removeAttr("href");
				
				$("#MainNav .sub-categories > a:not(.only-link)").on("click", function(){
					var thisSub = $(this);
					var thisSubParent = thisSub.parents("#MainNav").find(".sub-categories");
					
					if (thisSub.hasClass("open")){
						thisSubParent.removeClass("active-sub").children("a").removeClass("open");
						thisSubParent.children(".sub-categories-list").hide();
					}else{
						thisSubParent.removeClass("active-sub").children("a").removeClass("open");
						thisSubParent.children(".sub-categories-list").hide();
						
						thisSub.addClass("open");
						thisSub.parent().addClass("active-sub");
						thisSub.next().slideDown();
					}
				});
			}
		});
	},
	getAjaxDomainUrl: function(){
		return this.ajaxDomainUrl;
	},
	setAjaxDomainUrl: function(url){
		this.ajaxDomainUrl = url;
	},
	getSetting: function(key){
		return this.settings[key];
	},
	setSetting: function(key, value){
		this.settings[key] = value;
	},
	getAppPath: function(){
		return this.appPath;
	},
	setAppPath: function(path){
		this.appPath = path;
	},
	getAjaxUrl: function(url){
		if (url.indexOf("://") == -1){
			url = App.getAjaxDomainUrl() + url;
		}
		
		return url;
	}
};