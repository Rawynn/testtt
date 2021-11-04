<div class="user-new-password-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Nowe hasło') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($code_error): ?>
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
			<?php else: ?>
				<?php if (isset($saved)): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'success',
								'message'  => sprintf(
									__('Twoje hasło w serwisie zostało zmienione. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
								),
								'no_close' => true
							)
						)
					?>
				<?php else: ?>
					<?php
						echo $this->Form->create(
							'User',
							array(
								'url'           => getUserNewPasswordUrl($code),
								'class'         => 'form',
								'data-validate' => 'true',
								'data-submit'   => 'once'
							)
						)
					?>
						<?php
							echo $this->Form->input(
								'passwd',
								array(
									'type'          => 'password',
									'data-validate' => 'validate(required, minlength('.$min_password_length.'))',
									'div'           => 'form-row',
									'label'         => __('Podaj nowe hasło', true).':',
									'class'         => 'form-control'
								)
							);
							
							echo $this->Form->input(
								'passwd_2',
								array(
									'type'          => 'password',
									'data-validate' => 'validate(required, match-value(#UserPasswd))',
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
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				<?php endif ?>
			<?php endif?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>