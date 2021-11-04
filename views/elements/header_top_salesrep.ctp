<div class="header-top header-top-salesrep">
	<div class="container">
		<div class="row">
			<?php echo $this->element(TEMPLATE_NAME.DS.'menu_user_account', array('top_menu' => true)) ?>
			
			<div class="user-status-info">
				<a href="#UserAccountMenu" data-type="toggle">
					<i class="fa fa-chevron-circle-down"></i>
					<?php echo getLoggedUserId() ? (userIsAdmin(getLoggedUserId(), true) && !getUserUsername() ? 'Admin' : getUserUsername()) : '' ?>
				</a>
			</div>
		</div>
	</div>
</div>

<?php echo $this->element(TEMPLATE_NAME.DS.'choose_clients_cart_options') ?>