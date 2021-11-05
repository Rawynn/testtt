<?php
	$user_name = getUserUsername() ? getUserUsername() : __('Twoje konto', true);
	
	$user_edit           = '<a rel="nofollow" href="'.$this->Html->url(getUserAccountEditUrl(), array('escape' => false)).'"><i class="sprite sprite-twoje_konto"></i> '.$user_name.'</a>';
	$salesrep_clients    = $this->Html->link(__('Klienci', true), getUsersListUrl());
	$user_orders         = $this->Html->link(__('Zamówienia', true), getOrdersUrl());
	$user_login          = '<a rel="nofollow" href="'.$this->Html->url(getUserLoginUrl()).'"><i class="sprite sprite-twoje_konto"></i> '.__('Zaloguj', true).'</a>';
	$user_logout         = '<a rel="nofollow" href="'.$this->Html->url(getUserLogoutUrl()).'"><i class="sprite sprite-logout"></i> '.__('Wyloguj', true).'</a>';
	$user_register       = '<a rel="nofollow" href="'.$this->Html->url(getUserRegisterUrl()).'">'.__('Zarejestruj', true).'</a>';
	$user_cancel_session = '<a rel="nofollow" href="'.$this->Html->url(getUserCancelSessionUrl()).'">'.__('To nie Ty?', true).'</a>';
?>

<div class="user-status-info">
	<?php if (getLoggedUserId()): ?>
		<?php if (getLoggedUserIsAuthorized()): ?>
			<?php if (getUserLoggedByFacebook()): ?>
				<?php echo $user_edit ?> <a href="<?php echo $this->Html->url(getUserLogoutUrl(), array('data-type' => 'facebook-logout')) ?>"><i class="sprite sprite-logout"></i> <?php __('Wyloguj', true)?></a>
			<?php else: ?>
				<?php if (userIsSalesrep()): ?>
					<?php echo $user_logout ?> 
					
					<a rel="nofollow" data-type="slidemenu" data-target="salesrep-shortcuts" href="#" title="<?php echo h(__('Na skróty', true)) ?>">
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
						
						<a rel="nofollow" href="<?php echo $this->Html->url(getSavedUserCartsUrl()) ?>" title="<?php echo h(__('Zapisane koszyki', true)) ?>">
							<?php __('Zapisane koszyki') ?> (<span><?php echo getSavedUserCartsCount() ?></span>)
						</a>
						
						<?php echo $user_orders ?>
						
						<?php echo $salesrep_clients ?>
					</div>
				<?php else: ?>
					<?php echo $user_edit ?> <?php echo $user_logout ?>
				<?php endif ?>
			<?php endif ?>
		<?php else: ?>
			<?php if (getUserPersonalizationName()): ?>
				<?php echo $user_edit ?> <?php echo $user_logout ?>
				
				<div class="user-status-cancel-session">
					<?php echo $user_cancel_session ?>
				</div>
			<?php endif ?>
		<?php endif ?>
	<?php else: ?>
		<?php if (getUserPersonalizationName()): ?>
			<?php echo $user_edit ?> <?php echo $user_logout ?>
			
			<div class="user-status-cancel-session">
				<?php echo $user_cancel_session ?>
			</div>
		<?php else: ?>
			<?php echo $user_login ?> <?php echo $user_register ?>
		<?php endif ?>
	<?php endif ?>
</div>