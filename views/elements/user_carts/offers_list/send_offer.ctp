<?php
	if (!isset($default_current_user)):
		$default_current_user = false;
	endif;
	
	$user_id         = null;
	$username        = null;
	$email           = null;
	$phone           = null;
	$street          = null;
	$street_number_1 = null;
	$street_number_2 = null;
	$postcode        = null;
	$city            = null;
	$country_id      = null;
	$user_address_id = null;
	$comments        = null;
	
	if ($default_current_user && getCartUserId()):
		$user_id  = getCartUserId();
		$username = getUserField($user_id, 'username_rev');
		$email    = getUserField($user_id, 'email');
		$phone    = getUserField($user_id, 'phone');
	endif;
	
	$id                 = $offer['UserCart']['id'];
	$user_cart_offer_id = null;
	$expire             = date('Y-m-d', time() + setting('MODULE_B2B_OFFER_DEFAULT_EXPIRE_DAYS') * DAY);
	$summary            = 1;
	$link_products      = 1;
	
	if (!empty($user_cart_offer['id'])):
		$user_cart_offer_id = $user_cart_offer['id'];
		$id                .= '-'.$user_cart_offer['id'];
		$user_id            = $user_cart_offer['user_id'];
		$username           = $user_cart_offer['name'];
		$email              = $user_cart_offer['email'];
		$phone              = $user_cart_offer['phone'];
		$summary            = $user_cart_offer['summary'];
		$link_products      = $user_cart_offer['link_products'];
		$comments           = $user_cart_offer['comments'];
		$user_address_id    = $user_cart_offer['user_address_id'];
		
		if ($user_cart_offer['UserAddress']):
			$street          = $user_cart_offer['UserAddress']['street'];
			$street_number_1 = $user_cart_offer['UserAddress']['street_number_1'];
			$street_number_2 = $user_cart_offer['UserAddress']['street_number_2'];
			$postcode        = $user_cart_offer['UserAddress']['postcode'];
			$city            = $user_cart_offer['UserAddress']['city'];
			$country_id      = $user_cart_offer['UserAddress']['country_id'];
		endif;
		
		if (!empty($user_cart_offer['expire'])):
			$expire = $user_cart_offer['expire'];
		endif;
	endif;
	
	if (!$country_id):
		$country_id = getSessionValue('Country.id') ? getSessionValue('Country.id') : getCountryDefaultId();
	endif;
	
	if (!$country_id):
		$country_id = reset(array_keys(Set::combine($countries, '{n}.Country.id', '{n}.Country.name')));
	endif;
?>

