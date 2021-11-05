<div class="sms-notice form form-inline <?php echo !$sms ? 'hide' : '' ?>" data-type="shipping-sms-toggle">
	<div class="form-row">
		<label>
			<?php __('Powiadomienie SMS') ?>:
		</label>
		
		<?php
			echo $this->Form->input(
				'Sms.sms',
				array(
					'type'      => 'radio',
					'data-type' => 'change-shipping-sms',
					'div'       => array(
						'tag'   => 'span',
						'class' => 'radio'
					),
					'legend'    => false,
					'options'   => array(
						1 => __('Tak', true),
						0 => __('Nie', true)
					),
					'value'     => (int) getCartSMS(),
				)
			)
		?>
	</div>
</div>