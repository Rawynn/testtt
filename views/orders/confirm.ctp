<div class="order-confirm-page order-page page">
	<div class="page-header">
		<h1>
			<?php __('Potwierdzenie zamówienia') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if (isset($__order)): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'success',
							'message'  => __('Zamówienie zostało potwierdzone.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif (isset($error)): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'error',
							'message'  => __('Wystąpił błąd. Zamówienie nie zostało potwierdzone. Proszę spróbować jeszcze raz.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif (isset($current_confirmed)): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'info',
							'message'  => __('Zamówienie zostało już wcześniej potwierdzone.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif (isset($wrong_code)): ?>
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