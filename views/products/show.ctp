<?php
	$is_sellable       = !module('INVENTORY') || $product['InventoryAvailibilityStatus']['sellable'] || checkCanAddNotSellableProductToCart() ? true : false;
	$price             = getProductPrice($product['Product']['id'], (int) get('combination_id'));
	$advices           = null;
	$show_availibility = module('B2B') ? (setting('MODULE_B2B_SHOW_AVAILABILITY_TO_NOT_LOGGED_USERS') ? true : (getLoggedUserId() ? true : false)) : (setting('MODULE_INVENTORY_SHOW_AVAILIBILITY') ? true : false);
?>

<div class="product-page page" itemscope itemtype="http://data-vocabulary.org/Product">
	<div class="page-content">
		<div class="top-holder">
		<div class="product-column left">
			<?php
				$gallery = getProductGallery($product['Product']['id'], true, true);
				
				echo $this->element(
					TEMPLATE_NAME.DS.'product'.DS.'gallery',
					array(
						'product_id'   => $product['Product']['id'],
						'product_name' => $product['Product']['name'],
						'gallery'      => $gallery
					)
				);
				
				echo $this->element(
					TEMPLATE_NAME.DS.'product'.DS.'gallery_youtube',
					array(
						'product_id'         => $product['Product']['id'],
						'product_name'       => $product['Product']['name'],
						'gallery'            => getProductYoutubeGallery($product['Product']['id']),
						'gallery_indicators' => count($gallery) > 1 ? 1 : 0
					)
				);
			?>
			<div class="product-labels <?php echo count($gallery) > 1 ? '' : 'less'?>">
				<?php if (isset($price['base_price']) && !$price['sale_id']): ?>
					<div class="product-label promotion">
						<?php __('Promocja') ?>
					</div>
				<?php endif ?>
				
				<?php if (isset($price['base_price']) && $price['sale_id']): ?>
					<div class="product-label sale">
						<?php __('Wyprzedaż') ?>
					</div>
				<?php endif ?>
				
				<?php if ($product['Product']['new']): ?>
					<div class="product-label new">
						<?php __('Nowość') ?>
					</div>
				<?php endif ?>
				
				<?php if (checkIsBestseller($product['Product']['id'])): ?>
					<div class="product-label bestseller">
						<?php __('Bestseller') ?>
					</div>
				<?php endif ?>
				<?php $custom_labels = getProductAttributeValue($product['Product']['id'], 181, true) ?>
				<?php foreach($custom_labels as $key => $elem): ?>
					<div class="product-label custom attr-<?php echo $key ?>">
						<?php echo $elem['attribute_value_name'] ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		
		<div class="product-column right">
			<div class="product-header page-header">
				<h1>
					<span itemprop="name"><?php echo $product['Product']['name'] ?></span>
				</h1>
				
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'product'.DS.'kit_product_list',
						array(
							'kit_products' => isset($kit_products) ? $kit_products : array()
						)
					)
				?>
			</div>
			
			<div class="producer-availibility">
				<?php if ($product['Producer']['name']): ?>
					<?php __('Producent: ')?>
					<a href="<?php echo $this->Html->url(getProducerProductsUrl($product['Producer']['id'])) ?>" title="<?php echo h($product['Producer']['name']) ?>">
						<span itemprop="brand"><?php echo $product['Producer']['name'] ?></span>
					</a>
				<?php endif ?>
				<?php if ($product['Product']['code']): ?>
					<span class="separator">|</span>
					<?php __('Kod produktu: ')?><span data-type="product-code"><?php echo $product['Product']['code'] ?></span>
				<?php endif ?>
			</div>
			<div class="clearfix"></div>
			
			<?php if ($is_sellable): ?>
				<?php if (userAccessToPrice()): ?>
					<div class="product-price" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
						<meta itemprop="currency" content="<?php echo getCurrentCurrency('code') ?>"/>
						<meta itemprop="condition" content="new"/>
						<meta itemprop="availability" content="<?php echo $google_availability_meta ?>"/>
						<meta itemprop="price" content="<?php echo number_format($price['price'], 2, '.', '') ?>"/>
						
						<?php $user_points = getUserLoyaltyPointsSum(getLoggedUserId()) ?>
						
						<?php if ($user_points > 0 && setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && ($loyalty_product_points = getProductLoyaltyPrice($product['Product']['id'])) && $loyalty_product_points < $user_points): ?>
							<ul id="homeSelectPriceMenu" class="nav nav-tabs price-selection" role="tablist" data-type="add-to-cart-loyalty">
								<li role="presentation" class="active">
									<a href="#zakup-zwykly" id="zakup-zwykly-tab" role="tab" data-toggle="tab" aria-controls="zakup-zwykly" aria-expanded="true" class="btn">
										<?php __('Zakup zwykły') ?>
									</a>
								</li>
								<li role="presentation">
									<a href="#zakup-za-punkty" role="tab" id="zakup-za-punkty-tab" data-toggle="tab" aria-controls="zakup-za-punkty" class="btn">
										<?php __('Zakup za punkty') ?>
									</a>
								</li>
							</ul>
						<?php endif ?>
						
						<?php $netto = getDefaultPricesType() == 'netto' ?>

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="zakup-zwykly" aria-labelledBy="zakup-zwykly-tab">
								<div class="product-price-row brutto">
									<span class="price-label">
										<strong><?php __('Cena brutto') ?>:</strong>
									</span>
									<?php if ($price['price'] || !setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') || !$price['price'] && setting('GLOBAL_ORDERS_WITH_ZERO_PRICE_PRODUCTS') && (setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && getProductLoyaltyPrice($product['Product']['id']) === null) || !setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES')): ?>
										<?php
											$price_data_type      = 'product-price';
											$base_price_data_type = 'product-base-price';
											
											if ($netto):
												$price_data_type      = 'product-netto-price';
												$base_price_data_type = 'product-base-netto-price';
											endif;
										?>
										
										<?php if (isset($price['base_price'])): ?>
											<span class="price new-price" data-type="<?php echo $price_data_type ?>">
												<?php echo showPrice($price['price']) ?>
											</span>
											
											<span class="base-price" data-type="<?php echo $base_price_data_type ?>">
												<?php echo showPrice($price['base_price']) ?>
											</span>
										<?php else: ?>
											<span class="price" data-type="<?php echo $price_data_type ?>">
												<?php echo showPrice($price['price']) ?>
											</span>
											
											<span class="base-price" data-type="<?php echo $base_price_data_type ?>"></span>
										<?php endif ?>
									<?php else: ?>
										<span data-type="product-price">-</span>
									<?php endif ?>
								</div>
								
								
									<div class="product-price-row netto">
										<span class="price-label">
											<?php __('Cena netto') ?>:
										</span>
										
										<?php
											$data_type = 'product-netto-price';
											$base_data_type = 'product-base-netto-price';
											
										?>
										<?php if (isset($price['base_price'])): ?>
											<span class="price netto-price" data-type="<?php echo $data_type ?>">
												<?php echo showPrice($price['netto_price']) ?>
											</span>
											<span class="base-price netto-price" data-type="<?php echo $base_data_type ?>">
												<?php echo showPrice($price['netto_base_price']) ?>
											</span>
										<?php else:?>
											<span class="price netto-price" data-type="<?php echo $data_type ?>">
												<?php echo showPrice($price['netto_price']) ?>
											</span>
											
											<span class="base-price netto-price" data-type="<?php echo $base_data_type ?>"></span>
										<?php endif;?>
									</div>
								
							</div>
							
							<?php if (isset($loyalty_product_points) && $loyalty_product_points > 0 && $user_points > $loyalty_product_points): ?>
								<div role="tabpanel" class="tab-pane fade" id="zakup-za-punkty" aria-labelledBy="zakup-za-punkty-tab">
									<div class="product-price-row">
										<span class="price-label">
											<?php __('Cena punktowa') ?>:
										</span>
										
										<span class="price">
											<?php echo showProductLoyaltyPrice($product['Product']['id']) ?>
										</span>
									</div>
									
									<div class="product-price-row loyalty-price">
										<span class="price-label">
											<?php __('Stan konta') ?>:
										</span>
										
										<span class="price netto-price">
											<?php echo showProductLoyaltyPrice($product['Product']['id'], $user_points) ?>
										</span>
									</div>
									
									<div class="product-price-row loyalty-price">
										<span class="price-label">
											<?php __('Punkty po zakupie') ?>:
										</span>
										
										<span class="price netto-price">
											<?php echo showProductLoyaltyPrice($product['Product']['id'], ($user_points - $loyalty_product_points)) ?>
										</span>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
					
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'zagiel',
							array(
								'price' => $price['price'],
								'show'  => true
							)
						)
					?>
					
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'paribas',
							array(
								'price' => $price['price'],
								'show'  => true
							)
						)
					?>
					
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'platforma_finansowa',
							array(
								'price' => $price['price'],
								'show'  => true
							)
						)
					?>
					
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'credit_agricole',
							array(
								'price' => $price['price'],
								'show'  => true
							)
						)
					?>
				<?php else: ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => sprintf(
									__('Cena widoczna tylko dla zalogowanych użytkowników. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
								),
								'no_close' => true
							)
						)
					?>
				<?php endif ?>
				
				<?php if ($gratis_for_products = getGratisForProductProduct($product['Product']['id'])): ?>
				<?php foreach ($gratis_for_products as $from_quantity => $gratis_products): ?>
					<div class="gratis-products-section">
							<ul class="gratis-products-list product-list small">
								<?php $i = 1;?>
								<?php foreach ($gratis_products as $gratis_product): ?>
									<li>
										<div class="product-box small">
											<a href="#ProductGratisModal<?php echo $gratis_product['product_id'] ?>" data-toggle="modal" title="<?php echo h($gratis_product['product_name']) ?>" role="button">
												<span class="product-image preload-image" data-loaded="true">
													<?php
														echo $this->element(
															'_default'.DS.'miniature',
															array(
																'file'  => array(
																	'type'     => configuration('ProductMedium.dir'),
																	'filename' => isset($gratis_product['product_image']) ? $gratis_product['product_image'] : getProductMainPhotoId($gratis_product['product_id'], 'filename'),
																	'dir'      => isset($gratis_product['product_image_dir']) ? $gratis_product['product_image_dir'] : getProductMainPhotoId($gratis_product['product_id'], 'dir')
																),
																'image' => array(
																	'resize'     => 'resize',
																	'width'      => 90,
																	'height'     => 90,
																	'no_photo'   => true,
																	'watermark'  => $gratis_product['product_id'],
																	'background' => array(
																		'R' => 255,
																		'G' => 255,
																		'B' => 255
																	)
																),
																'html'  => array(
																	'image' => array(
																		'alt' => h($gratis_product['product_name'])
																	)
																)
															)
														)
													?>
												</span>
											</a>
											<?php if($i==1):?>
												<p>
													<span><?php __('Gratis do produktu') ?></span>
													<?php echo $from_quantity == 1 ? '' : sprintf(__('(przy zakupie %s produktów)', true), showQuantityValue($from_quantity, $product['Product']['id'])) ?>
												</p>
											<?php endif;?>
											<a class="product-name" href="#ProductGratisModal<?php echo $gratis_product['product_id'] ?>" data-toggle="modal" title="<?php echo h($gratis_product['product_name']) ?>" role="button">
												<?php echo $gratis_product['product_name']?>
											</a>
										</div>
									</li>
									<?php $i++;?>
								<?php endforeach ?>
							</ul>
					</div>
					
					<div class="clearfix"></div>
				<?php endforeach ?>
			<?php endif ?>
			
			<?php if($zestawy = getKitsForProduct($product['Product']['id'])):?>
				<div class="kit-product-hold">
				<div class="kits-products">
					<p><?php __('Kup w zestawie')?></p>
					<?php $i=1;?>
					<?php $count = count($zestawy)?>
					<?php foreach ($zestawy as $zestaw):?>
						<?php if($i==2):?><div class="more-kit" id="morekit"><?php endif;?>
						<div class="kit-prod-holder">
						<div class="hold">
						<div class="main-kit">
							<span class="product-image preload-image">
							<?php
								echo $this->element(
									'_default'.DS.'miniature',
									array(
										'file'  => array(
											'type'     => configuration('ProductMedium.dir'),
											'filename' => isset($product['ProductMedium'][0]['ProductMedium']['filename']) ? $product['ProductMedium'][0]['ProductMedium']['filename'] : false,
											'dir'      => isset($product['ProductMedium'][0]['ProductMedium']['dir']) ? $product['ProductMedium'][0]['ProductMedium']['dir'] : false,
										),
										'image' => array(
											'resize'     => 'resize',
											'width'      => 270,
											'height'     => 270,
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
												'alt' => !empty($product['ProductMedium'][0]['ProductMedium']['title']) ? h($product['ProductMedium'][0]['ProductMedium']['title']) : h($product['Product']['name'])
											)
										)
									)
								)
							?>
							</span>
							<div class="product-name"><?php echo $product['Product']['name'] ?></div>
						</div>
						<?php foreach($zestaw['Product'] as $product_kit):?>
							<a class="product-kit" href="<?php echo $this->Html->url(getProductUrl($product_kit['id']))?>" title="<?php echo h($product_kit['name'])?>">
								<span class="product-image preload-image">
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => isset($product_kit['filename']) ? $product_kit['filename'] : false,
												'dir'      => isset($product_kit['filename_dir']) ? $product_kit['filename_dir'] : false,
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 270,
												'height'     => 270,
												'no_photo'   => true,
												'watermark'  => $product_kit['id'],
												'blazy'      => true,
												'background' => array(
													'R' => 255,
													'G' => 255,
													'B' => 255
												)
											),
											'html'  => array(
												'image' => array(
													'alt' => !empty($product_kit['filename_title']) ? h($product_kit['filename_title']) : h($product_kit['name'])
												)
											)
										)
									)
								?>
								</span>
								<div class="product-name"><?php echo $product_kit['name'] ?></div>
							</a>
						<?php endforeach;?>
						</div>
						<div class="summary">
							<div class="product-price-container">
								<?php $price_kit = getProductPrice($zestaw['Kit']['id'])?>
								<?php if (isset($price_kit['base_price'])):?>
									<div class="discount-price"><?php echo showPrice($price_kit['price'])?></div>
									<span class="base-price"><?php echo showPrice($price_kit['base_price'])?></div>
								<?php else:?>
									<div class="price"><?php echo showPrice($price_kit['price'])?></div>
								<?php endif;?>
							</div>
							<a class="btn btn-grey btn-block" href="<?php echo $this->Html->url(getProductAddToCartUrl($zestaw['Kit']['id']))?>" title="<?php echo h(__('Do koszyka', true))?>"><i class="sprite sprite-koszyk"></i> <?php __('Do koszyka')?></a>
							<a class="btn btn-link" href="<?php echo $this->Html->url(getProductUrl($zestaw['Kit']['id']))?>" title="<?php echo h($zestaw['Kit']['name'])?>"><?php __('Zobacz zestaw')?> <i class="fa fa-angle-right"></i></a>
						</div>
						</div>
						<?php if($i>1 && $i==$count):?></div><?php endif;?>
						<?php $i++;?>
					<?php endforeach;?>
				</div>
				<?php if($count>1):?>
					<a href="#morekit" data-type="toggle" class="btn btn-link more_kit" title="<?php echo __('więcej zestawów')?>">
						<span class="show-filt"><span>+</span> <?php __('Więcej zestwów')?></span>
						<span class="hide-filt"><span>-</span> <?php __('Mniej zestawów')?></span>
					</a>
				<?php endif;?>
				</div>
			<?php endif;?>
				<?php $nothing = (!$zestawy && !$gratis_for_products && !$variants)? 'nothing' : '';?>
				<?php if (userAccessToAddToCart()): ?>
					<?php if (!$product['Product']['only_kit'] && !$product['Product']['only_gratis']): ?>
						<?php
							echo $this->Form->create(
								'UserCart',
								array(
									'url'             => getProductAddToCartUrl($product['Product']['id'], array('from' => 'cart'), null, null, true),
									'class'           => 'product-options form '.$nothing,
									'data-type'       => 'product-form',
									'data-product-id' => $product['Product']['id']
								)
							)
						?>
							<?php
								if ($variants):
									if (module('B2B') && setting('GLOBAL_PRODUCT_PAGE_USER_CART_QTY')):
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'variants_with_quantity',
											array(
												'variants'   => $variants,
												'product_id' => $product['Product']['id']
											)
										);
									else:
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'variants',
											array(
												'product_id' => $product['Product']['id']
											)
										);
									endif;
								endif;
								
								if (isset($kit_variants) && $kit_variants):
									echo $this->element(
										TEMPLATE_NAME.DS.'product'.DS.'kit_variants',
										 array(
											'kit_variants'          => $kit_variants,
										 	'extended_kit_variants' => $extended_kit_variants
										)
									);
								endif;
								
								if (isset($loyalty_product_points) && $loyalty_product_points > 0 && $user_points > $loyalty_product_points):
									/* Dla wartości 1 dodawane za punkty, dla wartości 0 dodawane za kasę */
									echo $this->Form->input(
										'UserCart.add_to_cart_by_loyalty',
										array(
											'type'      => 'hidden',
											'data-type' => 'add-to-cart-by-loyalty',
											'value'     => 0
										)
									);
								endif;
							?>
							<table class="product-attributes table-flat">
								<?php foreach ($product['AttributeValue'] as $attribute): ?>
									<?php if ($attribute['leading']): ?>
										<tr>
											<td>
												<?php if ($attribute['description']): ?>
													<?php echo $attribute['name'] ?>
													
													<a data-toggle="modal" href="#AttributeDescription<?php echo $attribute['id'] ?>" role="button" title="<?php echo h($attribute['name']) ?>">
														<i class="fa fa-info-circle"></i>
													</a>
													
													<div class="modal fade" id="AttributeDescription<?php echo $attribute['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	
																	<h2>
																		<?php echo $attribute['name'] ?>
																	</h2>
																</div>
																
																<div class="modal-body">
																	<?php echo $attribute['description'] ?>
																</div>
															</div>
														</div>
													</div>
												<?php else: ?>
													<?php echo $attribute['name'] ?>:
												<?php endif ?>
											</td>
											<td>
												<?php if (count($attribute['elements']) == 1): ?>
													<?php $attribute = reset($attribute['elements']) ?>
													
													<strong>
														<?php if ($attribute['indexable'] == 1): ?>
															<a href="<?php echo $this->Html->url(getAttributeValueCanonicalLink(array(), $attribute['ProductsAttributeValue']['attribute_value_id'])) ?>" target="_blank"><?php echo $attribute['ProductsAttributeValue']['name'] ?></a>
														<?php else: ?>
															<?php echo $attribute['ProductsAttributeValue']['name'] ?>
														<?php endif ?>
													</strong>
												<?php else: ?>
													<ul>
														<?php foreach ($attribute['elements'] as $element): ?>
															<li>
																<strong>
																	<?php if ($element['indexable'] == 1): ?>
																		<a href="<?php echo $this->Html->url(getAttributeValueCanonicalLink(array(), $element['ProductsAttributeValue']['attribute_value_id'])) ?>"><?php echo $element['ProductsAttributeValue']['name'] ?></a>
																	<?php else: ?>
																		<?php echo $element['ProductsAttributeValue']['name'] ?>
																	<?php endif ?>
																</strong>
															</li>
														<?php endforeach ?>
													</ul>
												<?php endif ?>
											</td>
										</tr>
									<?php endif ?>
								<?php endforeach ?>
				
								<?php if ($show_availibility): ?>
									<tr>
										<td>
											<?php __('Dostępność') ?>:
										</td>
										<td>
											<?php if ($availibility_description = getInventoryAvailibilityStatusDescription($product['InventoryAvailibilityStatus']['id'])): ?>
												<a data-toggle="modal" href="#AvailabilityDescription" role="button">
													<span data-type="product-availability"><?php echo $availibility_status ?></span>
												</a>
												
												<?php
													echo $this->element(
														TEMPLATE_NAME.DS.'product'.DS.'availability',
														array(
															'name'        => $availibility_status,
															'description' => $availibility_description
														)
													)
												?>
											<?php else: ?>
												<span data-type="product-availability"><?php echo $availibility_status ?></span>
											<?php endif ?>
										</td>
									</tr>
								<?php endif ?>
								
								<?php if (userAccessToProductQuantity() && !$variants): ?>
									<tr>
										<td>
											<?php __('Stan magazynowy') ?>:
										</td>
										<td>
											<?php echo showQuantityValue(getScheduledProductQuantity($product['Product']['id']), $product['Product']['id']) ?>
										</td>
									</tr>
								<?php endif ?>
								
								
								
								<?php if ($is_sellable && !canDownloadProduct($product['Product']['id'])): ?>
									<tr>
										<td>
											<?php __('Dostawa od') ?>:
										</td>
										<td>
											<?php echo showPrice(getProductMinShippingPrice($product['Product']['id'], getDefaultPricesType())) ?> <a data-toggle="modal" href="#ShippingMethods" role="button" title="<?php echo h(__('Koszty dostawy', true)) ?>"><?php __('zobacz wszystkie') ?></a>
										</td>
									</tr>
								<?php endif ?>
								<?php if ($is_sellable && ($delivery_time = anticipateProductDeliveryTime($product['Product']['id']))): ?>
									<tr>
										<td>
											<?php __('Wysyłka') ?>:
										</td>
										<td>
											<?php 
											if ($product['InventoryAvailibilityStatus']['sellable'] == 0):
											__('Ustalana indywidualnie');
											elseif ($product['InventoryAvailibilityStatus']['id'] == 10):
											__('3-4 dni');
											else:
											if($product['InventoryAvailibilityStatus']['id'] == 25):
											__('do 28 dni');
											elseif ($product['InventoryAvailibilityStatus']['id'] == 26):
											__('do 8 tygodni');
											else:
											if($product['InventoryAvailibilityStatus']['id'] == 27):
											__('do 5 tygodni');
											else:
											__('w ciągu 48h');
											endif;
											endif;
											/*
											 if (date('G') < 12):
											 __('Jeszcze dziś !');
											 else:
											 __('Już jutro!');
											 endif;
											 */
											endif;
											?>
										</td>
									</tr>
								<?php endif ?>
								<?php if ($is_sellable && $price['price'] && setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && $product['Product']['loyalty_points_addition'] > 0): ?>
									<tr>
										<td>
											<?php __('Punkty za zakup') ?>:
										</td>
										<td>
											<strong><?php echo showProductLoyaltyPrice($product['Product']['id'], $product['Product']['loyalty_points_addition']) ?></strong>
										</td>
									</tr>
									<tr>
										<td>
											<?php __('Cena punktowa') ?>:
										</td>
										<td>
											<strong><?php echo showProductLoyaltyPrice($product['Product']['id']) ?></strong>
										</td>
									</tr>
								<?php endif ?>
								
								<?php if ($suggested_price = getProductSuggestedPrice($product['Product']['id'])): ?>
									<tr>
										<td>
											<?php __('Cena katalogowa') ?>:
										</td>
										<td>
											<strong><?php echo showPrice($suggested_price) ?></strong>
										</td>
									</tr>
								<?php endif ?>
								
								<?php if (isset($supply_date) && !$is_sellable): ?>
									<tr>
										<td>
											<?php __('Planowana data dostępności') ?>:
										</td>
										<td>
											<strong><?php echo showDate($supply_date) ?></strong>
										</td>
									</tr>
								<?php endif ?>
								
								<?php if (!$is_sellable && ($last_availibilty = getProductLastAvailibiltyDate($product['Product']['id']))): ?>
									<tr>
										<td>
											<?php __('Ostatnio dostępny') ?>:
										</td>
										<td>
											<strong><?php echo showDate($last_availibilty) ?></strong>
										</td>
									</tr>
								<?php endif ?>
								
								<?php if ($is_sellable && $product['Sizing']['id'] && $product['Sizing']['file']): ?>
									<tr>
										<td>
											<?php __('Tabela rozmiarów') ?>:
										</td>
										<td>
											<a href="<?php echo getSizingFileUrl($product['Sizing']['file']) ?>" title="<?php echo h(__('Tabela rozmiarów', true)) ?>" target="_blank">
												<strong><?php echo $product['Sizing']['name'] ?></strong>
											</a>
										</td>
									</tr>
								<?php endif ?>
							</table>
							<?php if ((setting('GLOBAL_PRODUCT_PAGE_USER_CART_QTY')) || (module('SURFACES') && $product['Product']['surface'])): ?>
								<div class="product-quantity product-surfaces">
									<?php
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'surfaces',
											array(
												'surfaces' => module('SURFACES') ? $product['Product']['surface'] : false
											)
										)
									?>
									
									<?php
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'quantity',
											array(
												'has_variants' => $variants ? true : false,
												'product_id'   => $product['Product']['id']
											)
										)
									?>
								</div>
							<?php endif ?>
							
							<?php if ($product['Product']['min_order'] > 1): ?>
								<div class="quantity-discount-product-page">
									<div class="discount-type">
										<?php __('Sprzedawane po') ?>:
									</div>
									<div class="discount-description black">
										<table>
											<tr>
												<td>
													<?php echo showQuantityValue($product['Product']['min_order'], $product['Product']['id']) ?>
												</td>
											</tr>
										</table>
									</div>
								</div>
							<?php endif ?>
							
							<div  class="product-actions button-hold">
								<div class="button-holder on-up">
								<button class="product-add-cart btn btn-primary <?php echo getProductExcludedForUser($product['Product']['id']) ? 'disabled' : '' ?>" type="submit"><i class="sprite sprite-koszyk"></i> <?php echo h(getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true)) ?></button>
								</div>
							</div>
							
							<?php
								/* Zniżki ilościowe dla produktu */
								echo $this->element(
									TEMPLATE_NAME.DS.'product'.DS.'quantity_discount',
									array(
										'product_id'     => $product['Product']['id']
									)
								)
							?>
							<?php if (getNotAvailableProductCombinations($product['Product']['id'])): ?>
								<div class="unavailable-variants">
									<a class="btn btn-grey" href="#UnavailableVariants" data-toggle="modal"><?php __('Powiadom o dostępności wariantu') ?> <i class="fa fa-angle-right"></i></a>
								</div>
							<?php endif ?>
							<div class="product-services-container" data-type="product-services-container">
								<?php if (module('SERVICES') && !$product['Product']['has_combinations']): ?>
									<?php
										echo $this->element(
											TEMPLATE_NAME.DS.'product'.DS.'services',
											array(
												'product_id'     => $product['Product']['id'],
												'combination_id' => getPageParamValue('combination_id')
											)
										)
									?>
								<?php endif ?>
							</div>
							
							<?php if (canAddCommentToProductInCart($product['Product']['id'])): ?>
								<div class="more-information">
									<h3>
										<?php __('Dodatkowe informacje do produktu') ?>
									</h3>
									
									<?php
										echo $this->Form->input(
											'description',
											array(
												'div'   => false,
												'label' => false,
												'type'  => 'textarea',
												'class' => 'form-control'
											)
										)
									?>
								</div>
							<?php endif ?>
						<?php echo $this->Form->end() ?>
					<?php elseif ($product['Product']['only_kit']): ?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'product'.DS.'product_kit_list',
								array(
									'products' => getKitsForProduct($product['Product']['id'])
								)
							)
						?>
					<?php endif ?>
				<?php else: ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => sprintf(
									__('Produkt może zostać zakupiony tylko przez zalogowanych użytkowników. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
								),
								'no_close' => true
							)
						)
					?>
				<?php endif ?>
			<?php else: ?>
				<?php
					echo $this->Form->create(
						'AvailibilityNotification',
						array(
							'url'             => getProductAddToAvailibilityNotificationUrl($product['Product']['id']),
							'class'           => 'product-unavailable-form form',
							'data-submit'     => 'once',
							'data-product-id' => $product['Product']['id'],
							'data-type'       => 'product-unavailable-form'
						)
					)
				?>
					<div class="product-unavailable-label">
						<?php __('Pozycja niedostępna') ?>
					</div>
					
					<?php
						echo $this->Form->hidden(
							'product_id',
							array(
								'value' => $product['Product']['id']
							)
						)
					?>
					
					<p class="text-muted">
						<?php __('Jeżeli chcesz dostać powiadomienie gdy pozycja będzie dostępna podaj swój e-mail.') ?>
					</p>
					
					<?php if ($product['Product']['has_combinations']): ?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'product'.DS.'unavailable_variants',
								array(
									'product_id' => $product['Product']['id']
								)
							)
						?>
					<?php endif ?>
					
					<div class="form-inline">
						<?php
							echo $this->Form->input(
								'email',
								array(
									'type'        => 'email',
									'div'         => false,
									'label'       => false,
									'class'       => 'form-control',
									'value'       => getUserEmail(),
									'placeholder' => __('Wpisz swój e-mail', true)
								)
							)
						?>
						
						<input class="btn btn-primary btn-form-size" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
			<?php 
				echo $this->element(
					TEMPLATE_NAME.DS.'product'.DS.'social_sharing',
					array(
							'product'            => $product
					)
					);
			?>
			
			
		</div>
		</div>
		<?php  $banner = getBannersForSection($section_id = 12, $category_id=null, $producer_id=null, $product_id = $product['Product']['id']); ?>
		<?php if ($banner): ?>
			<div class="product-column clear">
				<div class="product-banner banners">
					
					<?php echo $this->Html->image($banner['Info']['image_path'].DS.$banner['Data']['Banner'][0]['Banner']['filename']); ?>
				</div>
			</div>
		<?php endif;  ?>
		<div class="product-column clear">
			<?php
				$product_tabs = array();
				
				/* Zakładka opis produktu */
				if (trim(Sanitize::html($product['Product']['description'])) || checkProductHasAnyVisibleAttribute($product['Product']['id'])):
					$product_tabs[] = array(
						'name'    => __('Opis produktu', true),
						'id'      => 'opis',
						'element' => 'description',
						'data'    => array(
							'name'          => $product['Product']['name'],
							'description'   => $product['Product']['description'],
							'attributes'    => $product['AttributeValue'],
							'product_media' => $product['ProductMedium'],
							'kit_products'  => !empty($kit_products) ? $kit_products : array(),
							'hide_leading'  => true,
							'product_id'    => $product['Product']['id'],
							'is_expensive'  => getProductAttributeValue($product['Product']['id'], 263) ? true : false
						)
					);
				endif;
				
				/* Zakładka 'Do pobrania' */
				if ($attachments = getProductAttachments($product['Product']['id'])):
					$product_tabs[] = array(
						'name'    => __('Do pobrania', true),
						'id'      => 'do-pobrania',
						'element' => 'attachments',
						'data'    => array(
							'attachments' => $attachments
						)
					);
				endif;
				
				if ($is_sellable):
					/* Zakładka 'Tabela rozmiarów' */
					if ($product['Sizing']['id'] && !$product['Sizing']['file']):
						$product_tabs[] = array(
							'name'    => __('Tabela rozmiarów', true),
							'id'      => 'Sizing',
							'element' => 'sizing',
							'data'    => array(
							)
						);
					endif;
					
					/* Zakładka 'Porady' */
					if ($advices = getSidebarAdvice('Product', 'show', $product['Product']['id'], true)):
						$product_tabs[] = array(
							'name'    => __('Porady', true),
							'id'      => 'Advices',
							'element' => 'advices',
							'data'    => array(
								'advices' => $advices
							)
						);
					endif;
				endif;
				
				/* Zakładka 'Opinie' */
				if (module('OPINIONS')):
					$product_tabs[] = array(
						'name'    => __('Opinie', true),
						'id'      => 'opinie',
						'element' => 'opinions',
						'data'    => array(
							'product_id' => $product['Product']['id']
						)
					);
				endif;
				
				if ($is_sellable):
				
					/* Zakładka 'Poleć produkt' */
					$product_tabs[] = array(
						'name'    => __('Poleć produkt', true),
						'id'      => 'RecommendProduct',
						'element' => 'recommend',
						'data'    => array(
								'product_id' => $product['Product']['id']
						)
					);
				
					/* Zakładka 'Zapytaj o produkt' */
					$product_tabs[] = array(
						'name'    => __('Zapytaj o produkt', true),
						'id'      => 'AskProduct',
						'element' => 'ask',
						'data'    => array(
							'product_id' => $product['Product']['id']
						)
					);
				endif;
				$product_tabs[] = array(
						'name'    => __('Reklamacja i wymiana', true),
						'id'      => 'Reclamation',
						'element' => 'reclamation',
						'data'    => array(
								'product_id' => $product['Product']['id']
						)
				);
			?>
			<a class="responsive-toggle" data-type="toggle" href="#ProductTabs">
				<?php __('Szczegóły') ?>
			</a>
			<?php if (count($product_tabs) > 1): ?>
				<ul class="product-tabs tabs" id="ProductTabs">
					<?php foreach ($product_tabs as $tab): ?>
						<li class="<?php echo $tab == reset($product_tabs) ? 'active' : '' ?>">
							<a href="#<?php echo $tab['id'] ?>" title="<?php echo h($tab['name']) ?>">
								<?php echo $tab['name'] ?> <i class="fa fa-angle-right"></i>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
			
			<div class="product-tab-content tab-content">
				<?php foreach ($product_tabs as $tab): ?>
					<div class="product-tab-pane tab-pane <?php echo $tab == reset($product_tabs) ? 'active' : '' ?>" id="<?php echo $tab['id'] ?>">
						<?php echo $this->element(TEMPLATE_NAME.DS.'product'.DS.$tab['element'], $tab['data']) ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
