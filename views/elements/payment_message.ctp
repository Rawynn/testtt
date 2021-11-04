<div class="payment-message-page user-page page">
	<div class="page-header">
		<h1>
			<?php echo $header ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if (isset($message)): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => isset($type) ? $type : 'info',
							'message'  => $message,
							'no_close' => true
						)
					)
				?>
			<?php endif ?>
			
			<?php if (isset($code)): ?>
				<?php echo $code ?>
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