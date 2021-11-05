<div class="user-add-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Dodaj nowego klienta') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php
			echo $this->Form->create(
				'User',
				array(
					'url'           => getCurrentUrl(),
					'class'         => 'form',
					'data-validate' => 'true',
					'autocomplete'  => 'off',
					'data-submit'   => 'once',
					'data-type'     => 'new-user-form'
				)
			)
		?>
			<?php
				echo $this->Form->hidden(
					'select',
					array(
						'value' => getPageParamValue('select')
					)
				);
				
				echo $this->Form->hidden(
					'b2b_lead_id',
					array(
						'data-type' => 'new-user-b2b-lead-id'
					)
				);
				
				echo $this->Form->hidden(
					'UserAddress.id',
					array(
						'data-type' => 'new-user-user-address-id'
					)
				);
			?>
			
			<div class="clearfix">
				<div class="user-form left">
					<?php
						echo $this->Form->input(
							'first_name',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Imię', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						)
					?>
					
					<div class="form-row">
						<label for="UserLastName">
							<?php __('Nazwisko') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'last_name',
								array(
									'type'                      => 'text',
									'data-validate'             => 'validate(required)',
									'label'                     => false,
									'class'                     => 'form-control',
									'escape'                    => false,
									'data-ac'                   => getPageParamValue('from') == 'cart' ? 'true' : 'false',
									'data-ac-url'               => html_entity_decode($this->Html->url(getSalesrepUsersAutocompleterUrl('lastname', array('from' => getPageParamValue('from'))))),
									'data-ac-field'             => 'lastname',
									'data-ac-handler'           => '[data-type=new-user-last-name-autocompleter-container]',
									'data-trigger-autocomplete' => 'select-user',
									'data-type'                 => 'new-user-autocompleter',
									'div'                       => array(
										'data-type' => 'new-user-last-name-autocompleter-container',
										'class'     => 'autocompleter-container'
									)
								)
							)
						?>
					</div>
					
					<div class="form-row">
						<label for="UserCompanyName">
							<?php __('Nazwa firmy') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'company_name',
								array(
									'type'                      => 'text',
									'data-validate'             => 'validate(required)',
									'label'                     => false,
									'class'                     => 'form-control',
									'escape'                    => false,
									'data-ac'                   => getPageParamValue('from') != 'offer' ? 'true' : 'false',
									'data-ac-url'               => html_entity_decode($this->Html->url(getSalesrepUsersAutocompleterUrl('company', array('from' => getPageParamValue('from'))))),
									'data-ac-handler'           => '[data-type=new-user-company-name-autocompleter-container]',
									'data-trigger-autocomplete' => 'select-user',
									'data-type'                 => 'new-user-autocompleter',
									'div'                       => array(
										'data-type' => 'new-user-company-name-autocompleter-container',
										'class'     => 'autocompleter-container'
									)
								)
							)
						?>
					</div>
					
					<?php
						if (count(getLocaleList()) > 1):
							echo $this->Form->input(
								'locale',
								array(
									'type'          => 'select',
									'div'           => 'form-row',
									'label'         => __('Język', true).':',
									'class'         => 'form-control',
									'options'       => getLocaleList(),
									'default'       => configuration('Config.language')
								)
							);
						endif;
						
						echo $this->Form->input(
							'phone',
							array(
								'type'          => 'number',
								'pattern'       => "[0-9]*",
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Telefon', true).':',
								'class'         => 'form-control'
							)
						);
					?>
					
					<div class="form-row">
						<label for="UserEmail">
							<?php __('E-mail') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'email',
								array(
									'type'                      => 'email',
									'data-validate'             => 'validate(email)',
									'label'                     => false,
									'class'                     => 'form-control',
									'escape'                    => false,
									'data-ac'                   => getPageParamValue('from') != 'offer' ? 'true' : 'false',
									'data-ac-url'               => html_entity_decode($this->Html->url(getSalesrepUsersAutocompleterUrl('email', array('from' => getPageParamValue('from'))))),
									'data-ac-handler'           => '[data-type=new-user-email-autocompleter-container]',
									'data-trigger-autocomplete' => 'select-user',
									'data-type'                 => 'new-user-autocompleter',
									'div'                       => array(
										'data-type' => 'new-user-email-autocompleter-container',
										'class'     => 'autocompleter-container'
									)
								)
							)
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'email_2',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(email, match-value(#UserEmail))',
								'div'           => 'form-row',
								'label'         => __('Powtórz e-mail', true).':',
								'class'         => 'form-control'
							)
						)
					?>
					
					<div class="form-row radio-group">
						<label>
							<?php __('Rejestracja') ?>:
						</label>
						
						<div class="radio-list">
							<?php foreach (array(1 => __('tak', true), 0 => __('nie', true)) as $register_option => $register_option_label): ?>
								<?php
									echo $this->Form->input(
										'register',
										array(
											'type'      => 'radio',
											'div'       => 'radio',
											'legend'    => false,
											'value'     => isset($this->data['User']['register']) ? $this->data['User']['register'] : 0,
											'id'        => 'UserRegister',
											'data-type' => 'user-add-register-toggle',
											'options'   => array(
												$register_option => $register_option_label
											)
										)
									)
								?>
							<?php endforeach ?>
						</div>
					</div>
					
					<?php
						echo $this->Form->input(
							'passwd',
							array(
								'type'                  => 'password',
								'data-validate'         => !empty($this->data['User']['register']) ? 'validate(required, minlength('.$min_password_length.'))' : '',
								'data-validate-pattern' => 'validate(required, minlength('.$min_password_length.'))',
								'div'                   => array(
									'class'     => 'form-row '.(empty($this->data['User']['register']) ? 'hide' : ''),
									'data-type' => 'user-add-password-row'
								),
								'label'                 => __('Hasło', true).':',
								'class'                 => 'form-control',
								'data-type'             => 'user-add-password-input'
							)
						);
						
						echo $this->Form->input(
							'passwd_2',
							array(
								'type'                  => 'password',
								'data-validate'         => !empty($this->data['User']['register']) ? 'validate(required, match-value(#UserPasswd))' : '',
								'data-validate-pattern' => 'validate(required, match-value(#UserPasswd))',
								'div'                   => array(
									'class'     => 'form-row '.(empty($this->data['User']['register']) ? 'hide' : ''),
									'data-type' => 'user-add-password-row'
								),
								'label'                 => __('Powtórz hasło', true).':',
								'class'                 => 'form-control',
								'data-type'             => 'user-add-password-input'
							)
						);
					?>
					
					<?php
						foreach ($custom_user_fields as $custom_user_field_key => $custom_user_field_label):
							echo $this->Form->input(
								$custom_user_field_key,
								array(
									'type'          => 'text',
									'div'           => 'form-row',
									'label'         => $custom_user_field_label.':',
									'class'         => 'form-control'
								)
							);
						endforeach;
					?>
					
					<?php
						echo $this->Form->input(
							'source',
							array(
								'type'     => 'select',
								'multiple' => 'multiple',
								'div'      => 'form-row',
								'label'    => __('Źródła', true).':',
								'options'  => $order_sources,
								'class'    => 'form-control transform-hide',
								'size'     => 5
							)
						)
					?>
				</div>
				
				<div class="user-form right">
					<div class="address-form form" data-type="new-user-address">
						<div class="form-row">
							<label for="UserAddressNip">
								<?php __('NIP') ?>:
							</label>
							
							<?php
								echo $this->Form->input(
									'UserAddress.nip',
									array(
										'type'                      => 'text',
										'data-validate'             => 'validate(required)',
										'label'                     => false,
										'class'                     => 'form-control',
										'escape'                    => false,
										'data-ac'                   => getPageParamValue('from') == 'cart' ? 'true' : 'false',
										'data-ac-url'               => html_entity_decode($this->Html->url(getSalesrepUsersAutocompleterUrl('nip', array('from' => getPageParamValue('from'))))),
										'data-ac-handler'           => '[data-type=new-user-nip-autocompleter-container]',
										'data-ac-field'             => 'nip',
										'data-trigger-autocomplete' => 'select-user',
										'data-type'                 => 'new-user-autocompleter',
										'div'                       => array(
											'data-type' => 'new-user-nip-autocompleter-container',
											'class'     => 'autocompleter-container'
										)
									)
								)
							?>
						</div>
						
						<?php
							echo $this->Form->input(
								'UserAddress.street',
								array(
									'type'          => 'text',
									'label'         => __('Ulica', true).':',
									'class'         => 'form-control',
									'div'           => 'form-row',
									'data-validate' => 'validate(required)'
								)
							)
						?>
						
						<div class="street-number-row form-row">
							<?php
								echo $this->Form->input(
									'UserAddress.street_number_1',
									array(
										'type'          => 'text',
										'label'         => __('Nr domu', true).':',
										'class'         => 'form-control',
										'div'           => false,
										'data-validate' =>  setting('GLOBAL_USER_ADDRESS_STREET_NUMBER_1_REQUIRED') ? 'validate(required)' : ''
									)
								);
								
								echo $this->Form->input(
									'UserAddress.street_number_2',
									array(
										'type'  => 'text',
										'div'   => false,
										'class' => 'form-control',
										'label' => array(
											'text'  => __('/', true),
											'class' => 'street-number-separator'
										)
									)
								);
							?>
						</div>
						
						<?php
							echo $this->Form->input(
								'UserAddress.postcode',
								array(
									'type'          => 'text',
									'label'         => __('Kod pocztowy', true).':',
									'class'         => 'form-control',
									'div'           => 'form-row',
									'data-validate' => 'validate(required)'
								)
							);
							
							echo $this->Form->input(
								'UserAddress.city',
								array(
									'type'          => 'text',
									'label'         => __('Miasto', true).':',
									'class'         => 'form-control',
									'div'           => 'form-row',
									'data-validate' => 'validate(required)'
								)
							);
							
							foreach ($countries as $country):
								if ($country['State']):
									$states = Set::combine($country['State'], '{n}.id', '{n}.name');
									
									if (!empty($this->data['UserAddress']['country_id']) && $this->data['UserAddress']['country_id'] == $country['Country']['id']):
										$state_row_class = '';
									else:
										$state_row_class = 'hide';
									endif;
									
									$state_disabled = false;
									
									if ($this->data['UserAddress']['country_id'] != $country['Country']['id'] || count($states) == 0):
										$state_disabled = 'disabled';
									endif;
									
									echo $this->Form->input(
										'UserAddress.state_id',
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
											'disabled'  => $state_disabled
										)
									);
								endif;
							endforeach;
							
							if (count($countries_list) > 1):
								echo $this->Form->input(
									'UserAddress.country_id',
									array(
										'type'            => 'select',
										'data-type'       => 'country',
										'data-codes-list' => json_encode(getCountriesCodesList()),
										'div'             => 'form-row',
										'label'           => __('Kraj', true).':',
										'class'           => 'form-control',
										'options'         => $countries_list,
										'empty'           => false
									)
								);
							elseif (count($countries_list) == 1):
								echo $this->Form->hidden(
									'UserAddress.country_id',
									array(
										'value'    => reset(array_keys($countries_list))
									)
								);
							endif;
						?>
					</div>
				</div>
			</div>
			
			<hr>
			
			<div class="user-form shipping-address">
				<div class="address-form form">
					<?php
						echo $this->Form->input(
							'ShippingAddress.new_shipping',
							array(
								'type'      => 'checkbox',
								'data-type' => 'toggle-different-shipping',
								'div'       => 'checkbox',
								'label'     => __('Inny adres dostawy', true)
							)
						);
						
						$is_selected = !empty($this->data['ShippingAddress']['new_shipping']);
					?>
					
					<div data-type="new-shipping-address" class="<?php echo empty($this->data['ShippingAddress']['new_shipping']) ? 'hide' : '' ?>">
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'address_form',
								array(
									'prefix'           => 'ShippingAddress',
									'address_required' => true,
									'name_validate'    => $is_selected && empty($this->data['ShippingAddress']['company']) ? 'validate(required)' : '',
									'company_validate' => $is_selected && !empty($this->data['ShippingAddress']['company']) ? 'validate(required)' : '',
									'phone_validate'   => $is_selected ? 'validate(required)' : '',
									'address_validate' => $is_selected ? 'validate(required)' : '',
									'postal_validate'  => $is_selected ? 'validate(required, postal-{code})' : '',
									'add_invoice'      => false,
									'add_vat_checkbox' => false,
									'show_user_type'   => true,
									'disabled'         => !$is_selected
								)
							)
						?>
					</div>
				</div>
			</div>
			
			<div class="user-form clear">
				<div class="form-actions">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Dodaj', true)) ?>">
				</div>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>
