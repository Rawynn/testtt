<?php if (setting('MODULE_LOYALTY_FREE_SHIPPING') && getLoggedUserId() !== null && getShippingMethodMinLoyaltyPointsRequired() !== false && getUserLoyaltyPointsSum(getLoggedUserId()) > getShippingMethodMinLoyaltyPointsRequired()): ?>
	<div class="loyalty-free-shipping form form-inline">
		<div class="form-row">
			<label>
				<?php __('Wykorzystaj punkty programu lojalnościowego') ?>:
			</label>
			
			<?php
				echo $this->Form->input(
					'ShippingMethod.loyalty_points',
					array(
						'type'      => 'radio',
						'data-type' => 'change-shipping-loyalty-price',
						'div'       => array(
							'tag'   => 'span',
							'class' => 'radio'
						),
						'legend'    => false,
						'options'   => array(
							1 => __('Tak', true),
							0 => __('Nie', true)
						),
						'value'     => isFreeLoyaltyShippingInCart() ? 1 : 0,
						'default'   => 0,
						'disabled'  => $cart_blocked
					)
				)
			?>
		</div>
	</div>
<?php endif ?>