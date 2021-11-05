<section class="cart-box aside-box" data-type="cart-box">
	<a class="responsive-toggle" data-type="toggle" href="#<?php echo isset($id) ? $id : 'BoxCart' ?>">
		<?php echo getCurrentCartName() ?>
	</a>
	
	<div class="box-content" id="<?php echo isset($id) ? $id : 'BoxCart' ?>">
		<?php if ($products = getCartProducts(getDefaultPricesType())): ?>
			<?php
				if (setting('MODULE_BOX_CART_ENTRIES_NUMBER')):
					$products = array_slice($products, 0, setting('MODULE_BOX_CART_ENTRIES_NUMBER'));
				endif;
				
				/* Źródło wejścia na kartę produktu */
				$get = array(
					'from' => 'wishlist-box'
				);
				
				if (isHomePageView()):
					$get['from'] .= ' main';
				endif;
			?>
			
			<div class="cart-box-max-height default-skin">
				<ul class="product-list small">
					<?php foreach ($products as $key => $product): ?>
						<li data-type="product-row" data-product-key="<?php echo $key ?>">
							<?php
								$name = getProductNameInCart($product);
								
								$product_url = $this->Html->url(getProductUrl($product['product_id'], $get));
								
								if (setting('MODULE_MULTISTORE_MERGE_CART_BETWEEN_STORES') == 2 && !checkProductIsVisible($product['product_id'])):
									$product_url = 'javascript: return false;';
								endif;
							?>
							
							<a class="product-box small" href="<?php echo $product_url ?>" title="<?php echo h($name) ?>">
								<span class="product-image preload-image" data-loaded="false">
									<?php
										echo $this->element(
											'_default'.DS.'miniature',
											array(
												'file'  => array(
													'type'     => configuration('ProductMedium.dir'),
													'filename' => $product['filename'] ? $product['filename'] : (($filename = getCombinationField($product['combination_id'], 'filename')) ? $filename : getProductMainPhotoId($product['product_id'], 'filename')),
													'dir'      => $product['filename'] ? $product['dir'] : (($dir = getCombinationField($product['combination_id'], 'dir')) ? $dir : getProductMainPhotoId($product['product_id'], 'dir'))
												),
												'image' => array(
													'resize'     => 'resize',
													'width'      => 60,
													'height'     => 60,
													'no_photo'   => true,
													'watermark'  => $product['product_id'],
													'blazy'      => true,
													'background' => array(
														'R' => 255,
														'G' => 255,
														'B' => 255
													)
												),
												'html'  => array(
													'image' => array(
														'alt' => h($name)
													)
												)
											)
										)
									?>
								</span>
								
								<span class="product-name">
									<?php echo $name ?>
								</span>
								
								<span class="product-quantity product-price">
									<span data-type="product-row-quantity"><?php echo showQuantityValue($product['quantity'], $product['product_id']) ?></span> x <?php echo showPrice($product['single_price']) ?>
								</span>
							</a>
							
							<a class="delete" href="<?php echo $this->Html->url(getProductDeleteFromCartUrl($product, 0, array('redirect' => 'referer'))) ?>" title="<?php echo h(__('usuń z koszyka', true)) ?>">&times; <?php __('usuń z koszyka')?></a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			
			<div class="free-shipping-info <?php echo ($deficiency = getCartFreeShippingDeficiency()) <= 0 ? 'hide' : '' ?>" data-type="free-shipping-info-toggle">
				<?php __('Do darmowej dostawy pozostało') ?>: <span data-type="free-shipping-info"><?php echo showPrice($deficiency) ?></span>
			</div>
			
			<div class="box-options">
				<span class="cart-box-ammount">
					<?php __('Razem') ?>: <strong class="price price-main" data-type="cart-price"><?php echo showPrice(getCartSumProductsPrice(getDefaultPricesType())) ?></strong>
				</span>
				
				<?php if (module('B2B')): ?>
					<a class="btn btn-primary" href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(__('Zamów', true)) ?>">
						<?php __('Zobacz koszyk') ?>  <i class="fa fa-angle-right"></i>
					</a>
				<?php else: ?>
					<a class="btn btn-primary" href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(__('Zamawiam', true)) ?>">
						<?php __('Zobacz koszyk') ?> <i class="fa fa-angle-right"></i>
					</a>
				<?php endif ?>
			</div>
		<?php else: ?>
			<div class="box-msg">
				<?php __('Twój koszyk jest pusty') ?>
			</div>
		<?php endif ?>
	</div>
</section>