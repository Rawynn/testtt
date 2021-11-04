<?php if (setting('MODULE_B2B_FULL_PACKAGES_DISCOUNT')): ?>
	<?php
		$full_package_discount = getFullPackageDiscountInCart(getDefaultPricesType());
		$discount_products     = getFullPackageDiscountProductsInCart(getDefaultPricesType());
	?>
	
	<div class="full-package-discount-section order-section <?php echo $full_package_discount ? '' : 'hide' ?>" data-type="full-package-discount-toggle">
		<div class="order-section-header">
			<h2>
				<?php __('Żniżka z tytułu zamówienia opakowania zbiorczego') ?>
			</h2>
		</div>
		
		<div class="order-section-inner">
			<ul data-type="full-package-discount-products">
				<?php foreach ($discount_products as $discount_product): ?>
					<li>
						<?php echo getProductName($discount_product['product_id']) ?>: <strong><?php echo showPrice($discount_product['package_discount']) ?></strong>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		
		<div class="order-section-summary">
			<span data-type="full-package-discount-price"><?php echo showPrice((-1) * $full_package_discount) ?></span>
		</div>
	</div>
	
	<hr class="<?php echo $full_package_discount ? '' : 'hide' ?>" />
<?php endif ?>