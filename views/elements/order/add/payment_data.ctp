<?php if (module('INVOICE') && $order['Order']['paypal_express']): ?>
	<?php if ($order['Order']['invoice']): ?>
		<a class="btn btn-primary" data-toggle="modal" href="#ChangeOrderPaymentData<?php echo $order['Order']['id'] ?>" role="button" title="<?php echo h(__('Zmień dane do faktury', true)) ?>">
			<?php __('Zmień dane do faktury') ?>
		</a>
	<?php else: ?>
		<div class="message info">
			<?php __('Jeśli chcesz otrzymać fakturę VAT do zamówienia zaznacz opcję poniżej i uzupełnij dane do faktury.') ?>
		</div>
		
		<?php
			echo $this->Form->input(
				'Order.order_invoice',
				array(
					'label'         => __('Chcę otrzymać fakturę', true),
					'type'          => 'checkbox',
					'data-type'     => 'order-change-payment-data',
					'data-order-id' => $order['Order']['id']
				)
			)
		?>
	<?php endif ?>
	
	<hr>
	
	<div class="modal fade" data-type="change-order-payment-data-modal" data-order-id="<?php echo $order['Order']['id'] ?>" id="ChangeOrderPaymentData<?php echo $order['Order']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Dane do faktury') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'Order',
							array(
								'url'           => getOrderChangePaymentDataUrl($order['Order']['id'], $order['Order']['code']),
								'class'         => 'address-form form ajax-modal-form',
								'id'            => 'OrderChangePaymentDataForm'.$order['Order']['id'],
								'data-type'     => 'change-order-payment-data-form',
								'data-order-id' => $order['Order']['id']
							)
						)
					?>
						<?php
							echo $this->Form->input(
								'payment_firstname',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('Imię', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_firstname'],
									'id'      => 'OrderChangePaymentFirstname'.$order['Order']['id']
								)
							);
							
							echo $this->Form->input(
								'payment_lastname',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('Nazwisko', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_lastname'],
									'id'      => 'OrderChangePaymentLastname'.$order['Order']['id']
								)
							);
							
							echo $this->Form->input(
								'payment_company',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('Nazwa firmy', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_company'],
									'id'      => 'OrderChangePaymentCompany'.$order['Order']['id']
								)
							);
							
							echo $this->Form->input(
								'payment_nip',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('NIP', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_nip'],
									'id'      => 'OrderChangePaymentNip'.$order['Order']['id']
								)
							);
							
							echo $this->Form->input(
								'payment_street',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('Ulica', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_street'],
									'id'      => 'OrderChangePaymentStreet'.$order['Order']['id']
								)
							);
						?>
						
						<div class="street-number-row form-row">
							<?php
								echo $this->Form->input(
									'payment_street_number_1',
									array(
										'type'    => 'text',
										'div'     => false,
										'label'   => __('Nr domu', true).':',
										'class'   => 'form-control',
										'default' => $order['Order']['payment_street_number_1'],
										'id'      => 'OrderChangePaymentStreetNumber1'.$order['Order']['id']
									)
								);
								
								echo $this->Form->input(
									'payment_street_number_2',
									array(
										'type'    => 'text',
										'div'     => false,
										'label'   => array(
											'text'  => __('/', true),
											'class' => 'street-number-separator'
										),
										'class'   => 'form-control',
										'default' => $order['Order']['payment_street_number_2'],
										'id'      => 'OrderChangePaymentStreetNumber2'.$order['Order']['id']
									)
								);
							?>
						</div>
						
						<?php
							echo $this->Form->input(
								'payment_postcode',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('Kod pocztowy', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_postcode'],
									'id'      => 'OrderChangePaymentPostcode'.$order['Order']['id']
								)
							);
							
							echo $this->Form->input(
								'payment_city',
								array(
									'type'    => 'text',
									'div'     => 'form-row',
									'label'   => __('Miasto', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_city'],
									'id'      => 'OrderChangePaymentCity'.$order['Order']['id']
								)
							);
							
							foreach (getAllCountries() as $country):
								if ($country['State']):
									$states = Set::combine($country['State'], '{n}.id', '{n}.name');
									
									if ($order['Order']['payment_country_id'] == $country['Country']['id']):
										$state_row_class = '';
									else:
										$state_row_class = 'hide';
									endif;
									
									$disabled = false;
									
									if ($order['Order']['payment_country_id'] != $country['Country']['id'] || count($states) == 0):
										$disabled = 'disabled';
									endif;
									
									echo $this->Form->input(
										'payment_state_id',
										array(
											'type'      => 'select',
											'data-type' => 'state',
											'div'       => array(
												'tag'           => 'div',
												'class'         => 'form-row'.' '.$state_row_class,
												'data-state-id' => $country['Country']['id']
											),
											'label'     => __('Województwo', true).':',
											'class'     => 'form-control',
											'options'   => $states,
											'empty'     => __('Wybierz', true),
											'disabled'  => $disabled,
											'default'   => $order['Order']['payment_state_id'],
											'id'        => 'OrderChangePaymentStateId'.$country['Country']['id'].'_'.$order['Order']['id']
										)
									);
								endif;
							endforeach;
							
							echo $this->Form->input(
								'payment_country_id',
								array(
									'type'      => 'select',
									'data-type' => 'country',
									'div'       => 'form-row',
									'label'     => __('Kraj', true).':',
									'class'     => 'form-control',
									'options'   => getCountriesList(),
									'empty'     => false,
									'default'   => $order['Order']['payment_country_id'],
									'id'        => 'OrderChangePaymentCountryId'.$order['Order']['id']
								)
							);
							
							echo $this->Form->input(
								'payment_phone',
								array(
									'type'    => 'number',
									'pattern' => "[0-9]*",
									'div'     => 'form-row',
									'label'   => __('Telefon', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['payment_phone'],
									'id'      => 'OrderChangePaymentPhone'.$order['Order']['id']
								)
							);
						?>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz')) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif?>
