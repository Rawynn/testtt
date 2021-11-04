<?php if (getCurrentPaginatePage() == 1): ?>
	<?php if ($product_filter['ProductFilter']['description']): ?>
		<div class="product-filter-description">
			<div class="cms-content">
				<?php echo $product_filter['ProductFilter']['description'] ?>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>