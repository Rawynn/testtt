<?php if (checkDropshippingAvailable(getLoggedUserId())): ?>
	<div class="order-type">
		<label>
			<?php __('Rodzaj zamówienia') ?>:
		</label>
		
		<?php foreach (array(0 => __('Zamówienie własne', true), 1 => __('Zamówienie dropshippingowe', true)) as $key => $value): ?>
			<?php
				echo $this->Form->input(
					'Dropshipping.dropshipping',
					array(
						'type'      => 'radio',
						'data-type' => 'change-dropshipping',
						'options'   => array(
							$key => $value
						),
						'value'     => getCartDropshipping(),
						'legend'    => false,
						'disabled'  => $cart_blocked
					)
				)
			?>
		<?php endforeach ?>
	</div>
<?php endif ?>