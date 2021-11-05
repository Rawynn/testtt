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
	$comments_on_pdf = null;
	
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
		$comments_on_pdf    = $user_cart_offer['comments_on_pdf'];
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

<div class="modal fade" id="SaveOffer<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Zapisz ofertę') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getUserCartSendOfferUrl($offer['UserCart']['id'], $user_cart_offer_id),
							'id'          => 'UserCartSaveOfferForm'.$id,
							'data-submit' => 'once',
							'class'       => 'form send-offer-form',
							'data-type'   => 'user-cart-save-offer-form-'.$id
						)
					)
				?>
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'data-send' => 'submit',
								'data-type' => 'user-cart-save-offer-user-id-'.$id,
								'id'        => 'UserCartSaveUserId'.$id,
								'value'     => $user_id
							)
						);
						
						echo $this->Form->input(
							'save',
							array(
								'type'  => 'hidden',
								'id'    => 'UserCartSave'.$id,
								'value' => 1
							)
						);
					?>
					
					<?php if (module('GUS')): ?>
						<?php
							echo $this->Form->input(
								'nip',
								array(
									'type'        => 'text',
									'data-type'   => 'user-cart-save-offer-nip-'.$id,
									'label'       => __('NIP', true).':',
									'class'       => 'form-control',
									'data-prefix' => 'save-offer',
									'data-id'     => $id,
									'div'         => array(
										'tag'       => 'div',
										'class'     => 'form-row',
										'data-type' => 'nip-row'
									),
									'data-gus'    => 'true',
									'data-offer'  => 'true',
									'value'       => $nip
								)
							);
						?>
					<?php endif ?>

					<div class="form-row">
						<label for="UserCartUsername<?php echo $id ?>">
							<?php __('Nazwa') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'username',
								array(
									'type'                 => 'text',
									'data-type'            => 'user-cart-save-offer-username-'.$id,
									'data-ac'              => 'true',
									'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('b2b' => true)))),
									'data-ac-handler'      => '[data-type=user-cart-save-offer-user-id-container-'.$id.']',
									'data-ac-extended'     => 'false',
									'data-ac-copy'         => '[data-type=user-cart-save-offer-user-id-'.$id.']',
									'data-ac-copy-fields'  => json_encode(
										array(
											'email'           => '[data-type=user-cart-save-offer-email-'.$id.']',
											'phone'           => '[data-type=user-cart-save-offer-phone-'.$id.']',
											'street'          => '[data-type=user-cart-save-offer-street-'.$id.']',
											'street_number_1' => '[data-type=user-cart-save-offer-street-number-1-'.$id.']',
											'street_number_2' => '[data-type=user-cart-save-offer-street-number-2-'.$id.']',
											'postcode'        => '[data-type=user-cart-save-offer-postcode-'.$id.']',
											'city'            => '[data-type=user-cart-save-offer-city-'.$id.']',
											'country_id'      => '[data-type=user-cart-save-offer-country-id-'.$id.']',
											'user_address_id' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
										)
									),
									'div'                  => array(
										'data-type' => 'user-cart-save-offer-user-id-container-'.$id,
										'class'     => 'autocompleter-container'
									),
									'label'                => false,
									'class'                => 'form-control',
									'id'                   => 'UserCartSaveUsername'.$id,
									'value'                => $username
								)
							)
						?>
					</div>
					
					<div class="form-row">
						<label for="UserCartSaveEmail<?php echo $id ?>">
							<?php __('Adres e-mail') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'email',
								array(
									'type'                 => 'email',
									'data-type'            => 'user-cart-save-offer-email-'.$id,
									'data-ac'              => 'true',
									'data-ac-field'        => 'email',
									'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl(array('search' => 'email', 'b2b' => true)))),
									'data-ac-handler'      => '[data-type=user-cart-save-offer-email-container-'.$id.']',
									'data-ac-extended'     => 'false',
									'data-ac-copy'         => '[data-type=user-cart-save-offer-user-id-'.$id.']',
									'data-ac-copy-fields'  => json_encode(
										array(
											'label'           => '[data-type=user-cart-save-offer-username-'.$id.']',
											'phone'           => '[data-type=user-cart-save-offer-phone-'.$id.']',
											'street'          => '[data-type=user-cart-save-offer-street-'.$id.']',
											'street_number_1' => '[data-type=user-cart-save-offer-street-number-1-'.$id.']',
											'street_number_2' => '[data-type=user-cart-save-offer-street-number-2-'.$id.']',
											'postcode'        => '[data-type=user-cart-save-offer-postcode-'.$id.']',
											'city'            => '[data-type=user-cart-save-offer-city-'.$id.']',
											'country_id'      => '[data-type=user-cart-save-offer-country-id-'.$id.']',
											'user_address_id' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
										)
									),
									'div'                  => array(
										'data-type' => 'user-cart-save-offer-email-container-'.$id,
										'class'     => 'autocompleter-container'
									),
									'label'                => false,
									'class'                => 'form-control',
									'id'                   => 'UserCartSaveEmail'.$id,
									'value'                => $email
								)
							)
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'phone',
							array(
								'type'      => 'number',
								'pattern'   => "[0-9]*",
								'div'       => 'form-row',
								'label'     => __('Telefon', true).':',
								'class'     => 'form-control',
								'id'        => 'UserCartSavePhone'.$id,
								'data-type' => 'user-cart-save-offer-phone-'.$id,
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
									'id'        => 'UserCartSaveUserAddressId'.$id,
									'data-type' => 'user-cart-save-offer-user-address-id-'.$id,
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
									'id'                => 'UserCartSaveStreet'.$id,
									'value'             => $street,
									'data-type'         => 'user-cart-save-offer-street-'.$id,
									'data-change-clear' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
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
									'id'                => 'UserCartSaveStreetNumber1-'.$id,
									'value'             => $street_number_1,
									'data-type'         => 'user-cart-save-offer-street-number-1-'.$id,
									'data-change-clear' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
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
									'id'                => 'UserCartSaveStreetNumber2-'.$id,
									'value'             => $street_number_2,
									'data-type'         => 'user-cart-save-offer-street-number-2-'.$id,
									'data-change-clear' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
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
									'id'                => 'UserCartSavePostcode'.$id,
									'value'             => $postcode,
									'data-type'         => 'user-cart-save-offer-postcode-'.$id,
									'data-change-clear' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
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
									'id'                => 'UserCartSaveStreetCity'.$id,
									'value'             => $city,
									'data-type'         => 'user-cart-save-offer-city-'.$id,
									'data-change-clear' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
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
								'id'                => 'UserCartSaveCountryId'.$id,
								'value'             => $country_id,
								'data-type'         => 'user-cart-save-offer-country-id-'.$id,
								'data-change-clear' => '[data-type=user-cart-save-offer-user-address-id-'.$id.']'
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
								'id'     => 'UserCartSaveExpire'.$id
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
											'id'     => 'UserCartSaveSummary'.$id,
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
											'id'     => 'UserCartSaveLinkProducts'.$id,
											'options' => array(
												$link_products_option => $link_products_option_label
											)
										)
									)
								?>
							<?php endforeach ?>
						</div>
					</div>
					
					<?php
						echo $this->Form->input(
							'selected_columns',
							array(
								'type'        => 'select',
								'multiple'    => 'multiple',
								'div'         => 'form-row',
								'label'       => __('Kolumny', true).':',
								'options'     => getOfferPossibleColumns(true),
								'value'       => getOfferSelectedColumns($offer['UserCart']['id'], $user_cart_offer_id),
								'id'          => 'UserCartSaveSelectedColumns'.$id,
								'class'       => 'form-control transform-hide',
								'hiddenField' => false,
								'size'        => 5
							)
						)
					?>
					
					<div class="form-row">
						<label for="UserCartSaveComments<?php echo $id ?>">
							<?php __('Uwagi') ?>:
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
											'data-textarea-id' => 'UserCartSaveComments'.$id,
											'id'               => 'UserCartOfferCommentsTemplateSaveId'.$id
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
										'id'     => 'UserCartSaveComments'.$id,
										'value'  => $comments,
										'escape' => false,
										'rows'   => 4
									)
								)
							?>
						</div>
					</div>
					
					<div class="form-row">
						<label for="UserCartSaveCommentsOnPdf<?php echo $id ?>">
							&nbsp;
						</label>
						
						<div class="checkbox-group-checkboxes">
							<?php
								echo $this->Form->input(
									'comments_on_pdf',
									array(
										'type'   => 'checkbox',
										'label'  => __('uwagi na PDF', true),
										'id'     => 'UserCartSaveCommentsOnPdf'.$id,
										'checked' => (bool) $comments_on_pdf
									)
								)
							?>
						</div>
					</div>
				<?php echo $this->Form->end() ?>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
					<?php __('Anuluj') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-save-offer" data-user-cart-id="<?php echo $offer['UserCart']['id'] ?>" data-user-cart-offer-id="<?php echo $user_cart_offer_id ?>">
					<?php __('Zapisz') ?>
				</a>
			</div>
		</div>
	</div>
</div>
