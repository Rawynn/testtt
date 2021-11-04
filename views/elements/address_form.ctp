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
		$nip_validate     = empty($company_validate)? '' : 'validate(required)';
	endif;
	
	/* Walidacja numeru telefonu */
	if (!isset($phone_validate)):
	//	$phone_validate = 'validate(number, minlength(13))';
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
	
	$countries_codes = getCountriesCodesList();
	$country_id      = !empty($this->data[$prefix]['country_id']) ? $this->data[$prefix]['country_id'] : reset(array_keys($__countries_list));
	
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
?>

<?php if ($show_user_type): ?>
	<div class="form-row hide">
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
			'data-validate'         => $name_validate,
			'data-validate-pattern' => 'validate(required)',
			'label'                 => false,
			'placeholder'           => __('IMIĘ', true).':*',
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'div'                   => array(
				'tag'       => 'div',
				'class'     => 'form-row',
				'data-type' => 'firstname-row'
			)
		)
	);
	
	echo $this->Form->input(
		$prefix.'.lastname',
		array(
			'type'                  => 'text',
			'data-type'             => 'lastname',
			'data-validate'         => $name_validate,
			'data-validate-pattern' => 'validate(required)',
			'label'                 => false,
			'placeholder'           => __('NAZWISKO', true).':*',
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'div'                   => array(
				'tag'       => 'div',
				'class'     => 'form-row',
				'data-type' => 'lastname-row'
			)
		)
	);
	
	if(isset($show_company)):
		echo $this->Form->input(
			$prefix.'.company',
			array(
					'type'                  => 'text',
					'data-type'             => 'company',
					'data-validate'         => '',
					'data-validate-pattern' => '',
					'label'                 => false,
					'placeholder'           => __('NAZWA FIRMY', true).':',
					'class'                 => 'form-control',
					'disabled'              => false,
					'div'                   => array(
							'tag'       => 'div',
							'class'     => 'form-row',
							'data-type' => 'company-row'
					)
			)
		);
	endif;
	
	echo $this->Form->input(
		$prefix.'.company',
		array(
			'type'                  => 'text',
			'data-type'             => 'company',
			'data-validate'         => $company_validate,
			'data-validate-pattern' => 'validate(required)',
			'label'                 => false,
			'placeholder'           => __('NAZWA FIRMY', true).':*',
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'div'                   => array(
				'tag'       => 'div',
				'class'     => 'form-row hide',
				'data-type' => 'company-row'
			)
		)
	);
	
	if (isset($add_invoice) && $add_invoice):
		if ($invoice_type != 3):
			$nip_row_class = $invoice_type == 1? 'hide' : '';
			
			echo $this->Form->input(
				$prefix.'.nip',
				array(
					'type'                  => 'text',
					'data-type'             => 'nip',
					'data-validate-pattern' => $nip_validate,
					'label'                 => false,
					'placeholder'           => __('NIP', true).':*',
					'class'                 => 'form-control',
					'disabled'              => $disabled,
					'div'                   => array(
						'tag'       => 'div',
						'class'     => 'form-row'.' '.$nip_row_class,
						'data-type' => 'nip-row'
					)
				)
			);
		endif;
	endif;
	
	foreach ($user_address_fields as $user_address_field_key => $user_address_field_label):
		echo $this->Form->input(
			$prefix.'.'.$user_address_field_key,
			array(
					'type'        => 'text',
					'data-type'   => str_replace('_', '-', $user_address_field_key),
					'placeholder' => $user_address_field_label,
					'label'       => false,
					'class'       => 'form-control',
					'disabled'    => $disabled,
					'div'                   => array(
							'tag'       => 'div',
							'class'     => 'form-row hide',
							'data-type' => 'dic-row'
					)
			)
			);
	endforeach;
	
	if (isset($add_invoice) && $add_invoice):
		if ($invoice_type == 1 && $add_vat_checkbox):
			echo $this->Form->input(
				$prefix.'.add_vat',
				array(
					'type'                  => 'checkbox',
					'data-type'             => 'add-vat',
					'data-validate'         => '',
					'data-validate-pattern' => '',
					'div'                   => 'form-row checkbox',
					'label'                 => __('KUPUJĘ NA FIRMĘ', true),
					'disabled'              => $disabled,
					'checked'               => (isset($this->data[$prefix]['add_vat']) && $this->data[$prefix]['add_vat'])?true:(bool)module('B2B')
				)
			);
		endif;
	endif;
	$requ = $address_required ? '*' : '';
	echo $this->Form->input(
		$prefix.'.street',
		array(
			'type'                  => 'text',
			'data-type'             => 'street',
			'data-validate'         => $address_validate,
			'data-validate-pattern' => $address_required ? 'validate(required)' : '',
			'data-validate-vat'     => $address_required? 'true' : 'false',
			'div'                   => 'form-row',
			'label'                 => false,
			'placeholder'           => __('ULICA', true).':'.$requ,
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'autocomplete'          => 'chrome-off'
		)
	);
	
