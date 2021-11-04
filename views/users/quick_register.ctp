<div class="user-quick-register-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Szybka rejestracja') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if (isset($code_error)): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'error',
							'message'  => __('Nieprawidłowe dane.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif (isset($password_exists)): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'info',
							'message'  => sprintf(
								__('Utworzyłeś już konto wcześniej. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
							),
							'no_close' => true
						)
					)
				?>
			<?php elseif (isset($code)): ?>
				<?php
					echo $this->Form->create(
						'User',
						array(
							'url' => getUserQuickRegisterUrl(
								array(
									'code' => $code
								)
							),
							'class'         => 'form',
							'data-validate' => 'true',
							'data-submit'   => 'once'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'password',
							array(
								'type'          => 'password',
								'data-validate' => 'validate(required, minlength('.$min_password_length.'))',
								'div'           => 'form-row',
								'label'         => __('Hasło', true).':',
								'class'         => 'form-control'
							)
						);
						
						echo $this->Form->input(
							'password_2',
							array(
								'type'          => 'password',
								'data-validate' => 'validate(required, match-value(#UserPassword))',
								'div'           => 'form-row',
								'label'         => __('Powtórz hasło', true).':',
								'class'         => 'form-control'
							)
						);
					?>
					
					<span class="form-info required-info">
						<?php __('Pola oznaczone (*) są wymagane') ?>
					</span>
					
					<div class="form-actions align-input">
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Załóż konto', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<h2>
				<?php __('Masz już konto?') ?>
			</h2>
			
			<a class="btn btn-lg btn-block" href="<?php echo $this->Html->url(getUserLoginUrl()) ?>" title="<?php echo h(__('Zaloguj się', true)) ?>">
				<?php __('Zaloguj się') ?>
			</a>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>