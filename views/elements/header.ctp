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
			
			<div class="search-form" id="MainSearchElement" data-toggle-extended-elements="top-navigation">
				<?php echo $this->element(TEMPLATE_NAME.DS.'header_search')?>
			</div>
			
			<div class="navbar navbar-cart">
				<?php if (!isBot()): ?>
					<ul>
						<li class="cart">
							<div class="header-nav-item">
								<?php $is_offer = getCartIsOffer() ?>
								<span class="sprite sprite-koszyk1"></span>
								<span class="left-hold">
									<a rel="nofollow" data-type="slidemenu" data-target="cart-box" href="#" title="<?php echo h($is_offer ? __('Pokaż ofertę', true) : __('Pokaż koszyk', true)) ?>">
										<?php __('Koszyk')?> <i class="fa fa-angle-down"></i>
									</a>
									<span data-type="cart-sum-quantity"><?php echo showQuantityValue(getRealProductsCountInCart())?></span><?php __(' szt.')?>
									<span data-type="cart-price"><?php echo showPrice(getCartSumProductsPrice(getDefaultPricesType())) ?></span>
								</span>
								
								<a rel="nofollow" href="<?php echo $this->Html->url(getCartUrl()) ?>" class="btn btn-primary btn-form-size" title="<?php h(__('Do kasy')) ?>">
									<?php __('Do kasy') ?> <i class="fa fa-angle-right"></i>
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