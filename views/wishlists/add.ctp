<div class="add-wishlist-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<div class="hheader">
					<?php __('Dodanie produktu do schowka') ?>
				</div>
			</div>
			
			<?php if (isset($raport)): ?>
				<div class="modal-body">
					<?php $i = 0 ?>
					
					<table class="product" data-type="wishlist-add-group-table">
						<?php foreach ($raport as $product_id): ?>
							<tr style="<?php echo $i > 2 ? 'display: none;' : '' ?>">
								<td class="preload-image" data-loaded="true">
									<?php
										$name  = getProductName($product_id);
										$price = getProductPrice($product_id);
									?>
									
									<?php
										echo $this->element(
											'_default'.DS.'miniature',
											array(
												'file'  => array(
													'type'     => configuration('ProductMedium.dir'),
													'filename' => getProductMainPhotoId($product_id, 'filename'),
													'dir'      => getProductMainPhotoId($product_id, 'dir')
												),
												'image' => array(
													'resize'     => 'resize',
													'width'      => 75,
													'height'     => 75,
													'no_photo'   => true,
													'watermark'  => $product_id,
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
								</td>
								<td>
									<span class="product-name">
										<?php echo $name ?>
									</span>
									
									<span class="product-quantity">
										<?php echo showQuantityValue(1, $product_id) ?> x <span class="price"><?php echo showPrice($price['price']) ?></span>
									</span>
								</td>
							</tr>
							
							<?php $i++ ?>
						<?php endforeach ?>
					</table>
					
					<?php if ($i > 2): ?>
						<a href="#" data-type="wishlist-add-group-more"><?php __('Pokaż wszystkie dodane') ?></a>
					<?php endif ?>
				</div>
				
				<?php if ($raport): ?>
					<div class="modal-footer modal-actions">
						<a class="btn-back btn-grey btn btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Kontynuuj zakupy', true)) ?>">
							<?php __('Kontynuuj zakupy') ?>
						</a>
						
						<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getWishlistUrl()) ?>" title="<?php echo h(__('Przejdź do Schowka', true)) ?>">
							<?php __('Przejdź do Schowka') ?>
						</a>
					</div>
				<?php else: ?>
					<div class="modal-footer">
						<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('OK', true)) ?>">
							<?php __('OK') ?>
						</a>
					</div>
				<?php endif ?>
			<?php else: ?>
				<div class="modal-body">
					<?php if ($status['code'] == 'success'): ?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'message'.DS.'message',
								array(
									'class'    => 'success',
									'message'  => $status['message'],
									'no_close' => true
								)
							)
						?>
						
						<table class="product">
							<tr>
								<td class="preload-image" data-loaded="false">
									<?php $name = getProductName($product_id) ?>
									
									<?php
										echo $this->element(
											'_default'.DS.'miniature',
											array(
												'file'  => array(
													'type'     => configuration('ProductMedium.dir'),
													'filename' => getProductMainPhotoId($product_id, 'filename'),
													'dir'      => getProductMainPhotoId($product_id, 'dir')
												),
												'image' => array(
													'resize'     => 'resize',
													'width'      => 150,
													'height'     => 150,
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
														'alt' => h($name)
													)
												)
											)
										)
									?>
								</td>
								<td>
									<span class="product-name">
										<?php echo $name ?>
										
										<?php if ($combination_id): ?>
											(<?php echo getCombinationName($combination_id) ?>)
										<?php endif ?>
									</span>
									<span class="product-quantity">
										<?php $price = getProductPrice($product_id, $combination_id) ?>
										
										1 x <span class="price"><?php echo showPrice(getDefaultPricesType() == 'netto' ? $price['netto_price'] : $price['price']) ?></span>
									</span>
								</td>
							</tr>
						</table>
					<?php else: ?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'message'.DS.'message',
								array(
									'class'    => 'error',
									'message'  => $status['message'],
									'no_close' => true
								)
							)
						?>
					<?php endif ?>
				</div>
				
				<?php if ($status['code'] == 'success'): ?>
					<div class="modal-footer modal-actions">
						<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Kontynuuj zakupy', true)) ?>">
							<?php __('Kontynuuj zakupy') ?>
						</a>
						
						<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getWishlistUrl()) ?>" title="<?php echo h(__('Przejdź do Schowka', true)) ?>">
							<?php __('Przejdź do Schowka') ?>
						</a>
					</div>
				<?php else: ?>
					<div class="modal-footer">
						<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('OK', true)) ?>">
							<?php __('OK') ?>
						</a>
					</div>
				<?php endif ?>
			<?php endif ?>
			
			<div class="hide">
				<span data-type="wishlist-quantity"><?php echo getWishlistProductsCount() ?></span>
				
				<?php
					/* Cały boks */
					echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.'wishlist')
				?>
			</div>
		</div>
	</div>
</div>