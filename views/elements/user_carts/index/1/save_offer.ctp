<?php if ($can_save_cart && userIsSalesrep() && module('OFFERS')): ?>
	<div class="save-offer">
		<div class="modal fade" id="SaveOffer" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php echo $edit_offer_mode ? __('Skopiuj ofertę', true) : __('Stwórz ofertę', true) ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->create(
								'UserCart',
								array(
									'url'         => getUserCartSaveOfferUrl(),
									'class'       => 'form',
									'data-submit' => 'once',
									'id'          => 'UserCartSaveOffer'
								)
							)
						?>
							<?php
								echo $this->Form->input(
									'offer_name',
									array(
										'type'    => 'text',
										'div'     => 'form-row',
										'label'   => __('Nazwa oferty', true).':',
										'class'   => 'form-control',
										'default' => getCartName(),
										'id'      => 'UserCartOfferName'
									)
								)
							?>
							
							<div class="form-actions">
								<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
							</div>
						<?php echo $this->Form->end() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>