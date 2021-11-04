<?php if (isset($secure_url)): ?>
	<div class="order-pay-page order-page page">
		
		<div class="page-header">
			<h1>
				<?php echo sprintf(__('Opłać zamówienie numer %s', true), getOrderFullId($order['Order']['id'])) ?>
			</h1>
		</div>
		<?php
			/* Menu */
			echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
		?>
		
		<div class="page-content-container">
			<div class="page-content page-sidebar-true">
				<iframe width="600" height="300" style="border: 0px;" src="<?php echo $secure_url ?>"></iframe>
			</div>
			
			<div class="page-sidebar">
				<?php
					/* Sidebar */
					echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
				?>
			</div>
		</div>
	</div>
<?php endif ?>