<?php if (getCartDropshipping()):?>
	<?php $showDropshippingCod = in_array(getCartPaymentMethodId(), $payment_exclusions) ? false : isCodInCart() ?>
	
	<div class="order-type-amount form form-inline <?php echo !$showDropshippingCod ? 'hide' : '' ?>" data-type="dropshipping-cod-value-toggle">
		<?php
			echo $this->Form->input(
				'Order.dropshipping_cod_value',
				array(
					'div'   => 'form-row',
					'label' => __('Proszę podać kwotę pobrania', true),
					'class' => 'form-control',
					'value' => getCartDropshippingCodValue() != null ? number_format(getCartDropshippingCodValue(), 2, ',', '') : ''
				)
			)
		?>
		
		<div class="form-row">
			<label>
				<?php echo getCurrentCurrency('code') ?>
			</label>
		</div>
	</div>
<?php endif ?>