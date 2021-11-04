<?php
	$is_sellable       = !module('INVENTORY') || $product['InventoryAvailibilityStatus']['sellable'] || checkCanAddNotSellableProductToCart() ? true : false;
	$price             = getProductPrice($product['Product']['id'], (int) get('combination_id'));
	$advices           = null;
	$show_availibility = module('B2B') ? (setting('MODULE_B2B_SHOW_AVAILABILITY_TO_NOT_LOGGED_USERS') ? true : (getLoggedUserId() ? true : false)) : (setting('MODULE_INVENTORY_SHOW_AVAILIBILITY') ? true : false);
?>

<div class="product-page page" itemscope itemtype="http://schema.org/Product">
	<div class="page-content">
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
		</div>
		
		<div class="product-column right">
			<div class="producer-availibility">
				<?php if ($product['Producer']['name']): ?>
					<a href="<?php echo $this->Html->url(getProducerProductsUrl($product['Producer']['id'])) ?>" title="<?php echo h($product['Producer']['name']) ?>">
						<?php if($product['Producer']['logo']):?>
							<?php 
								echo $this->Image->resize(
									Configure::read('Producer.dir').DS.$product['Producer']['logo'],
									150,
									150,
									true,
									array(
										'alt' => $product['Producer']['name'],
										'itemprop' => 'brand'
									)
								);
							?>
						<?php else: ?>
							<span itemprop="brand"><?php echo $product['Producer']['name'] ?></span>
						<?php endif;?>
					</a>
				<?php endif ?>
			</div>
			
			<div class="clearfix"></div>
			
			<?php if ($product['ProductOpinion']['count']): ?>
				<div class="opinions">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'opinion_rating',
							array(
								'input'        => false,
								'note'        => round($product['ProductOpinion']['average']),
								'google_meta' => array(
									'count'   => $product['ProductOpinion']['count'],
									'average' => $product['ProductOpinion']['average'],
									'item'    => $product['Product']['name']
								)
							)
						)
					?>
					<?php 
						if($product['ProductOpinion']['count']==1):
							$opinion = __('Opinia', true);
						elseif($product['ProductOpinion']['count']==2 || $product['ProductOpinion']['count']==3 || $product['ProductOpinion']['count']==4):
							$opinion = __('Opinie', true);
						else:
							$opinion = __('Opinii', true);
						endif;
					?>
					
					<span class="text-opinion">( <?php echo $product['ProductOpinion']['count'].' '.$opinion?>)</span>
				</div>
			<?php endif ?>
			<div class="clearfix"></div>
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
			<?php if ($product['ProductOpinion']['count']): ?>
				<div class="opinions hide-desk">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'opinion_rating',
							array(
								'input'        => false,
								'note'        => round($product['ProductOpinion']['average']),
								/*
								'google_meta' => array(
									'count'   => $product['ProductOpinion']['count'],
									'average' => $product['ProductOpinion']['average'],
									'item'    => $product['Product']['name']
								)
								*/
							)
						)
					?>
					<?php 
						if($product['ProductOpinion']['count']==1):
							$opinion = __('Opinia', true);
						elseif($product['ProductOpinion']['count']==2 || $product['ProductOpinion']['count']==3 || $product['ProductOpinion']['count']==4):
							$opinion = __('Opinie', true);
						else:
							$opinion = __('Opinii', true);
						endif;
					?>
					
					<span class="text-opinion">( <?php echo $product['ProductOpinion']['count'].' '.$opinion?>)</span>
				</div>
				<div class="clearfix"></div>
			<?php endif ?>
			<?php if ($is_sellable): ?>

				<div class="hide "itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="priceCurrency" content="<?php echo getCurrentCurrency('code') ?>"/>
					<meta itemprop="itemCondition" content="new"/>
					<meta itemprop="availability" content="<?php echo $google_availability_meta ?>"/>
					<meta itemprop="url" content="<?php echo $this->Html->url(getProductUrl($product['Producer']['id'])) ?>"/>
				
					<?php if (userAccessToPrice()): ?>
						<?php $last =  new \DateTime("sunday this week");?>
						<meta itemprop="price" content="<?php echo number_format($price['price'], 2, '.', '') ?>"/>
						<meta itemprop="priceValidUntil" content="<?php echo $last->format("c") ?>"/>
					<?php endif ?>
				</div>

				<?php if (userAccessToPrice()): ?>
					<div class="product-price">

						
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
								<div class="product-price-row">
									
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
												<?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?>
											</span>
											
											<span class="base-price" data-type="<?php echo $base_price_data_type ?>">
												<?php echo showPrice($netto ? $price['netto_base_price'] : $price['base_price']) ?>
											</span>
											
										<?php else: ?>
											<span class="price" data-type="<?php echo $price_data_type ?>">
												<?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?>
											</span>
											
											<span class="base-price" data-type="<?php echo $base_price_data_type ?>"></span>
										<?php endif ?>
									<?php else: ?>
										<span data-type="product-price">-</span>
									<?php endif ?>
								</div>
								
								<?php if (module('B2B')): ?>
									<div class="product-price-row">
										<span class="price-label">
											<?php echo getDefaultPricesType() == 'netto' ? __('Cena brutto', true) : __('Cena netto', true) ?>:
										</span>
										
										<?php
											$data_type = 'product-netto-price';
											
											if (getDefaultPricesType() == 'netto'):
												$data_type = 'product-price';
											endif
										?>
										
										<span class="price netto-price" data-type="<?php echo $data_type ?>">
											<?php echo showPrice(getDefaultPricesType() == 'netto' ? $price['price'] : $price['netto_price']) ?>
										</span>
									</div>
								<?php endif ?>
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
				
				<?php if (userAccessToAddToCart()): ?>
					<?php if (!$product['Product']['only_kit'] && !$product['Product']['only_gratis']): ?>
						<?php
							echo $this->Form->create(
								'UserCart',
								array(
									'url'             => getProductAddToCartUrl($product['Product']['id'], array('from' => 'cart'), null, null, true),
									'class'           => 'product-options form',
									'data-type'       => 'product-form',
									'data-product-id' => $product['Product']['id']
								)
							)
						?>
							<?php if ($variants):?>
								<div class="hold-variant">
									<?php 
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
													'product_id'  => $product['Product']['id']
												)
											);
										endif;
									?>
									<?php if($product['Sizing']['id'] && !$product['Sizing']['file']):?>
										<a class="tabela" href="#Sizing" data-toggle="modal" role="button" title="<?php echo h(__('Sprawdź tabelę rozmiarów'))?>"><?php __('Sprawdź tabelę rozmiarów')?></a>
									<?php endif;?>
								</div>
								
								<div class="data-right">
									
									<?php $date = strtotime("+".anticipateProductDeliveryTime($product['Product']['id'], true, null, true)." days");?>
									<div class="data-delivery"><?php __('DATA WYSYŁKI')?>: <?php echo showDate(date('d-m-Y', $date))?></div>
									<div class="free-delivery"><i class="sprite sprite-truck"></i><span><?php __('Darmowa dostawa od 150zł')?></span></div>
								</div>
							<?php else:?>
							
								<div class="hold-variant">
								
									<?php $date = strtotime("+".anticipateProductDeliveryTime($product['Product']['id'], true, null, true)." days");?>
									<div class="data-delivery"><?php __('DATA WYSYŁKI')?>: <?php echo showDate(date('d-m-Y', $date))?></div>
								</div>
								<div class="data-right">
									<div class="free-delivery"><i class="sprite sprite-truck"></i><span><?php __('Darmowa dostawa od 150zł')?></span></div>
								</div>
							
							<?php endif;
								
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
							
							<?php
								/* Zniżki ilościowe dla produktu */
								echo $this->element(
									TEMPLATE_NAME.DS.'product'.DS.'quantity_discount',
									array(
										'product_id'     => $product['Product']['id']
									)
								)
							?>
							
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
							
							<div class="product-actions">
								<button class="product-add-cart btn btn-primary <?php echo getProductExcludedForUser($product['Product']['id']) ? 'disabled' : '' ?>" type="submit"><i class="sprite sprite-cart-w"></i><?php echo h(getCartIsOffer() ? __('Dodaj do oferty', true) : __('Do koszyka', true)) ?></button>
								<?php if (module('WISHLIST') && !isBot()): ?>
									<a class="product-add-wishlist btn btn-link pull-right" data-type="add-to-wishlist" data-combination-id="<?php echo (int) getPageParamValue('combination_id') ?>" data-href="<?php echo $this->Html->url(getProductAddToWishlistUrl($product['Product']['id'])) ?>" href="<?php echo $this->Html->url(getProductAddToWishlistUrl($product['Product']['id'], array(), null, getPageParamValue('combination_id'))) ?>" title="<?php echo h(__('Dodaj do schowka', true)) ?>">
										<?php __('Dodaj do ulubionych') ?> <i class="fa fa-heart"></i>
									</a>
								<?php endif ?>
								
								<?php if (!isBot()): ?>
									<?php if (module('COMPARE')): ?>
										<a data-type="add-to-compare" class="product-add-wishlist btn btn-link" href="<?php echo $this->Html->url(getProductAddToCompareUrl($product['Product']['id'])) ?>" title="<?php echo h(__('Dodaj do porównania', true)) ?>">
											<?php __('Porównaj') ?> <i class="fa fa-caret-right"></i>
										</a>
									<?php endif ?>
									
									
								<?php endif ?>
								<?php if (getNotAvailableProductCombinations($product['Product']['id'])): ?>
									<div class="unavailable-variants">
										<a href="#UnavailableVariants" data-toggle="modal"><?php __('Powiadom o dostępności wariantu') ?> <i class="fa fa-angle-right"></i></a>
									</div>
								<?php endif ?>
							</div>
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
									'type'        => 'text',
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
			
			<?php if ($gratis_for_products = getGratisForProductProduct($product['Product']['id'])): ?>
				<?php foreach ($gratis_for_products as $from_quantity => $gratis_products): ?>
					<div class="gratis-products-section">
						<div class="info-left">
							<p>
								<?php echo $from_quantity == 1 ? __('Gratis do produktu', true) : sprintf(__('Gratis do produktu (przy zakupie %s)', true), showQuantityValue($from_quantity, $product['Product']['id'])) ?>
							</p>
						</div>
						
						<div class="info-right">
							<ul class="gratis-products-list product-list small">
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
																	'width'      => 120,
																	'height'     => 120,
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
												<span class="product-name">
													<?php echo $gratis_product['product_name'] ?>
												</span>
											</a>
										</div>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
					</div>
					
					<div class="clearfix"></div>
				<?php endforeach ?>
			<?php endif ?>
			
			<?php
				$product_tabs = array();
				
				/* Zakładka opis produktu */
				if (trim(Sanitize::html($product['Product']['description']))):
					$product_tabs[] = array(
						'name'    => __('Opis', true),
						'id'      => 'opis',
						'element' => 'description',
						'data'    => array(
							'description' => $product['Product']['description']
						)
					);
				endif;
				
				/* Dane techniczne */
				if (checkProductHasAnyVisibleAttribute($product['Product']['id']) || $product['Product']['code']):
					$product_tabs[] = array(
						'name'    => __('Dane techniczne', true),
						'id'      => 'dane-techniczne',
						'element' => 'attributes',
						'data'    => array(
							'attributes'    => $product['AttributeValue'],
							'product_media' => $product['ProductMedium'],
							'kit_products'  => !empty($kit_products) ? $kit_products : array(),
							'hide_leading'  => true,
							'code'          => $product['Product']['code']
						)
					);
				endif;
				
				/* Zakładka 'Dostawa i płatność' */
				/*$product_tabs[] = array(
					'name'    => __('Dostawa i płatność', true),
					'id'      => 'dostawa',
					'element' => 'delivery',
					'data'    => array(
						'product_id' => $product['Product']['id']
					)
				);*/
				
				/* Zakładka 'Warunki zwrotu' */
				/*$product_tabs[] = array(
					'name'    => __('Warunki zwrotu', true),
					'id'      => 'zwrot',
					'element' => 'return',
					'data'    => array(
						'product_id' => $product['Product']['id']
					)
				);*/
				
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
				//if (module('OPINIONS')):
					$product_tabs[] = array(
						'name'    => __('Opinie', true),
						'id'      => 'opinie',
						'element' => 'opinions',
						'data'    => array(
							'product_id' => $product['Product']['id']
						)
					);
				//endif;
				
				if ($is_sellable):
					/* Zakładka 'Zapytaj o produkt' */
					/*$product_tabs[] = array(
						'name'    => __('Zapytaj o produkt', true),
						'id'      => 'AskProduct',
						'element' => 'ask',
						'data'    => array(
							'product_id' => $product['Product']['id']
						)
					);*/
					
					/* Zakładka 'Poleć produkt' */
					/*$product_tabs[] = array(
						'name'    => __('Poleć produkt', true),
						'id'      => 'RecommendProduct',
						'element' => 'recommend',
						'data'    => array(
							'product_id' => $product['Product']['id']
						)
					);*/
				endif;
			?>
			<a class="responsive-toggle" data-type="toggle" href="#ProductTabs">
				<?php __('Szczegóły') ?>
			</a>
			<?php if (count($product_tabs) > 1): ?>
				<ul class="product-tabs tabs" id="ProductTabs">
					<?php foreach ($product_tabs as $tab): ?>
						<li class="<?php echo $tab == reset($product_tabs) ? 'active' : '' ?>">
							<a href="#<?php echo $tab['id'] ?>" title="<?php echo h($tab['name']) ?>">
								<?php echo $tab['name'] ?>
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
			<div class="bottom-option">
				<?php echo $this->element(
						TEMPLATE_NAME.DS.'product'.DS.'social_sharing',
						array(
							'product'            => $product,
							'gallery_indicators' => 0
						)
				);?>
				<?php if ($is_sellable):?>
					<div class="right">
						<a href="#Recommend" data-toggle="modal" role="button" title="<?php echo h(__('Poleć znajomemu'))?>"><?php __('Poleć znajomemu')?> <i class="sprite sprite-polec"></i></a>
						<a href="#AskProduct" data-toggle="modal" role="button" title="<?php echo h(__('Zapytaj o produkt'))?>"><?php __('Zapytaj o produkt')?> <i class="sprite sprite-question"></i></a>
					</div>
				<?php endif;?>
			</div>
		</div>
		
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
	/* Tabela rozmiarów */
	echo $this->element(
		TEMPLATE_NAME.DS.'product'.DS.'sizing',
		array(
			'name_sizing' => $product['Sizing']['name'],
			'desc_sizing' => $product['Sizing']['description']
		)
	)
?>
<?php if ($is_sellable):
	/* 'Zapytaj o produkt' */
	echo $this->element(
		TEMPLATE_NAME.DS.'product'.DS.'ask',
		array(
			'product_id' => $product['Product']['id']
		)
	);
		
	/* 'Poleć produkt' */
	echo $this->element(
		TEMPLATE_NAME.DS.'product'.DS.'recommend',
		array(
			'product_id' => $product['Product']['id']
		)
	);
endif;?>
<?php
	/* Ping dla produktu */
	echo $this->element('_default'.DS.'product_ping')
?>
