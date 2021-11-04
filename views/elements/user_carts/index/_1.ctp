<?php if (userIsSalesrep()): ?>
	<div class="salesrep-cart-box">
		<?php
			$user_name_in_cart = '-';
			
			if (getCartUserId() > 0):
				$user_name_in_cart = getUserField(getCartUserId(), 'first_name').' '.getUserField(getCartUserId(), 'last_name');
			endif;
		?>
		
		<?php /* ?>
		<span class="client-name">
			<?php __('Wybrany klient') ?>: <strong><?php echo $user_name_in_cart ?></strong>
			
			<a data-type="slidemenu" data-target="cart-bottom-box-select-client" href="#" title="<?php echo h(__('Zmień', true)) ?>" class="change-button">
				<?php __('zmień') ?>&nbsp;<i class="fa fa-angle-right"></i>
			</a>
		</span>
		
		<div class="dropdown-box" data-id="cart-bottom-box-select-client" data-group="header-box">
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'boxes'.DS.'salesrep_select_client',
					array(
						'client_cart_box_id' => 'ClientBottomCart'
					)
				)
			?>
		</div>
		<?php */ ?>
		
		<div class="salesrep-options">
			<?php if ($can_save_cart): ?>
				<a class="btn btn-link btn-small btn-next btn-save-cart <?php echo !$edit_offer_mode ? 'btn-primary' : '' ?>" data-tooltip-set="true" data-toggle="modal" href="#CartSave" role="button" title="<?php echo h($edit_offer_mode ? __('Zapisz jako koszyk', true) : __('Zapisz koszyk', true)) ?>">
					<i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
				</a>
				
				<?php if (userIsSalesrep() && module('OFFERS')): ?>
					<a class="btn btn-link btn-small btn-next btn-save-cart <?php echo !$edit_offer_mode ? 'btn-primary' : '' ?>" data-tooltip-set="true" data-toggle="modal" href="#SaveOffer" role="button" title="<?php echo h($edit_offer_mode ? __('Skopiuj ofertę', true) : __('Stwórz ofertę', true)) ?>">
						<i class="fa fa-files-o" aria-hidden="true"></i>
					</a>
				<?php endif ?>
				
				<?php if ($edit_offer_mode): ?>
					<?php
						$send_offer_id = getCartUserCartId();
						
						if ($user_cart_offer):
							$send_offer_id .= '-'.$user_cart_offer['id'];
						endif;
					?>
					
					<a class="btn btn-link btn-small btn-next btn-save-cart" data-toggle="modal" href="#SaveOffer<?php echo $send_offer_id ?>" data-tooltip-set="true" role="button" title="<?php echo h(__('Zapisz ofertę', true)) ?>">
						<i class="fa fa-floppy-o" aria-hidden="true"></i>
					</a>
					
					<a class="btn btn-primary btn-small btn-next btn-save-cart" data-toggle="modal" href="#SendOffer<?php echo $send_offer_id ?>" role="button" title="<?php echo h(__('Wyślij ofertę', true)) ?>">
						<?php __('Wyślij ofertę') ?>
					</a>
					
					<?php
						/* B2B - czyszczenie koszyka */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_clear')
					?>
					
					<div class="clear-cart">
						<a data-toggle="modal" href="#CloseCart" role="button" data-tooltip-set="true" title="<?php echo h(__('Wyjdź z oferty', true)) ?>">
							<i class="fa fa-sign-out" aria-hidden="true"></i>
						</a>
					</div>
				<?php else: ?>
					<?php
						/* B2B - czyszczenie koszyka */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_clear')
					?>
					
					<?php if (getCartName()): ?>
						<div class="clear-cart">
							<a data-toggle="modal" href="#CloseCart" role="button" data-tooltip-set="true" title="<?php echo h(__('Opuść koszyk', true)) ?>">
								<i class="fa fa-sign-out" aria-hidden="true"></i>
							</a>
						</div>
					<?php endif ?>
				<?php endif ?>
			<?php elseif (getCartUserCartOfferId()): ?>
				<a class="btn btn-primary btn-small btn-next btn-save-cart" data-toggle="modal" href="#RejectOffer" role="button" title="<?php echo h(__('Odrzuć ofertę', true)) ?>">
					<?php __('Odrzuć ofertę') ?>
				</a>
			<?php else: ?>
				<?php
					/* B2B - czyszczenie koszyka */
					echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_clear')
				?>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>

