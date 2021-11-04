<div class="order-list-page order-page order-show-page page">
	
	
	<div class="page-header">
		<h1>
			<?php echo sprintf(__('Oferta nr %s - "%s"', true), $offer_number, $name) ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content">
		<?php if ($user_cart_offer): ?>
			<div class="shipping-address-section order-section">
				<div class="order-section-header">
					<h2>
						<?php __('Oferta sporządzona przez') ?>
					</h2>
				</div>
				
				<div class="order-section-inner">
					<?php
						echo '<strong>'.$user_cart_offer['UserCart']['username'].'</strong><br/>';
						echo setting('GLOBAL_STORE_COMPANY').'<br/>';
						echo setting('GLOBAL_STORE_STREET').', '.setting('GLOBAL_STORE_POSTCODE').' '.setting('GLOBAL_STORE_CITY').'<br/>';
						echo __('NIP', true).': '.setting('GLOBAL_STORE_NIP').'<br/>';
						
						if (setting('MODULE_INVOICE_SHOW_SELLER_REGON') && setting('GLOBAL_STORE_REGON')):
							echo __('REGON', true).': '.setting('GLOBAL_STORE_REGON').'<br/>';
						endif;
						
						echo __('Telefon', true).': '.setting('GLOBAL_CONTACT_PHONE_1').'<br/>';
					?>
				</div>
			</div>
			
			<hr>
			
			<div class="shipping-address-section order-section">
				<div class="order-section-header">
					<h2>
						<?php __('Oferta dla') ?>
					</h2>
				</div>
				
				<div class="order-section-inner">
					<?php
						echo '<strong>'.$user_cart_offer['UserCartOffer']['name'].'</strong><br/>';
						
						if ($user_cart_offer['UserCartOffer']['address']):
							echo $user_cart_offer['UserCartOffer']['address'].'<br/>';
						endif;
						
						if ($user_cart_offer['UserCartOffer']['phone']):
							echo __('Telefon', true).': '.$user_cart_offer['UserCartOffer']['phone'].'<br/>';
						endif;
						
						echo __('E-mail', true).': '.$user_cart_offer['UserCartOffer']['email'].'<br/>';
					?>
				</div>
			</div>
			
			<hr class="no-border" />
		<?php endif ?>
		
		<?php if ($products): ?>
			<div class="product-section order-section">
				<?php $count_columns = count($selected_columns) ?>
				
				<table class="cart-table product-table offer-table offer-show-table <?php echo ($count_columns > 14) ? 'smaller' : '' ?>">
					<thead>
						<tr class="product-header">
							<?php foreach ($selected_columns as $column): ?>
								<th class="product-header-<?php echo str_replace('_', '-', $column) ?>">
									<?php echo $columns[$column] ?>
								</th>
							<?php endforeach ?>
						</tr>
					</thead>
					
					<tbody>
						<?php
							$current_offer_union   = null;
							$current_product_label = null;
							
							/* Grupowe pobranie zdjęć produktów */
							$products_photos    = getProductsMainPhotos(Set::extract($products, '{n}.product_id'));
							$cominations_photos = getCombinationsPhotos(Set::extract($products, '{n}.combination_id'));
							
							/* Pobranie informacje o tym czy produkty są widoczne */
							$products_visible = getProductsAreVisible(Set::extract($products, '{n}.product_id'));
							
							/* Grupowe pobranie informacji o produktach */
							$products_fields = getProductsFields(
								Set::extract($products, '{n}.product_id'),
								array(
									'Product.name',
									'`Producer`.`name`',
									'`Producer`.`logo`',
									'`InventoryAvailibilityStatus`.`id`'
								),
								array(
									'Producer',
									'InventoryAvailibilityStatus'
								)
							);
							
							$inventory_statuses = getInventoryAvailibilityStatusesList(null, false);
							
							/* Grupowe pobranie atrybutów */
							$possible_attributes = array();
							
							foreach ($selected_columns as $column):
								if (strpos($column, 'attribute:') === 0):
									if (is_numeric($attribute_id = str_replace('attribute:', '', $column))):
										$possible_attributes[] = $attribute_id;
									endif;
								endif;
							endforeach;
							
							if ($possible_attributes):
								$products_attribute_values = array();
								
								foreach (array_unique(Set::extract($products, '{n}.product_id')) as $product_id):
									$products_attribute_values[] = array(
										'Product' => array(
											'id' => $product_id
										)
									);
								endforeach;
								
								$products_attribute_values = addProductsAttributeValues($products_attribute_values, $possible_attributes);
							endif;
						?>
						
						<?php foreach ($products as $key => $product): ?>
							<?php
								$product_url      = getProductUrl($product['product_id']);
								$product_name     = strlen($product['product_name']) > 0 ? $product['product_name'] : $products_fields[$product['product_id']]['Product']['name'];
								$combination_name = is_numeric($product['combination_id']) && $product['combination_id'] > 0 ? getCombinationName($product['combination_id']) : '';
							?>
							
							<?php if (strlen($product['label']) > 0 && $current_product_label != $product['label']): ?>
								<tr class="product-row product-label-row product-label-label">
									<td colspan="<?php echo count($selected_columns) ?>">
										<h2>
											<?php echo $product['label'] ?>
										</h2>
									</td>
								</tr>
								
								<?php $current_product_label = $product['label'] ?>
							<?php endif ?>
							
							<?php if ($product['offer_union'] && $current_offer_union != $product['offer_union']): ?>
								<tr class="product-row <?php echo strlen($product['label']) > 0 ? 'product-label-row' : '' ?> offer-union-row offer-union-label">
									<td colspan="<?php echo count($selected_columns) ?>">
										<h2>
											<?php echo $product['offer_union_name'] ?>
										</h2>
									</td>
								</tr>
								
								<?php $current_offer_union = $product['offer_union'] ?>
							<?php endif ?>
							
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
							
							<tr class="product-row <?php echo $class ?>">
								<?php foreach ($selected_columns as $column): ?>
									<?php if ($column == 'lp'): ?>
										<td class="product-lp">
											<?php echo $product['number'] ?>.
										</td>
									<?php elseif ($column == 'photo'): ?>
										<td class="product-image">
											<span class="preload-image" data-loaded="false">
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
													);
												?>
											</span>
										</td>
									<?php elseif ($column == 'name'): ?>
										<td class="product-data">
											<div class="name">
												<?php if ($products_visible[$product['product_id']]): ?>
													<a href="<?php echo $this->Html->url($product_url) ?>" title="<?php echo h($product_name) ?>">
														<?php echo $product_name ?>
													</a>
												<?php else: ?>
													<span>
														<?php echo $product_name ?>
													</span>
												<?php endif ?>
												
												<?php if ($product['custom_description'] || $product['attributes']): ?>
													<br>
													
													<span class="combination-name">
														<?php
															if ($product['custom_description']):
																echo nl2br(htmlspecialchars_decode(htmlspecialchars_decode($product['custom_description'])));
															endif;
															
															if ($product['attributes']):
																if ($product['custom_description']):
																	echo '<br/>';
																endif;
																
																$attributes = array();
																
																foreach ($product['attributes'] as $attribute_name => $attribute_values):
																	$attributes[] = $attribute_name.': '.implode(', ', $attribute_values);
																endforeach;
																
																echo implode(' | ', $attributes);
															endif;
														?>
													</span>
												<?php endif ?>
											</div>
										</td>
									<?php elseif ($column == 'combination'): ?>
										<td class="product-data">
											<div class="name">
												<?php if (!empty($combination_name)): ?>
													<span class="combination-name">
														<?php echo $combination_name ?>
													</span>
												<?php else: ?>
													-
												<?php endif ?>
											</div>
										</td>
									<?php elseif ($column == 'code'): ?>
										<td class="product-code">
											<span class="table-responsive-label">
												<?php __('Kod produktu') ?>:
											</span>
											
											<?php echo $product['code'] ? $product['code'] : '-' ?>
										</td>
									<?php elseif ($column == 'producer'): ?>
										<td class="product-data">
											<div class="name">
												<span>
													<?php
														if ($producer = isset($products_fields[$product['product_id']]) ? $products_fields[$product['product_id']]['Producer']['name'] : null):
															echo $producer;
														else:
															echo '-';
														endif;
													?>
												</span>
											</div>
										</td>
									<?php elseif ($column == 'producer_logo'): ?>
										<td class="product-image">
											<span class="preload-image" data-loaded="false">
												<?php
													echo $this->element(
														'_default'.DS.'miniature',
														array(
															'file'  => array(
																'type'     => configuration('Producer.dir'),
																'filename' => isset($products_fields[$product['product_id']]) ? $products_fields[$product['product_id']]['Producer']['logo'] : null,
																'dir'      => ''
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
											</span>
										</td>
									<?php elseif ($column == 'availibility'): ?>
										<td class="product-data">
											<div class="name">
												<span class="combination-name">
													<?php
														if ($product['combination_id'] && is_numeric($product['combination_id'])):
															echo getCombinationInventoryAvailibilityStatusName($product['combination_id']);
														else:
															echo $inventory_statuses[$products_fields[$product['product_id']]['InventoryAvailibilityStatus']['id']];
														endif;
													?>
												</span>
											</div>
										</td>
									<?php elseif ($column == 'suggested_netto_price'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo showPrice($product['suggested_netto_price'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'suggested_brutto_price'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo showPrice($product['suggested_brutto_price'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'rabat'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo $product['rabat'] ? number_format($product['rabat'], 2, ',', '').'%' : '-' ?>
											</span>
										</td>
									<?php elseif ($column == 'netto_price'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo showPrice($product['single_price'] / (1 + $product['tax_value'] / 100), true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'brutto_price'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo showPrice($product['single_price'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'vat'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php
													if ($product['Tax']['released']):
														__('zw');
													elseif ($product['Tax']['excluded']):
														__('np');
													else:
														if (($product['tax_value'] * 100) % 100 > 0):
															echo number_format($product['tax_value'], 2, ',', '').'%';
														else:
															echo $product['tax_value'].'%';
														endif;
													endif;
												?>
											</span>
										</td>
									<?php elseif ($column == 'quantity'): ?>
										<td class="product-price product-quantity">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<?php echo showQuantityValue($product['quantity'], $product['product_id']) ?>
										</td>
									<?php elseif ($column == 'suggested_netto_value'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo showPrice($product['suggested_netto_value'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'suggested_brutto_value'): ?>
										<td class="product-price">
											<span class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</span>
											
											<span>
												<?php echo showPrice($product['suggested_brutto_value'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'netto_value'): ?>
										<td class="product-price product-summary">
											<div class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</div>
											
											<span>
												<?php echo showPrice($product['netto_price'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'vat_value'): ?>
										<td class="product-price product-summary">
											<div class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</div>
											
											<span>
												<?php echo showPrice($product['vat_value'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif ($column == 'brutto_value'): ?>
										<td class="product-price product-summary">
											<div class="table-responsive-label">
												<?php echo ucfirst($columns[$column]) ?>:
											</div>
											
											<span>
												<?php echo showPrice($product['brutto_price'], true, $currency['Currency']['code']) ?>
											</span>
										</td>
									<?php elseif (strpos($column, 'attribute:') === 0): ?>
										<?php
											/* Atrybut - #18663 */
											$attribute_id = str_replace('attribute:', '', $column);
											
											$product_attribute_value = array();
											
											foreach ($products_attribute_values as $products_attribute_value):
												if ($products_attribute_value['Product']['id'] == $product['product_id']):
													if (isset($products_attribute_value['AttributeValue'][$attribute_id])):
														$product_attribute_value = Set::extract($products_attribute_value['AttributeValue'][$attribute_id], '{n}.attribute_value_name');
													endif;
													
													break;
												endif;
											endforeach;
										?>
										
										<td class="product-data">
											<div class="name">
												<span>
													<?php echo $product_attribute_value ? implode(', ', $product_attribute_value) : '-' ?>
												</span>
											</div>
										</td>
									<?php endif ?>
								<?php endforeach ?>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			
			<hr>
			
			<div class="shipping-section order-section">
				<div class="order-section-header">
					<h2>
						<?php __('Dostawa') ?>
					</h2>
				</div>
				
				<div class="order-section-inner">
					<h3>
						<?php echo $offer['UserCart']['shipping_method'] ?>
					</h3>
				</div>
				
				<div class="order-section-summary">
					<span>
						<?php echo showPrice($offer['UserCart']['shipping_method_price'], true, $currency['Currency']['code']) ?>
					</span>
				</div>
			</div>
			
			<hr>
			
			<div class="payment-section order-section">
				<div class="order-section-header">
					<h2>
						<?php __('Forma płatności') ?>
					</h2>
				</div>
				
				<div class="order-section-inner">
					<h3>
						<?php echo $offer['UserCart']['payment_method'] ?>
					</h3>
				</div>
				
				<div class="order-section-summary">
					<span>
						<?php echo showPrice($offer['UserCart']['payment_method_price'], true, $currency['Currency']['code']) ?>
					</span>
				</div>
			</div>
			
			<?php foreach ($user_cart_fields as $user_cart_field_name => $user_cart_field_value): ?>
				<hr>
				
				<div class="order-section">
					<div class="order-section-header">
						<h2>
							<?php echo $user_cart_field_name ?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<h3>
							<?php echo $user_cart_field_value ?>
						</h3>
					</div>
				</div>
			<?php endforeach ?>
			
			<hr>
			
			<?php if (isset($summary) && $summary): ?>
				<div class="cart-summary order-summary">
					<h2>
						<?php __('Podsumowanie') ?>
					</h2>
					
					<table class="order-summary-table table-flat">
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma netto') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span data-type="cart-total-netto-price">
									<?php echo showPrice($offer_netto_value, true, $currency['Currency']['code']) ?>
								</span>
							</td>
						</tr>
						<tr>
							<td class="summary-label">
								<?php __('VAT') ?>:
							</td>
							<td class="summary-value">
								<span data-type="cart-total-vat">
									<?php echo showPrice($offer_vat_value, true, $currency['Currency']['code']) ?>
								</span>
							</td>
						</tr>
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma brutto') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span data-type="cart-total-price">
									<?php echo showPrice($offer_brutto_value, true, $currency['Currency']['code']) ?>
								</span>
							</td>
						</tr>
					</table>
				</div>
				
				<hr>
			<?php endif ?>
			
			<?php if ($user_cart_offer && userIsSalesrep()): ?>
				<div class="payment-section order-section">
					<div class="order-section-header">
						<h2>
							<?php __('Uwagi') ?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<?php echo $user_cart_offer['UserCartOffer']['comments'] ? nl2br($user_cart_offer['UserCartOffer']['comments']) : '-' ?>
					</div>
				</div>
				
				<hr>
			<?php endif ?>
			
			<div class="order-actions form-actions">
				<a class="btn-back btn btn-lg" href="javascript: history.back()" title="<?php echo h(__('Powrót', true)) ?>">
					<?php __('Powrót') ?>
				</a>
				
				<?php if (userIsSalesrep()): ?>
					<?php if ($offer['UserCart']['can_edit']): ?>
						<a class="btn btn-primary btn-lg btn-next" data-toggle="modal" href="#EditOffer<?php echo $offer['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Edytuj ofertę', true)) ?>">
							<?php __('Edytuj ofertę') ?>
						</a>
					<?php endif ?>
				<?php elseif ($user_cart_offer_id): ?>
					<?php if ($can_confirm_offer): ?>
						<a class="btn btn-primary btn-lg btn-next" href="<?php echo $this->Html->url(getOfferConfirmUrl($offer['UserCart']['id'], $user_cart_offer_id)) ?>" title="<?php echo h(__('Realizuj ofertę', true)) ?>">
							<?php __('Realizuj ofertę') ?>
						</a>
					<?php endif ?>
				<?php endif ?>
			</div>
			
			<?php if (userIsSalesrep()): ?>
				<?php
					/* Dialogi do edycji oferty */
					echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'edit_offer')
				?>
			<?php endif ?>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Nie znaleziono żadnych produktów w wybranej ofercie.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>