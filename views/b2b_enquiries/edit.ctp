<div class="user-address-edit-page user-page page">
	
	<div class="page-header">
		<h1>
			<?php echo $id ? __('Edytuj zapytanie', true) : __('Dodaj zapytanie', true) ?>
		</h1>
	</div>
	
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-false">
			<?php
				echo $this->Form->create(
					'B2bEnquire',
					array(
						'url'           => getB2bEnquiriesEditUrl($id),
						'class'         => 'form',
						'data-validate' => 'true',
						'data-submit'   => 'once'
					)
				)
			?>
				<?php
					echo $this->Form->hidden(
						'user_id',
						array(
							'data-type' => 'b2b-enquire-user-id'
						)
					);
					
					echo $this->Form->hidden(
						'b2b_lead_id',
						array(
							'data-type' => 'b2b-enquire-b2b-lead-id'
						)
					);
					
					echo $this->Form->input(
						'title',
						array(
							'type'          => 'text',
							'div'           => 'form-row',
							'label'         => __('Tytuł', true).':',
							'class'         => 'form-control',
							'data-validate' => 'validate(required)',
							'escape'        => false
						)
					);
					
					echo $this->Form->input(
						'content',
						array(
							'type'          => 'textarea',
							'div'           => 'form-row',
							'label'         => __('Treść', true).':',
							'class'         => 'form-control',
							'data-validate' => 'validate(required-textarea)',
							'escape'        => false
						)
					);
				?>
				
				<div class="form-row">
					<label for="B2bEnquireUsername">
						<?php __('Klient') ?>:
					</label>
					
					<?php
						echo $this->Form->input(
							'username',
							array(
								'type'                 => 'text',
								'data-type'            => 'b2b-enquire-username',
								'data-ac'              => 'true',
								'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('b2b' => true)))),
								'data-ac-handler'      => '[data-type=b2b-enquire-user-id-container]',
								'data-ac-extended'     => 'false',
								'data-ac-copy'         => '[data-type=b2b-enquire-user-id]',
								'data-ac-copy-fields'  => json_encode(
									array(
										'b2b_lead_id'     => '[data-type=b2b-enquire-b2b-lead-id]',
										'email'           => '[data-type=b2b-enquire-email]',
										'phone'           => '[data-type=b2b-enquire-phone]',
										'street'          => '[data-type=b2b-enquire-street]',
										'street_number_1' => '[data-type=b2b-enquire-street-number-1]',
										'street_number_2' => '[data-type=b2b-enquire-street-number-2]',
										'postcode'        => '[data-type=b2b-enquire-postcode]',
										'city'            => '[data-type=b2b-enquire-city]',
										'country_id'      => '[data-type=b2b-enquire-country-id]',
										'user_address_id' => '[data-type=b2b-enquire-user-address-id]'
									)
								),
								'div'                  => array(
									'data-type' => 'b2b-enquire-user-id-container',
									'class'     => 'autocompleter-container'
								),
								'label'                => false,
								'class'                => 'form-control'
							)
						)
					?>
				</div>
				
				<div class="form-row">
					<label for="B2bEnquireEmail">
						<?php __('Adres e-mail') ?>:
					</label>
					
					<?php
						echo $this->Form->input(
							'email',
							array(
								'type'                 => 'text',
								'data-type'            => 'b2b-enquire-email',
								'data-ac'              => 'true',
								'data-ac-field'        => 'email',
								'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('search' => 'email', 'b2b' => true)))),
								'data-ac-handler'      => '[data-type=b2b-enquire-email-container]',
								'data-ac-extended'     => 'false',
								'data-ac-copy'         => '[data-type=b2b-enquire-user-id]',
								'data-ac-copy-fields'  => json_encode(
									array(
										'b2b_lead_id'     => '[data-type=b2b-enquire-b2b-lead-id]',
										'label'           => '[data-type=b2b-enquire-username]',
										'phone'           => '[data-type=b2b-enquire-phone]',
										'street'          => '[data-type=b2b-enquire-street]',
										'street_number_1' => '[data-type=b2b-enquire-street-number-1]',
										'street_number_2' => '[data-type=b2b-enquire-street-number-2]',
										'postcode'        => '[data-type=b2b-enquire-postcode]',
										'city'            => '[data-type=b2b-enquire-city]',
										'country_id'      => '[data-type=b2b-enquire-country-id]',
										'user_address_id' => '[data-type=b2b-enquire-user-address-id]'
									)
								),
								'div'                  => array(
									'data-type' => 'b2b-enquire-email-container',
									'class'     => 'autocompleter-container'
								),
								'label'                => false,
								'class'                => 'form-control'
							)
						)
					?>
				</div>
				
				<?php
					echo $this->Form->input(
						'phone',
						array(
							'type'      => 'text',
							'div'       => 'form-row',
							'label'     => __('Telefon', true).':',
							'class'     => 'form-control',
							'data-type' => 'b2b-enquire-phone',
							'escape'    => false
						)
					)
				?>
				
				<div class="street-row form-row">
					<?php
						echo $this->Form->input(
							'user_address_id',
							array(
								'type'      => 'hidden',
								'div'       => false,
								'label'     => false,
								'data-type' => 'b2b-enquire-user-address-id'
							)
						);
						
						echo $this->Form->input(
							'street',
							array(
								'type'              => 'text',
								'div'               => false,
								'label'             => __('Ulica / nr / lokal', true).':',
								'class'             => 'form-control street',
								'data-type'         => 'b2b-enquire-street',
								'data-change-clear' => '[data-type=b2b-enquire-user-address-id]',
								'escape'            => false
							)
						);
						
						echo $this->Form->input(
							'street_number_1',
							array(
								'type'              => 'text',
								'div'               => false,
								'label'             => array(
									'text'  => __('/', true),
									'class' => 'street-number-separator'
								),
								'class'             => 'form-control street-number',
								'data-type'         => 'b2b-enquire-street-number-1',
								'data-change-clear' => '[data-type=b2b-enquire-user-address-id]',
								'escape'            => false
							)
						);
						
						echo $this->Form->input(
							'street_number_2',
							array(
								'type'              => 'text',
								'div'               => false,
								'label'             => array(
									'text'  => __('/', true),
									'class' => 'street-number-separator'
								),
								'class'             => 'form-control street-number',
								'data-type'         => 'b2b-enquire-street-number-2',
								'data-change-clear' => '[data-type=b2b-enquire-user-address-id]',
								'escape'            => false
							)
						);
					?>
				</div>
				
				<div class="city-row form-row">
					<?php
						echo $this->Form->input(
							'postcode',
							array(
								'type'              => 'text',
								'div'               => false,
								'label'             => __('Kod / miasto', true).':',
								'class'             => 'form-control postcode',
								'data-type'         => 'b2b-enquire-postcode',
								'data-change-clear' => '[data-type=b2b-enquire-user-address-id]',
								'escape'            => false
							)
						);
						
						echo $this->Form->input(
							'city',
							array(
								'type'              => 'text',
								'div'               => false,
								'label'             => array(
									'text'  => __('/', true),
									'class' => 'street-number-separator'
								),
								'class'             => 'form-control city',
								'data-type'         => 'b2b-enquire-city',
								'data-change-clear' => '[data-type=b2b-enquire-user-address-id]',
								'escape'            => false
							)
						)
					?>
				</div>
				
				<?php
					echo $this->Form->input(
						'country_id',
						array(
							'type'              => 'select',
							'options'           => Set::combine($countries, '{n}.Country.id', '{n}.Country.name'),
							'div'               => 'form-row country-row',
							'label'             => __('Kraj', true).':',
							'class'             => 'form-control',
							'data-type'         => 'b2b-enquire-country-id',
							'data-change-clear' => '[data-type=b2b-enquire-user-address-id]'
						)
					)
				?>
				
				<span class="form-info required-info">
					<?php __('Pola oznaczone (*) są wymagane') ?>
				</span>
				
				<div class="form-actions align-input">
					<a class="btn-back btn btn-link btn-lg" href="<?php echo $this->Html->url(getB2bEnquiriesListUrl()) ?>" title="<?php echo h(__('Anuluj', true)) ?>">
						<?php __('Anuluj') ?>
					</a>
					
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		</div>
	</div>
</div>