<div class="wishlist-page page">
	<div class="page-header">
		<h1>
			<?php __('Lista życzeń') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($products): ?>
			<?php
				echo $this->Form->create(
					'GiftsList',
					array(
						'url' => getGiftListAddToCartUrl()
					)
				)
			?>
				<table class="table wishlist-table product-table">
					<colgroup>
						<col width="13%">
						<col width="42%">
						<col width="15%">
						<col width="20%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr class="product-header">
							<th class="product-data-header" colspan="2">
								<?php __('Produkt') ?>
							</th>
							
							<?php if (userAccessToPrice()): ?>
								<th class="product-price-header">
									<?php __('Cena') ?>
								</th>
							<?php endif ?>
							
							<?php if (userAccessToAddToCart()): ?>
								<th class="product-quantity-header">
									<?php __('Ilość') ?>
								</th>
								<th class="product-summary-header">
									&nbsp;
								</th>
							<?php endif ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($products as $key => $product): ?>
							<?php
								$product_url   = getProductUrl($product['Product']['id']);
								$product_name  = getProductName($product['Product']['id']);
								$product_price = getProductPrice($product['Product']['id']);
								$netto         = getDefaultPricesType() == 'netto';
							?>
							
							<tr class="product-row" data-type="product-row" data-product-id="<?php echo $product['Product']['id'] ?>">
								<td class="product-image">
									<a class="preload-image" data-type="product-row-image" href="<?php echo $this->Html->url($product_url) ?>" data-loaded="false" title="<?php echo h($product_name) ?>">
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
														'width'      => 400,
														'height'     => 400,
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
															'alt' => h($product_name)
														)
													)
												)
											)
										?>
									</a>
								</td>
								<td class="product-data">
									<?php
										echo $this->Form->hidden(
											'GiftsList.'.$key.'.product_id',
											array(
												'value' => $product['Product']['id']
											)
										)
									?>
									
									<div class="name">
										<a href="<?php echo $this->Html->url($product_url) ?>" title="<?php echo h($product_name) ?>">
											<?php echo $product_name ?>
										</a>
									</div>
									
									<?php
										/* Informacja o dostępności produktu */
										echo $this->element(
											TEMPLATE_NAME.DS.'gifts_list'.DS.'ias',
											array(
												'product_id' => $product['Product']['id']
											)
										)
									?>
									
									<?php if (userAccessToAddToCart()): ?>
										<?php
											/* Kombinacje produktu */
											echo $this->element(
												TEMPLATE_NAME.DS.'gifts_list'.DS.'combinations',
												array(
													'key'        => $key,
													'product_id' => $product['Product']['id'],
												)
											)
										?>
									<?php endif ?>
								</td>
								
								<?php if (userAccessToPrice()): ?>
									<td class="product-price">
										<span class="table-responsive-label">
											<?php __('Cena') ?>:
										</span>
										
										<span data-type="product-row-price">
											<?php echo showPrice($netto ? $product_price['netto_price'] : $product_price['price']) ?>
										</span>
									</td>
								<?php endif ?>
								
								<?php if (userAccessToAddToCart()): ?>
									<td class="product-price product-quantity">
										<span class="table-responsive-label">
											<?php __('Ilość') ?>:
										</span>
										
										<?php
											echo $this->Form->input(
												'GiftsList.'.$key.'.quantity',
												array(
													'type'               => 'text',
													'data-step'          => getProductQuantityStep($product['Product']['id']),
													'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
													'data-max'           => 999,
													'data-unit'          => getProductUnit($product['Product']['id']),
													'data-show-controls' => 1,
													'div'                => false,
													'label'              => false,
													'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
													'value'              => showQuantityValue(getProductDefaultQuantity($product['Product']['id']))
												)
											)
										?>
									</td>
									<td class="product-summary">
										<?php if (in_array($product['Product']['id'], Set::extract(getCartProducts(), '{n}.product_id'))): ?>
											<span>
												<?php __('W koszyku') ?>
											</span>
										<?php else: ?>
											<input class="btn btn-form-size pull-right" type="submit" name="data[GiftsList][<?php echo $key ?>][add_to_cart]" value="<?php echo h(getCartIsOffer() ? __('Do oferty', true) : __('Doo koszyka', true)) ?>">
										<?php endif ?>
									</td>
								<?php endif ?>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php echo $this->Form->end() ?>
		<?php else: ?>
			<?php if ($error == 'all_purchased'): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'error',
							'message'  => __('Wszystkie produkty z listy zostały kupione.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif ($error == 'no_active'): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'info',
							'message'  => __('Przepraszamy. Podana lista została zdeaktywowana.', true),
							'no_close' => true
						)
					)
				?>
			<?php elseif ($error == 'no_exists'): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'flat no-items',
							'message'  => __('Nie znaleziono.', true)
						)
					)
				?>
			<?php endif ?>
		<?php endif ?>
	</div>
</div>