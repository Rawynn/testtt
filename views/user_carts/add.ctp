<div class="add-cart-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php echo getCartIsOffer() ? __('Dodanie produktu do oferty', true) : __('Dodanie produktu do koszyka', true) ?>
				</h2>
			</div>
			
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
						<?php foreach ($add_raport as $product_id => $products): ?>
							<?php foreach ($products as $combination_id => $quantities): ?>
								<?php foreach ($quantities as $price => $quantity): ?>
									<tr>
										<td class="preload-image" data-loaded="false">
											<?php
												$name              = getProductName($product_id);
												$combinantion_name = getCombinationName($combination_id);
												
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
												);
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
								<?php endforeach ?>
							<?php endforeach ?>
						<?php endforeach ?>
					</table>
					
					<?php
						/* Możliwość wyboru usług */
						$services = $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'add_product'.DS.'services');
						
						echo $services;
					?>
					
					<?php
						/* Produkty polecane */
						if (strlen(trim($services)) == 0):
							echo $this->element(TEMPLATE_NAME.DS.'cart_modal_products',
									array('product_id' =>$product_id));
						endif;
					?>
					
					<?php
						/* JavaScript po dodaniu produktu do koszyka */
						echo $this->element('_default'.DS.'add_product_to_cart_ajax_scripts')
					?>
				<?php elseif ($status['code'] == 'no_variant_selected' || $status['code'] == 'no_sizes_selected'): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => $status['message'],
								'no_close' => true
							)
						)
					?>
					
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'             => getProductAddToCartUrl($product_id, array(), null, null, true),
								'data-type'       => 'product-modal-form',
								'data-product-id' => $product_id,
								'class'           => 'form',
								'id'              => 'UserCartAddModalForm',
								'data-submit'     => 'once'
							)
						)
					?>
						<?php
							if (!empty($this->data['UserCart']['quantity'])):
								echo $this->Form->hidden('UserCart.quantity');
							endif;
						?>
						
						<div class="form-inner">
							<div class="form-variants">
								<?php if (module('KITS') && getProductField($product_id, 'kit_id')): ?>
									<?php
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'kit_variants',
											array(
												'kit_variants'          => getProductKitCombinations($product_id, null, true, true),
												'kit_variant_prefix'    => 'UserCartAddCombinationId',
												'extended_kit_variants' => setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM') ? getProductExtendedKitCombinations($product_id, null, true, true) : array()
											)
										)
									?>
								<?php else: ?>
									<?php
										if (module('B2B') && setting('GLOBAL_PRODUCT_PAGE_USER_CART_QTY')):
											echo $this->element(
												TEMPLATE_NAME.DS.'product'.DS.'variants_with_quantity',
												array(
													'variants' => getProductCombinations($product_id, !checkCanAddNotSellableProductToCart(), true)
												)
											);
										else:
											echo $this->element(
												TEMPLATE_NAME.DS.'product'.DS.'variants',
												array(
													'product_id' => $product_id
												)
											);
										endif;
									?>
								<?php endif ?>
							</div>
							
							<div class="form-surfaces">
								<div class="product-surfaces">
									<?php
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'surfaces',
											array(
												'surfaces' => getProductField($product_id, 'surface')
											)
										)
									?>
								</div>
							</div>
						</div>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Anuluj', true)) ?>">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				<?php elseif ($status['code'] == 'only_kit'): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => $status['message'],
								'no_close' => true
							)
						)
					?>
					
					<ul class="product-kit-list navigation-list">
						<?php foreach (getKitsForProduct($product_id) as $product): ?>
							<li>
								<a href="<?php echo $this->Html->url(getProductUrl($product['Kit']['id'])) ?>" title="<?php echo h($product['Kit']['name']) ?>">
									<?php echo $product['Kit']['name'] ?>
								</a>
							</li>
						<?php endforeach ?>
					</ul>
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
					<a class="btn-back btn btn-grey btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Kontynuuj zakupy', true)) ?>">
						<?php __('Kontynuuj zakupy') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(getCartIsOffer() ? __('Przejdź do oferty', true) : __('Przejdź do koszyka', true)) ?>">
						<?php echo getCartIsOffer() ? __('Przejdź do oferty', true) : __('Przejdź do koszyka', true) ?>
					</a>
				</div>
			<?php elseif ($status['code'] != 'no_variant_selected' && $status['code'] != 'no_sizes_selected'): ?>
				<div class="modal-footer">
					<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('OK', true)) ?>">
						<?php __('OK') ?>
					</a>
				</div>
			<?php endif ?>
			
			<div class="hide">
				<span data-type="cart-price"><?php echo showPrice(getCartSumProductsPrice(getDefaultPricesType())) ?></span>
				
				<span data-type="cart-sum-quantity"><?php echo showQuantityValue(getRealProductsCountInCart()) ?></span>
				
				<?php
					/* Boks koszyka */
					echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.'cart')
				?>
			</div>
		</div>
	</div>
</div>