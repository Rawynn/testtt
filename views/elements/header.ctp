<header>
	<?php
		if (userIsSalesrep()):
			echo $this->element(TEMPLATE_NAME.DS.'header_top_salesrep');
		else:
			echo $this->element(TEMPLATE_NAME.DS.'header_top');
		endif
	?>
	
	<div class="container">
		<div class="row">
			<div class="right-box">
				<div class="search-form" id="MainSearchElement" data-toggle-extended-elements="top-navigation">
					<?php echo $this->element(TEMPLATE_NAME.DS.'header_search')?>
				</div>
			
					<?php if (!isBot()): ?>
						<ul>
							<?php if (!userIsSalesrep()): ?>
								<?php if (module('COMPARE')): ?>
									<li class="compare">
										<div class="header-nav-item">
											<span>|</span>
											<a data-toggle="modal" href="#ComparisonTable" role="button" title="<?php echo h(__('Porównaj', true)) ?>">
												<?php __('Porównaj') ?> (<span data-type="compare-products-count"><?php echo getProductsCountInComparison() ?></span>)
											</a>
										</div>
									</li>
								<?php endif ?>
								
								<?php if (module('WISHLIST')): ?>
									<li class="wishlist">
										<div class="header-nav-item">
											<span></span>
											<a href="<?php echo $this->Html->url(getWishlistUrl()) ?>" title="<?php echo h(__('Ulubione', true)) ?>">
												<i class="fa fa-heart-o"></i> <?php __('Ulubione') ?>
											</a>
										</div>
									</li>
								<?php endif ?>
								
								<?php if (getSavedUserCartsCount()): ?>
									<li class="saved-carts">
										<div class="header-nav-item">
											<span></span>
											<a href="<?php echo $this->Html->url(getSavedUserCartsUrl()) ?>" title="<?php echo h(__('Zapisane koszyki', true)) ?>">
												<?php __('Zapisane koszyki') ?>
											</a>
										</div>
									</li>
								<?php endif ?>
							<?php endif ?>
						</ul>
					<?php endif ?>
					<?php echo $this->element(TEMPLATE_NAME.DS.'header_user_status') ?>
			</div>
			<div class="company-logo">
				<?php if(isHomePageView()):?>
					<h1>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'header_logo',
								array(
									'cache' => array(
										'time' => configuration('Cache.short_time'),
										'key'  => getStandardCacheKey()
									)
								)
							)
						?>
					</h1>
				<?php else: ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'header_logo',
							array(
								'cache' => array(
									'time' => configuration('Cache.short_time'),
									'key'  => getStandardCacheKey()
								)
							)
						)
					?>
				<?php endif; ?>
			</div>
			
			<?php echo $this->element(TEMPLATE_NAME.DS.'mobile_nav') ?>
			<div class="navbar navbar-cart">
				<?php if (!isBot()): ?>
					<ul>
						<li class="cart">
							<div class="header-nav-item">
								<?php $is_offer = getCartIsOffer() ?>
								
								<a data-type="slidemenu" data-target="cart-box" href="#" title="<?php echo h($is_offer ? __('Pokaż ofertę', true) : __('Pokaż koszyk', true)) ?>">
									<span class="sprite sprite-cart"></span>
									<span class="num" data-type="cart-sum-quantity"><?php echo showQuantityValue(getRealProductsCountInCart()) ?></span>
								</a>
								
								<a href="<?php echo $this->Html->url(getCartUrl()) ?>" class="price" title="<?php h(__('Do kasy')) ?>">
									<?php $price_sum = getCartSumProductsPrice(getDefaultPricesType());?>
									<span data-type="cart-price"><?php echo $price_sum==0? '<span>'.__('Twój koszyk<br/>jest pusty', true).'</span>' : showPrice($price_sum); ?></span>
								</a>
							</div>
							
							<div class="dropdown-box" data-id="cart-box" data-group="header-box">
								<?php
									echo $this->element(
										TEMPLATE_NAME.DS.'boxes'.DS.'cart',
										array(
											'id' => 'Cart'
										)
									)
								?>
							</div>
						</li>
					</ul>
				<?php endif ?>
			</div>
		</div>
	</div>
</header>

<?php if (module('COMPARE')): ?>
	<?php
		/* Porównywarka */
		echo $this->element(TEMPLATE_NAME.DS.'comparison_modal')
	?>
<?php endif ?>