<div class="order-pay-page order-page user-page page">
	<div class="page-header">
		<h1>
			<?php echo sprintf(__('Opłać zamówienie numer %s', true), getOrderFullId($order['Order']['id'])) ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($possible_order_payment_methods): ?>
				<?php foreach ($possible_order_payment_methods as $payment_method): ?>
					<p class="message notice hide" data-type="order-change-payment-method-notice" data-payment-method-id="<?php echo $payment_method['PaymentMethod']['id'] ?>">
						<?php echo sprintf(__('UWAGA! zmiana formy płatności na "%s" wiąże się ze zmianą kwoty zamówienia na %s.', true), $payment_method['PaymentMethod']['name'], showOrderPrice($payment_method['PaymentMethod']['order_price'], $order['Order']['id'])) ?>
					</p>
				<?php endforeach ?>
			<?php endif ?>
			
			<?php
				echo $this->Form->create(
					'Order',
					array(
						'url'         => getOrderPayUrl($order['Order']['id'], $order['Order']['code']),
						'class'       => 'form',
						'data-submit' => 'once',
						'data-type'   => 'change-order-payment-method-form'
					)
				)
			?>
				<div class="form-row">
					<label>
						<?php __('Wartość zamówienia') ?>:
					</label>
					
					<strong data-type="order-price" class="form-text">
						<?php echo showOrderPrice($order_price, $order['Order']['id']) ?>
					</strong>
				</div>
				
				<div class="form-row">
					<label>
						<?php __('Aktualnie opłacono') ?>:
					</label>
					
					<strong class="text-important form-text">
						<?php echo showOrderPrice($payment_sum, $order['Order']['id']) ?>
					</strong>
				</div>
				
				<?php if ($possible_order_payment_methods): ?>
					<?php
						$payment_method_prices = array();
						
						foreach ($possible_order_payment_methods as $payment_method):
							$payment_method_prices[$payment_method['PaymentMethod']['id']] = showOrderPrice($payment_method['PaymentMethod']['order_price'], $order['Order']['id']);
						endforeach;
						
						echo $this->Form->input(
							'payment_method_id',
							array(
								'div'         => 'form-row',
								'label'       => __('Forma płatności', true).': ',
								'type'        => 'select',
								'options'     => Set::combine($possible_order_payment_methods, '{n}.PaymentMethod.id', '{n}.PaymentMethod.name'),
								'default'     => $order['Order']['payment_method_id'],
								'class'       => 'form-control',
								'data-type'   => 'change-order-payment-method-id',
								'data-prices' => json_encode($payment_method_prices)
							)
						);
					?>
					
					<div class="form-actions">
						<a class="btn-next btn" data-toggle="modal" href="#ChangeOrderPaymentMethodConfirmation" role="button">
							<?php __('Zmień') ?>
						</a>
					</div>
					
					<div class="modal fade" id="ChangeOrderPaymentMethodConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									
									<h2>
										<?php __('Zmiana formy płatności') ?>
									</h2>
								</div>
								
								<div class="modal-body">
									<?php __('Czy na pewno chcesz zmienić formę płatności dla tego zamówienia?') ?>
								</div>
								
								<div class="modal-footer modal-actions">
									<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
										<?php __('Anuluj') ?>
									</a>
									
									<a class="btn-next btn btn-primary btn-lg" data-type="change-order-payment-method-submit">
										<?php __('Zmień') ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endif ?>
			<?php echo $this->Form->end() ?>
			
			<hr>
			
			<?php if ($payment_sum >= $order_price): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'success',
							'message'  => __('Twoje zamówienie jest już opłacone.', true),
							'no_close' => true
						)
					)
				?>
			<?php else: ?>
				<?php if ($order['Order']['payment_method_id']): ?>
					<?php if ($payment_description = getPaymentMethodDescription($order['Order']['payment_method_id'], $order['Order']['id'])): ?>
						<h2>
							<?php echo $order['Order']['payment_method'] ?>
						</h2>
						
						<p class="cms-content">
							<?php echo $payment_description ?>
						</p>
					<?php endif ?>
				<?php endif ?>
				
				<?php
					echo $this->element(
						'_default'.DS.'payment_form',
						array(
							'order'                               => $order,
							'button_class'                        => 'btn btn-primary js-submit',
							'order_payment_method_options_select' => true
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>