?>

<div class="street-number-row form-row">
	<?php
		echo $this->Form->input(
			$prefix.'.street_number_1',
			array(
				'type'                  => 'text',
				'data-type'             => 'street-number-1',
				'data-validate'         => $address_validate,
				'data-validate-pattern' => $address_required ? 'validate(required)' : '',
				'data-validate-vat'     => $address_required ? 'true' : 'false',
				'div'                   => false,
				'label'                 => false,
				'placeholder'           => __('NR', true).':'.$requ,
				'class'                 => 'form-control',
				'disabled'              => $disabled,
				'error'                 => false,
				'autocomplete'          => 'chrome-off'
			)
		);
		
		echo $this->Form->input(
			$prefix.'.street_number_2',
			array(
				'type'          => 'text',
				'data-type'     => 'street-number-2',
				'div'           => false,
				'label'         => array(
					'text' => __('/', true),
					'class'=> 'street-number-separator'
				),
				'class'         => 'form-control',
				'disabled'      => $disabled,
				'autocomplete'          => 'chrome-off'
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
			'data-validate'         => $postal_validate,
			'data-validate-pattern' => $address_required ? 'validate(required, postal-{code})' : '',
			'data-validate-vat'     => $address_required ? 'true' : 'false',
			'div'                   => 'form-row',
			'label'                 => false,
			'placeholder'           => __('KOD POCZTOWY', true).':'.$requ,
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'autocomplete'          => 'chrome-off'
		)
	);
	
	echo $this->Form->input(
		$prefix.'.city',
		array(
			'type'                  => 'text',
			'data-type'             => 'city',
			'data-validate'         => $address_validate,
			'data-validate-pattern' => $address_required ? 'validate(required)' : '',
			'data-validate-vat'     => $address_required ? 'true' : 'false',
			'div'                   => 'form-row',
			'label'                 => false,
			'placeholder'           => __('MIASTO', true).':'.$requ,
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'autocomplete'          => 'chrome-off'
		)
	);
	
	if (count($__countries_list) > 1):
		echo $this->Form->input(
			$prefix.'.country_id',
			array(
				'type'            => 'select',
				'data-type'       => 'country',
				'data-codes-list' => json_encode($countries_codes),
				'div'             => 'form-row',
				'label'           => false,
				'class'           => 'form-control',
				'options'         => $__countries_list,
				'disabled'        => $disabled,
				'empty'           => __('KRAJ', true).':*'
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
	
	echo $this->Form->input(
		$prefix.'.phone',
		array(
			'type'                  => 'text',
			'data-type'             => 'phone',
			'data-validate'         => $phone_validate,
			'data-validate-pattern' => 'validate(required)',
			'div'                   => 'form-row',
			'label'                 => false,
			'placeholder'           => __('TELEFON', true).':*',
			'class'                 => 'form-control',
			'disabled'              => $disabled,
			'autocomplete'          => 'chrome-off'
		)
	);
	
	if ($shipping_email):
		echo $this->Form->input(
			$prefix.'.shipping_email',
			array(
				'type'                  => 'text',
				'data-type'             => 'shipping-email',
				'data-validate'         => $shipping_email_validate,
				'data-validate-pattern' => 'validate(email)',
				'div'                   => 'form-row',
				'label'                 => false,
				'placeholder'           => __('E-mail odbiorcy', true).':',
				'class'                 => 'form-control',
				'disabled'              => $disabled
			)
		);
	endif;
?>
