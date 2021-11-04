<?php
	echo $this->Form->input(
		'client_group',
		array(
			'type'     => 'text',
			'div'      => 'form-row',
			'label'    => __('Grupa cenowa', true).':',
			'class'    => 'form-control form-hidden',
			'value'    => $client_group ? $client_group : '-',
			'disabled' => 'disabled'
		)
	);
	
	if (module('CREDIT')):
		echo $this->Form->input(
			'payment_term_in_days',
			array(
				'type'     => 'text',
				'div'      => 'form-row',
				'label'    => __('Domyślny termin płatności', true).':',
				'class'    => 'form-control form-hidden',
				'value'    => sprintf(__('%s dni', true), !empty($user['User']['payment_term_in_days']) ? $user['User']['payment_term_in_days'] : setting('MODULE_CREDIT_DEFAULT_PAYMENT_TERM')),
				'disabled' => 'disabled'
			)
		);
	endif;
?>

<div class="form-row checkbox-group">
	<label>
		<?php __('Dostępne formy płatności') ?>:
	</label>
	
	<div class="checkbox-group-checkboxes">
		<?php
			echo $this->Form->input(
				'payment_method_id',
				array(
					'type'     => 'select',
					'multiple' => 'checkbox',
					'div'      => false,
					'label'    => false,
					'disabled' => 'disabled',
					'options'  => $payment_methods
				)
			)
		?>
	</div>
</div>