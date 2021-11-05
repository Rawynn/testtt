<?php if ($discounts = getProductQuantityDiscounts($product_id)): ?>
	<div class="quantity-discount-product-page">
		<div class="discount-type">
			<?php __('Przy zakupie') ?>:
		</div>
		
		<div class="discount-description red">
			<table>
				<?php foreach ($discounts as $discount_from => $discount_percentage): ?>
					<tr>
						<td>
							<?php echo sprintf(__('%s', true), showQuantityValue($discount_from, $product_id)) ?>
						</td>
						<td>
							<?php echo sprintf(__(' -%s%%', true), round($discount_percentage, 4)) ?>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
<?php endif ?>