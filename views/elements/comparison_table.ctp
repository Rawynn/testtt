<?php if ($products = getProductsInComparison(true)): ?>
	<?php $products_nr = count($products['Products']) ?>
	
	<table class="compare-table table table-striped" data-type="compare-table">
		<colgroup>
			<col width="20%">
			<?php for ( $i = 0; $i < $products_nr; $i++ ): ?>
				<col width="<?php echo 80 / $products_nr ?>%">
			<?php endfor ?>
		</colgroup>
		
		<thead>
			<tr>
				<th></th>
				
				<?php foreach ($products['Products'] as $key => $product): ?>
					<th>
						<div class="compare-product">
							<div class="product-image preload-image" data-loaded="false">
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => getProductMainPhotoId($product['Product']['id'], 'filename'),
												'dir'      => getProductMainPhotoId($product['Product']['id'], 'dir'),
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 150,
												'height'     => 150,
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
							</div>
							
							<a class="product-name" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
								<?php echo $product['Product']['name'] ?>
							</a>
							
							<a class="delete" data-type="delete-product" href="<?php echo $this->Html->url(getProductDeleteFromCompareUrl($product['Product']['id'])) ?>" title="<?php __('Usuń produkt z porównywarki') ?>">&times;</a>
						</div>
					</th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products['Attribute'] as $key => $attribute): ?>
				<tr class="compare-row" data-type="compare-row">
					<td>
						<?php echo $attribute['Attribute']['name'] ?>
					</td>
					
					<?php foreach ($products['Products'] as $product): ?>
						<?php if (isset($product['AttributeValue'][$key])): ?>
							<?php if (count($product['AttributeValue'][$key]) > 1): ?>
								<td data-type="compare-value">
									<ul>
										<?php foreach ($product['AttributeValue'][$key] as $attribute_value): ?>
											<li>
												<strong><?php echo $attribute_value ?></strong>
											</li>
										<?php endforeach ?>
									</ul>
								</td>
							<?php else: ?>
								<td data-type="compare-value">
									<strong><?php echo reset($product['AttributeValue'][$key]) ?></strong>
								</td>
							<?php endif ?>
						<?php else: ?>
							<td data-type="compare-value"></td>
						<?php endif ?>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
			
			<?php if (userAccessToPrice()): ?>
				<tr class="compare-row price-row">
					<td>
						<?php __('Cena') ?>
					</td>
					
					<?php foreach ($products['Products'] as $product): ?>
						<td>
							<?php if (($price = getProductPrice($product['Product']['id'])) || !setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES')): ?>
								<?php $netto = getDefaultPricesType() == 'netto' ?>
								
								<strong class="price">
									<?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?>
								</strong>
								
								<?php if (isset($price['base_price'])): ?>
									<strong class="base-price">
										<?php echo showPrice($netto ? $price['netto_base_price'] : $price['base_price']) ?>
									</strong>
								<?php endif ?>
							<?php elseif ($price['price'] == 0 && setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && getProductLoyaltyPrice($product['Product']['id']) !== null): ?>
								<strong class="price">
									<?php echo showProductLoyaltyPrice($product['Product']['id']) ?>
								</strong>
							<?php else: ?>
								<strong class="price">-</strong>
							<?php endif ?>
						</td>
					<?php endforeach ?>
				</tr>
			<?php endif ?>
			
			<?php if (userAccessToAddToCart()): ?>
				<tr class="compare-row cart-row">
					<td></td>
					
					<?php foreach ($products['Products'] as $product): ?>
						<td>
							<a class="btn btn-primary" href="<?php echo $this->Html->url(getProductAddToCartUrl($product['Product']['id'])) ?>" title="<?php echo h(getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true)) ?>">
								<strong><?php echo getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true) ?></strong>
							</a>
						</td>
					<?php endforeach ?>
				</tr>
			<?php endif ?>
		</tbody>
	</table>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => __('Brak produktów do porównania.', true)
			)
		)
	?>
<?php endif ?>