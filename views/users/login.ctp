<div class="user-login-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Logowanie') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				/* Formularz logowania */
				echo $this->element(TEMPLATE_NAME.DS.'login_page')
			?>
		</div>
		<div class="page-sidebar">
			<h2>
				<?php __('Nie masz konta?') ?>
			</h2>
			
			<a class="btn btn-lg btn-primary btn-block" href="<?php echo $this->Html->url(getUserRegisterUrl()) ?>" title="<?php echo h(__('Zarejestruj się', true)) ?>">
				<?php __('Zarejestruj się') ?>
			</a>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>