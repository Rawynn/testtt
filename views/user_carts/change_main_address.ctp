<?php
	$output = array();
	
	if ($user_address_count):
		/* Wystawianie faktur */
		$output['invoice'] = $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'vat_addresses_invoice',
			array(
				'invoice' => getInvoiceType()
			)
		);
	endif;
	
	if ($user_addresses):
		$output['shipping'] = $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'shipping_addresses',
			array(
				'shipping_addresses' => $user_addresses,
			)
		);
	endif;
	
	$output['current_vat_address']      = (int) $address_id;
	$output['current_shipping_address'] = (int) $current_shipping_address_id;
	
	echo json_encode($output)
?>