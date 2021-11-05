<?php if (count($vat_addresses) > 1): ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'change_address',
			array(
				'addresses' => $vat_addresses,
				'type'      => 'change-vat-address'
			)
		)
	?>
<?php endif ?>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'addresses_list',
		array(
			'addresses' => $vat_addresses,
			'selected'  => $this->data['UserAddress']['vat'],
			'type'      => 'vat-address'
		)
	)
?>

<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'vat_addresses_invoice') ?>