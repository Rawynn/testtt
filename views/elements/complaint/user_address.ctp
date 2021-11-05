<div class="radio-list">
	<?php
		$addresses = array(
			'receive' => __('zgodny z adresem odbioru', true)
		);
		
		foreach ($user_addresses as $user_address_id => $user_address):
			$addresses[$user_address_id] = $user_address;
		endforeach;
		
		$value = 'receive';
		
		if (!empty($this->data['Complaint']['user_address_id'])):
			$value = $this->data['Complaint']['user_address_id'];
		endif;
	?>
	
	<?php foreach ($addresses as $user_address_id => $user_address): ?>
		<?php
			echo $this->Form->input(
				'Complaint.user_address_id',
				array(
					'type'        => 'radio',
					'data-type'   => 'complaint-change-address',
					'div'         => 'radio',
					'checked'     => $user_address_id == $value,
					'hiddenField' => false,
					'options'     => array(
						$user_address_id => $user_address
					)
				)
			)
		?>
	<?php endforeach ?>
</div>

<div data-type="shipping-address" class="hide">
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'address_form',
			array(
				'prefix'           => 'UserAddress',
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