<section class="cart-box aside-box" data-type="cart-box">
	
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
													'width'      => 70,
													'height'     => 70,
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
							
							<a class="delete" href="<?php echo $this->Html->url(getProductDeleteFromCartUrl($product, 0, array('redirect' => 'referer'))) ?>" title="<?php echo h(__('Usuń', true)) ?>"><i class="fa fa-times"></i> <?php __('usuń produkt')?></a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			<?php if(showQuantityValue(getRealProductsCountInCart())>setting('MODULE_BOX_CART_ENTRIES_NUMBER')):?>
			<div class="more-br"><?php __('Dodałeś do koszyka')?> <span data-type="cart-sum-quantity"><?php echo showQuantityValue(getRealProductsCountInCart()) ?></span> <?php __('produktów, jeżeli chcesz zobaczyć wszystkie - przejdź do koszyka')?></div>
			<?php endif;?>
			<div class="br-50">
				<?php __('Wartość produktów') ?><strong data-type="cart-price"><?php echo showPrice(getCartSumProductsPrice(getDefaultPricesType())) ?></strong>
			</div>
			<div class="br-50">
				<?php __('Koszt przesyłki')?>
				<?php if(getCartFreeShippingDeficiency(true) == 0):?>
					<strong data-type="price-small"><?php echo __('od ',true).showPrice(0.0)?></strong>
				<?php else: ?>
					<strong data-type="price-small"><?php echo __('od ',true).showPrice(2) ?></strong>
				<?php endif;?>
			</div>
			<div class="clearfix"></div>
			<a class="btn btn-primary btn-block" href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(__('Do koszyka'))?>">
				<?php __('Do koszyka')?>
			</a>
		<?php else: ?>
			<div class="box-msg">
				<?php __('Twój koszyk jest pusty') ?>
			</div>
		<?php endif ?>
	</div>
</section>