<?php
	$is_address_required = checkCartAddressIsRequired();
	
	if ($parent_user || $salesrep_user || module('B2B') && !setting('MODULE_B2B_ALLOW_OWN_USER_ADDRESS_EDIT')):
		$vat_addresses = $vat_addresses;
	else:
		$vat_addresses = $user_addresses;
	endif;
?>
<hr>
<div class="row border-holder">
<div class="border-hold"></div>
<?php
	echo $this->Form->create(
		'UserCart',
		array(
			'url'           => getCartUrl($step),
			'class'         => 'address-form form',
			'data-validate' => 'true',
			'data-submit'   => 'once',
			'id'            => 'OrderFormLogged',
			'autocomplete'  => 'off'
		)
	)
?>
	<div class="clearfix">
		<div class="order-form left">
			<?php
				echo $this->Form->hidden(
					'UserAddress.vat',
					array(
						'data-type' => 'selected-vat-address'
					)
				)
			?>
			<div class="order-section-header">
				<h2>
					<?php __('Dane klienta') ?>
				</h2>
			</div>
			<?php if ($vat_addresses): ?>
				<div class="address-select-container vat-address" data-type="vat-addresses-container">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'vat_addresses',
							array(
								'vat_addresses' => $vat_addresses
							)
						)
					?>
				</div>
				
				<hr>
			<?php endif ?>
			
			<?php if (checkCanAddUserAddress(true)): ?>
				<?php if ($vat_addresses): ?>
					<?php
						echo $this->Form->input(
							'UserAddress.new_vat',
							array(
								'type'      => 'checkbox',
								'data-type' => 'toggle-new-vat-address',
								'div'       => 'form-row checkbox',
								'label'     => __('Nowe dane klienta', true)
							)
						)
					?>
				<?php else: ?>
					<?php
						echo $this->Form->hidden(
							'UserAddress.new_vat',
							array(
								'value' => 1
							)
						)
					?>
				<?php endif ?>
				
				<div class="form-inner">
					<div data-type="new-vat-address">
						<?php $is_selected = !empty($this->data['UserAddress']['new_vat']) && $this->data['UserAddress']['new_vat'] ? true : false ?>
						
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'address_form',
								array(
									'prefix'           => 'VatAddress',
									'nip_check_prefix' => 'UserAddress',
									'add_invoice'      => true,
									'invoice_type'     => $invoice,
									'add_vat_checkbox' => true,
									'name_validate'    => $is_selected ? (!empty($this->data['VatAddress']['company']) ? '' : 'validate(required)') : '',
									'company_validate' => $is_selected ? (!empty($this->data['VatAddress']['company']) ? 'validate(required)' : '') : '',
									'phone_validate'   => $is_selected ? 'validate(required)' : '',
									'address_required' => $is_address_required,
									'address_validate' => $is_address_required && $is_selected ? 'validate(required)' : '',
									'postal_validate'  => $is_address_required && $is_selected ? 'validate(required, postal-{code})' : '',
									'disabled'         => $is_selected ? false : true,
									'show_user_type'   => true
								)
							)
						?>
						
						<?php if (userIsSalesrep() && getCartUserCartOfferId()): ?>
							<?php
								echo $this->Form->input(
									'Offer.email',
									array(
										'div'   => 'form-row',
										'label' => __('E-mail klienta', true).':',
										'class' => 'form-control',
										'value' => getCartUserEmail()
									)
								)
							?>
						<?php endif ?>
					</div>
					<?php
						echo $this->Form->input(
							'OrderHistory.comment',
							array(
								'type'  => 'textarea',
								'div'   => false,
								'label' => false,
								'placeholder' => __('KOMENTARZ',true).':',
								'class' => 'form-control comment',
								'value' => getCartOrderComment(),
								'rows'  => 4
							)
						)
					?>
				</div>
			<?php endif ?>
			
			<?php if (showOpineoCheckbox()): ?>
				<div class="form-inner">
					<?php
						echo $this->Form->input(
							'OrderField.opineo_agreement',
							array(
								'type'    => 'checkbox',
								'div'     => 'form-row checkbox',
								'label'   => __('Wyrażam zgodę na przesłanie na mój adres poczty elektronicznej ankiety w ramach programu "System Wiarygodne Opinie" oraz wyrażam zgodę na przetwarzanie i przekazanie moich danych osobowych - adresu e-mail oraz informacji o dokonanym zakupie, spółce Opineo Sp. z o.o. z siedzibą we Wrocławiu, 53-333 Wrocław, ul. Powstańców Śląskich 2-4.', true),
								'checked' => (bool) getCartOrderFieldValue('opineo_agreement')
							)
						)
					?>
				</div>
			<?php endif ?>
			
			<?php if (showCeneoCheckbox()): ?>
				<div class="form-inner">
					<?php
						echo $this->Form->input(
							'ModuleCeneo.ceneo_on_demand',
							array(
								'type'  => 'checkbox',
								'div'   => 'form-row checkbox',
								'label' => __('Wyrażam zgodę na przesłanie na mój adres poczty elektronicznej ankiety w ramach programu "Zaufane Opinie" oraz wyrażam zgodę na przetwarzanie i przekazanie moich danych osobowych - adresu e-mail oraz informacji o dokonanym zakupie, spółce Ceneo Sp. z o.o. z siedzibą w Poznaniu, 60-166 Poznań, ul. Grunwaldzka 182.', true)
							)
						)
					?>
				</div>
			<?php endif ?>
		</div>
		
		<div class="order-form right">
		
			<?php if (checkCartAddressIsRequired(false) && !checkOnlyVirtualProductsInCart()): ?>
				<?php
					if (getCartShippingAddress() != null && getCartShippingAddress() != getCartVatAddress() && !isset($this->data['ShippingAddress']['new_shipping'])):
						$this->data['ShippingAddress']['new_shipping']       = 1;
						$this->Form->data['ShippingAddress']['new_shipping'] = 1;
					endif;
					
					echo $this->Form->hidden(
						'UserAddress.shipping_address',
						array(
							'data-type' => 'selected-shipping-address'
						)
					);
				?>
				<div class="order-section-header">
				<h2>
					<?php
						echo $this->Form->input(
							'ShippingAddress.new_shipping',
							array(
								'type'      => 'checkbox',
								'data-type' => 'toggle-different-shipping',
								'div'       => 'checkbox',
								'label'     => __('Inny adres dostawy', true),
								'disabled'  => !checkCanAddUserAddress(false, null, 'new_shipping')
							)
						)
					?>
				</h2>
				</div>
				<?php if (count($user_addresses) > 1): ?>
					<div class="address-select-container shipping-address" data-type="shipping-addresses-container">
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'shipping_addresses',
								array(
									'shipping_addresses' => $user_addresses
								)
							)
						?>
					</div>
					
					<hr>
				<?php endif ?>
				
				<?php if (count($user_addresses) > 1): ?>
					<?php
						echo $this->Form->input(
							'UserAddress.new_shipping',
							array(
								'type'      => 'checkbox',
								'data-type' => 'toggle-new-shipping-address',
								'div'       => 'form-row checkbox',
								'label'     => __('Nowy adres do wysyłki', true),
								'disabled'  => isset($this->data['ShippingAddress']['new_shipping']) && $this->data['ShippingAddress']['new_shipping'] ? false : true
							)
						)
					?>
				<?php else: ?>
					<?php
						echo $this->Form->hidden(
							'UserAddress.new_shipping',
							array(
								'data-type' => 'toggle-new-shipping-address'
							)
						)
					?>
				<?php endif ?>
				
				<div class="form-inner">
					<div data-type="new-shipping-address">
						<?php
							$is_selected = isset($this->data['UserAddress']['new_shipping']) && $this->data['UserAddress']['new_shipping'] ? true : false;
							
							echo $this->element(
								TEMPLATE_NAME.DS.'address_form',
								array(
									'prefix'                  => 'ShippingAddress',
									'name_validate'           => $is_selected ? (!empty($this->data['ShippingAddress']['company']) ? '' : 'validate(required)') : '',
									'company_validate'        => $is_selected ? (!empty($this->data['ShippingAddress']['company']) ? 'validate(required)' : '') : '',
									'phone_validate'          => $is_selected ? 'validate(required)' : '',
									'address_required'        => true,
									'address_validate'        => $is_selected ? 'validate(required)' : '',
									'postal_validate'         => $is_selected ? 'validate(required, postal-{code})' : '',
									'disabled'                => $is_selected ? false : true,
									'shipping_email'          => getCartDropshipping(),
									'shipping_email_required' => getCartDropshipping() && $is_selected ? 'validate(email)' : '',
									'show_user_type'          => true
								)
							)
						?>
					</div>
				</div>
			<?php else: ?>
				<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'no_shipping_address_info') ?>
			<?php endif ?>
		</div>
	</div>
	
	<div class="order-form clear">
		
		<?php if (getCartShippingCommentAvailable()): ?>
			<h2>
				<?php __('Uwagi dla kuriera') ?>
			</h2>
			
			<div>
				<?php
					echo $this->Form->input(
						'OrderHistory.shipping_comment',
						array(
							'type'  => 'textarea',
							'div'   => false,
							'label' => false,
							'class' => 'form-control comment',
							'value' => getCartShippingComment(),
							'rows'  => 4
						)
					)
				?>
			</div>
			<hr class="no-border" />
		<?php endif ?>
		
		<div class="form-actions hide">
			<a class="btn-back btn btn-pink btn-lg" href="<?php echo $this->Html->url(getCartUrl(1)) ?>" title="<?php echo h(__('Strona główna', true)) ?>">
		<?php __('Wróć do sklepu') ?>
	</a>
	<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php __('Złóż zamówienie') ?>">
		</div>
	</div>
<?php echo $this->Form->end() ?>
</div>
<div class="order-actions form-actions link-action">
	<a class="btn-back btn btn-pink btn-lg" href="<?php echo $this->Html->url(getCartUrl(1)) ?>" title="<?php echo h(__('Strona główna', true)) ?>">
		<?php __('Wróć do sklepu') ?>
	</a>
	<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php __('Złóż zamówienie') ?>">
</div>
<script>
	$('.order-actions.form-actions.link-action input[type=submit]').click(function(){
		$('.address-form .form-actions .btn-next').trigger('click');
	});
</script>
<?php
	/* Ostrzeżenie o ostatnim zamówieniu - #17126 */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'3'.DS.'check_last_order')
?>
