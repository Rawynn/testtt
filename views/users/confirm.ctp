<div class="user-confirm-account-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Aktywacja konta') ?>
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
			<?php elseif ($save_error): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'error',
							'message'  => __('Wystapił błąd podczas aktywacji konta. Proszę spróbować jeszcze raz.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif ($current_active): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'info',
							'message'  => sprintf(
								__('Twoje konto zostało już wcześniej aktywowane. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
							),
							'no_close' => true
						)
					)
				?>
			<?php elseif ($activated): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'success',
							'message'  => sprintf(
								__('Twoje konto zostało aktywowane. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
							),
							'no_close' => true
						)
					)
				?>
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