</section>
</div>
</div>
</div>
<hr class="no-mrg" />
<div class="container">
<div>
<section class="main-content sidebar-left-false">
<div class="product-page page">
<div class="page-content">
		<div class="product-column clear">
			<div class="product-additional-box preload-box" data-type="ajax-load" data-load-url="<?php echo $this->Html->url(getUsersAjaxUrl('ajax_product_additional', array('id' => $product['Product']['id'], 'sellable' => (int) $is_sellable))) ?>" data-load-type="onscroll" data-load-offset="50" data-loaded="false">
				<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
			</div>
		</div>
		<?php if ($is_sellable && !canDownloadProduct($product['Product']['id'])): ?>
			<?php
				/* Formy dostawy */
				echo $this->element(
					TEMPLATE_NAME.DS.'product'.DS.'shipping_methods',
					array(
						'product_id' => $product['Product']['id']
					)
				)
			?>
		<?php endif ?>
		<?php
			/* Gratisy do produktu */
			if ($gratis_for_products):
				echo $this->element(
					TEMPLATE_NAME.DS.'product'.DS.'product_gratis',
					array(
						'gratis_for_products' => $gratis_for_products
					)
				);
			endif;
		?>
	</div>
</div>

<?php
	/* Zapytaj o niedostępny wariant */
	echo $this->element(
		TEMPLATE_NAME.DS.'product'.DS.'unavailable_variants_modal',
		array(
			'product' => $product
		)
	)
?>

<?php
	/* Ping dla produktu */
	echo $this->element('_default'.DS.'product_ping')
?>
