<?php if (userIsSalesrep()): ?>
	<div class="add-cart-modal modal fade" id="AddProductToCart" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Dodaj produkt') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'       => getProductAddToCartUrl(null),
								'class'     => 'product-options form',
								'id'        => 'UserCartAddProductForm',
								'data-type' => 'user-cart-add-product-form'
							)
						)
					?>
						<div class="form-inner">
							<div class="form-row">
								<label for="NewProductProductName">
									<?php __('Produkt') ?>:
								</label>
								
								<?php
									echo $this->Form->hidden(
										'NewProduct.product_id',
										array(
											'id'        => 'UserCartAddProductId',
											'data-type' => 'user-cart-add-product-id',
											'value'     => ''
										)
									);
									
									echo $this->Form->input(
										'NewProduct.product_name',
										array(
											'type'                      => 'text',
											'data-type'                 => 'autocomplete',
											'data-ac'                   => 'true',
											'data-ac-url'               => $this->Html->url(getUserCartProductsAutocompleterUrl()),
											'data-ac-handler'           => '[data-type=user-cart-add-product-id-container]',
											'data-ac-extended'          => 'false',
											'data-ac-copy'              => '[data-type=user-cart-add-product-id]',
											'data-trigger-autocomplete' => 'autocomplete-select',
											'data-allow-not-exists'     => setting('MODULE_B2B_OFFER_ALLOW_NOT_EXISTS_PRODUCTS') ? 'true' : 'false',
											'div'                       => array(
												'data-type' => 'user-cart-add-product-id-container',
												'class'     => 'autocompleter-container'
											),
											'label'                     => false,
											'class'                     => 'form-control',
											'placeholder'               => __('Podaj nazwę produktu', true),
											'id'                        => 'NewProductProductName',
											'value'                     => ''
										)
									);
								?>
							</div>
							
							<?php if (setting('MODULE_B2B_OFFER_ALLOW_NOT_EXISTS_PRODUCTS')): ?>
								<div class="form-row product-tax-value">
									<?php
										echo $this->Form->input(
											'NewProduct.price',
											array(
												'type'      => 'text',
												'div'       => false,
												'label'     => __('Cena', true).':',
												'class'     => 'form-control quantity-input',
												'value'     => '0,00',
												'data-type' => 'user-cart-add-product-price',
												'disabled'  => 'disabled'
											)
										);
										
										echo $this->Form->input(
											'NewProduct.tax_id',
											array(
												'type'         => 'select',
												'div'          => false,
												'label'        => false,
												'class'        => 'form-control',
												'options'      => getTaxesList(true),
												'data-type'    => 'user-cart-add-product-tax-id',
												'default'      => getDefaultTaxId(),
												'data-default' => getDefaultTaxId(),
												'value'        => null,
												'disabled'     => 'disabled'
											)
										);
									?>
								</div>
							<?php endif ?>
							
							<div class="quantity form-row">
								<?php
									echo $this->Form->input(
										'NewProduct.quantity',
										array(
											'type'               => 'text',
											'data-step'          => 1,
											'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
											'data-max'           => null,
											'data-unit'          => getProductUnit(0),
											'data-show-controls' => 1,
											'data-type'          => 'user-cart-add-product-quantity',
											'div'                => false,
											'label'              => __('Ilość', true).':',
											'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
											'value'              => number_format(1, (int)setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'), ',', '')
										)
									)
								?>
							</div>
							
							<div class="form-row">
								<label>
									&nbsp;
								</label>
								
								<input class="btn btn-primary" data-type="user-cart-add-product-button" value="<?php echo h(__('Dodaj', true)) ?>" disabled>
							</div>
							
							<?php $products = getSessionValue('Offer.added_products') ?>
							
							<div data-type="cart-add-product-products-list" class="new-products-list <?php echo !$products ? 'hide' : '' ?>">
								<?php if ($products): ?>
									<table class="product">
										<?php
											$count = count($products);
											$i     = 0;
										?>
										
										<?php foreach ($products as $key => $product): ?>
											<tr>
												<td>
													<?php
														$name              = getProductName($product['product_id']);
														$combinantion_name = getCombinationName($product['combination_id']);
														
														echo $this->Form->hidden(
															'UserCart.'.$key.'.product_id',
															array(
																'value' => $product['product_id']
															)
														);
														
														echo $this->Form->hidden(
															'UserCart.'.$key.'.combination_id',
															array(
																'value' => $product['combination_id']
															)
														);
														
														echo $this->Form->hidden(
															'UserCart.'.$key.'.quantity',
															array(
																'value' => $product['quantity']
															)
														);
														
														echo $this->Form->hidden(
															'UserCart.'.$key.'.price',
															array(
																'value' => $product['price']
															)
														);
														
														echo $this->element(
															'_default'.DS.'miniature',
															array(
																'file'  => array(
																	'type'     => configuration('ProductMedium.dir'),
																	'filename' => ($filename = getCombinationField($product['combination_id'], 'filename')) ? $filename : getProductMainPhotoId($product['product_id'], 'filename'),
																	'dir'      => ($dir = getCombinationField($product['combination_id'], 'dir')) ? $dir : getProductMainPhotoId($product['product_id'], 'dir')
																),
																'image' => array(
																	'resize'     => 'resize',
																	'width'      => 60,
																	'height'     => 60,
																	'no_photo'   => true,
																	'watermark'  => $product['product_id'],
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
														<?php echo showQuantityValue($product['quantity'], $product['product_id']) ?> x <span class="price"><?php echo showPrice($product['price']) ?></span>
													</span>
													
													<a href="#" data-type="delete-offer-tmp-product" data-offer-product-key="<?php echo $key ?>" class="remove" title="<?php echo h(__('Usuń', true)) ?>">
														<?php __('usuń') ?> &times;
													</a>
												</td>
											</tr>
											
											<?php $i++ ?>
											
											<?php if ($i < $count): ?>
												<tr class="hr">
													<td colspan="2">
														<hr>
													</td>
												</tr>
											<?php endif ?>
										<?php endforeach ?>
									</table>
								<?php endif ?>
							</div>
						</div>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" data-type="user-cart-add-product-submit" value="<?php echo h(__('Dodaj', true)) ?>" <?php echo !$products ? 'disabled' : '' ?>>
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>