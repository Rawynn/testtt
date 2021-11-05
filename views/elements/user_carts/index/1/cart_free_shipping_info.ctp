<div class="free-shipping-info <?php echo $products_gratis_info = getCartGratisProductsForAmountsList() ? 'free-shipping-info-small' : '' ?> <?php echo ($deficiency = getCartFreeShippingDeficiency()) <= 0 ? 'hide' : '' ?>" data-type="free-shipping-info-toggle">
	<?php if (!$products_gratis_info && ($free_shipping_from = getCartFreeShippingFromPrice())): ?>
		<div class="info-left">
			<?php 
				echo $this->Html->image(
					'layout/'.TEMPLATE_NAME.'/dostawa.png',
					array(
							'class'   => 'free-img',
					)
				);
			?>
			<p>
				<?php __('Darmowa dostawa ') ?><?php echo sprintf(__('od %s', true), '<span class="price" data-type="free-shipping-from-price">'.showPrice($free_shipping_from).'</span>') ?>
			</p>
		</div>
	<?php endif ?>
	
	<div class="info-right">
		<?php __('Do darmowej dostawy brakuje Ci') ?> <span class="price-info" data-type="free-shipping-info"><?php echo showPrice($deficiency) ?></span>. <?php __('Sprawdź nasze propozycje produktów:') ?>
		
		<?php if (!$products_gratis_info): ?>
			<div class="<?php echo $deficiency <= 0 ? 'hide' : '' ?>" data-type="free-shipping-products-toggle">
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'free_shipping_products',
						array(
							'deficiency' => $deficiency
						)
					)
				?>
			</div>
		<?php endif ?>
	</div>
</div>