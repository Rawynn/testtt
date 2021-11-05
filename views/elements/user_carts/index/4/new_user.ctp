<?php if (getLoggedUserId() && !userIsRegistered($order['Order']['user_id'])): ?>
	<div class="new-user-order-section order-section order-section-50">
		<div class="order-section-header">
			<h2>
				<?php __('Załóż konto') ?>
			</h2>
		</div>
		
		<div class="order-section-inner">
			<h3>
				<?php echo __('Chcesz w łatwiejszy sposób korzystać ze sklepu', true).' '.setting('GLOBAL_STORE_NAME').'?' ?>
			</h3>
			
			<?php
				echo $this->Form->create(
					'User',
					array(
						'url'           => getUserSetPasswordUrl(getUserField($order['Order']['user_id'], 'code')),
						'class'         => 'form ajax-modal-form',
						'data-validate' => 'true'
					)
				)
			?>
				<?php
					echo $this->Form->input(
						'passwd',
						array(
							'type'          => 'password',
							'data-validate' => 'validate(required, minlength('.setting('GLOBAL_PASSWORD_MIN_LENGTH').'))',
							'div'           => 'form-row',
							'label'         => __('Hasło', true).':',
							'class'         => 'form-control',
							'escape'        => false
						)
					);
					
					echo $this->Form->input(
						'passwd_2',
						array(
							'type'          => 'password',
							'data-validate' => 'validate(required, match-value(#UserPasswd))',
							'div'           => 'form-row',
							'label'         => __('Powtórz hasło', true).':',
							'class'         => 'form-control',
							'escape'        => false
						)
					);
				?>
				
				<p>
					<input class="btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Utwórz konto', true)) ?>">
				</p>
			<?php echo $this->Form->end() ?>
		</div>
	</div>
<?php endif ?>