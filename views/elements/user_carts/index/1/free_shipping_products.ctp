<?php $products = $deficiency > 0 ? getRecommendedProductsForUser(3, $deficiency, array_unique(Set::extract(getCartProducts(), '{n}.product_id')), !setting('GLOBAL_INCLUDE_SPECIALS_IN_SHIPPING_METHODS_FREE_FROMS'), false, array(), $deficiency * 5) : array() ?>

<?php if ($products): ?>
	<ul class="product-list small" data-from="free-shipping">
		<?php foreach ($products as $product): ?>
			<li>
				<div class="product-box small">
					<span class="product-image preload-image" data-loaded="false">
						<a href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
							<?php
								echo $this->element(
									'_default'.DS.'miniature',
									array(
										'file'  => array(
											'type'     => configuration('ProductMedium.dir'),
											'filename' => getProductMainPhotoId($product['Product']['id'], 'filename'),
											'dir'      => getProductMainPhotoId($product['Product']['id'], 'dir')
										),
										'image' => array(
											'resize'     => 'resize',
											'width'      => 120,
											'height'     => 120,
											'no_photo'   => true,
											'watermark'  => $product['Product']['id'],
											'blazy'      => true,
											'background' => array(
												'R' => 255,
												'G' => 255,
												'B' => 255
											)
										),
										'html'  => array(
											'image' => array(
												'alt' => h($product['Product']['name'])
											)
										)
									)
								)
							?>
						</a>
					</span>
					
					<a href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" class="product-name" title="<?php echo h($product['Product']['name']) ?>">
						<?php echo $product['Product']['name'] ?>
					</a>
					
					<span class="product-price">
						<?php
							$price = getProductPrice($product['Product']['id']);
							$netto = getDefaultPricesType() == 'netto';
						?>
						
						<?php if (isset($price['base_price'])): ?>
							<span class="discount-price"><?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?></span>
							<span class="base-price"><?php echo showPrice($netto ? $price['netto_base_price'] : $price['base_price']) ?></span>
						<?php else: ?>
							<span class="price"><?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?></span>
						<?php endif ?>
					</span>
					
					<a href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" class="more" title="<?php echo h($product['Product']['name']) ?>">
						<?php __('zobacz') ?><i class="fa fa-sngle-right"></i>
					</a>
				</div>
			</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