<div class="modal fade" id="SendOffer<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Wyślij ofertę') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getUserCartSendOfferUrl($offer['UserCart']['id'], $user_cart_offer_id),
							'id'          => 'UserCartSendOfferForm'.$id,
							'data-submit' => 'once',
							'class'       => 'form send-offer-form',
							'data-type'   => 'user-cart-send-offer-form-'.$id
						)
					)
				?>
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'data-send' => 'submit',
								'data-type' => 'user-cart-send-offer-user-id-'.$id,
								'id'        => 'UserCartUserId'.$id,
								'value'     => $user_id
							)
						)
					?>
					
					<?php if (setting('MODULE_B2B_OFFER_ONLY_INDIVIDUAL') || $user_cart_offer_id): ?>
						<div class="form-row">
							<label for="UserCartUsername<?php echo $id ?>">
								<?php __('Nazwa') ?>:
							</label>
							
							<?php
								echo $this->Form->input(
									'username',
									array(
										'type'                 => 'text',
										'data-type'            => 'user-cart-send-offer-username-'.$id,
										'data-ac'              => 'true',
										'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('b2b' => true)))),
										'data-ac-handler'      => '[data-type=user-cart-send-offer-user-id-container-'.$id.']',
										'data-ac-extended'     => 'false',
										'data-ac-copy'         => '[data-type=user-cart-send-offer-user-id-'.$id.']',
										'data-ac-copy-fields'  => json_encode(
											array(
												'email'           => '[data-type=user-cart-send-offer-email-'.$id.']',
												'phone'           => '[data-type=user-cart-send-offer-phone-'.$id.']',
												'street'          => '[data-type=user-cart-send-offer-street-'.$id.']',
												'street_number_1' => '[data-type=user-cart-send-offer-street-number-1-'.$id.']',
												'street_number_2' => '[data-type=user-cart-send-offer-street-number-2-'.$id.']',
												'postcode'        => '[data-type=user-cart-send-offer-postcode-'.$id.']',
												'city'            => '[data-type=user-cart-send-offer-city-'.$id.']',
												'country_id'      => '[data-type=user-cart-send-offer-country-id-'.$id.']',
												'user_address_id' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
											)
										),
										'div'                  => array(
											'data-type' => 'user-cart-send-offer-user-id-container-'.$id,
											'class'     => 'autocompleter-container'
										),
										'label'                => false,
										'class'                => 'form-control',
										'id'                   => 'UserCartUsername'.$id,
										'value'                => $username
									)
								)
							?>
						</div>
						
						<div class="form-row">
							<label for="UserCartEmail<?php echo $id ?>">
								<?php __('Adres e-mail') ?>:
							</label>
							
							<?php
								echo $this->Form->input(
									'email',
									array(
										'type'                 => 'text',
										'data-type'            => 'user-cart-send-offer-email-'.$id,
										'data-ac'              => 'true',
										'data-ac-field'        => 'email',
										'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('search' => 'email', 'b2b' => true)))),
										'data-ac-handler'      => '[data-type=user-cart-send-offer-email-container-'.$id.']',
										'data-ac-extended'     => 'false',
										'data-ac-copy'         => '[data-type=user-cart-send-offer-user-id-'.$id.']',
										'data-ac-copy-fields'  => json_encode(
											array(
												'label'           => '[data-type=user-cart-send-offer-username-'.$id.']',
												'phone'           => '[data-type=user-cart-send-offer-phone-'.$id.']',
												'street'          => '[data-type=user-cart-send-offer-street-'.$id.']',
												'street_number_1' => '[data-type=user-cart-send-offer-street-number-1-'.$id.']',
												'street_number_2' => '[data-type=user-cart-send-offer-street-number-2-'.$id.']',
												'postcode'        => '[data-type=user-cart-send-offer-postcode-'.$id.']',
												'city'            => '[data-type=user-cart-send-offer-city-'.$id.']',
												'country_id'      => '[data-type=user-cart-send-offer-country-id-'.$id.']',
												'user_address_id' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
											)
										),
										'div'                  => array(
											'data-type' => 'user-cart-send-offer-email-container-'.$id,
											'class'     => 'autocompleter-container'
										),
										'label'                => false,
										'class'                => 'form-control',
										'id'                   => 'UserCartEmail'.$id,
										'value'                => $email
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
									'id'        => 'UserCartPhone'.$id,
									'data-type' => 'user-cart-send-offer-phone-'.$id,
									'value'     => $phone
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
										'id'        => 'UserCartUserAddressId'.$id,
										'data-type' => 'user-cart-send-offer-user-address-id-'.$id,
										'value'     => $user_address_id
									)
								);
								
								echo $this->Form->input(
									'street',
									array(
										'type'              => 'text',
										'div'               => false,
										'label'             => __('Ulica / nr / lokal', true).':',
										'class'             => 'form-control street',
										'id'                => 'UserCartStreet'.$id,
										'value'             => $street,
										'data-type'         => 'user-cart-send-offer-street-'.$id,
										'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
										'id'                => 'UserCartStreetNumber1-'.$id,
										'value'             => $street_number_1,
										'data-type'         => 'user-cart-send-offer-street-number-1-'.$id,
										'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
										'id'                => 'UserCartStreetNumber2-'.$id,
										'value'             => $street_number_2,
										'data-type'         => 'user-cart-send-offer-street-number-2-'.$id,
										'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
										'id'                => 'UserCartPostcode'.$id,
										'value'             => $postcode,
										'data-type'         => 'user-cart-send-offer-postcode-'.$id,
										'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
										'id'                => 'UserCartStreetCity'.$id,
										'value'             => $city,
										'data-type'         => 'user-cart-send-offer-city-'.$id,
										'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
									'id'                => 'UserCartCountryId'.$id,
									'value'             => $country_id,
									'data-type'         => 'user-cart-send-offer-country-id-'.$id,
									'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
								)
							)
						?>
					<?php else: ?>
						<div class="form-row checkbox-group">
							<label>
								<?php __('Adresat') ?>:
							</label>
							
							<div class="checkbox-group-checkboxes">
								<?php
									echo $this->Form->input(
										'send_type',
										array(
											'type'          => 'radio',
											'data-type'     => 'change-send-offer-type',
											'data-offer-id' => $id,
											'div'           => 'radio',
											'hiddenField'   => false,
											'checked'       => false,
											'id'            => 'UserCartSendType1-'.$id,
											'options'       => array(
												1 => __('wybierz klienta', true)
											)
										)
									)
								?>
								
								<div class="show-client-data">
									<div class="form-row username-row username-row-autocompleter-on after-radio-form-row">
										<label for="UserCartUsername<?php echo $id ?>">
											<?php __('nazwa') ?>:
										</label>
										
										<?php
											echo $this->Form->input(
												'username',
												array(
													'type'                 => 'text',
													'data-type'            => 'user-cart-send-offer-username-'.$id,
													'data-ac'              => 'true',
													'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('b2b' => true)))),
													'data-ac-handler'      => '[data-type=user-cart-send-offer-user-id-container-'.$id.']',
													'data-ac-extended'     => 'false',
													'data-ac-copy'         => '[data-type=user-cart-send-offer-user-id-'.$id.']',
													'data-ac-copy-fields'  => json_encode(
														array(
															'email'           => '[data-type=user-cart-send-offer-email-'.$id.']',
															'phone'           => '[data-type=user-cart-send-offer-phone-'.$id.']',
															'street'          => '[data-type=user-cart-send-offer-street-'.$id.']',
															'street_number_1' => '[data-type=user-cart-send-offer-street-number-1-'.$id.']',
															'street_number_2' => '[data-type=user-cart-send-offer-street-number-2-'.$id.']',
															'postcode'        => '[data-type=user-cart-send-offer-postcode-'.$id.']',
															'city'            => '[data-type=user-cart-send-offer-city-'.$id.']',
															'country_id'      => '[data-type=user-cart-send-offer-country-id-'.$id.']',
															'user_address_id' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
														)
													),
													'div'                  => array(
														'data-type' => 'user-cart-send-offer-user-id-container-'.$id,
														'class'     => 'autocompleter-container'
													),
													'label'                => false,
													'class'                => 'form-control',
													'id'                   => 'UserCartUsername'.$id,
													'value'                => $username
												)
											)
										?>
									</div>
									
									<div class="form-row username-row username-row-autocompleter-on after-radio-form-row">
										<label for="UserCartEmail<?php echo $id ?>">
											<?php __('adres e-mail') ?>:
										</label>
										
										<?php
											echo $this->Form->input(
												'email',
												array(
													'type'                 => 'text',
													'data-type'            => 'user-cart-send-offer-email-'.$id,
													'data-ac'              => 'true',
													'data-ac-field'        => 'email',
													'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('search' => 'email', 'b2b' => true)))),
													'data-ac-handler'      => '[data-type=user-cart-send-offer-email-container-'.$id.']',
													'data-ac-extended'     => 'false',
													'data-ac-copy'         => '[data-type=user-cart-send-offer-user-id-'.$id.']',
													'data-ac-copy-fields'  => json_encode(
														array(
															'label'           => '[data-type=user-cart-send-offer-username-'.$id.']',
															'phone'           => '[data-type=user-cart-send-offer-phone-'.$id.']',
															'street'          => '[data-type=user-cart-send-offer-street-'.$id.']',
															'street_number_1' => '[data-type=user-cart-send-offer-street-number-1-'.$id.']',
															'street_number_2' => '[data-type=user-cart-send-offer-street-number-2-'.$id.']',
															'postcode'        => '[data-type=user-cart-send-offer-postcode-'.$id.']',
															'city'            => '[data-type=user-cart-send-offer-city-'.$id.']',
															'country_id'      => '[data-type=user-cart-send-offer-country-id-'.$id.']',
															'user_address_id' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
														)
													),
													'div'                  => array(
														'data-type' => 'user-cart-send-offer-email-container-'.$id,
														'class'     => 'autocompleter-container'
													),
													'label'                => false,
													'class'                => 'form-control',
													'id'                   => 'UserCartEmail'.$id,
													'value'                => $email
												)
											)
										?>
									</div>
									
									<div class="form-row username-row username-row-autocompleter-on after-radio-form-row">
										<label for="UserCartPhone<?php echo $id ?>">
											<?php __('telefon') ?>:
										</label>
										
										<div class="autocompleter-container">
											<?php
												echo $this->Form->input(
													'phone',
													array(
														'type'      => 'text',
														'div'       => false,
														'label'     => false,
														'class'     => 'form-control',
														'id'        => 'UserCartPhone'.$id,
														'data-type' => 'user-cart-send-offer-phone-'.$id
													)
												)
											?>
										</div>
									</div>
									
									<div class="street-row form-row username-row username-row-autocompleter-on after-radio-form-row">
										<label for="UserCartStreet<?php echo $id ?>">
											<?php echo __('ulica / nr / lokal', true).':' ?>
										</label>
										
										<div class="autocompleter-container">
											<?php
												echo $this->Form->input(
													'user_address_id',
													array(
														'type'      => 'hidden',
														'div'       => false,
														'label'     => false,
														'id'        => 'UserCartUserAddressId'.$id,
														'data-type' => 'user-cart-send-offer-user-address-id-'.$id,
														'value'     => $user_address_id
													)
												);
												
												echo $this->Form->input(
													'street',
													array(
														'type'              => 'text',
														'div'               => false,
														'label'             => false,
														'class'             => 'form-control street',
														'id'                => 'UserCartStreet'.$id,
														'value'             => $street,
														'data-type'         => 'user-cart-send-offer-street-'.$id,
														'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
														'id'                => 'UserCartStreetNumber1-'.$id,
														'value'             => $street_number_1,
														'data-type'         => 'user-cart-send-offer-street-number-1-'.$id,
														'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
														'id'                => 'UserCartStreetNumber2-'.$id,
														'value'             => $street_number_2,
														'data-type'         => 'user-cart-send-offer-street-number-2-'.$id,
														'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
													)
												);
											?>
										</div>
									</div>
									
									<div class="city-row form-row username-row username-row-autocompleter-on after-radio-form-row">
										<label for="UserCartStreet<?php echo $id ?>">
											<?php echo __('kod / miasto', true).':' ?>
										</label>
										
										<div class="autocompleter-container">
											<?php
												echo $this->Form->input(
													'postcode',
													array(
														'type'              => 'text',
														'div'               => false,
														'label'             => false,
														'class'             => 'form-control postcode',
														'id'                => 'UserCartPostcode'.$id,
														'value'             => $postcode,
														'data-type'         => 'user-cart-send-offer-postcode-'.$id,
														'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
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
														'id'                => 'UserCartStreetCity'.$id,
														'value'             => $city,
														'data-type'         => 'user-cart-send-offer-city-'.$id,
														'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
													)
												)
											?>
										</div>
									</div>
									
									<div class="country-row form-row username-row username-row-autocompleter-on after-radio-form-row">
										<label for="UserCartStreet<?php echo $id ?>">
											<?php echo __('kraj', true).':' ?>
										</label>
										
										<div class="autocompleter-container">
											<?php
												echo $this->Form->input(
													'country_id',
													array(
														'type'              => 'select',
														'options'           => Set::combine($countries, '{n}.Country.id', '{n}.Country.name'),
														'div'               => false,
														'label'             => false,
														'class'             => 'form-control',
														'id'                => 'UserCartCountryId'.$id,
														'value'             => $country_id,
														'data-type'         => 'user-cart-send-offer-country-id-'.$id,
														'data-change-clear' => '[data-type=user-cart-send-offer-user-address-id-'.$id.']'
													)
												)
											?>
										</div>
									</div>
								</div>
								
								<?php
									echo $this->Form->input(
										'send_type',
										array(
											'type'          => 'radio',
											'data-type'     => 'change-send-offer-type',
											'data-offer-id' => $id,
											'div'           => 'radio',
											'hiddenField'   => false,
											'checked'       => false,
											'id'            => 'UserCartSendType2-'.$id,
											'options'       => array(
												2 => __('wyślij do wszystkich klientów z grupy', true)
											)
										)
									)
								?>
								
								<?php
									echo $this->Form->input(
										'client_group_id',
										array(
											'type'          => 'select',
											'data-type'     => 'send-offer-client-group-id-'.$id,
											'data-offer-id' => $id,
											'div'           => 'form-row after-radio-form-row show-goup-data',
											'label'         => false,
											'class'         => 'form-control',
											'disabled'      => true,
											'options'       => $client_groups,
											'empty'         => __('-wybierz-', true),
											'id'            => 'UserCartClientGroupId'.$id
										)
									)
								?>
							</div>
						</div>
					<?php endif ?>
					
					<div class="form-row checkbox-group">
						<label>
							&nbsp;
						</label>
						
						<div class="checkbox-group-checkboxes">
							<?php
								echo $this->Form->input(
									'send_email',
									array(
										'type'          => 'checkbox',
										'div'           => 'checkbox',
										'label'         => __('wyślij ofertę na adres e-mail klienta, tytuł wiadomości', true).':',
										'checked'       => 'checked',
										'id'            => 'UserCartSendEmail'.$id,
										'data-type'     => 'offer-send-email-checkbox',
										'data-input-id' => $id
									)
								)
							?>
						</div>
					</div>
					
					<?php
						echo $this->Form->input(
							'email_subject',
							array(
								'type'        => 'text',
								'div'         => 'form-row',
								'label'       => '&nbsp;',
								'class'       => 'form-control',
								'id'          => 'UserCartEmailSubject'.$id,
								'data-type'   => 'offer-email-subject',
								'default'     => getSystemEmailSubject('EMAIL_SEND_OFFER', configuration('Config.language')),
								'placeholder' => __('Podaj tytuł wiadomośc e-mail', true)
							)
						);
						
						echo $this->Form->input(
							'expire',
							array(
								'type'   => 'text',
								'div'    => 'form-row',
								'label'  => __('Data wygaśnięcia', true).':',
								'class'  => 'form-control datepicker',
								'value'  => $expire,
								'id'     => 'UserCartExpire'.$id
							)
						);
					?>
					
					<div class="form-row radio-group">
						<label>
							<?php __('Podsumowanie') ?>:
						</label>
						
						<div class="radio-list">
							<?php foreach (array(1 => __('tak', true), 0 => __('nie', true)) as $summary_option => $summary_option_label): ?>
								<?php
									echo $this->Form->input(
										'summary',
										array(
											'type'   => 'radio',
											'div'    => 'radio',
											'legend' => false,
											'value'  => $summary,
											'id'     => 'UserCartSummary'.$id,
											'options' => array(
												$summary_option => $summary_option_label
											)
										)
									)
								?>
							<?php endforeach ?>
						</div>
					</div>
					
					<div class="form-row radio-group">
						<label>
							<?php __('Linkuj produkty na PDF') ?>:
						</label>
						
						<div class="radio-list">
							<?php foreach (array(1 => __('tak', true), 0 => __('nie', true)) as $link_products_option => $link_products_option_label): ?>
								<?php
									echo $this->Form->input(
										'link_products',
										array(
											'type'   => 'radio',
											'div'    => 'radio',
											'legend' => false,
											'value'  => $link_products,
											'id'     => 'UserCartLinkProducts'.$id,
											'options' => array(
												$link_products_option => $link_products_option_label
											)
										)
									)
								?>
							<?php endforeach ?>
						</div>
					</div>
					
					<div class="toggle-box">
						<a href="#" data-target="ShowColumns" data-type="slidemenu" title="<?php h(__('Wyświetlane kolumny')) ?>">
							<?php __('Wyświetlane kolumny') ?>
						</a>
						
						<?php
							echo $this->Form->input(
								'selected_columns',
								array(
									'type'     => 'select',
									'multiple' => 'checkbox',
									'div'      => array(
										'class'   => 'form-row form-row-checkbox',
										'data-id' => 'ShowColumns'
									),
									'label'    => false,
									'options'  => getOfferPossibleColumns(true),
									'value'    => getOfferSelectedColumns($offer['UserCart']['id'], $user_cart_offer_id),
									'id'       => 'UserCartSelectedColumns'.$id,
								)
							)
						?>
					</div>
					
					<div class="toggle-box">
						<a href="#" data-target="ShowComment" data-type="slidemenu" title="<?php h(__('Uwagi')) ?>">
							<?php __('Uwagi') ?>
						</a>
						
						<div class="form-row" data-id="ShowComment">
							<label for="UserCartComments<?php echo $id ?>">
								&nbsp;
							</label>
							
							<div class="checkbox-group-checkboxes">
								<?php if (!empty($user_cart_offer_comments_templates)): ?>
									<?php
										echo $this->Form->input(
											'UserCartOfferCommentsTemplate.id',
											array(
												'div'              => false,
												'label'            => false,
												'type'             => 'select',
												'class'            => 'form-control',
												'options'          => $user_cart_offer_comments_templates,
												'empty'            => __('-wstaw z szablonu-', true),
												'data-type'        => 'user-cart-offer-comments-template-select',
												'data-textarea-id' => 'UserCartComments'.$id,
												'id'               => 'UserCartOfferCommentsTemplateId'.$id
											)
										)
									?>
								<?php endif ?>
								
								<?php
									echo $this->Form->input(
										'comments',
										array(
											'type'   => 'textarea',
											'div'    => false,
											'label'  => false,
											'class'  => 'form-control',
											'id'     => 'UserCartComments'.$id,
											'value'  => $comments,
											'escape' => false,
											'rows'   => 4
										)
									)
								?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				<?php echo $this->Form->end() ?>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
					<?php __('Anuluj') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-send-offer" data-user-cart-id="<?php echo $offer['UserCart']['id'] ?>" data-user-cart-offer-id="<?php echo $user_cart_offer_id ?>">
					<?php __('Wyślij') ?>
				</a>
			</div>
		</div>
	</div>
</div>