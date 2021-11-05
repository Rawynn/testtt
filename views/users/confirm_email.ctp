<div class="user-confirm-email-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Zmiana adresu e-mail') ?>
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
			<?php elseif ($save_error):?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'error',
							'message'  => __('Wystąpił błąd podczas zmiany adresu. Proszę spróbować jeszcze raz.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif ($confirmed):?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'success',
							'message'  => __('Nowy adres e-mail został potwierdzony. Od tej pory należy korzystać z nowego adresu e-mail.', true),
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