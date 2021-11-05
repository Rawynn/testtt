<?php
	/* Czy wymagany jest adres */
	if (!isset($address_required)):
		$address_required = checkCartAddressIsRequired();
	endif;
	
	/* Walidacja imienia/nazwiska */
	if (!isset($name_validate)):
		$name_validate = !empty($this->data[$prefix]['company']) ? '' : 'validate(required)';
	endif;
	
	/* Walidacja nazwy firmy */
	$nip_validate = '';
	
	if (!isset($company_validate)):
		$company_validate = empty($this->data[$prefix]['company']) ? '' : 'validate(required)';
		$nip_validate     = empty($company_validate)? '' : 'validate(required, nip-pl)';
	endif;
	
	/* Walidacja numeru telefonu */
	if (!isset($phone_validate)):
		$phone_validate = 'validate(required)';
	endif;
	
	/* Walidacja adresu */
	if (!isset($address_validate)):
		$address_validate = $address_required ? 'validate(required)' : '';
	endif;
	
	/* Walidacja kodu pocztowego */
	if (!isset($postal_validate)):
		$postal_validate = $address_required ? 'validate(required, postal-{code})' : '';
	endif;
	
	/* Walidacja emailu */
	if (!isset($shipping_email_validate)):
		$shipping_email_validate = 'validate(email)';
	endif;
	
	$countries_codes       = getCountriesCodesList();
	$__countries_list_keys = array_keys($__countries_list);
	$country_id            = !empty($this->data[$prefix]['country_id']) ? $this->data[$prefix]['country_id'] : reset($__countries_list_keys);
	
	$postal_validate = str_replace('{code}', isset($countries_codes[$country_id]) ? $countries_codes[$country_id] : '', $postal_validate);
	
	/* Czy pola mają być disabled */
	if (!isset($disabled)):
		$disabled = false;
	endif;
	
	/* Nip prefix */
	if (!isset($nip_prefix)):
		$nip_prefix = $prefix;
	endif;
	
	/* Adres e-mail odbiorcy */
	if (!isset($shipping_email)):
		$shipping_email = false;
	endif;
	
	/* Czy wymagane adres e-mail odbiorcy */
	if (!isset($shipping_email_required)):
		$shipping_email_required = false;
	endif;
	
	/* Czy wyświetlać wybór typu osoby */
	if (!isset($show_user_type)):
		$show_user_type = false;
	endif;

	/* Czy pobierać dane GUS */
	if (!isset($gus)):
		$gus = 0;
	endif;
?>

<?php if ($show_user_type): ?>
	<div class="form-row">
		<label class="user-type-label <?php echo $disabled ? 'disabled' : '' ?>"><?php echo (isset($user_type_label) && $user_type_label) ? $user_type_label : '&nbsp;' ?> </label>
		<?php foreach (array('p' => __('Osoba prywatna', true), 'f' => __('Firma', true)) as $user_type_key => $user_type_value): ?>
			<div class="radio">
				<?php
					echo $this->Form->input(
						$prefix.'.select_user_type',
						array(
							'type'        => 'radio',
							'div'         => false,
							'data-type'   => 'selected-user-type',
							'data-prefix' => strtolower($prefix),
							'legend'      => false,
							'default'     => 'p',
							'disabled'    => $disabled,
							'options'     => array(
								$user_type_key => $user_type_value
							)
						)
					)
				?>
			</div>
		<?php endforeach ?>
	</div>
<?php endif ?>

