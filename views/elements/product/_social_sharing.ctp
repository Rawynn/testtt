<?php
	if (isset($product['ProductMedium'][0]['ProductMedium']['filename'])):
		$main_photo = '/'.IMAGES_URL.configuration('ProductMedium.dir').'/'.$product['ProductMedium'][0]['ProductMedium']['dir'].$product['ProductMedium'][0]['ProductMedium']['filename'];
	else:
		$main_photo = null;
	endif;
?>

<?php if (setting('MODULE_MARKETING_JS_FACEBOOK_SHARE_BUTTON') || setting('MODULE_MARKETING_JS_GOOGLE_PLUS_SHARE_BUTTON') || setting('MODULE_MARKETING_JS_TWITTER_SHARE_BUTTON') || setting('MODULE_MARKETING_JS_PINTEREST_SHARE_BUTTON')): ?>
	<div class="product-social-sharing <?php echo $gallery_indicators ? 'carousel-indicators-true' : '' ?>">
		
		<?php if (setting('MODULE_MARKETING_JS_FACEBOOK_SHARE_BUTTON')): ?>
			<div class="sharing-option">
				<i class="sprite sprite-fb"></i>
				<div class="fb-like" data-href="<?php echo $this->Html->url(getProductUrl($product['Product']['id']), true) ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div>
			</div>
		<?php endif ?>
		
		<?php if (setting('MODULE_MARKETING_JS_TWITTER_SHARE_BUTTON')): ?>
			<div class="sharing-option">
				<i class="sprite sprite-twitter"></i>
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $this->Html->url(getProductUrl($product['Product']['id']), true) ?>" data-text="<?php echo $product['Product']['name'] ?>" data-lang="pl" data-count="none"></a>
			</div>
		<?php endif ?>
		
		<?php if (setting('MODULE_MARKETING_JS_GOOGLE_PLUS_SHARE_BUTTON')): ?>
			<div class="sharing-option">
				<i class="sprite sprite-google"></i>
				<div class="g-plusone" data-size="medium" data-annotation="none"></div>
			</div>
		<?php endif ?>
		
		<?php if (setting('MODULE_MARKETING_JS_PINTEREST_SHARE_BUTTON') && $main_photo): ?>
			<div class="sharing-option">
				<a href="//www.pinterest.com/pin/create/button/?url=<?php echo $this->Html->url(getProductUrl($product['Product']['id']), true) ?>&amp;media=<?php echo $this->Html->url($main_photo, true) ?>&amp;description=<?php echo Sanitize::html(str_replace(' ', '%20', $product['Product']['name']), array('remove' => true)) ?>" data-pin-do="buttonPin" data-pin-config="none"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" alt="Pinterest" /></a>
			</div>
		<?php endif ?>
	</div>
<?php endif ?>