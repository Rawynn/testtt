<?php if ($voucher_available): ?>
	<div class="order-section-header voucher-section-header">
		<?php $voucher = getCartVoucher() ?>
		
		<div class="voucher-box form form-inline">
			<div class="form-row">
				<?php
					echo $this->Form->input(
						'Voucher.active',
						array(
							'type'      => 'checkbox',
							'data-type' => 'change-voucher',
							'div'       => 'checkbox',
							'label'     => __('mam bon płatniczy', true),
							'checked'   => (bool)$voucher,
							'disabled'  => $cart_blocked
						)
					)
				?>
			</div>
			
			<div data-type="voucher-code-container" class="voucher-code-container <?php echo $voucher ? '' : 'hide' ?>">
				<?php if ($voucher): ?>
					<div class="voucher-name">
						<span><?php echo $voucher['name'] ?></span>
					</div>
				<?php else: ?>
					<div class="voucher-code form-row">
						<?php
							echo $this->Form->input(
								'Voucher.code',
								array(
									'type'        => 'text',
									'div'         => false,
									'label'       => false,
									'class'       => 'form-control',
									'placeholder' => __('Wprowadź kod bonu', true),
									'value'       => $voucher ? $voucher['code'] : '',
									'disabled'    => $cart_blocked
								)
							)
						?>
					</div>
					
					<input class="btn btn-primary btn-form-size" name="data[Voucher][activate]" type="submit" value="<?php echo h(__('Aktywuj bon', true)) ?>" data-submit="no-disable">
				<?php endif ?>
			</div>
			
			<div data-type="voucher-error-message">
				<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_voucher_message') ?>
			</div>
		</div>
	</div>
<?php endif ?>