<?php
	echo $this->Form->input(
		$prefix.'.firstname',
		array(
			'type'                  => 'text',
			'data-type'             => 'firstname',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $name_validate,
			'data-validate-pattern' => 'validate(required)',
			'label'                 => false,
			'placeholder'           => __('Imię', true),
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'div'                   => array(
				'tag'       => 'div',
				'class'     => 'form-row form-block',
				'data-type' => 'firstname-row'
			)
		)
	);
	
	echo $this->Form->input(
		$prefix.'.lastname',
		array(
			'type'                  => 'text',
			'data-type'             => 'lastname',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $name_validate,
			'data-validate-pattern' => 'validate(required)',
			'placeholder'           => __('Nazwisko', true),
			'label'                 => false,
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'div'                   => array(
				'tag'       => 'div',
				'class'     => 'form-row form-block',
				'data-type' => 'lastname-row'
			)
		)
	);
	
	if (isset($add_invoice) && $add_invoice):
		if ($invoice_type != 3):
			$nip_row_class = $invoice_type == 2 ? (!empty($this->data[$nip_prefix]['add_vat']) && $this->data[$nip_prefix]['add_vat'] == 1 ? '' : 'hide') : '';
			
			echo $this->Form->input(
				$prefix.'.nip',
				array(
					'type'                  => 'text',
					'data-type'             => 'nip',
					'data-prefix'           => strtolower($prefix),
					'data-validate'         => $nip_validate,
					'data-validate-pattern' => 'validate(required, nip-pl)',
					'placeholder'           => __('NIP', true),
					'label'                 => false,
					'class'                 => 'form-control',
					'disabled'              => $disabled,
					'div'                   => array(
						'tag'       => 'div',
						'class'     => 'form-row form-block'.' '.$nip_row_class,
						'data-type' => 'nip-row'
					),
					'data-gus'              => $gus ? 'true' : 'false'
				)
			);

			if ($gus):
				echo $this->Html->tag(
					'div',
					__('Podaj numer NIP - system pobierze dane Twojej firmy z bazy Głównego Urzędu Statystycznego', true),
					array(
						'class' => 'gus-info '.$nip_row_class
					)
				);
			endif;
		endif;
	endif;
	

	
	echo $this->Form->input(
		$prefix.'.company',
		array(
			'type'                  => 'text',
			'data-type'             => 'company',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $company_validate,
			'data-validate-pattern' => 'validate(required)',
			'placeholder'           => __('Nazwa firmy', true),
			'label'                 => false,
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'div'                   => array(
				'tag'       => 'div',
				'class'     => 'form-row form-block hide',
				'data-type' => 'company-row'
			)
		)
	);

	if (isset($add_invoice) && $add_invoice):
		if ($invoice_type == 2 && $add_vat_checkbox):
			echo $this->Form->input(
				$prefix.'.add_vat',
				array(
					'type'                  => 'checkbox',
					'data-type'             => 'add-vat',
					'data-prefix'           => strtolower($prefix),
					'data-validate'         => '',
					'data-validate-pattern' => '',
					'div'                   => 'form-row checkbox hide',
					'label'                 => __('Kupuję na firmę', true),
					'disabled'              => $disabled,
					'checked'               => (isset($this->data[$prefix]['add_vat']) && $this->data[$prefix]['add_vat'])?true:(bool)module('B2B')
				)
			);
		endif;
	endif;
	
	echo $this->Form->input(
		$prefix.'.street',
		array(
			'type'                  => 'text',
			'data-type'             => 'street',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $address_validate,
			'data-validate-pattern' => $address_required ? 'validate(required)' : '',
			'data-validate-vat'     => $address_required? 'true' : 'false',
			'div'                   => 'form-row form-block',
			'placeholder'           => __('Ulica', true),
			'label'                 => false,
			'class'                 => 'form-control',
			'disabled'              => $disabled
		)
	);
	
?>

<div class="street-number-row form-row form-block">
	<?php
		echo $this->Form->input(
			$prefix.'.street_number_1',
			array(
				'type'                  => 'text',
				'data-type'             => 'street-number-1',
				'data-prefix'           => strtolower($prefix),
				'data-validate'         => $address_validate,
				'data-validate-pattern' => $address_required ? 'validate(required)' : '',
				'data-validate-vat'     => $address_required ? 'true' : 'false',
				'div'                   => false,
				'placeholder'           => __('Nr domu', true),
				'label'                 => false,
				'class'                 => 'form-control',
				'disabled'              => $disabled,
				'error'                 => false
			)
		);
		
		echo $this->Form->input(
			$prefix.'.street_number_2',
			array(
				'type'          => 'text',
				'data-type'     => 'street-number-2',
				'data-prefix'   => strtolower($prefix),
				'div'           => false,
				'label'         => array(
					'text' => __('/', true),
					'class'=> 'street-number-separator'
				),
				'class'         => 'form-control',
				'disabled'      => $disabled
			)
		);
		
		echo $this->Form->error(
			$prefix.'.street_number_1'
		);
	?>
</div>

