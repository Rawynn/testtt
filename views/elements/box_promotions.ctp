<?php if (module('BOX_SPECIALS')): ?>
	<?php
		$limit      = setting('MODULE_BOX_SPECIALS_ENTRIES_NUMBER');
		$promotions = getRandomSpecial($limit, $this->params);
	?>
	
	<?php if ($promotions != null): ?>
		<?php
			if ($limit == 1):
				$promotions = array($promotions);
			endif;
			
			$show_button = !isBot() ? setting('MODULE_BOX_SPECIALS_SHOW_BUY') : false;
		?>
		
		<section class="promotion-box aside-box section">
			<h2 class="box-header section-header">
				<?php __('Promocje') ?>
			</h2>
			
			<a class="responsive-toggle" data-type="toggle" href="#BoxSales">
				<?php __('Promocje') ?>
			</a>
			
			<div id="BoxSales" class="box-content">
				<?php foreach ($promotions as $key => $promotion): ?>
					<?php
						/* Źródło wejścia na kartę produktu */
						$get = array(
							'from' => 'box-promotion'
						);
						
						if (isHomePageView()):
							$get['from'] .= ' main';
						endif;
					?>
					
					<div class="promotion-box-item">
						<a href="<?php echo $this->Html->url(getProductUrl($promotion['Product']['id'], $get)) ?>" title="<?php echo h($promotion['Product']['name']) ?>" class="promotion-box-item-inner">
							<div class="preload-image image-main" data-loaded="false">
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => isset($promotion['ProductMedium']['filename']) ? $promotion['ProductMedium']['filename'] : false,
												'dir'      => isset($promotion['ProductMedium']['dir']) ? $promotion['ProductMedium']['dir'] : false,
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 300,
												'height'     => 300,
												'no_photo'   => true,
												'watermark'  => $promotion['Product']['id'],
												'blazy'      => true,
												'background' => array(
													'R' => 255,
													'G' => 255,
													'B' => 255
												)
											),
											'html'  => array(
												'image' => array(
													'alt' => !empty($promotion['ProductMedium']['title']) ? h($promotion['ProductMedium']['title']) : h($promotion['Product']['name'])
												)
											)
										)
									)
								?>
							</div>
							
							<h2 class="product-name">
								<?php echo $promotion['Product']['name'] ?>
							</h2>
						</a>
						
						<hr/>
						
						<div class="row-fluid">
							<div class="span16">
								<span class="product-price-<?php echo $promotion['Product']['id'] ?> product-price"></span>
							</div>
							
							<div class="span8">
								<?php if ($show_button): ?>
									<a class="add-do-cart btn btn-primary btn-small btn-block" href="<?php echo $this->Html->url(getProductAddToCartUrl($promotion['Product']['id'], $get)) ?>" title="<?php echo h(getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true)) ?>">
										<?php echo getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true) ?>
									</a>
								<?php endif ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</section>
	<?php endif ?>
<?php endif ?>