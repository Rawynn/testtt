<?php
	$id = $offer['UserCart']['id'];
	
	if ($user_cart_offer):
		$id .= '_'.$user_cart_offer['id'];
	endif;
?>

<div class="modal fade" id="AcceptOffer<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Akceptacja oferty') ?>
				</h2>
			</div>
			
			<?php if ($user_cart_offer): ?>
				<div class="modal-body">
					<?php echo sprintf(__('Czy na pewno chcesz zaakceptować ofertę "%s" i ją zrealizować?', true), $offer['UserCart']['name']) ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Anuluj') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getOfferConfirmUrl($offer['UserCart']['id'], $user_cart_offer['id'])) ?>">
						<?php __('Akceptuj') ?>
					</a>
				</div>
			<?php else: ?>
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'         => getOfferConfirmUrl($offer['UserCart']['id'], null),
								'id'          => 'UserCartAcceptOfferForm'.$id,
								'data-submit' => 'once',
								'class'       => 'form send-offer-form'
							)
						)
					?>
						<?php
							echo $this->Form->hidden(
								'user_id',
								array(
									'data-send' => 'submit',
									'data-type' => 'user-cart-accept-offer-user-id-'.$id,
									'id'        => 'UserCartAcceptOfferUserId'.$id
								)
							);
							
							echo $this->Form->hidden(
								'new_user',
								array(
									'data-send' => 'submit',
									'data-type' => 'user-cart-accept-offer-new-user-'.$id,
									'id'        => 'UserCartAcceptOfferNewUser'.$id
								)
							);
						?>
						
						<div class="form-row">
							<label for="UserCartAcceptOfferUsername<?php echo $id ?>">
								<?php __('Klient') ?>:
							</label>
							
							<?php
								echo $this->Form->input(
									'username',
									array(
										'type'                 => 'text',
										'data-ac'              => 'true',
										'data-ac-url'          => html_entity_decode($this->Html->url(getUsersAutocompleterUrl())),
										'data-ac-handler'      => '[data-type=user-cart-accept-offer-user-id-container-'.$id.']',
										'data-ac-extended'     => 'false',
										'data-ac-copy'         => '[data-type=user-cart-accept-offer-user-id-'.$id.']',
										'div'                  => array(
											'data-type' => 'user-cart-accept-offer-user-id-container-'.$id,
											'class'     => 'autocompleter-container'
										),
										'label'                => false,
										'class'                => 'form-control',
										'id'                   => 'UserCartAcceptOfferUsername'.$id
									)
								)
							?>
						</div>
						
						<div class="form-row">
							<label>
								<?php __('lub') ?>
							</label>
							
							<div class="autocompleter-container">
								<?php
									echo $this->Html->link(
										__('załóż nowe konto klienta', true),
										'#',
										array(
											'data-type' => 'user-cart-accept-offer-new-user-submit',
											'data-id'   => $id
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
					
					<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-accept-offer-submit" data-id="<?php echo $id ?>">
						<?php __('Akceptuj') ?>
					</a>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>