<div class="radio payment-term form form-inline" data-type="payment-term-toggle" data-payment-term-for="<?php echo $payment_method_id ?>">
	<?php
		echo $this->Form->input(
			'Payment.term',
			array(
				'data-type'        => 'payment-term',
				'data-options-for' => $payment_method_id,
				'div'              => 'form-row',
				'label'            => __('Termin płatności', true).':',
				'class'            => 'form-control',
				'disabled'         => getCartPaymentMethodId() != $payment_method_id,
				'after'            => '<label>'.__('dni', true).'</label>',
				'id'               => 'PaymentTerm'.$payment_method_id,
				'value'            => getCartPaymentTerm(),
				'default'          => getCartDefaultPaymentTerm()
			)
		)
	?>
</div>
