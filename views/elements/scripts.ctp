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

			TEMPLATE_NAME.DS.'vendor'.DS.'jquery.mask',

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

<script>
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
		App.setSetting("webpush", <?php echo (int) module('WEBPUSH') ?>);
		App.setSetting("user-email", "<?php echo getUserField(getLoggedUserId(), 'email') ?>");
	})();
</script>

<?php
	echo $this->element(
		'_default'.DS.'recaptcha',
		array(
			'cache' => array(
				'time' => '+1 day',
				'key'   => getStandardCacheKey()
			)
		)
	)
?>

<script>
	<?php
		/* Regionalne ustawienia DatePickera */
		echo $this->element('_default'.DS.'datepicker_regionals');
		
		/* Tłumaczenia walidatora */
		echo $this->element(TEMPLATE_NAME.DS.'ketchup');
	?>
</script>

<?php
	/* Do Facebook'a */
	echo $this->element(
		'_default'.DS.'facebook',
		array(
			'cache' => array(
				'time' => '+1 day',
				'key'   => getStandardCacheKey()
			)
		)
	);
	
	if (isProductShowView()):
		/* Google Plus */
		echo $this->element(
			'_default'.DS.'google_plus',
			array(
				'cache' => array(
					'time' => '+1 day',
					'key'   => getStandardCacheKey()
				)
			)
		);
		
		/* Twitter */
		echo $this->element(
			'_default'.DS.'twitter',
			array(
				'cache' => array(
					'time' => '+1 day',
					'key'   => getStandardCacheKey()
				)
			)
		);
		
		/* Pinterest */
		echo $this->element(
			'_default'.DS.'pinterest',
			array(
				'cache' => array(
					'time' => '+1 day',
					'key'   => getStandardCacheKey()
				)
			)
		);
	endif;
?>

<script type="text/javascript">
if ($(window).width() > 992) {
	var menu_hei = 173;
}
else{
	var menu_hei = 281;
}
var hei = $(window).height();
$('.main-nav-top> ul>li>a').click(function(){
	
	var main_hei = $('.main-nav').height() + menu_hei;
	var set_hei = hei - menu_hei;
	if(main_hei>hei){
		$('.main-nav .col-md-3, .main-nav .last').height(set_hei);
		 setTimeout(function() {
			 $('.main-nav .col-md-3, .main-nav .last').customScrollbar();
       }, 200);
	}
});
$('.parent li>a').hover(function(){
	var data = $(this).attr('data-target');
	var id = '#' + data;
	var name = $(this).attr('title');

	$('.last.banner-menu a').hide();
	
	$('.last.banner-menu a[data-banner-name="'+name+'"]').show();
	
	
	$('.child1 li ul').height('auto');
	$('.child1 li ul').css("overflow-y", "auto");
	
	$('.child1 #' + data).show();
	var main_hei = $('.child1 #' + data).height() + menu_hei;
	var set_hei = hei - menu_hei;
	if(main_hei>hei){
		$('.child1 #' + data).height(set_hei).customScrollbar();
	}
	
	$('.child1 ul').not(id).hide();
	$('.child2 ul').hide();
	$('.parent li').removeClass('hover');
	$(this).parent().addClass('hover');
});

$('.child1 ul li>a').hover(function(){
	var data1 = $(this).attr('data-target');
	var id1 = '#' + data1;

	$('.child2 li ul').height('auto');
	$('.child2 li ul').css("overflow-y", "auto");
	
	$('.child2 li ul#' + data1).show();
	var main_hei2 = $('.child2 li ul#' + data1).height() + menu_hei;
	var set_hei2 = hei - menu_hei;
	if(main_hei2>hei){
		$('.child2 li ul#' + data1).height(set_hei2).customScrollbar();
	}
	
	$('.child2 ul').not(id1).hide();
	$('.child1 ul li').removeClass('hover');
	$(this).parent().addClass('hover');
});

</script>
<?php if(isMobile()):?>
<script>
$('.parent li>a:not(.single)').click(function(){
	return false;
	var data = $(this).attr('data-target');
	var id = '#' + data;
	$('.child1 #' + data).show();
	$('.child1 ul').not(id).hide();
	$('.child2 ul').hide();
	$('.parent li').removeClass('hover');
	$(this).parent().addClass('hover');
});

$('.child1 ul li>a:not(.only-link)').click(function(){
	return false;
	var data1 = $(this).attr('data-target');
	var id1 = '#' + data1;
	$('.child2 li ul#' + data1).show();
	$('.child2 ul').not(id1).hide();
	$('.child1 ul li').removeClass('hover');
	$(this).parent().addClass('hover');
});
</script>
<?php endif;?>

<script>
	var bLazy;
</script>

<?php
	/* Google Analytics */
	echo $this->element('_default'.DS.'google');
	
	/* Dodatkowe skrypty na strone - NIE USUWAĆ!!! */
	echo $this->element('_default'.DS.'scripts');
	
	/* Web Push */
	echo $this->element(TEMPLATE_NAME.DS.'web_push');
?>
