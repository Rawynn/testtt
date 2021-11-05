<div class="header-top">
	<div class="container">
		<div class="contact-info">
			
			<?php if ($email = setting('GLOBAL_EMAIL_CONTACT')): ?>
				<a class="mail" href="mailto:<?php echo $email ?>">
					<i class="sprite sprite-mail"></i> <?php echo $email ?>
				</a>
			<?php endif ?>
			<?php if ($phone = setting('GLOBAL_CONTACT_PHONE_1')): ?>
				<span class="phone">
					<i class="sprite sprite-tel"></i> <?php echo $phone ?>
				</span>
			<?php endif ?>
		</div>
		
		<div class="navbar">
			
			<?php if (!isBot()): ?>
				<ul>
					<?php if (!userIsSalesrep()): ?>
						<?php if (module('COMPARE')): ?>
							<li class="compare">
								<div class="header-nav-item">
									<a rel="nofollow" data-toggle="modal" href="#ComparisonTable" role="button" title="<?php echo h(__('Porównaj', true)) ?>">
										<?php __('Porównaj') ?> (<span data-type="compare-products-count"><?php echo getProductsCountInComparison() ?></span>)
									</a>
								</div>
							</li>
						<?php endif ?>
						
						<?php if (module('WISHLIST')): ?>
							<li class="wishlist">
								<div class="header-nav-item">
									<a rel="nofollow" href="<?php echo $this->Html->url(getWishlistUrl()) ?>" title="<?php echo h(__('Schowek', true)) ?>">
										<i class="sprite sprite-schowek"></i> <?php __('Schowek') ?> (<span data-type="wishlist-quantity"><?php echo getWishlistProductsCount() ?></span>)
									</a>
								</div>
							</li>
						<?php endif ?>
						
						<?php if (getSavedUserCartsCount()): ?>
							<li class="saved-carts">
								<div class="header-nav-item">
									<span>|</span>
									<a rel="nofollow" href="<?php echo $this->Html->url(getSavedUserCartsUrl()) ?>" title="<?php echo h(__('Zapisane koszyki', true)) ?>">
										<?php __('Zapisane koszyki') ?> (<span><?php echo getSavedUserCartsCount() ?></span>)
									</a>
								</div>
							</li>
						<?php endif ?>
					<?php endif ?>
				</ul>
			<?php endif ?>
			<?php echo $this->element(TEMPLATE_NAME.DS.'header_user_status') ?>
		</div>
	</div>
</div>