<?php if ($user): ?>
	<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Informacja') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<strong><?php __('Mamy już zarejestrowane konto dla podanego adresu e-mail. Czy chcesz skorzystać z tego konta aby złożyć zamówienie?') ?></strong><br>
					
					<span><?php __('Jeśli pamiętasz swoje hasło, wprowadź je poniżej i zaloguj się do sklepu') ?>:</span>
					
					<?php
						echo $this->Form->create(
							'User',
							array(
								'url'         => getUserLoginUrl(),
								'class'       => 'form-login form-fast-login form',
								'data-submit' => 'once',
								'id'          => 'UserFastLoginForm'
							)
						)
					?>
						<?php
							echo $this->Form->hidden(
								'User.redirect',
								array(
									'id'    => 'UserFastLoginRedirect',
									'value' => Router::url(getCartUrl(3), true)
								)
							);
							
							echo $this->Form->hidden(
								'User.email',
								array(
									'id'    => 'UserFastLoginEmail',
									'value' => $user['User']['email']
								)
							);
						?>
						
						<div class="form-row">
							<?php
								echo $this->Form->input(
									'User.password',
									array(
										'type'        => 'password',
										'div'         => false,
										'label'       => false,
										'class'       => 'form-control',
										'placeholder' => __('Hasło', true),
										'id'          => 'UserFastLoginPassword'
									)
								)
							?>
							
							<input class="btn btn-primary" type="submit" value="<?php echo h(__('Zaloguj się', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
					
					<hr>
					
					<span><?php __('Jeśli nie pamiętasz swojego hasła, możesz skorzystać z opcji przypomnienia hasła. Czy chcesz otrzymać link z przypomnieniem hasła?') ?></span><br>
					
					<?php
						echo $this->Form->create(
							'User',
							array(
								'url'         => getUserGenerateLoginUrl(),
								'class'       => 'form-login form-fast-login form',
								'data-submit' => 'once',
								'id'          => 'UserFastLoginForm'
							)
						)
					?>
						<?php
							echo $this->Form->hidden(
								'User.email',
								array(
									'id'    => 'UserLoginUrlEmail',
									'value' => $user['User']['email']
								)
							)
						?>
						
						<input class="btn btn-primary" type="submit" value="<?php echo h(__('Tak, wyślij mi link', true)) ?>">
					<?php echo $this->Form->end() ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
						<?php __('Zamknij') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>