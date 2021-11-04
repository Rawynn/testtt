<div class="modal fade" id="Recommend" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<div class="hheader">
					<?php __('Poleć znajomemu') ?>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="product-recommend">
					<?php
						echo $this->Form->create(
							'Product',
							array(
								'url'           => Router::url(getProductUrl($product_id), true),
								'class'         => 'form recommend-product-form validate-form',
								'data-validate' => 'true',
								'data-submit'   => 'once',
								'escapeInputs'  => false
							)
						)
					?>
						<?php
							echo $this->Form->hidden(
								'recommend',
								array(
									'value' => 1
								)
							);
							
							echo $this->Form->input(
								'username',
								array(
									'type'          => 'text',
									'data-validate' => 'validate(required)',
									'div'           => 'form-row',
									'label'         => __('Twoje imię', true),
									'class'         => 'form-control',
									'default'       => getUserUsername()
								)
							);
							
							echo $this->Form->input(
								'email',
								array(
									'type'          => 'text',
									'data-validate' => 'validate(email)',
									'div'           => 'form-row',
									'label'         => __('Twój e-mail', true),
									'class'         => 'form-control',
									'default'       => getUserEmail()
								)
							);
							
							echo $this->Form->input(
								'friend_email',
								array(
									'type'          => 'text',
									'data-validate' => 'validate(email)',
									'div'           => 'form-row',
									'label'         => __('Adres e-mail', true),
									'class'         => 'form-control'
								)
							);
						?>
						
						<?php if (setting('MODULE_RECOMMEND_CAPTCHA') && !getLoggedUserId()): ?>
							<div class="captcha">
								<div class="g-recaptcha" id="recaptcha-recommend-product"></div>
							</div>
						<?php endif ?>
						
						<div class="form-actions align-input">
							<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
</div>
