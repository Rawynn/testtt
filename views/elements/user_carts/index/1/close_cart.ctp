<?php if (!getCartUserCartOfferId() && ($edit_offer_mode || getCartName())): ?>
	<div class="modal fade" id="CloseCart" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h2>
						<?php echo $edit_offer_mode ? __('Wyjdź z oferty', true) : __('Opuść koszyk', true) ?> 
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'         => getCloseCartUrl(),
								'id'          => 'UserCartCloseForm',
								'data-submit' => 'once',
								'class'       => 'form',
								'data-type'   => 'user-cart-close-form'
							)
						)
					?>
						<?php
							echo $this->Form->input(
								'save_products',
								array(
									'type' => 'checkbox',
									'label' => __('zachowaj zawartość koszyka', true)
								)
							)
						?>
					<?php echo $this->Form->end() ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Anuluj') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-close-button">
						<?php echo $edit_offer_mode ? __('Wyjdź z oferty', true) : __('Opuść koszyk', true) ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>