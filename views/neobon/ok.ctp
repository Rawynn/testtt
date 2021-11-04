<?php if ($order && $to_pay > 0): ?>
	<div class="order-pay-page order-page page">
		<div class="page-header">
			<h1>
				<?php echo sprintf(__('Do dopłaty pozostało: %s.', true), showOrderPrice($to_pay, $order['Order']['id'])) ?>
			</h1>
		</div>
		
		<div class="page-content-container">
			<div class="page-content page-sidebar-true">
				<?php
					echo $this->Form->create(
						'Neobon',
						array(
							'url' => getCurrentUrl(),
							'data-submit' => 'once',
							'class'       => 'form'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'payment_method_id',
							array(
								'type'    => 'select',
								'div'     => 'form-row',
								'label'   => __('Wybierz formę płatności', true).':',
								'class'   => 'form-control',
								'options' => $payment_methods
							)
						)
					?>
					
					<div class="form-actions align-input">
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			</div>
			
			<div class="page-sidebar">
				<?php
					/* Sidebar */
					echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
				?>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'payment_message',
			array(
				'type'    => 'success',
				'header'  => __('Potwierdzenie zapłaty', true),
				'message' => __('Twoja płatność została przyjęta do realizacji.', true)
			)
		)
	?>
<?php endif ?>