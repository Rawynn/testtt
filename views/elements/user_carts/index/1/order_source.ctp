<?php if (userIsSalesrep() && !$edit_offer_mode && ($order_sources = getOrderSourcesList())): ?>
	<div class="order-source-section order-section">
		<div class="order-section-header">
			<h2>
				<?php __('Źródła zamówienia') ?>
			</h2>
		</div>
		
		<div class="order-section-inner">
			<div class="form-row checkbox-group">
				<?php
					echo $this->Form->input(
						'OrderSource.key',
						array(
							'type'     => 'select',
							'multiple' => 'checkbox',
							'div'      => false,
							'label'    => false,
							'options'  => $order_sources,
							'value'    => getCartOrderSources(),
							'disabled' => $cart_blocked
						)
					)
				?>
			</div>
		</div>
	</div>
	
	<hr>
<?php endif ?>