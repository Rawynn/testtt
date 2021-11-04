<?php
	$user_name = getUserUsername() ? getUserUsername() : __('Twoje konto', true);
	
	$user_edit           = $this->Html->link($user_name, getUserAccountEditUrl(), array('escape' => false));
	$salesrep_clients    = $this->Html->link(__('Klienci', true), getUsersListUrl());
	$user_orders         = $this->Html->link(__('Zamówienia', true), getOrdersUrl());
	$user_login          = $this->Html->link(__('Logowanie', true), getUserLoginUrl());
	$user_logout         = $this->Html->link(__('Wyloguj', true), getUserLogoutUrl());
	$user_register       = $this->Html->link(__('Rejestracja', true), getUserRegisterUrl());
	$user_cancel_session = $this->Html->link(__('To nie Ty?', true), getUserCancelSessionUrl());
?>

<div class="user-status-info">
	<?php if (getLoggedUserId()): ?>
		<?php if (getLoggedUserIsAuthorized()): ?>
			<?php if (getUserLoggedByFacebook()): ?>
				<span class="squer"></span><?php echo $user_edit ?> <span class="squer"></span> <?php echo $this->Html->link(__('Wyloguj', true), getUserLogoutUrl(), array('data-type' => 'facebook-logout')) ?>
			<?php else: ?>
				<?php if (userIsSalesrep()): ?>
					<?php echo $user_logout ?> <span class="squer"></span>
					
					<a data-type="slidemenu" data-target="salesrep-shortcuts" href="#" title="<?php echo h(__('Na skróty', true)) ?>">
						<?php __('Na skróty') ?> <i class="fa fa-chevron-circle-down"></i>
					</a>
					
					<div class="dropdown-box" data-id="salesrep-shortcuts">
						<?php if (module('WISHLIST')): ?>
							<a href="<?php echo $this->Html->url(getWishlistUrl()) ?>" title="<?php echo h(__('Schowek', true)) ?>">
								<?php __('Schowek') ?> (<span data-type="wishlist-quantity"><?php echo getWishlistProductsCount() ?></span>)
							</a>
						<?php endif ?>
						
						<?php if (module('OFFERS')): ?>
							<a href="<?php echo $this->Html->url(getSavedOffersUrl()) ?>" title="<?php echo h(__('Oferty', true)) ?>">
								<?php __('Oferty') ?> (<span><?php echo getSavedOffersCount() ?></span>)
							</a>
						<?php endif ?>
						
						<a href="<?php echo $this->Html->url(getSavedUserCartsUrl()) ?>" title="<?php echo h(__('Zapisane koszyki', true)) ?>">
							<?php __('Zapisane koszyki') ?> (<span><?php echo getSavedUserCartsCount() ?></span>)
						</a>
						
						<?php echo $user_orders ?>
						
						<?php echo $salesrep_clients ?>
					</div>
				<?php else: ?>
					<span class="squer"></span><?php echo $user_edit ?> <span class="squer"></span> <?php echo $user_logout ?>
				<?php endif ?>
			<?php endif ?>
		<?php else: ?>
			<?php if (getUserPersonalizationName()): ?>
				<span class="squer"></span><?php echo $user_edit ?> <span class="squer"></span> <?php echo $user_logout ?>
				
				<div class="user-status-cancel-session">
					<?php echo $user_cancel_session ?>
				</div>
			<?php endif ?>
		<?php endif ?>
	<?php else: ?>
		<?php if (getUserPersonalizationName()): ?>
			<span class="squer"></span><?php echo $user_edit ?> <span class="squer"></span> <?php echo $user_logout ?>
			
			<div class="user-status-cancel-session">
				<?php echo $user_cancel_session ?>
			</div>
		<?php else: ?>
			<span class="squer"></span><?php echo $user_login ?> <span class="squer"></span> <?php echo $user_register ?>
		<?php endif ?>
	<?php endif ?>
</div>