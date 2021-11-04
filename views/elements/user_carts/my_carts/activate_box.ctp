<?php if ($cart['UserCart']['can_activate']): ?>
	<div class="modal fade" id="ActivateCart<?php echo $cart['UserCart']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Aktywuj koszyk') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'         => getUserCartActivateUrl($cart['UserCart']['id']),
								'id'          => 'UserCartActivateForm'.$cart['UserCart']['id'],
								'data-submit' => 'once',
								'class'       => 'form',
								'data-type'   => 'user-cart-activate-form-'.$cart['UserCart']['id']
							)
						)
					?>
						<?php if (userIsSalesrep() && $cart['UserCart']['selected_user_id'] && $cart['UserCart']['selected_user_id'] != getCartUserId()): ?>
							<p>
								<?php
									echo sprintf(__('Czy na pewno chcesz aktywować koszyk "%s"?', true), $cart['UserCart']['name'])
								?>
							</p>
							
							<?php
								echo $this->Form->input(
									'change_user',
									array(
										'type'      => 'checkbox',
										'div'       => 'form-row checkbox',
										'label'     => getCartUserId() ? sprintf(__('aktywuj klienta "%s" (aktualnie wybrany "%s")', true), getUserField($cart['UserCart']['selected_user_id'], 'username'), getUserField(getCartUserId(), 'username')) : sprintf(__('aktywuj klienta "%s"', true), getUserField($cart['UserCart']['selected_user_id'], 'username')),
										'id'        => 'UserCartChangeUser'.$cart['UserCart']['id']
									)
								)
							?>
						<?php else: ?>
							<p class="text-center">
								<?php
									echo sprintf(__('Czy na pewno chcesz aktywować koszyk "%s"?', true), $cart['UserCart']['name'])
								?>
							</p>
						<?php endif ?>
					<?php echo $this->Form->end() ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Nie') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-activate" data-user-cart-id="<?php echo $cart['UserCart']['id'] ?>">
						<?php __('Tak') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>