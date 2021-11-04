<?php $cart_products = getCartProducts() ?>

<div class="add-cart-modal add-group-cart-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Dodanie produktów do koszyka') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php if ($error_add): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'error',
								'message'  => __('Nie wszystkie produkty zostały dodane do kosyka', true),
								'no_close' => true
							)
						)
					?>
				<?php endif ?>
				
				<?php if (!$error_add && $success_add): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'success',
								'message'  => __('Do koszyka zostały dodane produkty.', true),
								'no_close' => true
							)
						)
					?>
				<?php endif ?>
				
				<?php $i = 0 ?>
				
				<table class="product" data-type="add-group-table">
					<?php foreach ($add_raport as $product_id => $products): ?>
						<?php foreach ($products as $combination_id => $quantities): ?>
							<?php foreach ($quantities as $price => $quantity): ?>
								<tr style="<?php echo $i > 2 ? 'display: none;' : '' ?>">
									<td class="preload-image preload-image-small" data-loaded="false">
										<?php
											$name              = getProductName($product_id);
											$combinantion_name = getCombinationName($combination_id);
										?>
										
										<?php
											echo $this->element(
												'_default'.DS.'miniature',
												array(
													'file'  => array(
														'type'     => configuration('ProductMedium.dir'),
														'filename' => ($filename = getCombinationField($combination_id, 'filename')) ? $filename : getProductMainPhotoId($product_id, 'filename'),
														'dir'      => ($dir = getCombinationField($combination_id, 'dir')) ? $dir : getProductMainPhotoId($product_id, 'dir')
													),
													'image' => array(
														'resize'     => 'resize',
														'width'      => 75,
														'height'     => 75,
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
											
											<?php if ($combinantion_name): ?>
												<br>
												
												<span class="product-combination-name">
													<?php echo $combinantion_name ?>
												</span>
											<?php endif ?>
										</span>
										
										<span class="product-quantity">
											<?php echo showQuantityValue($quantity, $product_id) ?> x <span class="price"><?php echo showPrice($price) ?></span>
										</span>
									</td>
								</tr>
								
								<?php $i++ ?>
							<?php endforeach ?>
						<?php endforeach ?>
					<?php endforeach ?>
				</table>
				
				<?php if ($i > 2): ?>
					<a href="#" data-type="add-group-more"><?php __('Pokaż wszystkie dodane') ?></a>
				<?php endif ?>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Kontynuuj zakupy', true)) ?>">
					<?php __('Kontynuuj zakupy') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(__('Przejdź do koszyka', true)) ?>">
					<?php __('Przejdź do koszyka') ?>
				</a>
			</div>
			
			<div class="hide">
				<span data-type="cart-price">
					<?php echo showPrice(getCartSumProductsPrice(getDefaultPricesType())) ?>
				</span>
				
				<span data-type="cart-sum-quantity">
					<?php echo showQuantityValue(getRealProductsCountInCart()) ?> <?php __('szt.') ?>
				</span>
				<?php
					/* Boks koszyka */
					echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.'cart')
				?>
			</div>
		</div>
	</div>
</div>