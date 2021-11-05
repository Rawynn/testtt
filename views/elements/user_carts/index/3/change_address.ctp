<?php
	if (isset($current_shipping_address_id)):
		$current_shipping_address = $current_shipping_address_id;
	else:
		$current_shipping_address = getCartShippingAddress();
	endif;
	
	if (isset($address_id)):
		$current_vat_address = $address_id;
	else:
		$current_vat_address = getCartVatAddress();
	endif;
?>

<a class="address-change btn btn-primary <?php echo $type == 'change-shipping-address' && $current_vat_address == $current_shipping_address ? 'left' : 'right' ?>" data-type="<?php echo $type ?>-button" data-title="<?php echo h(__('Zmień adres', true)) ?>" data-toggle="modal" href="#<?php echo $type ?>" role="button" title="<?php echo h(__('Zmień adres', true)) ?>">
	<?php if ($type == 'change-shipping-address' && $current_vat_address == $current_shipping_address): ?>
		<?php __('Wybierz adres z książki adresowej') ?> <i class="fa fa-angle-right"></i>
	<?php else: ?>
		<?php __('Zmień adres') ?> <i class="fa fa-angle-right"></i>
	<?php endif ?>
</a>

<div class="address-change-modal modal fade" id="<?php echo $type ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Zmień adres') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<div class="address-list">
					<?php foreach ($addresses as $address): ?>
						<a data-type="<?php echo $type ?>" data-address-id="<?php echo $address['UserAddress']['id'] ?>" href="">
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
						</a>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>