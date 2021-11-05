<?php if (userIsSalesrep() && !$edit_offer_mode && ($order_statuses = getCartOrderStatusesList())): ?>
	<div class="order-source-section order-section">
		<div class="order-section-header">
			<h2>
				<?php __('Status zamówienia') ?>
			</h2>
		</div>
		
		<div class="order-section-inner user-cart-fields-section-inner">
			<?php
				echo $this->Form->input(
					'OrderStatus.id',
					array(
						'type'      => 'select',
						'div'       => 'form-row',
						'label'     => false,
						'class'     => 'form-control',
						'options'   => $order_statuses,
						'value'     => getCartOrderStatusId(),
						'data-type' => 'cart-order-status',
						'disabled'  => $cart_blocked,
						'empty'     => __('-zgodny z formą płatności-', true)
					)
				)
			?>
		</div>
	</div>
	
	<hr>
<?php endif ?>