<div class="free-shipping-info <?php echo $products_gratis_info = getCartGratisProductsForAmountsList() ? 'free-shipping-info-small' : '' ?> <?php echo ($deficiency = getCartFreeShippingDeficiency()) <= 0 ? 'hide' : '' ?>" data-type="free-shipping-info-toggle">
	<div class="info">
		<span class="inform">i</span><?php __('Do darmowej dostawy brakuje Ci jeszcze') ?> <span class="price-info" data-type="free-shipping-info"><?php echo showPrice($deficiency) ?></span>
	</div>
</div>