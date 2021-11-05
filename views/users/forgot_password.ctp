<div class="user-forgot-password-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Nie pamiętasz hasła?') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'info',
						'message' => __('Nowe hasło zostanie wysłane na Twój adres e-mail.', true)
					)
				)
			?>
			
			<?php
				echo $this->Form->create(
					'User',
					array(
						'url'          => getUserForgotPasswordUrl(),
						'class'        => 'form',
						'data-submit'  => 'once',
						'autocomplete' => 'off'
					)
				)
			?>
				<?php
					echo $this->Form->input(
						'email',
						array(
							'type'  => 'email',
							'div'   => 'form-row',
							'label' => __('Adres e-mail', true).':',
							'class' => 'form-control'
						)
					)
				?>
				
				<div class="form-actions align-input">
					<input class="btn-next btn btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>
