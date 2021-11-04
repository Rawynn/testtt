<div class="user-login-page user-page page">
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				/* Formularz logowania */
				echo $this->element(TEMPLATE_NAME.DS.'login_page')
			?>
		</div>
		<div class="page-sidebar">
			<h2>
				<?php __('Nie masz jeszcze konta w peripetie.cz?<br/>Zarejestruj się:') ?>
			</h2>
			
			<a class="btn btn-lg btn-primary btn-block" href="<?php echo $this->Html->url(getUserRegisterUrl()) ?>" title="<?php echo h(__('Zarejestruj się', true)) ?>">
				<?php __('Zarejestruj się') ?>
			</a>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>