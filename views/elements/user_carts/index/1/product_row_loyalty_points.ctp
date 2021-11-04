<?php if (canBuyProductForLoyaltyPoints($product) && ($product_loyalty_price = getProductLoyaltyPrice($product, $key))): ?>
	<?php $is_disabled = $cart_blocked || getUserLoyaltyPointsSum(getLoggedUserId()) >= $product_loyalty_price ? false : true ?>
	
	<div class="loyalty-points-change <?php echo $is_disabled ? 'hide' : '' ?>" data-type="loyalty-price-toggle">
		<?php
			echo $this->Form->input(
				'UserCart.'.$key.'.loyalty_points',
				array(
					'type'      => 'checkbox',
					'data-type' => 'change-loyalty-price',
					'div'       => 'checkbox',
					'label'     => sprintf(__('wymień punkty - %s pkt.', true), $product_loyalty_price),
					'checked'   => $product['loyalty_points'] == true ? 'checked' : '',
					'disabled'  => $is_disabled
				)
			)
		?>
	</div>
<?php endif ?>