<?php
	echo $this->Form->input(
		$prefix.'.postcode',
		array(
			'type'                  => 'text',
			'data-type'             => 'postcode',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $postal_validate,
			'data-validate-pattern' => $address_required ? 'validate(required, postal-{code})' : '',
			'data-validate-vat'     => $address_required ? 'true' : 'false',
			'div'                   => 'form-row form-block postcode',
			'placeholder'           => __('Kod pocztowy', true),
			'label'                 => false,
			'class'                 => 'form-control',
			'disabled'              => $disabled
		)
	);
	
	echo $this->Form->input(
		$prefix.'.city',
		array(
			'type'                  => 'text',
			'data-type'             => 'city',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $address_validate,
			'data-validate-pattern' => $address_required ? 'validate(required)' : '',
			'data-validate-vat'     => $address_required ? 'true' : 'false',
			'div'                   => 'form-row form-block city',
			'placeholder'           => __('Miasto', true),
			'label'                 => false,
			'class'                 => 'form-control',
			'disabled'              => $disabled
		)
	);
	
	/*foreach ($countries as $country):
		if ($country['State']):
			$states = Set::combine($country['State'], '{n}.id', '{n}.name');
			
			if (!empty($this->data[$prefix]['country_id']) && $this->data[$prefix]['country_id'] == $country['Country']['id']):
				$state_row_class = '';
			else:
				$state_row_class = 'hide';
			endif;
			
			$state_disabled = false;
			
			if (!empty($this->data[$prefix]['country_id']) && $this->data[$prefix]['country_id'] != $country['Country']['id'] || count($states) == 0):
				$state_disabled = 'disabled';
			endif;
			
			echo $this->Form->input(
				$prefix.'.state_id',
				array(
					'type'      => 'select',
					'data-prefix' => strtolower($prefix),
					'data-type' => 'state',
					'div'       => array(
						'tag'           => 'div',
						'class'         => 'form-row'.' '.$state_row_class,
						'data-state-id' => $country['Country']['id']
					),
					'label'     => false,
					'class'     => 'form-control',
					'options'   => $states,
					'empty'     => __('Województwo', true),
					'disabled'  => $disabled ? true : $state_disabled
				)
			);
		endif;
	endforeach;*/
	
	if (count($__countries_list) > 1):
		echo $this->Form->input(
			$prefix.'.country_id',
			array(
				'type'            => 'select',
				'data-type'       => 'country',
				'data-prefix'     => strtolower($prefix),
				'data-codes-list' => json_encode($countries_codes),
				'div'             => 'form-row form-block',
				'placeholder'     => __('Kraj', true),
				'label'           => false,
				'class'           => 'form-control',
				'options'         => $__countries_list,
				'default'         => getCountryDefaultId(),
				'disabled'        => $disabled,
				'empty'           => false
			)
		);
	elseif (count($__countries_list) == 1):
		echo $this->Form->hidden(
			$prefix.'.country_id',
			array(
				'value'    => reset(array_keys($__countries_list)),
				'disabled' => $disabled
			)
		);
	endif;
?>	

<?php if ($show_user_type): ?>
	<div class="address-contact hide">
		<hr />
		
		<span><?php __('Dane kontaktowe')?></span>
	
		<div class="form-row form-block" data-type="firstname-row2">

			<input name="data21" type="text" data-type="firstname2" class="form-control name1" id="UserFirstname2" placeholder="<?php echo h(__('Imię', true)) ?>" <?php echo $disabled ? 'disabled' : '' ?>>
		</div>
		<div class="form-row form-block" data-type="lastname-row2">

			<input name="data22" type="text" data-type="lastname2" class="form-control name2" id="UserLastname2" placeholder="<?php echo h(__('Nazwisko', true)) ?>" <?php echo $disabled ? 'disabled' : '' ?>>
		</div>
	</div>
<?php endif ?>

<?php
	echo $this->Form->input(
		$prefix.'.phone',
		array(
			'type'     				=> 'number',
			'pattern'  				=> "[0-9]*",
			'data-type'             => 'phone',
			'data-prefix'           => strtolower($prefix),
			'data-validate'         => $phone_validate,
			'data-validate-pattern' => 'validate(required)',
			'div'                   => 'form-row form-block',
			'placeholder'           => __('Telefon', true),
			'label'                 => false,
			'class'                 => 'form-control',
			'disabled'              => $disabled
		)
	);
	
	if ($shipping_email):
		echo $this->Form->input(
			$prefix.'.shipping_email',
			array(
				'type'                  => 'email',
				'data-type'             => 'shipping-email',
				'data-prefix'           => strtolower($prefix),
				'data-validate'         => $shipping_email_validate,
				'data-validate-pattern' => 'validate(email)',
				'div'                   => 'form-row form-block',
				'placeholder'           => __('E-mail odbiorcy', true),
				'label'                 => false,
				'class'                 => 'form-control',
				'disabled'              => $disabled
			)
		);
	endif;
	
	foreach ($user_address_fields as $user_address_field_key => $user_address_field_label):
		echo $this->Form->input(
			$prefix.'.'.$user_address_field_key,
			array(
				'type'        => 'text',
				'data-type'   => str_replace('_', '-', $user_address_field_key),
				'data-prefix' => strtolower($prefix),	
				'div'         => 'form-row form-block',
				'placeholder' => $user_address_field_label,
				'label'       => false,
				'class'       => 'form-control',
				'disabled'    => $disabled
			)
		);
	endforeach;
?>

