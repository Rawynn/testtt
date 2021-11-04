<div class="wishlist-page page">
	<div class="page-header">
		<h1>
			<?php __('Schowek') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($products = getWishlistProducts(true)): ?>
			<?php
				echo $this->Form->create(
					'Wishlist',
					array(
						'url' => getWishlistAddToCartUrl(
							array(
								'from' => 'wishlist'
							)
						)
					)
				)
			?>
				<table class="table wishlist-table product-table">
					<colgroup>
						<col width="10%">
						<col width="30%">
						<col width="20%">
						<col width="20%">
						<col width="15%">
						<col width="5%">
					</colgroup>
					<thead>
						<tr class="product-header">
							<th class="product-data-header" colspan="2">
								<?php __('Produkty') ?>
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
								<th class="product-summary-header">
									&nbsp;
								</th>
							<?php endif ?>
						</tr>
					</thead>
					<tbody>
						<?php $key = 0 ?>
						
						<?php foreach ($products as $product_id => $combinations): ?>
							<?php
								$product_url   = getProductUrl($product_id);
								$product_name  = getProductName($product_id);
							?>
							
							<?php foreach ($combinations as $combination_id => $quantity): ?>
								<?php $product_price = getProductPrice($product_id, $combination_id) ?>
								
								<tr class="product-row" data-type="product-row" data-product-id="<?php echo $product_id ?>" data-combination-id="<?php echo $combination_id ?>">
									<td class="product-image">
										<a class="preload-image" data-type="product-row-image" href="<?php echo $this->Html->url($product_url) ?>" data-loaded="false" title="<?php echo h($product_name) ?>">
											<?php
												echo $this->element(
													'_default'.DS.'miniature',
													array(
														'file'  => array(
															'type'     => configuration('ProductMedium.dir'),
															'filename' => (($filename = getCombinationField($combination_id, 'filename')) ? $filename : getProductMainPhotoId($product_id, 'filename')),
															'dir'      => (($dir = getCombinationField($combination_id, 'dir')) ? $dir : getProductMainPhotoId($product_id, 'dir'))
														),
														'image' => array(
															'resize'     => 'resize',
															'width'      => 400,
															'height'     => 400,
															'no_photo'   => true,
															'watermark'  => $product_id,
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
												'Wishlist.'.$key.'.product_id',
												array(
													'value' => $product_id
												)
											);
											
											echo $this->Form->hidden(
												'Wishlist.'.$key.'.combination_id',
												array(
													'value' => $combination_id
												)
											);
										?>
										
										<div class="name">
											<a href="<?php echo $this->Html->url($product_url) ?>" title="<?php echo h($product_name) ?>">
												<?php echo $product_name ?>
											</a>
										</div>
										
										<?php if (userAccessToAddToCart()): ?>
											<?php
												/* Kombinacje produktu */
												echo $this->element(
													TEMPLATE_NAME.DS.'wishlist'.DS.'combinations',
													array(
														'key'            => $key,
														'product_id'     => $product_id,
														'combination_id' => $combination_id
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
												<?php echo showPrice(getDefaultPricesType() == 'netto' ? $product_price['netto_price'] : $product_price['price']) ?>
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
													'Wishlist.'.$key.'.quantity',
													array(
														'type'               => 'text',
														'data-step'          => getProductQuantityStep($product_id),
														'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
														'data-max'           => 999,
														'data-unit'          => false,
														'data-show-controls' => 1,
														'div'                => false,
														'label'              => false,
														'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
														'value'              => showQuantityValue($quantity)
													)
												)
											?>
										</td>
										<td class="product-price">
											<input class="btn btn-form-size btn-grey" type="submit" name="data[Wishlist][<?php echo $key ?>][add_to_cart]" value="<?php echo h(getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true)) ?>">
										</td>
										<td class="product-price product-summary">
											<div class="remove">
											<a data-toggle="modal" href="#DeleteProduct<?php echo $product_id ?>_<?php echo $combination_id ?>" role="button" title="<?php echo h(__('Usuń produkt ze schowka', true)) ?>">
												<i class="fa fa-times"></i>
											</a>
											
											<div class="modal fade" id="DeleteProduct<?php echo $product_id ?>_<?php echo $combination_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															
															<h2>
																<?php __('Usunięcie produktu ze schowka') ?>
															</h2>
														</div>
														
														<div class="modal-body">
															<p class="text-center">
																<?php __('Czy na pewno chcesz usunąć ten produkt ze schowka ?') ?>
															</p>
														</div>
														
														<div class="modal-footer modal-actions">
															<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
																<?php __('Nie') ?>
															</a>
															
															<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getProductDelereFromWishlistUrl($product_id, array(), null, 1, $combination_id)) ?>">
																<?php __('Tak') ?>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										</td>
									<?php endif ?>
								</tr>
								
								<?php $key++ ?>
							<?php endforeach ?>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<div class="form-actions">
					<input class="btn btn-primary btn-lg btn-next" type="submit" name="data[Wishlist][add_all]" value="<?php echo h(getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Twój schowek jest pusty', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>