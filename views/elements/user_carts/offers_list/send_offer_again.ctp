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

<div class="modal fade" id="SendOfferAgain<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Wyślij ofertę ponownie') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getUserCartSendOfferUrl($offer['UserCart']['id'], $user_cart_offer_id),
							'id'          => 'UserCartSendOfferAgainForm'.$id,
							'data-submit' => 'once',
							'class'       => 'form send-offer-form',
							'data-type'   => 'user-cart-send-offer-again-form-'.$id
						)
					)
				?>
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'data-send' => 'submit',
								'id'        => 'SendOfferAgainUserCartUserId'.$id,
								'value'     => $user_id
							)
						)
					?>
					

					<?php if (module('GUS')): ?>
						<?php
							echo $this->Form->input(
								'nip',
								array(
									'type'  => 'text',
									'label' => __('NIP', true).':',
									'class' => 'form-control',
// 									'div'   => 'form-row',
									'div'         => array(
										'tag'       => 'div',
										'class'     => 'form-row',
										'data-type' => 'nip-row-offer'
									),
									'value' => $nip,
									'id'    => 'SendOfferAgainUserCartUsername'.$id,
								)
							);
							
							echo $this->Form->hidden(
								'nip',
								array(
									'data-send' => 'submit',
									'id'        => 'SendOfferAgainHiddenUserCartUsername'.$id,
									'value'     => $nip
								)
							);
						?>
						
						<script>
							var options_tmp = {
								'translation': {
									Z: {pattern: /[A-Za-z0-9]/}
								},
								onInvalid: function(val, e, f, invalid, options){
									var error = invalid[0];

									if ($("[data-type=nip-row-offer]").find(".nip-info").length == 0){
										$("[data-type=nip-row-offer]").append("<div class='nip-info'>Poprawny format nr NIP to: 5482643867 lub PL5482643867</div>");
									}
								}
							};
						
							$("[data-type=nip-row-offer] > input").mask('ZZ000000000000000', options_tmp);
							
							$("[data-type=nip-row-offer] > input").keyup(function(e){
								var inputNip = $(this);
								var first_char = $(this).val().charAt(0);
								var second_char = $(this).val().charAt(1);
								
								if (!(second_char)){
									if (first_char == ""){
										$(this).unmask();
									} else {
										if (isNaN(first_char)){
											var options = {
												'translation': {
													Z: {pattern: /[A-Za-z]/}
												},
												onInvalid: function(val, e, f, invalid, options){
													var error = invalid[0];
													
													if (inputNip.parent().find(".nip-info").length == 0){
														inputNip.parent().append("<div class='nip-info'>Poprawny format nr NIP to: 5482643867 lub PL5482643867</div>");
													}
												}
											};
											
											$(this).parent().find(".error-message").slice(1).remove();
											
											$(this).removeClass("nip-pl");
											$(this).mask('ZZ00000000000000000000000', options).addClass("nip-foreign");
										} else {
											var options2 = {
												reverse: true,
												onInvalid: function(val, e, f, invalid, options){
													var error = invalid[0];
												
													if (inputNip.parent().find(".nip-info").length == 0){
														inputNip.parent().append("<div class='nip-info'>Poprawny format nr NIP to: 5482643867 lub PL5482643867</div>");
													}
												}
											};
											
											$(this).removeClass("nip-foreign");
											$(this).mask('#0', options2).addClass("nip-pl");
										}
									}
								}
							});
						</script>
					<?php endif ?>

					<div class="form-row">
						<label for="SendOfferAgainUserCartUsername<?php echo $id ?>">
							<?php __('Nazwa') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'username',
								array(
									'type'     => 'text',
									'div'      => 'autocompleter-container',
									'label'    => false,
									'class'    => 'form-control',
									'id'       => 'SendOfferAgainUserCartUsername'.$id,
									'value'    => $username,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'username',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartUsername'.$id,
									'value' => $username
								)
							);
						?>
					</div>
					
					<div class="form-row">
						<label for="SendOfferAgainUserCartEmail<?php echo $id ?>">
							<?php __('Adres e-mail') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'email',
								array(
									'type'     => 'email',
									'div'      => 'autocompleter-container',
									'label'    => false,
									'class'    => 'form-control',
									'id'       => 'SendOfferAgainUserCartEmail'.$id,
									'value'    => $email,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'email',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartEmail'.$id,
									'value' => $email
								)
							);
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'phone',
							array(
								'type'      => 'number',
								'pattern'   => "[0-9]*",
								'div'      => 'form-row',
								'label'    => __('Telefon', true).':',
								'class'    => 'form-control',
								'id'       => 'SendOfferAgainUserCartPhone'.$id,
								'value'    => $phone,
								'disabled' => 'disabled'
							)
						);
						
						echo $this->Form->hidden(
							'phone',
							array(
								'id'    => 'SendOfferAgainHiddenUserCartPhone'.$id,
								'value' => $phone
							)
						);
					?>
					
					<div class="street-row form-row">
						<?php
							echo $this->Form->input(
								'user_address_id',
								array(
									'type'  => 'hidden',
									'div'   => false,
									'label' => false,
									'id'    => 'SendOfferAgainUserCartUserAddressId'.$id,
									'value' => $user_address_id
								)
							);
							
							echo $this->Form->input(
								'street',
								array(
									'type'     => 'text',
									'div'      => false,
									'label'    => __('Ulica / nr / lokal', true).':',
									'class'    => 'form-control street',
									'id'       => 'SendOfferAgainUserCartStreet'.$id,
									'value'    => $street,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'street',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartStreet'.$id,
									'value' => $street
								)
							);
							
							echo $this->Form->input(
								'street_number_1',
								array(
									'type'     => 'text',
									'div'      => false,
									'label'    => array(
										'text'  => __('/', true),
										'class' => 'street-number-separator'
									),
									'class'    => 'form-control street-number',
									'id'       => 'SendOfferAgainUserCartStreetNumber1-'.$id,
									'value'    => $street_number_1,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'street_number_1',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartStreetNumber1-'.$id,
									'value' => $street_number_1
								)
							);
							
							echo $this->Form->input(
								'street_number_2',
								array(
									'type'     => 'text',
									'div'      => false,
									'label'    => array(
										'text'  => __('/', true),
										'class' => 'street-number-separator'
									),
									'class'    => 'form-control street-number',
									'id'       => 'UserCartStreetNumber2-'.$id,
									'value'    => $street_number_2,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'street_number_2',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartStreetNumber2-'.$id,
									'value' => $street_number_2
								)
							);
						?>
					</div>
					
					<div class="city-row form-row">
						<?php
							echo $this->Form->input(
								'postcode',
								array(
									'type'     => 'text',
									'div'      => false,
									'label'    => __('Kod / miasto', true).':',
									'class'    => 'form-control postcode',
									'id'       => 'SendOfferAgainUserCartPostcode'.$id,
									'value'    => $postcode,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'postcode',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartPostcode'.$id,
									'value' => $postcode
								)
							);
							
							echo $this->Form->input(
								'city',
								array(
									'type'     => 'text',
									'div'      => false,
									'label'    => array(
										'text'  => __('/', true),
										'class' => 'street-number-separator'
									),
									'class'    => 'form-control city',
									'id'       => 'SendOfferAgainUserCartStreetCity'.$id,
									'value'    => $city,
									'disabled' => 'disabled'
								)
							);
							
							echo $this->Form->hidden(
								'city',
								array(
									'id'    => 'SendOfferAgainHiddenUserCartCity'.$id,
									'value' => $city
								)
							);
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'country_id',
							array(
								'type'     => 'select',
								'options'  => Set::combine($countries, '{n}.Country.id', '{n}.Country.name'),
								'div'      => 'form-row country-row',
								'label'    => __('Kraj', true).':',
								'class'    => 'form-control',
								'id'       => 'SendOfferAgainUserCartCountryId'.$id,
								'value'    => $country_id,
								'disabled' => 'disabled'
							)
						);
						
						echo $this->Form->hidden(
							'country_id',
							array(
								'id'    => 'SendOfferAgainHiddenUserCartCountryId'.$id,
								'value' => $country_id
							)
						);
					?>
					
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
										'id'            => 'SendOfferAgainUserCartSendEmail'.$id,
										'data-type'     => 'offer-send-again-email-checkbox',
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
								'id'          => 'SendOfferAgainUserCartEmailSubject'.$id,
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
								'id'     => 'SendOfferAgainUserCartExpire'.$id
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
											'id'     => 'SendOfferAgainUserCartSummary'.$id,
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
											'id'     => 'SendOfferAgainUserCartLinkProducts'.$id,
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
						<a href="#" data-target="ShowColumnsSendOfferAgain" data-type="slidemenu" title="<?php h(__('Wyświetlane kolumny')) ?>">
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
										'data-id' => 'ShowColumnsSendOfferAgain'
									),
									'label'    => false,
									'options'  => getOfferPossibleColumns(true),
									'value'    => getOfferSelectedColumns($offer['UserCart']['id'], $user_cart_offer_id),
									'id'       => 'SendOfferAgainUserCartSelectedColumns'.$id,
								)
							)
						?>
					</div>
					
					<div class="toggle-box">
						<a href="#" data-target="ShowCommentSendOfferAgain" data-type="slidemenu" title="<?php h(__('Uwagi')) ?>">
							<?php __('Uwagi') ?>
						</a>
						
						<div class="form-row" data-id="ShowCommentSendOfferAgain">
							<label for="SendOfferAgainUserCartComments<?php echo $id ?>">
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
												'data-textarea-id' => 'SendOfferAgainUserCartComments'.$id,
												'id'               => 'SendOfferAgainUserCartOfferCommentsTemplateId'.$id
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
											'id'     => 'SendOfferAgainUserCartComments'.$id,
											'value'  => $comments,
											'escape' => false,
											'rows'   => 4
										)
									)
								?>
							</div>
						</div>
						
						<div class="form-row" data-id="ShowCommentSendOfferAgain">
							<label for="SendOfferAgainUserCartCommentsOnPdf<?php echo $id ?>">
								&nbsp;
							</label>
							
							<div class="checkbox-group-checkboxes">
								<?php
									echo $this->Form->input(
										'comments_on_pdf',
										array(
											'type'   => 'checkbox',
											'label'  => __('uwagi na PDF', true),
											'id'     => 'SendOfferAgainUserCartCommentsOnPdf'.$id,
											'checked' => (bool) $comments_on_pdf
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
				
				<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-send-offer-again" data-user-cart-id="<?php echo $offer['UserCart']['id'] ?>" data-user-cart-offer-id="<?php echo $user_cart_offer_id ?>">
					<?php __('Wyślij') ?>
				</a>
			</div>
		</div>
	</div>
</div>
