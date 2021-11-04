<?php if ($products = getRecommendedProductsForUser(2,  null, array_keys($add_raport), false, false, array_keys($add_raport))): ?>
	<?php addCampaignViewBox($campaign_id = getSectionCampaignId('recommendations')) ?>
	
	<hr>
	
	<h2 class="product-list-label">
		<?php __('Polecamy również') ?>
	</h2>
	
	<ul class="product-list small" data-from="recommendations" data-campaign-id="<?php echo $campaign_id ?>">
		<?php foreach ($products as $product): ?>
			<li>
				<a class="product-box small" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
					<span class="product-image preload-image" data-loaded="false">
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
										'width'      => 70,
										'height'     => 70,
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
					</span>
					
					<span class="product-name">
						<?php echo $product['Product']['name'] ?>
					</span>
					
					<span class="product-price">
						<?php
							$price = getProductPrice($product['Product']['id']);
							$netto = getDefaultPricesType() == 'netto';
						?>
						
						<span class="price"><?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?></span> <span class="base-price"><?php echo isset($price['base_price']) ? showPrice($netto ? $price['netto_base_price'] : $price['base_price']) : '' ?></span>
					</span>
				</a>
			</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>