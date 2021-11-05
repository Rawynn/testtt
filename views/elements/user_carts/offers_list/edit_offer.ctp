<?php if ($offer['UserCart']['can_edit']): ?>
	<div class="modal fade" id="EditOffer<?php echo $offer['UserCart']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Edytuj ofertę') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'         => getUserCartActivateUrl($offer['UserCart']['id']),
								'id'          => 'UserCartActivateForm'.$offer['UserCart']['id'],
								'data-submit' => 'once',
								'class'       => 'form',
								'data-type'   => 'user-cart-activate-form-'.$offer['UserCart']['id']
							)
						)
					?>
						<p class="text-center">
							<?php echo sprintf(__('Czy na pewno chcesz edytować ofertę "%s"?', true), $offer['UserCart']['name']) ?>
						</p>
					<?php echo $this->Form->end() ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Nie') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-activate" data-user-cart-id="<?php echo $offer['UserCart']['id'] ?>">
						<?php __('Tak') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>