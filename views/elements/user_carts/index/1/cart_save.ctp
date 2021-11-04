<?php if ($can_save_cart): ?>
	<div class="save-cart">
		<div class="modal fade" id="CartSave" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						
						<h2>
							<?php __('Zapisz koszyk') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->create(
								'UserCart',
								array(
									'url'         => getUserCartSaveUrl(),
									'class'       => 'form',
									'data-submit' => 'once',
									'id'          => 'UserCartSaveForm'
								)
							)
						?>
							<?php
								echo $this->Form->input(
									'name',
									array(
										'type'    => 'text',
										'div'     => 'form-row',
										'label'   => __('Nazwa koszyka', true).':',
										'class'   => 'form-control',
										'default' => getCartName(),
										'id'      => 'UserCartName'
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