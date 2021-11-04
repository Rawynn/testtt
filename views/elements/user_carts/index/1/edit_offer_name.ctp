<?php if (getCartIsOffer() && userIsSalesrep()): ?>
	<div class="modal fade" id="OfferEditName" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Edytuj nazwę oferty') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'       => getUserCartEditOfferNameUrl(),
								'class'     => 'form',
								'id'        => 'UserCartEditOfferNameForm'
							)
						)
					?>
						<div class="form-inner">
							<?php
								echo $this->Form->input(
									'UserCart.name',
									array(
										'div'   => 'form-row',
										'label' => __('Nazwa oferty', true).':',
										'type'  => 'text',
										'id'    => 'UserCartEditOfferNameName',
										'class' => 'form-control',
										'value' => getCartName()
									)
								)
							?>
						</div>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz')) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>