<?php
	/* PopUp do zapisu do newslettera */
	echo $this->element(TEMPLATE_NAME.DS.'newsletter_popup')
?>

<!-- Pretty Loader -->

<div class="pretty-loader">
	<div class="pretty-loader-inner"></div>
</div>

<!-- Modal Gallery -->

<div id="modal-gallery" class="modal-gallery modal-gallery-controls">
	<div class="slides"></div>
	
	<div class="title hide-on-slide hheader"></div>
	
	<a class="close">
		&times;
	</a>
	
	<a class="controls prev"></a>
	
	<a class="controls next"></a>
	
	<a class="play-pause"></a>
	
	<ol class="indicator"></ol>
</div>

<div id="modal-video-gallery" class="modal-gallery video-gallery modal-gallery-controls">
	<div class="slides"></div>
	
	<div class="title hide-on-slide hheader"></div>
	
	<a class="close">
		&times;
	</a>
	
	<a class="controls prev"></a>
	
	<a class="controls next"></a>
	
	<ol class="indicator"></ol>
</div>

<?php
	/* URL'e do Ajax'ów */
	echo $this->element(
		'_default'.DS.'ajax_links',
		array(
			'cache' => array(
				'time' => Configure::read('Cache.short_time'),
				'key'  => getStandardCacheKey()
			)
		)
	);
	
	/* Pliki JS */
	echo $this->Compressor->js(
		array(
			TEMPLATE_NAME.DS.'vendor'.DS.'modernizr',
			
			TEMPLATE_NAME.DS.'vendor'.DS.'jquery-ui-1.10.3.custom',
			TEMPLATE_NAME.DS.'vendor'.DS.'jquery-cookie',
			TEMPLATE_NAME.DS.'vendor'.DS.'jquery-prettyloader',
			TEMPLATE_NAME.DS.'vendor'.DS.'jquery.custom-scrollbar.min',
			
			/* Bootstrap */
			TEMPLATE_NAME.DS.'vendor'.DS.'bootstrap'.DS.'bootstrap.min',
			
			/* Walidacja formularzy - ketchup */
			TEMPLATE_NAME.DS.'vendor'.DS.'ketchup'.DS.'jquery-ketchup',
			TEMPLATE_NAME.DS.'vendor'.DS.'ketchup'.DS.'jquery-ketchup.helpers',
			TEMPLATE_NAME.DS.'vendor'.DS.'ketchup'.DS.'jquery-ketchup.validations',
			TEMPLATE_NAME.DS.'vendor'.DS.'ketchup'.DS.'jquery-ketchup.displays',
			
			/* Galeria karty produktu */
			TEMPLATE_NAME.DS.'vendor'.DS.'blueimp-gallery'.DS.'blueimp-gallery',
			TEMPLATE_NAME.DS.'vendor'.DS.'blueimp-gallery'.DS.'blueimp-gallery-indicator',
			TEMPLATE_NAME.DS.'vendor'.DS.'blueimp-gallery'.DS.'blueimp-gallery-fullscreen',
			TEMPLATE_NAME.DS.'vendor'.DS.'blueimp-gallery'.DS.'blueimp-gallery-video',
			TEMPLATE_NAME.DS.'vendor'.DS.'blueimp-gallery'.DS.'blueimp-gallery-youtube',
			TEMPLATE_NAME.DS.'vendor'.DS.'blueimp-gallery'.DS.'jquery-blueimp-gallery',
			TEMPLATE_NAME.DS.'vendor'.DS.'carousel',
			TEMPLATE_NAME.DS.'vendor'.DS.'blazy',
			
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.ajaxcompare',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.ajaxtabs',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.ajaxsend',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.ajaxload',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.ajaxcart',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.ajaxwishlist',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.slidemenu',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.toggle',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.imageloader',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.messages',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.transform',
			TEMPLATE_NAME.DS.'atomstore'.DS.'plugins'.DS.'atomstore.quantityinput',
			
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.product.field.updater',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.productlist',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.product',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.product.variants',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.wishlist',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.giftlist',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.cart',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.addresslist',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.form',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.complaint',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.complaints',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.addressform',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.opinions',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.orderform.unlogged',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.orderform.logged',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.surveys',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.comparison',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.categories',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.orders',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.users',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.invoices',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.payments',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.partners',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.enquiries',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.new_user',
			TEMPLATE_NAME.DS.'atomstore'.DS.'atomstore.user',
			TEMPLATE_NAME.DS.'atomstore.app'
		),
		TEMPLATE_NAME,
		true,
		'scripts.min'
	);