<?php if ($products = getCartProducts(getDefaultPricesType(), userIsSalesrep())): ?>
	<?php $products_count = count($products) ?>
	
	<?php
		/* Minimalna wartość koszyka */
		echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_min_value_info')
	?>
	
	<?php
		echo $this->Form->create(
			'UserCart',
			array(
				'url'           => getCartUrl($step),
				'data-submit'   => 'once',
				'data-validate' => setting('GLOBAL_RESIGNATION_READ_CHECKBOX') ? 'true' : 'false',
				'class'         => 'form'
			)
		)
	?>
		<div class="product-section order-section">
			<a class="btn btn-grey btn-clear" href="<?php echo $this->Html->url(getCartClearUrl()) ?>" title="<?php echo h(__('Wyczyść koszyk', true))?>"><?php __('Wyczyść koszyk')?></a>
			<hr>
			<table class="cart-table product-table <?php echo userIsSalesrep() ? 'offer-table' : '' ?>">
				<?php if (userIsSalesrep()): ?>
					<?php if (getDefaultPricesType() == 'netto'): ?>
						<?php if ($edit_offer_mode): ?>
							<colgroup>
								<col width="3%">
								<col width="4%">
								<col width="5%">
								<col width="27%">
								<col width="7%">
								<col width="7%">
								<col width="7%">
								<col width="6%">
								<col width="6%">
								<col width="7%">
								<col width="5%">
								<col width="12%">
								<col width="4%">
							</colgroup>
						<?php else: ?>
							<colgroup>
								<col width="4%">
								<col width="5%">
								<col width="30%">
								<col width="7%">
								<col width="7%">
								<col width="7%">
								<col width="6%">
								<col width="6%">
								<col width="7%">
								<col width="5%">
								<col width="12%">
								<col width="4%">
							</colgroup>
						<?php endif ?>
					<?php else: ?>
						<?php if ($edit_offer_mode): ?>
							<colgroup>
								<col width="3%">
								<col width="6%">
								<col width="6%">
								<col width="29%">
								<col width="7%">
								<col width="7%">
								<col width="7%">
								<col width="6%">
								<col width="6%">
								<col width="7%">
								<col width="12%">
								<col width="4%">
							</colgroup>
						<?php else: ?>
							<colgroup>
								<col width="6%">
								<col width="6%">
								<col width="32%">
								<col width="7%">
								<col width="7%">
								<col width="7%">
								<col width="6%">
								<col width="6%">
								<col width="7%">
								<col width="12%">
								<col width="4%">
							</colgroup>
						<?php endif ?>
					<?php endif ?>
				<?php else: ?>
					<colgroup>
						<col width="10%">
						<col width="10%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="15%">
						<col width="5%">
					</colgroup>
				<?php endif ?>
				
				<thead>
					<tr class="product-header">
						<?php if ($edit_offer_mode): ?>
							<th class="product-number-header product-lp-first-header">
								<?php __('Lp.') ?>
							</th>
						<?php endif ?>
						
						<th class="product-data-header" colspan="3">
							<?php __('Produkty') ?>
						</th>
						
						<?php if (userIsSalesrep()): ?>
							<th class="product-price-header">
								<?php __('Cena katalogowa') ?>
							</th>
							<th class="product-price-header">
								<?php __('Cena zakupu') ?>
							</th>
							<th class="product-price-header">
								<?php __('Cennik klienta') ?>
							</th>
							<th class="product-price-header">
								<?php __('Marża') ?>
							</th>
							<th class="product-price-header">
								<?php __('Rabat') ?>
							</th>
						<?php endif ?>
						
						<th class="product-price-header">
							<?php __('Cena') ?>
						</th>
						
						<?php if (userIsSalesrep() && getDefaultPricesType() == 'netto'): ?>
							<th class="product-price-header">
								<?php __('VAT') ?>
							</th>
						<?php endif ?>
						
						<th class="product-quantity-header">
							<?php __('Ilość') ?>
						</th>
						<th class="product-quantity-header">
							<?php __('Razem') ?>
						</th>
						<th class="product-summary-header">
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						setGlobals('current_kit_id', 0);
						setGlobals('current_offer_union', null);
						setGlobals('current_product_label', null);
						
						/* Grupowe pobranie zdjęć produktów */
						$products_photos    = getProductsMainPhotos(Set::extract($products, '{n}.product_id'));
						$cominations_photos = getCombinationsPhotos(Set::extract($products, '{n}.combination_id'));
						
						/* Grupowe pobranie pól */
						$products_fields = getProductsFields(
							Set::extract($products, '{n}.product_id'),
							array(
								'`Product`.`kit_id`',
								'Product.name'
							)
						);
						
						/* Lista stawek podatkowych */
						$taxes_list = getTaxesList(true);
					?>
					
					<?php foreach ($products as $key => $product): ?>
						<?php if (showProductInCart($product)): ?>
							<?php
								$product_url  = $this->Html->url(getProductUrl($product['product_id']));
								
								if (setting('MODULE_MULTISTORE_MERGE_CART_BETWEEN_STORES') == 2 && !checkProductIsVisible($product['product_id'])):
									$product_url = 'javascript: return false;';
								endif;
								
								if (strlen($product['product_name']) == 0):
									$product['product_name'] = $products_fields[$product['product_id']]['Product']['name'];
								endif;
								
								$product_name = getProductNameInCart($product);
							?>
							
							<?php
								/* Nagłówek produktu */
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_label',
									array(
										'label' => $product['label'],
										'key'   => $key
									)
								)
							?>
							
							<?php
								/* Nagłówek produktu */
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_offer_union',
									array(
										'offer_union'      => $product['offer_union'],
										'offer_union_name' => $product['offer_union_name'],
										'product_label'    => $product['label']
									)
								)
							?>
							
							<?php
								/* Zestawy z rozbijaniem na produkty */
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_kit_label',
									array(
										'product_kit_id' => $product['kit_id']
									)
								)
							?>
							
							<?php
								$class = '';
								
								if ($product['kit_id']):
									$class .= ' kit-row';
								endif;
								
								if ($product['label']):
									$class .= 'product-label-row';
								endif;
								
								if ($product['offer_union']):
									$class .= ' offer-union-row';
								endif;
							?>
							
							<tr class="product-row <?php echo $class ?>" data-type="product-row" data-product-key="<?php echo $key ?>">
								<?php if ($edit_offer_mode): ?>
									<td class="product-price product-lp-first">
										<span class="table-responsive-label">
											<?php __('Lp.') ?>:
										</span>
										
										<?php
											echo $this->Form->input(
												'UserCart.'.$key.'.number',
												array(
													'type'      => 'text',
													'data-type' => 'change-number-input',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control number-input',
													'value'     => $product['number'],
													'disabled'  => $cart_blocked
												)
											)
										?>
									</td>
								<?php endif ?>
								
								<td class="product-image">
									<a class="preload-image" data-type="product-row-image" data-product-key="<?php echo $key ?>" data-kit-id="<?php echo $products_fields[$product['product_id']]['Product']['kit_id'] ?>" href="<?php echo $product_url ?>" data-loaded="false" title="<?php echo h($product_name) ?>">
										<?php
											$filename = '';
											$dir      = '';
											
											if ($product['filename']):
												$filename = $product['filename'];
												$dir      = $product['dir'];
											else:
												if ($product['combination_id'] && is_numeric($product['combination_id']) && isset($cominations_photos[$product['combination_id']])):
													$filename = $cominations_photos[$product['combination_id']]['filename'];
													$dir      = $cominations_photos[$product['combination_id']]['dir'];
												elseif (isset($products_photos[$product['product_id']])):
													$filename = $products_photos[$product['product_id']]['filename'];
													$dir      = $products_photos[$product['product_id']]['dir'];
												endif;
											endif;
											
											echo $this->element(
												'_default'.DS.'miniature',
												array(
													'file'  => array(
														'type'     => configuration('ProductMedium.dir'),
														'filename' => $filename,
														'dir'      => $dir
													),
													'image' => array(
														'resize'     => 'resize',
														'width'      => 400,
														'height'     => 400,
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
															'alt' => h($product_name)
														)
													)
												)
											)
										?>
									</a>
								</td>
								<td class="product-data" colspan="2">
									<?php
										echo $this->Form->hidden(
											'UserCart.'.$key.'.product_id',
											array(
												'value'    => $product['product_id'],
												'disabled' => $cart_blocked
											)
										)
									?>
									
									<?php
										echo $this->Form->hidden(
											'UserCart.'.$key.'.add_time',
											array(
												'value'    => $product['add_time'],
												'disabled' => $cart_blocked
											)
										)
									?>
									
									<?php
										/* Powierzchnie produktu */
										echo $this->element(
											TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_surfaces',
											array(
												'key'          => $key,
												'product_id'   => $product['product_id'],
												'width'        => $product['width'],
												'height'       => $product['height']
											)
										)
									?>
									
									<div class="name">
										
										<?php if ($product['type'] == 0 && $product['offer_union'] && getCartUserCartOfferId()): ?>
											<span class="user-cart-delete-checkbox">
												<?php
													echo $this->Form->input(
														'UserCart.'.$key.'.active',
														array(
															'type'             => 'radio',
															'legend'           => false,
															'label'            => false,
															'div'              => false,
															'checked'          => (bool) $product['active'],
															'data-type'        => 'cart-active-product-radio',
															'data-key'         => $key,
															'name'             => 'data[Offer]['.$product['offer_union'].']',
															'options'          => array(
																1 => ''
															)
														)
													)
												?>
											</span>
										<?php endif ?>
										
										<?php if ($edit_offer_mode && !$cart_blocked): ?>
											<a data-toggle="modal" href="#EditProductName<?php echo $key ?>" role="button" title="<?php echo h($product_name) ?>" data-type="product-name" data-key="<?php echo $key ?>">
												<?php echo $product_name ?>
											</a>
										<?php else: ?>
											<a href="<?php echo $product_url ?>" title="<?php echo h($product_name) ?>">
												<?php echo $product_name ?>
											</a>
										<?php endif ?>
										
										<?php if ($product['type'] >= 1 && $product['type'] <= 4): ?>
											<span class="label">
												<?php __('Gratis') ?>
											</span>
										<?php endif ?>
									</div>
									
									<?php
										/* Wymiana punktów programu lojalnościowego */
										echo $this->element(
											TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_loyalty_points',
											array(
												'key'     => $key,
												'product' => $product
											)
										)
									?>
									
									<?php
										/* Kombinacje produktu */
										echo $this->element(
											TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_combinations',
											array(
												'key'                   => $key,
												'product_id'            => $product['product_id'],
												'combination_id'        => $product['combination_id'],
												'selected_kit_products' => $product['selected_kit_products']
											)
										)
									?>
								</td>
								
								<?php if (userIsSalesrep()): ?>
									<td class="product-price">
										<span class="table-responsive-label">
											<?php __('Cena katalogowa') ?>:
										</span>
										
										<?php
											echo $this->Form->input(
												'UserCart.'.$key.'.suggested_price',
												array(
													'type'      => 'text',
													'data-type' => 'change-suggested-price-input',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control price-input '.($product['price_locked'] ? 'invalid' : ''),
													'value'     => showPrice($product['suggested_price'], false),
													'disabled'  => $cart_blocked
												)
											)
										?>
									</td>
									<td class="product-price">
										<span class="table-responsive-label">
											<?php __('Cena zakupu') ?>:
										</span>
										
										<?php
											echo $this->Form->input(
												'UserCart.'.$key.'.purchase_price',
												array(
													'type'      => 'text',
													'data-type' => 'change-purchase-price-input',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control price-input '.($product['price_locked'] ? 'invalid' : ''),
													'value'     => showPrice($product['purchase_price'], false),
													'disabled'  => $cart_blocked
												)
											)
										?>
									</td>
									<td class="product-price">
										<span class="table-responsive-label">
											<?php __('Cennik klienta') ?>:
										</span>
										
										<?php echo showPrice(getDefaultPricesType() == 'netto' ? $product['product_price'] / (1 + $product['tax_value'] / 100): $product['product_price']) ?>
									</td>
									<td class="product-price product-margin">
										<span class="table-responsive-label">
											<?php __('Marża') ?>:
										</span>
										
										<?php
											if ($product['type'] == 0):
												echo $this->Form->input(
													'UserCart.'.$key.'.margin',
													array(
														'type'      => 'text',
														'data-type' => 'change-margin-input',
														'div'       => false,
														'label'     => false,
														'class'     => 'form-control margin-input '.($product['price_locked'] ? 'invalid' : ''),
														'value'     => number_format($product['margin'], 2, ',', '').'%',
														'disabled'  => $cart_blocked
													)
												);
											else:
												echo '-';
											endif;
										?>
										
										<?php if ($product['type'] == 0): ?>
											<span class="product-purchase-price" data-type="product-row-margin-value">
												<?php echo showPrice($product['margin_value']) ?>
											</span>
										<?php endif ?>
									</td>
									<td class="product-price product-rabat">
										<span class="table-responsive-label">
											<?php __('Rabat') ?>:
										</span>
										
										<?php
											echo $this->Form->input(
												'UserCart.'.$key.'.rabat',
												array(
													'type'      => 'text',
													'data-type' => 'change-rabat-input',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control rabat-input '.($product['price_locked'] ? 'invalid' : ''),
													'value'     => number_format($product['rabat'], 2, ',', '').'%',
													'disabled'  => $cart_blocked
												)
											)
										?>
									</td>
								<?php endif ?>
								
								<td class="product-price">
									<span class="table-responsive-label">
										<?php __('Cena') ?>:
									</span>
									
									<?php if ($product['type'] >= 1 && $product['type'] <= 4 && $product['price'] == 0): ?>
										<span class="label">
											<?php __('Gratis') ?>
										</span>
									<?php else: ?>
										<?php if (!$product['loyalty_points']): ?>
											<?php if ($product['type'] == 0 && checkEditPricesInCartAvailable()): ?>
												<?php
													echo $this->Form->input(
														'UserCart.'.$key.'.single_price',
														array(
															'type'                => 'text',
															'data-type'           => 'change-single-price-input',
															'data-purchase-price' => round($product['purchase_price'] / getCurrentCurrency('value'), getCurrencyPrecision()),
															'div'                 => false,
															'label'               => false,
															'class'               => 'form-control price-input '.($product['price_locked'] ? 'invalid' : ''),
															'value'               => showPrice($product['single_price'], false),
															'disabled'            => $cart_blocked
														)
													)
												?>
												
												<?php if ($product['purchase_price'] > 0): ?>
													<span class="product-purchase-price">
														<?php echo sprintf(__('Min.: %s', true), showPrice($product['purchase_price'])) ?>
													</span>
												<?php endif ?>
											<?php else: ?>
												<span data-type="product-row-price">
													<?php echo showPrice($product['single_price']) ?>
												</span>
												
												<?php if ($product['product_base_price'] > $product['single_price']): ?>
													<span data-type="product-row-base-price" class="base-price">
														<?php echo showPrice($product['product_base_price']) ?>
													</span>
												<?php endif ?>
											<?php endif ?>
										<?php else: ?>
											<span data-type="product-row-price">
												<?php if ($product['single_price']): ?>
													<?php echo showPrice($product['single_price']) ?>
													
													<?php if ($product['product_base_price'] > $product['single_price']): ?>
														<span class="base-price">
															<?php echo showPrice($product['product_base_price']) ?>
														</span>
													<?php endif ?>
													
													<br>
												<?php endif ?>
												
												<?php echo showProductLoyaltyPrice($product['product_id']) ?>
											</span>
										<?php endif ?>
									<?php endif ?>
								</td>
								
								<?php if (userIsSalesrep() && getDefaultPricesType() == 'netto'): ?>
									<td class="product-price product-tax-value">
										<span class="table-responsive-label">
											<?php __('VAT') ?>:
										</span>
										
										<?php
											echo $this->Form->input(
												'UserCart.'.$key.'.tax_id',
												array(
													'type'      => 'select',
													'data-type' => 'change-tax-value-select',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control '.($product['price_locked'] ? 'invalid' : ''),
													'options'   => $taxes_list,
													'value'     => $product['tax_id'],
													'disabled'  => $cart_blocked || module('KITS') && $products_fields[$product['product_id']]['Product']['kit_id'] > 0
												)
											)
										?>
									</td>
								<?php endif ?>
								
								<td class="product-price product-quantity">
									<span class="table-responsive-label">
										<?php __('Ilość') ?>:
									</span>
									
									<?php if ($product['type'] == 0): ?>
										<?php
											echo $this->Form->input(
												'UserCart.'.$key.'.quantity',
												array(
													'type'                 => 'text',
													'data-type'            => 'change-quantity-input',
													'data-step'            => getProductQuantityStep($product['product_id']),
													'data-precision'       => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
													'data-max'             => getProductQuantityInputDataMax($product['product_id'], $product['combination_id']),
													//'data-unit'            => getProductUnit($product['product_id']),
													'data-unit'            => false,
													'data-show-controls'   => 1,
													'data-trigger'         => 'cart.change.quantity',
													'div'                  => false,
													'label'                => false,
													'class'                => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
													'value'                => showQuantityValue($product['quantity']),
													'disabled'             => $cart_blocked,
													'data-tooltip'         => getCartProductWarningMessage($product),
													'data-tooltip-timeout' => 5
												)
											)
										?>
									<?php else: ?>
										<span><?php echo showQuantityValue($product['quantity'], $product['product_id']) ?></span>
									<?php endif ?>
								</td>
								<td class="product-price">
									<div class="table-responsive-label">
										<?php __('Wartość') ?>:
									</div>
									
									<span data-type="product-row-summary-price">
										<?php if (!$product['loyalty_points']): ?>
											<?php echo showPrice($product['price']) ?>
										<?php else: ?>
											<?php if ($product['single_price']): ?>
												<?php echo showPrice($product['price']) ?>
												
												<br>
											<?php endif ?>
											
											<?php echo showProductLoyaltyPrice($product['product_id'], $product['quantity'] * getProductLoyaltyPrice($product['product_id'])) ?>
										<?php endif ?>
									</span>
									
									<?php
										/* Zniżki ilościowe dla produktu */
										if (!userIsSalesrep()):
											echo $this->element(
												TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_row_quantity_discount',
												array(
													'product_id'     => $product['product_id'],
													'combination_id' => $product['combination_id'],
													'product_type'   => $product['type']
												)
											);
										endif;
									?>
								</td>
								<td class="product-price product-summary">
									<?php if ($product['type'] == 0 && !$cart_blocked): ?>
										<div class="remove">
											<?php if (canAddCommentToProductInCart($product['product_id'])): ?>
												<a data-toggle="modal" href="#EditProductCustomDescription<?php echo $key ?>" role="button" title="<?php echo h(__('Wprowadź informacje dodatkowe', true)) ?>">
													<i class="fa fa-edit"></i>
												</a>
											<?php endif ?>
											
											<?php if ($edit_offer_mode): ?>
												<a data-toggle="modal" href="#DeleteProduct<?php echo $key ?>" role="button" title="<?php echo h(__('Usuń produkt z koszyka', true)) ?>">
													<i class="fa fa-times"></i>
												</a>
												
												<a href="#" data-type="product-row-move-up" title="<?php echo h(__('Przesuń produkt w górę.', true)) ?>">
													<i class="fa fa-arrow-up"></i>
												</a>
												
												<a href="#" data-type="product-row-move-down" title="<?php echo h(__('Przesuń produkt w dół.', true)) ?>">
													<i class="fa fa-arrow-down"></i>
												</a>
											<?php else: ?>
												<a data-toggle="modal" href="#DeleteProduct<?php echo $key ?>" role="button" title="<?php echo h(__('Usuń produkt z koszyka', true)) ?>">
													<i class="fa fa-times"></i>
												</a>
											<?php endif ?>
											
											<div class="modal fade" id="DeleteProduct<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															
															<h2>
																<?php __('Usunięcie produktu z koszyka') ?>
															</h2>
														</div>
														
														<div class="modal-body">
															<p class="text-center">
																<?php __('Czy na pewno chcesz usunąć ten produkt z koszyka?') ?>
															</p>
														</div>
														
														<div class="modal-footer modal-actions">
															<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
																<?php __('Nie') ?>
															</a>
															
															<a
																class="btn-next btn btn-primary btn-lg"
																href="<?php echo $this->Html->url(getProductDeleteFromCartUrl($product)) ?>"
																data-type="delete-product-from-cart"
																data-product-id="<?php echo $product['product_id'] ?>"
																data-product-name="<?php echo h(getProductName($product['product_id'])) ?>"
																data-product-category="<?php echo h(getProductMainCategoryFullName($product['product_id'], '/')) ?>"
																data-product-brand="<?php echo h(getProductProducerName($product['product_id'])) ?>"
																data-product-variant="<?php echo h($product['combination_id'] && is_numeric($product['combination_id']) ? getCombinationName($product['combination_id']) : '') ?>"
																data-product-price="<?php echo number_format($product['single_price'], 2, '.', '') ?>"
																data-product-quantity="<?php echo (int) $product['quantity'] ?>"
															>
																<?php __('Tak') ?>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endif ?>
								
								</td>
							</tr>
							
							<?php
								/* Usługi dla produktu */
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_services',
									array(
										'services_for_products' => true,
										'key'                   => $key,
										'product_id'            => $product['product_id'],
										'combination_id'        => $product['combination_id'],
										'quantity'              => $product['quantity'],
										'width'                 => $product['width'],
										'height'                => $product['height'],
										'price'                 => getDefaultPricesType() == 'netto' ? $product['single_brutto_price'] : $product['single_price'],
										'selected_kit_products' => $product['selected_kit_products'],
										'add_time'              => $product['add_time']
									)
								)
							?>
						<?php endif ?>
					<?php endforeach ?>
					
					<?php
						/* Usługi dla koszyka */
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_services',
							array(
								'services_for_products' => false,
								'key'                   => $key + 1
							)
						)
					?>
				</tbody>
			</table>
		</div>
		
		<hr>
		
		<?php
			/* Gratisy */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_gratis_products')
		?>
		
		<?php
			/* Informacje o przysługujących zniżkach */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'bound_specials')
		?>
		
		<?php
			/* Słownik cech */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'user_cart_fields')
		?>
		
		<div class="row border-holder">
		<div class="border-hold"></div>
		<?php if (!checkOnlyVirtualProductsInCart()): ?>
			<?php $shipping_exclusions = getShippingMethodExclusionsExtended() ?>
			<div class="col-sm-6">
			<div class="shipping-section order-section">
				
				<?php
					/* Różne daty dostawy */
					echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_possible_order_dates')
				?>
				
				<div class="order-section-header">
					<h2>
						<?php __('Sposób dostawy') ?>
					</h2>
				</div>
				
				<div class="order-section-inner">
					<?php
						/* Wybór kraju dostawy */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_shipping_countries')
					?>
					
					<div class="radio-list">
						<?php $all_shipping_methods = getAllShippingMethods();?>
						<?php 
							foreach($__shipping_methods as $shipping_method_id => $shipping_method_name):
								if($descshipping = getShippingMethodDescription($shipping_method_id)):
									$desc = "<button type='button' class='btn btn-link' data-trigger='hover' data-toggle='tooltip' data-html='ture' title='".$descshipping."'><i class='fa fa-question-circle'></i></button>";
								else:
									$desc= '';
								endif;
								$__shipping_methods[$shipping_method_id]='<span class="shipping name-shipping">'.$shipping_method_name.'</span><span class="shipping desc-shipping">'.$desc.'</span>';
							endforeach;
						?>
						<?php
							/* Wybór formy dostawy */
							foreach ($__shipping_methods as $shipping_method_id => $shipping_method_name):
								$is_disabled = array_key_exists($shipping_method_id, $shipping_exclusions) && $shipping_exclusions[$shipping_method_id] != array('payment_method') ? true : false;
								
								echo $this->Form->input(
									'ShippingMethod.id',
									array(
										'type'             => 'radio',
										'data-type'        => 'change-shipping',
										'data-has-options' => isset($shipping_methods_with_options[$shipping_method_id]) ? 'true' : 'false',
										'div'              => array(
											'tag'     => 'div',
											'class'   => $is_disabled ? 'radio hide' : 'radio'
										),
										'options'          => array(
											$shipping_method_id => $shipping_method_name
										),
										'checked'          => $shipping_method_id == getCartShippingMethodId() && !$is_disabled ? true : false,
										'disabled'         => $cart_blocked && !userIsSalesrep() && !getCartUserCartOfferId() || $is_disabled,
										'hiddenField'      => false
									)
								);
							endforeach;
						?>
					</div>
					
					<?php
						/* Dropshipping */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_dropshipping')
					?>
					
					<?php
						/* Darmowa dostawa za punkty */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_loyalty_free_shipping')
					?>
					
					<?php
						/* Powiadomienie SMS */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_sms_notice')
					?>
					
					<?php
						/* Dostawa produktu z listy prezentów */
						echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_gift_list_shipping')
					?>
				</div>
				
				<div class="order-section-summary">
					<?php __('Dostawa: ')?>
					<?php if (module('B2B') && checkIsNoCalculateShippingMethod(getCartShippingMethodId())): ?>
						<span data-type="cart-shipping-price">-</span>
					<?php elseif (userIsSalesrep()): ?>
						<?php
							echo $this->Form->input(
								'shipping_method_price',
								array(
									'div'       => false,
									'label'     => false,
									'data-type' => 'cart-shipping-price-input',
									'class'     => 'cart-cost',
									'value'     => showShippingPriceInCart(getDefaultPricesType(), false),
									'disabled'  => $cart_blocked
								)
							)
						?>
					<?php elseif (!(array_key_exists(getCartShippingMethodId(), $shipping_exclusions) && $shipping_exclusions[getCartShippingMethodId()] != array('payment_method'))): ?>
						<span data-type="cart-shipping-price"><?php echo showShippingPriceInCart(getDefaultPricesType()) ?></span>
					<?php else: ?>
						<span data-type="cart-shipping-price">-</span>
					<?php endif ?>
				</div>
			</div>
			</div>
		<?php endif ?>
		<div class="col-sm-6">
		<div class="payment-section order-section">
			<?php
				/* Informacja o niedostępności pobraniowej formy płatności */
				echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_virtual_products_info')
			?>
			
			<div class="order-section-header">
				<h2>
					<?php __('Forma płatności') ?>
				</h2>
			</div>
			
			<?php
				/* Bon zakupowy */
				echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_voucher')
			?>
			<?php 
			foreach ($__payment_methods as $payment_method_id => $payment_method_name):
				if($descshiping = getPaymentMethodDescription($payment_method_id)):
					$desc = '<button type="button" class="btn btn-link" data-trigger="click" data-toggle="tooltip" data-html="ture" title="'.$descshiping.'"><i class="fa fa-question-circle"></i></button>';
				else:
					$desc= '';
				endif;
				$__payment_methods[$payment_method_id] = '<span class="shipping name-shipping">'.$payment_method_name.'</span><span class="shipping desc-shipping">'.$desc.'</span>';
			endforeach;
				?>
			<div class="order-section-inner">
				<div class="radio-list">
					<?php foreach ($__payment_methods as $payment_method_id => $payment_method_name): ?>
						<?php
							$is_disabled = in_array($payment_method_id, $payment_exclusions);
							
							echo $this->Form->input(
								'PaymentMethod.id',
								array(
									'type'        => 'radio',
									'data-type'   => 'change-payment',
									'div'         => 'radio',
									'options'     => array(
										$payment_method_id => $payment_method_name
									),
									'checked'     => $payment_method_id == getCartPaymentMethodId() && !$is_disabled ? true : false,
									'disabled'    => $cart_blocked && !userIsSalesrep() && !getCartUserCartOfferId() || $is_disabled,
									'hiddenField' => false
								)
							);
							
							if (getCartPaymentTermAvailable($payment_method_id)):
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_payment_method_term', array(
										'payment_method_id' => $payment_method_id
									)
								);
							endif;
						?>
						
						<?php if (!empty($payment_method_options[$payment_method_id])): ?>
							<div class="radio payment-method-options form form-inline <?php echo !($payment_method_id == getCartPaymentMethodId() && !$is_disabled) ? 'hide' : '' ?>" data-type="payment-method-options" data-payment-method-id="<?php echo $payment_method_id ?>">
								<?php
									foreach ($payment_method_options[$payment_method_id] as $payment_method_option):
										echo $this->Form->input(
											'PaymentMethodOption.id',
											array(
												'type'        => 'radio',
												'data-type'   => 'change-payment-option',
												'div'         => 'radio',
												'options'     => array(
													$payment_method_option['id'] => $payment_method_option['name']
												),
												'data-img'    => $payment_method_option['img'],
												'data-name'   => $payment_method_option['name'],
												'checked'     => $payment_method_option['id'] == getCartPaymentMethodOptionId() && !$is_disabled ? true : false,
												'disabled'    => $cart_blocked && !userIsSalesrep() && !getCartUserCartOfferId() || $is_disabled || $payment_method_id != getCartPaymentMethodId(),
												'hiddenField' => false
											)
										);
									endforeach;
								?>
							</div>
						<?php endif ?>
						
						<?php if ($payment_method_id == setting('MODULE_BLUE_MEDIA_PAY_FOR_ME_PAYMENT_METHOD_ID')): ?>
							<div class="form <?php echo !($payment_method_id == getCartPaymentMethodId() && !$is_disabled) ? 'hide' : '' ?>" data-type="payment-method-blue-media-pay-for-me" data-payment-method-id="<?php echo $payment_method_id ?>">
								<?php
									echo $this->Form->input(
										'BlueMediaPayForMe.email',
										array(
											'type'        => 'text',
											'div'         => 'form-row',
											'label'       => __('Adres e-mail', true).':',
											'class'       => 'form-control',
											'value'       => getCartBlueMediaPayForMeData('email'),
											'placeholder' => __('Podaj adres e-mail osoby, która ma opłacić zamówienie', true)
										)
									);
									
									echo $this->Form->input(
										'BlueMediaPayForMe.content',
										array(
											'type'    => 'textarea',
											'div'     => 'form-row',
											'label'   => __('Treść wiadomości', true).':',
											'class'   => 'form-control',
											'value'   => getCartBlueMediaPayForMeData('content'),
											'default' => getUpdatedSystemEmailText(__("Cześć.\nWłaśnie złożyłem zamówienie w sklepie #global_store_name#. Proszę wejdź na poniższy link i dokonaj za mnie płatności.", true), null)
										)
									);
								?>
							</div>
						<?php endif ?>
					<?php endforeach ?>
					
					<?php
						echo $this->Form->hidden(
							'cod',
							array(
								'data-type' => 'cart-cod',
								'value'     => (int) isCodInCart(),
								'disabled'  => true
							)
						)
					?>
				</div>
				
				<?php
					/* Dropshipping */
					echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_dropshipping_amount')
				?>
			</div>
		</div>
		</div>
		</div>
		<?php
			/* Informacja o darmowej dostawie */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_free_shipping_info')
		?>
		
		<?php
			/* Kupon rabatowy */
			if ($next_step_available && !$edit_offer_mode):
				echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_coupon');
				
				echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'loyalty_payment');
			endif;
		?>
		
		<?php
			/* Zniżki ilościowe */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_full_packages_discount')
		?>
		
		<?php
			/* Źródła zamówień */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'order_source')
		?>
		
		<?php
			/* Status zamówienia */
			echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'order_status')
		?>
		
		<?php if (!(getCartIsOffer() && getCartIsAnyOfferUnion())): ?>
			<div class="cart-summary order-summary">
				<h2>
					<?php __('Podsumowanie zamówienia') ?>
				</h2>
				
				<table class="order-summary-table table-flat">
					<?php if (getDefaultPricesType() == 'netto'): ?>
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma netto') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span data-type="cart-total-netto-price"><?php echo showPrice(getCartPriceToPay('netto')) ?></span>
							</td>
						</tr>
						<tr>
							<td class="summary-label">
								<?php __('VAT') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-total-vat"><?php echo showPrice(getCartVatValue()) ?></span>
							</td>
						</tr>
						
						<?php if ($coupon = getCartCoupon()): ?>
							<tr>
								<td class="summary-label">
									<?php __('Rabat') ?>:
								</td>
								<td class="summary-value">
									<span data-type="cart-coupon-price"><?php echo showPrice($coupon['value']) ?></span>
								</td>
							</tr>
						<?php endif ?>
						
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma brutto') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span data-type="cart-base-price"><?php echo showPrice(getCartBasePrice()) ?></span>
							</td>
						</tr>
						
						<?php if ($voucher = getCartVoucher()): ?>
							<tr>
								<td class="summary-label">
									<?php echo sprintf(__('Bon "%s"', true), $voucher['name']) ?>:
								</td>
								<td class="summary-value">
									<span data-type="cart-voucher-price"><?php echo showPrice((-1) * $voucher['price']) ?></span>
								</td>
							</tr>
						<?php endif ?>
						
						<?php if (setting('MODULE_CREDIT_DECREASE_NEXT_ORDER_WITH_CURRENT_EXCESS')): ?>
							<?php $credit_payment = getCartCreditPayment() ?>
							
							<tr data-type="cart-credit-payment-toogle" class="<?php echo !$credit_payment ? 'hide' : '' ?>">
								<td class="summary-label">
									<?php __('Kredyt kupiecki') ?>:
								</td>
								<td class="summary-value">
									<span data-type="cart-credit-payment"><?php echo showPrice((-1) * $credit_payment) ?></span>
								</td>
							</tr>
						<?php endif ?>
						
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Do zapłaty') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span data-type="cart-total-price"><?php echo showPrice(getCartPriceToPay()) ?></span>
							</td>
						</tr>
					<?php else: ?>
						<tr>
							<td class="summary-label">
								<?php __('Koszt produktów') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-base-price"><?php echo showPrice(getCartSumProductsPrice()) ?></span>
							</td>
						</tr>
						<tr>
							<td class="summary-label">
								<?php __('Koszt dostawy') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-shipping-price"><?php echo showShippingPriceInCart(getDefaultPricesType()) ?></span>
							</td>
						</tr>
						<tr>
							<td class="summary-label">
								<?php __('Rabat') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-coupon-price">
									<?php echo ($coupon = getCartCoupon())? showPrice($coupon['value']) : showPrice(0); ?>
								</span>
							</td>
						</tr>
						<?php if ($voucher = getCartVoucher()): ?>
							<tr>
								<td class="summary-label">
									<?php echo sprintf(__('Bon "%s"', true), $voucher['name']) ?>:
								</td>
								<td class="summary-value">
									<span data-type="cart-voucher-price"><?php echo showPrice($voucher['price']) ?></span>
								</td>
							</tr>
						<?php endif ?>
						
						<?php if (setting('MODULE_CREDIT_DECREASE_NEXT_ORDER_WITH_CURRENT_EXCESS')): ?>
							<?php $credit_payment = getCartCreditPayment() ?>
							
							<tr data-type="cart-credit-payment-toogle" class="<?php echo !$credit_payment ? 'hide' : '' ?>">
								<td class="summary-label">
									<?php __('Kredyt kupiecki') ?>:
								</td>
								<td class="summary-value">
									<span data-type="cart-credit-payment"><?php echo showPrice((-1) * $credit_payment) ?></span>
								</td>
							</tr>
						<?php endif ?>
						<tr class="<?php echo (($delete_loyalty_points = getCartDeletePoints()) && getLoggedUserId()) ? '' : 'hide' ?>" data-type="cart-point-delete-toggle">
							<td class="summary-label">
								<?php __('Punkty wykorzystane') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-point-delete"><?php echo $delete_loyalty_points ?></span>
							</td>
						</tr>
						<tr class="<?php echo ($add_loyalty_points = getCartAddPoints()) ? '' : 'hide' ?>" data-type="cart-point-add-toggle">
							<td class="summary-label">
								<?php __('Punkty przyznane') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-point-add"><?php echo $add_loyalty_points ?></span>
							</td>
						</tr>
						<tr class="<?php echo ($shipping_method_time = anticipateCartDeliveryTime(true, setting('GLOBAL_ORDER_SEND_DATE_BORDER_TIME'), true)) ? '' : 'hide' ?>" data-type="cart-shipping-time-toggle">
							<td class="summary-label">
								<?php __('Planowana data doręczenia') ?>:
							</td>
							<?php $date=strtotime("+".$shipping_method_time." days")?>
							<td class="summary-value">
								<span data-type="cart-shipping-time"><?php echo showDate(date('d-m-Y', $date)) ?></span>
							</td>
						</tr>
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span data-type="cart-total-price"><?php echo showPrice(getCartPriceToPay()) ?></span>
							</td>
						</tr>
					<?php endif ?>
					
					<?php if (userIsSalesrep()): ?>
						<tr>
							<td class="summary-label">
								<?php __('Marża') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-margin-sum"><?php echo showPrice(getCartMarginSum()) ?></span>
							</td>
						</tr>
					<?php endif ?>
				</table>
				
				<?php
					/* Zagiel Raty */
					echo $this->element(
						TEMPLATE_NAME.DS.'zagiel',
						array(
							'price' => getCartPriceToPay(),
							'show'  => getCartPaymentMethodId() == setting('MODULE_ZAGIEL_PAYMENT_METHOD_ID') ? true : false
						)
					)
				?>
				
				<?php
					/* Raty BGŻ BNP Paribas */
					echo $this->element(
						TEMPLATE_NAME.DS.'paribas',
						array(
							'price' => getCartPriceToPay(),
							'show'  => getCartPaymentMethodId() == setting('MODULE_SYGMA_PAYMENT_METHOD_ID') ? true : false
						)
					)
				?>
				
				<?php
					/* PlatformaFinansowa - i-Raty */
					echo $this->element(
						TEMPLATE_NAME.DS.'platforma_finansowa',
						array(
							'price' => getCartPriceToPay(),
							'show'  => in_array(getCartPaymentMethodId(), explode(',', setting('MODULE_PLATFORMA_FINANSOWA_I_RATY_PAYMENT_METHOD_ID')))
						)
					)
				?>
				
				<?php
					/* Raty Credit Agricole */
					echo $this->element(
						TEMPLATE_NAME.DS.'credit_agricole',
						array(
							'price' => getCartPriceToPay(),
							'show'  => in_array(getCartPaymentMethodId(), explode(',', setting('MODULE_CREDIT_AGRICOLE_PAYMENT_METHOD_ID')))
						)
					)
				?>
			</div>
		<?php endif ?>
		
		<div class="order-actions form-actions link-action">
			<?php if (!$edit_offer_mode): ?>
				<?php if (setting('GLOBAL_RESIGNATION_READ_CHECKBOX') && isAnyNotVirtualProductInCart()):?>
					<?php
						echo $this->Form->input(
							'Setting.registration_read_agreement',
							array(
								'type'          => 'checkbox',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row checkbox align-input',
								'label'         => __('Oświadczam, że zostałem poinformowany o prawie konsumenta do odstąpienia od umowy w okresie 14 dni od wydania przedmiotu umowy. Zostałem poinformowany, że poniosę koszt dostarczenia zwracanych przedmiotów do Sprzedającego.', true)
							)
						)
					?>
					<div class="clearfix"></div>
				<?php endif ?>
				
				<?php if (setting('GLOBAL_NO_RESIGNATION_WHEN_DOWNLOADABLE_PRODUCTS_CHECKBOX') && isAnyVirtualProductInCart()): ?>
					<?php
						echo $this->Form->input(
							'Setting.downloadable_products_agreement',
							array(
								'type'          => 'checkbox',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row checkbox align-input',
								'label'         => __('Składając zamówienie na produkty cyfrowe, zgadzam się, że jego zawartość zostanie mi udostępniona natychmiast, w związku z czym tracę prawo do odstąpienia w tym zakresie od umowy zawartej na odległość, bez podania przyczyny i bez ponoszenia kosztów do 14 dni od momentu wydania rzeczy.', true)
							)
						)
					?>
				<?php endif ?>
			<?php endif ?>
			
			<?php if ($next_step_available && !$is_offer): ?>
				<?php if (setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID') && !getLoggedUserId()): ?>
					<div data-type="paypal-express-checkout-true" class="<?php echo getCartPaymentMethodId() != setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID') ? 'hide' : '' ?>">
						<?php if (setting('GLOBAL_REGISTER_CONDITIONS_CONFIRMATION_REQUIRED')): ?>
							<?php
								echo $this->Form->input(
									'NewUser.regulamin',
									array(
										'type'          => 'checkbox',
										'data-validate' => 'validate(required)',
										'div'           => 'form-row checkbox align-input required',
										'label'         => sprintf(
											__('Przeczytałem/am i akceptuję %s.', true),
											$this->Html->link(
												sprintf(
													__('Regulamin %s', true), setting('GLOBAL_STORE_NAME')
												),
												getStaticPageUrl(getStaticPageConditionsId()),
												array(
													'target' => '_blank'
												)
											)
										)
									)
								)
							?>
						<?php endif ?>
						
						<?php if (setting('GLOBAL_REGISTER_PROCESSING_USER_DATA_CONFIRMATION_REQUIRED')): ?>
							<?php
								echo $this->Form->input(
									'NewUser.personal_data',
									array(
										'type'          => 'checkbox',
										'data-validate' => 'validate(required)',
										'div'           => 'form-row checkbox align-input required',
										'label'         => sprintf(
											__('Wyrażam zgodę na przetwarzanie moich danych osobowych w celu rejestracji konta i realizacji zamówienia przez sklep internetowy %s prowadzony przez %s z siedzibą w: %s, która jest administratorem danych osobowych. Zgodnie z Ustawą z dnia 29.08.1997 r. każdy Klient ma prawo wglądu do swoich danych, ich poprawiania, zarządzania, zaprzestania przetwarzania oraz zażądania ich usunięcia. Podanie danych jest dobrowolne, ale brak zgody uniemożliwia założenie konta i realizację zamówienia.', true),
											setting('GLOBAL_STORE_NAME'),
											setting('GLOBAL_STORE_COMPANY'),
											setting('GLOBAL_STORE_POSTCODE').' '.setting('GLOBAL_STORE_CITY').', '.setting('GLOBAL_STORE_STREET')
										)
									)
								)
							?>
						<?php endif ?>
					</div>
				<?php endif ?>
			<?php endif ?>
			
			<?php if ($next_step_errors): ?>
				<div class="message info">
					<?php __('UWAGA: oferta zawiera następujące pozycje') ?>:<br/><br/>
					
					<?php echo implode('<br/>', $next_step_errors) ?>
				</div>
			<?php endif ?>
			
			<?php if (getCartUserCartOfferId()): ?>
				<a class="btn-back btn btn-link btn-lg" data-toggle="modal" href="#CloseOffer" role="button" title="<?php echo h(__('Zamknij ofertę', true)) ?>">
					<?php __('Zamknij ofertę') ?>
				</a>
				
				<div class="modal fade" id="CloseOffer" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								
								<h2>
									<?php __('Zamknięcie oferty') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<p class="text-center">
									<?php __('Czy na pewno chcesz zamknąć ofertę?') ?>
								</p>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Nie') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getCartCloseOfferUrl()) ?>">
									<?php __('Tak') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<a class="btn-back btn btn-pink btn-lg" href="<?php echo $this->Html->url('/') ?>" title="<?php echo h(__('Strona główna', true)) ?>">
					<?php __('Kontynuuj zakupy') ?>
				</a>
			<?php endif ?>
			
			<?php if ($can_save_cart): ?>
				<?php if ($next_step_available && !$is_offer): ?>
					<?php if (setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID')): ?>
						<input data-type="paypal-express-checkout-true" class="btn-next <?php echo getCartPaymentMethodId() != setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID') ? 'hide' : '' ?>" type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png"/>
						
						<input data-type="paypal-express-checkout-false" class="btn-next btn btn-primary btn-lg <?php echo getCartPaymentMethodId() == setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID') ? 'hide' : '' ?>" type="submit" value="<?php echo h(__('Dalej', true)) ?>">
					<?php else: ?>
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Dalej', true)) ?>">
					<?php endif ?>
				<?php endif ?>
				
				<?php if ($edit_offer_mode): ?>
					<?php
						$send_offer_id = getCartUserCartId();
						
						if ($user_cart_offer):
							$send_offer_id .= '-'.$user_cart_offer['id'];
						endif;
					?>
					
					<a class="btn btn-primary btn-lg btn-next btn-save-cart" data-toggle="modal" href="#SendOffer<?php echo $send_offer_id ?>" role="button" title="<?php echo h(__('Wyślij ofertę', true)) ?>">
						<?php __('Wyślij ofertę') ?>
					</a>
					
					<a class="btn btn-lg btn-next btn-save-cart btn-link" data-toggle="modal" data-tooltip-set="true" href="#SaveOffer<?php echo $send_offer_id ?>" role="button" title="<?php echo h(__('Zapisz ofertę', true)) ?>">
						<i class="fa fa-floppy-o" aria-hidden="true"></i>
					</a>
				<?php endif ?>
				
				<a class="btn btn-lg btn-next btn-save-cart btn-link" data-toggle="modal" data-tooltip-set="true" href="#CartSave" role="button" title="<?php echo h($edit_offer_mode ? __('Zapisz jako koszyk', true) : __('Zapisz koszyk', true)) ?>">
					<i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
				</a>
				
				<?php if (userIsSalesrep() && module('OFFERS')): ?>
					<a class="btn btn-lg btn-next btn-save-cart btn-link" data-toggle="modal" data-tooltip-set="true" href="#SaveOffer" role="button" title="<?php echo h($edit_offer_mode ? __('Skopiuj ofertę', true) : __('Stwórz ofertę', true)) ?>">
						<i class="fa fa-files-o" aria-hidden="true"></i>
					</a>
				<?php endif ?>
			<?php elseif (getCartUserCartOfferId()): ?>
				<?php if ($next_step_available && !$is_offer): ?>
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Akceptuj i zamów', true)) ?>">
				<?php endif ?>
				
				<a class="btn btn-primary btn-lg btn-next btn-save-cart" href="<?php echo $this->Html->url(getAcceptOfferUrl()) ?>" title="<?php echo h(__('Akceptuj ofertę', true)) ?>">
					<?php __('Akceptuj') ?>
				</a>
				
				<a class="btn btn-lg btn-next btn-save-cart" data-toggle="modal" href="#RejectOffer" role="button" title="<?php echo h(__('Odrzuć ofertę', true)) ?>">
					<?php __('Odrzuć ofertę') ?>
				</a>
			<?php else: ?>
				<?php if ($next_step_available && !$is_offer): ?>
					<?php if (setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID')): ?>
						<input data-type="paypal-express-checkout-false" class="btn-next btn btn-primary btn-lg btn-block <?php echo getCartPaymentMethodId() == setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID') ? 'hide' : '' ?>" type="submit" value="<?php echo h(__('Do kasy', true)) ?>">
						
						<input data-type="paypal-express-checkout-true" class="btn-next paypal-express-checkout <?php echo getCartPaymentMethodId() != setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID') ? 'hide' : '' ?>" type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png"/>
					<?php else: ?>
						<input class="btn-next btn btn-primary btn-lg btn-block" type="submit" value="<?php echo h(__('Kupuję i płacę', true)) ?>">
					<?php endif ?>
				<?php endif ?>
			<?php endif ?>
		</div>
		
		<?php if (!getCartUserCartOfferId()): ?>
			<?php if ($edit_offer_mode || getCartName()): ?>
				<div class="clear-cart">
					<a data-toggle="modal" href="#CloseCart" role="button" data-tooltip-set="true" title="<?php echo h($edit_offer_mode ? __('Wyjdź z oferty', true) : __('Opuść koszyk', true)) ?>">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
					</a>
				</div>
			<?php endif ?>
			
			<?php
				/* B2B - czyszczenie koszyka */
				echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_clear')
			?>
		<?php endif ?>
		
		<?php
			echo $this->Form->input(
				'Redirect.stay',
				array(
					'type'      => 'hidden',
					'data-type' => 'cart-reload',
					'value'     => 1,
					'disabled'  => true
				)
			)
		?>
	<?php echo $this->Form->end() ?>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => $is_offer ? __('Twoja oferta jest pusta', true) : __('Twój koszyk jest pusty.', true)
			)
		)
	?>
	
	<?php if (userIsSalesrep()): ?>
		<div class="cart-add-product-button">
			<a class="btn btn-primary" data-toggle="modal" title="<?php echo h(__('Dodaj produkt', true)) ?>" href="#AddProductToCart" role="button" <?php echo $cart_blocked ? 'disabled' : '' ?>>
				<?php __('Dodaj produkt') ?>
			</a>
		</div>
	<?php endif ?>
<?php endif ?>

<?php
	/* Gratisy */
	if ($products_gratis = getCartGratisProductsForAmountsList()):
		echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'product_cart_gratis', array('products_gratis'=>$products_gratis));
	endif;
