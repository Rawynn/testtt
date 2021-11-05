<?php if (!$cart_blocked): ?>
	<?php foreach ($user_cart_fields as $user_cart_field_id => $user_cart_field_name): ?>
		<div class="modal fade" id="NewUserCartFieldValue<?php echo $user_cart_field_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php echo sprintf(__('Dodaj wartość do cechy "%s"', true), $user_cart_field_name) ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->create(
								'UserCartField',
								array(
									'url'   => getUserCartFieldAddValueUrl($user_cart_field_id),
									'class' => 'form',
									'id'    => 'UserCartFieldAddValueForm'.$user_cart_field_id
								)
							)
						?>
							<div class="form-inner">
								<?php
									foreach ($locales as $locale => $language):
										echo $this->Form->input(
											'value_'.$locale,
											array(
												'type'  => 'text',
												'label' => $language,
												'class' => 'form-control',
												'id'    => 'UserCartFieldValue'.ucfirst($locale).$user_cart_field_id
											)
										);
									endforeach;
								?>
							</div>
							
							<div class="form-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Dodaj', true)) ?>">
							</div>
						<?php echo $this->Form->end() ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach ?>
<?php endif ?>