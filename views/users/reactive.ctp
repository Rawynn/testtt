<div class="user-reactive-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Ponowienie aktywacja konta') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($sent): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'info',
							'message'  => __('Na podany adres e-mail został wysłany link aktywacyjny.', true),
							'no_close' => true
						)
					)
				?>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'info',
							'message' => __('Jeżeli nie dotarł do Ciebie wiadomość z linkiem aktywującym konto w serwisie możesz otrzymać go jeszcze raz wypełniając poniższy formularz', true)
						)
					)
				?>
				<?php
					echo $this->Form->create(
						'User',
						array(
							'url'          => getUserReactiveUrl(),
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
								'type'  => 'text',
								'div'   => 'form-row',
								'label' => __('Adres e-mail', true).':',
								'class' => 'form-control'
							)
						)
					?>
					
					<div class="form-actions align-input">
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>