<div class="radio-list">
	<?php foreach ($user_addresses as $user_address_id => $user_address): ?>
		<?php
			echo $this->Form->input(
				'Complaint.receive_user_address_id',
				array(
					'type'        => 'radio',
					'data-type'   => 'complaint-change-receive-address',
					'div'         => 'radio',
					'checked'     => isset($complaint) && $user_address_id == $complaint['Complaint']['receive_user_address_id'],
					'hiddenField' => false,
					'options'     => array(
						$user_address_id => $user_address
					)
				)
			)
		?>
	<?php endforeach ?>
</div>

<div data-type="receive-address">
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'address_form',
			array(
				'prefix'           => 'ReceiveUserAddress',
				'address_required' => true,
				'name_validate'    => '',
				'company_validate' => '',
				'add_invoice'      => false,
				'add_vat_checkbox' => false,
				'disabled'         => true,
				'show_user_type'   => true
			)
		)
	?>
</div>