?>

<script type="text/javascript">
	(function(){
		$(function(){
			App.onready();
		});
		
		$(window).load(function(){
			App.onload();
		});
		
		App.setAppPath("<?php echo getAppPathKey() ?>");
		App.setAjaxDomainUrl("<?php echo getAjaxDomain() ?>");
		App.setSetting("ajax-paging", <?php echo (int) setting('OPTIMALIZATION_PAGINATION_VIA_AJAX') ?>);
		App.setSetting("ajax-preloading", <?php echo (int) setting('OPTIMALIZATION_PAGINATION_PRELOADING') ?>);
		App.setSetting("max-filter-entries", <?php echo (int) setting('MODULE_FILTER_ENTRIES_NUMBER') ?>);
		App.setSetting("add-cart-ajax", <?php echo (int) setting('GLOBAL_AJAX_ADD_TO_CART') ?>);
		App.setSetting("add-wishlist-ajax", <?php echo (int) setting('GLOBAL_AJAX_ADD_TO_WISHLIST') ?>);
		App.setSetting("quantity-precision", <?php echo (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION') ?>);
		App.setSetting("newsletter-popup-delay", <?php echo (int) setting('MODULE_NEWSLETTER_POPUP_DISPLAY_DELAY_SECONDS') ?>);
		App.setSetting("categories-box-ajax", <?php echo (int) setting('MODULE_BOX_CATEGORIES_WITHOUT_RELOAD') ?>);
		App.setSetting("categories-ajax-url", "<?php echo $this->Html->url(getCategoryChildsUrl(isProductListIndexView() ? getProductSearchGetParams() : array())) ?>");
		App.setSetting("ajax-url-requests", "<?php echo $this->Html->url('/') ?>");
		App.setSetting("search-label", "<?php __('Szukaj') ?>");
		App.setSetting("offer-edit-mode", <?php echo (int) (userIsSalesrep() && getCartIsOffer()) ?>);
		App.setSetting("offer-alow-not-exists-products", <?php echo (int) setting('MODULE_B2B_OFFER_ALLOW_NOT_EXISTS_PRODUCTS') ?>);
		App.setSetting("cart-calculate-shipping-costs", <?php echo (int) Configure::read('Cart.calculate_shipping_costs') ?>);
		App.setSetting("analytics-enhanced-ecommerce", <?php echo (int) (setting('GLOBAL_GOOGLE_ANALYTICS_ID') && setting('GLOBAL_GOOGLE_ANALYTICS_UNIVERSAL_ANALYTICS') && setting('GLOBAL_GOOGLE_ANALYTICS_ENHANCED_ECOMMERCE')) ?>);
		App.setSetting("user-hash", "<?php echo getUserHash() ?>");
		App.setSetting("kit-combination-for-every-kit-product-item", "<?php echo (int) setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM') ?>");
		App.setSetting("check-user-last-order", <?php echo userIsSalesrep() ? 0 : (int) setting('MODULE_USERS_AND_ORDERS_CHECK_USER_LAST_ORDER_MINUTES') ?>);
	})();
</script>

<?php if (module('RECAPTCHA')): ?>
	<script type="text/javascript">
		function runReCaptcha(){
			$(".g-recaptcha").each(function(){
				var id = $(this).attr("id");
				
				if (id){
					grecaptcha.render(id, {
						"sitekey" : "<?php echo setting('MODULE_RECAPTCHA_PUBLIC_KEY') ?>"
					});
				}
			});
		}
	</script>
	
	<script src="https://www.google.com/recaptcha/api.js?onload=runReCaptcha&amp;render=explicit" async defer></script>
<?php endif ?>

<script type="text/javascript">
	<?php
		/* Regionalne ustawienia DatePickera */
		echo $this->element('_default'.DS.'datepicker_regionals');
		
		/* Tłumaczenia walidatora */
		echo $this->element(TEMPLATE_NAME.DS.'ketchup');
	?>
</script>

<?php if (($facebook_id = setting('GLOBAL_FACEBOOK_APP_ID')) && (setting('GLOBAL_ALLOW_FB_LOGIN') || setting('MODULE_MARKETING_JS_FACEBOOK_SHARE_BUTTON'))): ?>
	<div id="fb-root"></div>
	
	<script type="text/javascript">
		window.fbAsyncInit = function(){
			FB.init({
				appId  : "<?php echo $facebook_id ?>",
				status : true,
				cookie : false,
				xfbml  : true,
				version: "v2.8"
			});
		};
		
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/<?php echo getCurrentLanguageField('ctype') ?>/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		$("[data-type=facebook-login]").on("click.facebook-login", function(e){
			e.preventDefault();
			
			FB.login(function(response){
				if (response.authResponse){
					var accessToken = response.authResponse.accessToken;
					
					FB.api("/me", function(response){
						window.location.href = "<?php echo $this->Html->url(getUserFacebookLoginUrl()) ?>?access_token=" + accessToken;
					});
				}
			}, {scope: "public_profile,email"});
		});
		
		$("[data-type=facebook-logout]").on("click.facebook-logout", function(e){
		
		});
	</script>
<?php endif ?>

<?php if (isProductShowView()): ?>
	<?php if (setting('MODULE_MARKETING_JS_GOOGLE_PLUS_SHARE_BUTTON')): ?>
		<script type="text/javascript">
			window.___gcfg = {lang: '<?php echo getCurrentLanguageField('language') ?>'};
			
			(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
	<?php endif ?>
	
	<?php if (setting('MODULE_MARKETING_JS_TWITTER_SHARE_BUTTON')): ?>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<?php endif ?>
	
	<?php if (setting('MODULE_MARKETING_JS_PINTEREST_SHARE_BUTTON')): ?>
		<script type="text/javascript">
			(function(d){
				var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
				p.type = 'text/javascript';
				p.async = true;
				p.src = '//assets.pinterest.com/js/pinit.js';
				f.parentNode.insertBefore(p, f);
			}(document));
		</script>
	<?php endif ?>
<?php endif ?>

<script type="text/javascript">
	var bLazy;
</script>
<script>
/* Opis kategorii - wyświetlanie przycisku 'Czytaj więcej' */
if ($(".category-description .cms-content").height() >= 55){
	$(".category-description .cms-content").css({"maxHeight": 54});
	$(".category-more span").on("click", function(){
		$(this).parent().toggleClass("active");
		
		$(".category-description").toggleClass("all");
		
		$(".category-description .cms-content").css({"maxHeight": 54});
		$(".category-description.all .cms-content").css({"maxHeight": "none"});
	});
}else{
	$(".category-more span").parent().hide();
}
</script>
<script>
if ($(window).width() > 767){
	$(".main-nav-list> li").hover(function () {
		$(this).find(".sub-cat").stop(true,true).delay(500).show(0);
	}, function () {
		$(this).find(".sub-cat").stop(true,true).delay(500).hide(0);
	});
	$('.sub-categories> span').click(function(){
		var id_cat=$(this).attr('data-target');
		$('.sub-categories-list:not([data-id='+id_cat+'])').slideUp();
		$('.sub-categories-list[data-id='+id_cat+']').slideToggle();
	});
	$("#element-to-toggle").hide();
	$(".search-btn").click(function() {
		$("#ProductSearchForm").show();
		$(this).hide();
		$(this).parent().find('.form-control').focus();
	});
	$('.search-form .form-control').focusout(function(){
		$("#ProductSearchForm").animate({width: "toggle"}, 100);
		$(".search-btn").show();
	});
}
else{
	$('.main-nav .sub-cat .sub-categories .down').remove();
}
</script>
<?php
	/* Google Analytics */
	echo $this->element('_default'.DS.'google');
	
	/* Dodatkowe skrypty na strone - NIE USUWAĆ!!! */
	echo $this->element('_default'.DS.'scripts');
?>