?>

<?php
	/* Udostępnienie koszyka */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_url')
?>

<?php
	/* Import koszyka */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_import')
?>

<?php
	/* Zapis koszyka */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_save')
?>

<?php
	/* Stworzenie oferty */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'save_offer')
?>

<?php
	/* Wyjście z oferty */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'close_cart')
?>

<?php
	/* Odrzucenie oferty */
	if (getCartUserCartOfferId()):
		echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'reject_offer');
	endif;
?>

<?php
	/* UPS */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_ups')
?>

<?php
	/* Dodawnie produktu */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_add_product')
?>

<?php
	/* Edycja zdjęcia głównego produktów */
	echo $this->element(
		TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'edit_image',
		array(
			'products_photos'    => isset($products_photos) ? $products_photos : array(),
			'cominations_photos' => isset($cominations_photos) ? $cominations_photos : array()
		)
	)
?>

<?php
	/* Wysłanie oferty */
	if ($edit_offer_mode):
		echo $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'send_offer',
			array(
				'offer'                => array(
					'UserCart' => array(
						'id' => getCartUserCartId()
					)
				),
				'user_cart_offer'      => $user_cart_offer,
				'default_current_user' => true
			)
		);
		
		echo $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'save_offer',
			array(
				'offer'                => array(
					'UserCart' => array(
						'id' => getCartUserCartId()
					)
				),
				'user_cart_offer'      => $user_cart_offer,
				'default_current_user' => true
			)
		);
	endif;
?>
<script>
$(window).click(function() {
	$('.shipping.desc-shipping .btn').tooltip('hide')
	});

	$('.shipping.desc-shipping .btn').click(function(event){
	    event.stopPropagation();
	});
$($('.shipping.desc-shipping .btn')).click(function() {
		$('.shipping.desc-shipping .btn').not(this).tooltip('hide')
		});

		$('.shipping.desc-shipping .btn').not(this).click(function(event){
		    event.stopPropagation();
		});	
</script>
<?php
	/* Słownik cech - formularze do dodawania cech */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'new_user_cart_field_value_form')
?>

<?php
	/* Edycja informacji dodatkowych produktu */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_product_custom_description')
?>

<?php
	/* Edycja nazwy produktu */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_product_name')
?>

<?php
	/* Dołączanie atrybutów */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'attributes')
?>

<?php
	/* Sortowanie produktów */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'sort_products')
?>

<?php
	/* Edycja nazwy oferty */
	echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'edit_offer_name')
?>