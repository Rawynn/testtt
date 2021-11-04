<?php if ($loyalty_price = getCartLoyaltyPaymentAllowedPrice()): ?>
	<div class="loyalty-price-section order-section">
		<div class="order-section-inner">
			<?php
				echo $this->Form->input(
					'LoyaltyPoints.price',
					array(
						'type'      => 'checkbox',
						'data-type' => 'cart-loyalty-price',
						'checked'   => getCartLoyaltyPrice('active'),
						'label'     => array(
							'data-type' => 'loyalty-price-label',
							'text'      => sprintf(__('Wykorzystaj punkty programu lojalnościowego %s pkt -> %s.', true), $loyalty_price['points'], showPrice($loyalty_price['price']))
						)
					)
				)
			?>
		</div>
		
		<div class="order-section-summary">
			<span data-type="loyalty-price-price">
				<?php echo getCartLoyaltyPrice('price') ? showPrice((-1) * getCartLoyaltyPrice('price')) : '-' ?>
			</span>
		</div>
	</div>
	
	<hr>
<?php endif ?>