<?php foreach ($addresses as $address): ?>
	<div class="<?php echo $selected == $address['UserAddress']['id'] ? '' : 'hide' ?>" data-type="<?php echo $type ?>" data-address-id="<?php echo $address['UserAddress']['id'] ?>">
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'address',
				array(
					'firstname'    => $address['UserAddress']['firstname'],
					'lastname'     => $address['UserAddress']['lastname'],
					'company'      => $address['UserAddress']['company'],
					'nip'          => $address['UserAddress']['nip'],
					'street'       => $address['UserAddress']['street'],
					'street_1'     => $address['UserAddress']['street_number_1'],
					'street_2'     => $address['UserAddress']['street_number_2'],
					'postcode'     => $address['UserAddress']['postcode'],
					'city'         => $address['UserAddress']['city'],
					'state_name'   => $address['State']['name'],
					'country_name' => $address['Country']['name'],
					'phone'        => $address['UserAddress']['phone']
				)
			)
		?>
	</div>
<?php endforeach ?>