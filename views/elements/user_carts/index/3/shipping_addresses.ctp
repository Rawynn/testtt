<?php
	foreach ($shipping_addresses as $key => $address):
		if ($address['UserAddress']['id'] == getCartVatAddress()):
			unset($shipping_addresses[$key]);
		endif;
	endforeach;
?>

<?php if ($shipping_addresses): ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'change_address',
			array(
				'addresses' => $shipping_addresses,
				'type'      => 'change-shipping-address'
			)
		)
	?>
<?php endif ?>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'addresses_list',
		array(
			'addresses' => $shipping_addresses,
			'selected'  => $this->data['UserAddress']['shipping_address'],
			'type'      => 'shipping-address'
		)
	)
?>