<div class="modal fade" id="shipping-address-edit" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<?php
			echo $this->Form->create(
				'Order',
				array(
					'url'           => getOrderUrl($id, $code),
					'class'         => 'address-form form',
					'data-submit'   => 'once',
					'escapeInputs'  => false,
					'id'            => 'OrdersShippingAddressEditForm'
				)
			)
		?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h2>
						<?php __('Edytuj adres dostawy') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->input(
							'shipping_save',
							array(
								'type'      => 'hidden',
								'value'     => 1
							)
						);
						
						echo $this->Form->input(
							'shipping_firstname',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Imię', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_firstname']
							)
						);
						
						echo $this->Form->input(
							'shipping_lastname',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Nazwisko', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_lastname']
							)
						);
						
						echo $this->Form->input(
							'shipping_company',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Nazwa firmy', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_company']
							)
						);
						
						echo $this->Form->input(
							'shipping_street',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Ulica', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_street']
							)
						);
					?>
					
					<div class="street-number-row form-row">
						<?php
							echo $this->Form->input(
								'shipping_street_number_1',
								array(
									'type'    => 'text',
									'div'     => false,
									'label'   => __('Nr domu', true).':',
									'class'   => 'form-control',
									'default' => $order['Order']['shipping_street_number_1']
								)
							);
							
							echo $this->Form->input(
								'shipping_street_number_2',
								array(
									'type'    => 'text',
									'div'     => false,
									'label'   => array(
										'text'  => __('/', true),
										'class' => 'street-number-separator'
									),
									'class'   => 'form-control',
									'default' => $order['Order']['shipping_street_number_2']
								)
							);
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'shipping_postcode',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Kod pocztowy', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_postcode']
							)
						);
						
						echo $this->Form->input(
							'shipping_city',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Miasto', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_city']
							)
						);
						
						foreach (getAllCountries() as $country):
							if ($country['State']):
								$states = Set::combine($country['State'], '{n}.id', '{n}.name');
								
								if ($order['Order']['shipping_country_id'] == $country['Country']['id']):
									$state_row_class = '';
								else:
									$state_row_class = 'hide';
								endif;
								
								$disabled = false;
								
								if ($order['Order']['shipping_country_id'] != $country['Country']['id'] || count($states) == 0):
									$disabled = 'disabled';
								endif;
								
								echo $this->Form->input(
									'shipping_state_id',
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
										'default'   => $order['Order']['shipping_state_id']
									)
								);
							endif;
						endforeach;
						
						echo $this->Form->input(
							'shipping_country_id',
							array(
								'type'      => 'select',
								'data-type' => 'country',
								'div'       => 'form-row',
								'label'     => __('Kraj', true).':',
								'class'     => 'form-control',
								'options'   => getCountriesList(),
								'empty'     => false,
								'default'   => $order['Order']['shipping_country_id']
							)
						);
						
						echo $this->Form->input(
							'shipping_phone',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Telefon', true).':',
								'class'   => 'form-control',
								'default' => $order['Order']['shipping_phone']
							)
						);
					?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Anuluj') ?>
					</a>
					
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
				</div>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>