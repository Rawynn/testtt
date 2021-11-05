<div class="order-show-page order-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php echo sprintf(__('Zamówienie nr %s', true), getOrderFullId($order['Order']['id'], true)) ?>
			
			<small>
				<?php echo showDate($order['Order']['created']) ?> - <strong><?php echo $order_status['OrderStatus']['name'] ?></strong>
			</small>
		</h1>
	</div>
	
	<?php if (isset($order_status_history) && !empty($order_status_history)): ?>
		<div class="order-status-history">
			<h4 class="status-header">
				<?php __('Status') ?>
			</h4>
			
			<?php if (isset($order_status_history[0]['OrderStatus']['name'])): ?>
				<strong>
					<?php echo $order_status_history[0]['OrderStatus']['name'] ?>, <?php echo showDate($order_status_history[0]['OrderStatusHistory']['created']) ?>
				</strong>
				
				<a data-toggle="collapse" href="#orderStatusHistoryList" aria-expanded="false" aria-controls="orderStatusHistoryList">
					<?php __('zobacz historię') ?>
				</a>
				
				<div class="collapse" id="orderStatusHistoryList">
					<table class="table table-striped table-responsive">
						<tr>
							<th>
								<?php __('Data') ?>
							</th>
							<th>
								<?php __('Status') ?>
							</th>
							<th>
								<?php __('Komentarz') ?>
							</th>
						</tr>
						
						<?php $current_status_id = 0 ?>
						
						<?php foreach ($order_status_history as $key => $history_status): ?>
							<?php if ($history_status['OrderStatusHistory']['public'] == 1 || $history_status['OrderStatusHistory']['order_status_id'] != $current_status_id): ?>
								<tr>
									<td>
										<?php echo $history_status['OrderStatusHistory']['created'] ?>
									</td>
									<td>
										<?php echo $history_status['OrderStatus']['name'] ?>
									</td>
									<td>
										<?php if ($history_status['OrderStatusHistory']['public'] == 1) echo $history_status['OrderStatusHistory']['comments'] ?>
									</td>
								</tr>
							<?php endif ?>
							
							<?php $current_status_id = $history_status['OrderStatusHistory']['order_status_id'] ?>
						<?php endforeach ?>
					</table>
				</div>
			<?php endif ?>
		</div>
	<?php endif ?>
	
	<div class="page-content">
		<?php
			echo $this->Form->create(
				'Order',
				array(
					'url'           => getOrderUrl($id, $code),
					'class'         => 'address-form form',
					'data-submit'   => 'once',
					'escapeInputs'  => false,
					'id'            => 'OrderOrderProductsEditForm'
				)
			)
		?>
			<?php
				echo $this->Form->hidden(
					'products_save',
					array(
						'value' => 1
					)
				)
			?>
			
			<div class="product-section order-section">
				<table class="table product-table">
					<colgroup>
						<col width="12%">
						<col width="44%">
						<col width="20%">
						<col width="12%">
						<col width="12%">
					</colgroup>
					<thead>
						<tr class="product-header">
							<th class="product-data-header" colspan="2">
								<?php __('Produkt') ?>
							</th>
							<th class="product-price-header">
								<?php __('Cena') ?>
							</th>
							<th class="product-quantity-header">
								<?php __('Ilość') ?>
							</th>
							<th class="product-summary-header">
								<?php __('Wartość') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$products_ids     = Set::extract($order['OrderProduct'], '{n}.product_id');
							$combinations_ids = Set::extract($order['OrderProduct'], '{n}.combination_id');
							
							/* Grupowe pobranie zdjęć produktów */
							$products_photos    = getProductsMainPhotos($products_ids);
							$cominations_photos = getCombinationsPhotos($combinations_ids);
							
							/* Grupowe pobranie informacji o producentach */
							$products_fields = getProductsFields(
								Set::extract($order['OrderProduct'], '{n}.product_id'),
								array(
									'`Producer`.`name`'
								),
								array(
									'Producer'
								)
							);
							
							/* Pobranie informacje o tym czy produkty są widoczne */
							$products_visible = getProductsAreVisible($products_ids);
							
							/* Lista linków do produktów */
							$products_urls = getProductsUrl($products_ids);
							
							if ($order_editable):
								/* Kroki w produktach */
								$products_quantity_step = getProductsQuantityStep($products_ids);
							endif;
							
							/* Jednostki miary */
							$products_units = getProductsUnits($products_ids);
						?>
						
						<?php foreach ($order['OrderProduct'] as $key => $product): ?>
							<?php $product_url = $products_urls[$product['product_id']] ?>
							
							<tr class="product-row">
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
															'alt' => h($product['product_name'])
														)
													)
												)
											)
										?>
									</span>
								</td>
								<td class="product-data">
									<div class="name">
										<?php $product_name = getOrderProductName($product) ?>
										
										<?php if ($products_visible[$product['product_id']]): ?>
											<a href="<?php echo $this->Html->url($product_url) ?>" title="<?php echo h($product_name) ?>">
												<?php echo $product_name ?>
											</a>
										<?php else: ?>
											<span>
												<?php echo $product_name ?>
											</span>
										<?php endif ?>
									</div>
									
									<?php if (!empty($product['combination_name'])): ?>
										<div class="combination">
											<?php echo $product['combination_name'] ?>
										</div>
									<?php endif ?>
									
									<?php if (!empty($product['description'])): ?>
										<br>
										
										<div class="combination">
											<?php echo nl2br($product['description']) ?>
										</div>
									<?php endif ?>
								</td>
								<td class="product-price">
									<span class="table-responsive-label">
										<?php __('Cena') ?>:
									</span>
									
									<?php if (isProductGratisInOrder($product)): ?>
										<span class="label">
											<?php __('Gratis') ?>
										</span>
									<?php else: ?>
										<span>
											<?php echo showOrderPrice(getDefaultPricesType() == 'netto' ? getOrderProductNettoPrice($product) : getOrderProductBruttoPrice($product), $order['Order']['id']) ?>
										</span>
									<?php endif ?>
								</td>
								<td class="product-price product-quantity">
									<span class="table-responsive-label">
										<?php __('Ilość') ?>:
									</span>
									
									<?php
										if ($order_editable):
											echo $this->Form->hidden(
												'OrderProduct.'.$key.'.id',
												array(
													'type'  => 'hidden',
													'value' => $product['id']
												)
											);
											
											echo $this->Form->hidden(
												'OrderProduct.'.$key.'.product_id',
												array(
													'type'  => 'hidden',
													'value' => $product['combination_id']
												)
											);
											
											echo $this->Form->input(
												'OrderProduct.'.$key.'.quantity',
												array(
													'type'               => 'text',
													'data-type'          => 'change-quantity-input',
													'data-step'          => $products_quantity_step[$product['product_id']],
													'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
													'data-unit'          => $products_units[$product['product_id']],
													'data-show-controls' => 1,
													'data-min'           => 0,
													'div'                => false,
													'label'              => false,
													'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
													'value'              => showQuantityValue($product['quantity'])
												)
											);
										else:
											echo showQuantityValue($product['quantity'], $product['product_id'], $products_units[$product['product_id']]);
										endif;
									?>
								</td>
								<td class="product-price product-summary">
									<div class="table-responsive-label">
										<?php __('Wartość') ?>:
									</div>
									
									<?php if (isProductGratisInOrder($product)): ?>
										<span>-</span>
									<?php else: ?>
										<span>
											<?php echo showOrderPrice((getDefaultPricesType() == 'netto' ? getOrderProductNettoPrice($product, true) : getOrderProductBruttoPrice($product, false, true)), $order['Order']['id']) ?>
										</span>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			
			<?php if ($order_editable): ?>
				<div class="form-actions">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
					
					<a class="btn btn-primary btn-lg btn-next" data-toggle="modal" href="#order-add-product" role="button"  title="<?php echo h(__('Dodaj produkt do zamówienia', true)) ?>">
						<?php __('Dodaj produkt') ?>
					</a>
				</div>
			<?php endif ?>
			
			<hr>
			
			<div class="row">
				<div class="shipping-section order-section">
					<div class="order-section-header">
						<h2>
							<?php __('Forma dostawy') ?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<h3>
							<?php echo $order['Order']['shipping_method'] ?> -
							<strong>
								<?php echo showOrderPrice($order['Order']['shipping_price'], $order['Order']['id']) ?>
							</strong>
						</h3>
						
						<?php if ($shipping_description = getShippingMethodDescription($order['Order']['shipping_method_id'], $order['Order']['id'])): ?>
							<?php echo $shipping_description ?>
						<?php endif ?>
						
						<?php if ($order['Order']['tracking_number']): ?>
							<br>
							
							<p>
								<strong>
									<?php echo !empty($order['Order']['tracking_status']) ? __('Numer i status paczki', true) : __('Numer paczki', true) ?>:
								</strong>
								
								<strong class="text-important">
									<?php echo $order['Order']['tracking_number'] ?>
								</strong>
								
								<?php if ($order['Order']['tracking_status']): ?>
									&nbsp;-&nbsp;
									<span>
										<?php echo $order['Order']['tracking_status'] ?>
									</span>
								<?php endif ?>
							</p>
						<?php endif ?>
						
						<?php if ($order['Order']['date_shipment']): ?>
							<br>
							
							<p>
								<strong>
									<?php __('Data wysyłki') ?>:
								</strong>
								
								<span>
									<?php echo showDate($order['Order']['date_shipment']) ?>
								</span>
							</p>
						<?php endif ?>
						
						<?php if ($order['Order']['date_delivery']): ?>
							<br>
							
							<p>
								<strong>
									<?php __('Planowana data dostarczenia') ?>:
								</strong>
								
								<span>
									<?php echo showDate($order['Order']['date_delivery']) ?>
								</span>
							</p>
						<?php endif ?>
					</div>
				</div>
				
				<div class="shipping-section payment-section order-section">
					<div class="order-section-header">
						<h2>
							<?php __('Forma płatności') ?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<h3>
							<?php echo $order['Order']['payment_method'] ?> -
							<strong>
								<?php echo showOrderPrice($order['Order']['payment_price'], $order['Order']['id']) ?>
							</strong>
						</h3>
						
						<?php if ($payment_description = getPaymentMethodDescription($order['Order']['payment_method_id'], $order['Order']['id'])): ?>
							<?php echo $payment_description ?>
						<?php endif ?>
					</div>
				</div>
				<div class="clearfix"></div>
				
				<div class="shipping-address-section order-section">
					<div class="order-section-header">
						<h2>
							<?php __('Adres dostawy') ?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<?php
							if ($order['Order']['shipping_method_option_id']):
								echo getShippingMethodOptionName($order['Order']['shipping_method_option_id']);
							else:
								echo $this->element(
									TEMPLATE_NAME.DS.'address',
									array(
										'firstname'    => $order['Order']['shipping_firstname'],
										'lastname'     => $order['Order']['shipping_lastname'],
										'company'      => $order['Order']['shipping_company'],
										'nip'          => null,
										'street'       => $order['Order']['shipping_street'],
										'street_1'     => $order['Order']['shipping_street_number_1'],
										'street_2'     => $order['Order']['shipping_street_number_2'],
										'postcode'     => $order['Order']['shipping_postcode'],
										'city'         => $order['Order']['shipping_city'],
										'state_name'   => $order['ShippingState']['name'],
										'country_name' => $order['ShippingCountry']['name'],
										'phone'        => null
									)
								);
							endif;
						?>
						
						<?php if ($order_editable): ?>
							<a class="btn btn-primary btn-order-edit" data-toggle="modal" href="#shipping-address-edit" role="button" title="<?php echo h(__('Edytuj', true)) ?>">
								<?php __('Edytuj') ?>
							</a>
						<?php endif ?>
					</div>
				</div>
				
				<div class="payment-address-section order-section">
					<div class="order-section-header">
						<h2>
							<?php
								if ($order['Order']['invoice'] == 1):
									__('Dane do faktury');
								else:
									__('Dane do rachunku');
								endif;
							?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'address',
								array(
									'firstname'    => $order['Order']['payment_firstname'],
									'lastname'     => $order['Order']['payment_lastname'],
									'company'      => $order['Order']['payment_company'],
									'nip'          => $order['Order']['payment_nip'],
									'street'       => $order['Order']['payment_street'],
									'street_1'     => $order['Order']['payment_street_number_1'],
									'street_2'     => $order['Order']['payment_street_number_2'],
									'postcode'     => $order['Order']['payment_postcode'],
									'city'         => $order['Order']['payment_city'],
									'state_name'   => $order['PaymentState']['name'],
									'country_name' => $order['PaymentCountry']['name'],
									'phone'        => null
								)
							)
						?>
					</div>
				</div>
			</div>
			<hr>
			
			<?php if ($order['Order']['coupon_id']): ?>
				<div class="coupon-section order-section">
					<div class="order-section-header">
						<h2>
							<?php __('Kupon rabatowy') ?>
						</h2>
					</div>
					
					<div class="order-section-inner">
						<h3>
							<?php echo $order['Order']['coupon_name'] ?>
						</h3>
					</div>
					
					<div class="order-section-summary">
						<span>
							<?php if ($order['Order']['coupon_value']): ?>
								<?php echo '-'.showOrderPrice($order['Order']['coupon_value'], $order['Order']['id']) ?>
							<?php endif ?>
						</span>
					</div>
				</div>
				
				<hr>
			<?php endif ?>
			
			<?php if ($order['OrderAttachment']): ?>
				<div class="order-attachemtn-section order-section">
					<div class="order-section-header">
						<h2>
							<?php __('Załączniki') ?>
						</h2>
					</div>
					
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>
									<?php __('Nazwa pliku') ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($order['OrderAttachment'] as $order_attachment): ?>
								<tr>
									<td>
										<?php
											echo $this->Html->link(
												$order_attachment['name'],
												getOrderAttachmentDownloadUrl($order_attachment['id'], $order['Order']['id'], $order['Order']['code']),
												array(
													'target' => '_blank'
												)
											)
										?>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				
				<hr>
			<?php endif ?>
			
			<div class="order-summary">
				<h2>
					<?php __('Podsumowanie') ?>
				</h2>
				
				<table class="order-summary-table table-flat">
					<?php if (getDefaultPricesType() == 'netto'): ?>
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma netto') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span>
									<?php echo showOrderPrice(getOrderNettoBasePrice($order['Order']['id']), $order['Order']['id']) ?>
								</span>
							</td>
						</tr>
						<tr>
							<td class="summary-label">
								<?php __('VAT') ?>:
							</td>
							<td class="summary-value">
								<span>
									<?php echo showOrderPrice(getOrderTaxValue($order['Order']['id']), $order['Order']['id']) ?>
								</span>
							</td>
						</tr>
						
						<?php if ($order['Order']['coupon_value'] > 0): ?>
							<tr>
								<td class="summary-label">
									<?php __('Rabat') ?>:
								</td>
								<td class="summary-value">
									<span>
										<?php echo showOrderPrice((-1) * $order['Order']['coupon_value'], $order['Order']['id']) ?>
									</span>
								</td>
							</tr>
						<?php endif ?>
						
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Suma brutto') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span>
									<?php echo showOrderPrice(getOrderPriceWithoutCurrency($order['Order']['id']), $order['Order']['id']) ?>
								</span>
							</td>
						</tr>
						
						<?php if ($voucher_value = getOrderVoucherValue($order['Order']['id'])): ?>
							<tr>
								<td class="summary-label">
									<?php echo sprintf(__('Bon "%s"', true), getOrderVoucherName($order['Order']['id'])) ?>:
								</td>
								<td class="summary-value">
									<span>
										<?php echo showOrderPrice((-1) * $voucher_value, $order['Order']['id']) ?>
									</span>
								</td>
							</tr>
						<?php endif ?>
						
						<?php if ($credit_payment = getOrderCreditPayment($order['Order']['id'])): ?>
							<tr>
								<td class="summary-label">
									<?php __('Kredyt kupiecki') ?>:
								</td>
								<td class="summary-value">
									<span>
										<?php echo showOrderPrice((-1) * $credit_payment, $order['Order']['id']) ?>
									</span>
								</td>
							</tr>
						<?php endif ?>
						
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Do zapłaty') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span>
									<?php echo showOrderPrice(getOrderPriceToPay($order['Order']['id']), $order['Order']['id']) ?>
								</span>
							</td>
						</tr>
					<?php else: ?>
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Razem') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span>
									<?php echo showOrderPrice(getOrderPriceWithoutCurrency($order['Order']['id']), $order['Order']['id']) ?>
								</span>
							</td>
						</tr>
						
						<?php if ($voucher_value = getOrderVoucherValue($order['Order']['id'])): ?>
							<tr>
								<td class="summary-label">
									<?php echo sprintf(__('Bon "%s"', true), getOrderVoucherName($order['Order']['id'])) ?>:
								</td>
								<td class="summary-value">
									<span>
										<?php echo showOrderPrice((-1) * $voucher_value, $order['Order']['id']) ?>
									</span>
								</td>
							</tr>
						<?php endif ?>
						
						<?php if ($credit_payment = getOrderCreditPayment($order['Order']['id'])): ?>
							<tr>
								<td class="summary-label">
									<?php __('Kredyt kupiecki') ?>:
								</td>
								<td class="summary-value">
									<span>
										<?php echo showOrderPrice((-1) * $credit_payment, $order['Order']['id']) ?>
									</span>
								</td>
							</tr>
						<?php endif ?>
						
						<tr>
							<td class="summary-label order-cost-summary">
								<?php __('Do zapłaty') ?>:
							</td>
							<td class="summary-value order-cost-summary">
								<span>
									<?php echo showOrderPrice(getOrderPriceToPay($order['Order']['id']), $order['Order']['id']) ?>
								</span>
							</td>
						</tr>
					<?php endif ?>
				</table>
			</div>
		<?php echo $this->Form->end() ?>
		
		<?php
			echo $this->Form->create(
				'Order',
				array(
					'url'           => getOrderChangeStatusUrl($id, $code),
					'class'         => 'address-form form',
					'data-validate' => 'true',
					'data-submit'   => 'once',
					'escapeInputs'  => false,
					'id'            => 'OrderChangeStatusForm'
				)
			)
		?>
			<?php if ($change_status_available): ?>
				<hr>
				
				<?php
					echo $this->Form->input(
						'Order.order_status_id',
						array(
							'type'            => 'select',
							'div'             => 'form-row order-chang-status-row',
							'label'           => __('Zmień status', true).':',
							'class'           => 'form-control',
							'options'         => $possible_order_statuses,
							'empty'           => __('-wybierz-', true)
						)
					)
				?>
			<?php endif ?>
			
			<div class="order-actions form-actions">
				<?php if ($change_status_available): ?>
					<input class="btn-back btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
				<?php endif ?>
				
				<?php if (getLoggedUserId()): ?>
					<a class="btn-back btn btn-lg" href="javascript: history.back()" title="<?php echo h(__('Powrót', true)) ?>">
						<?php __('Powrót') ?>
					</a>
				<?php else: ?>
					<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getOrderPayUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Opłać zamówienie', true)) ?>">
						<?php __('Opłać zamówienie') ?>
					</a>
					
					<?php if (module('COMPLAINTS')): ?>
						<?php if ($order_has_complaint): ?>
							<a class="btn-next btn btn-lg" href="<?php echo $this->Html->url(getComplaintsUrl(isset($quick_register_code) ? array('code' => $quick_register_code) : array())) ?>" title="<?php echo h(__('Zobacz reklamacje', true)) ?>">
								<?php __('Zobacz reklamacje') ?>
							</a>
						<?php else: ?>
							<a class="btn-next btn btn-lg" href="<?php echo $this->Html->url(getComplaintAddUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Złóż reklamację', true)) ?>">
								<?php __('Złóż reklamację') ?>
							</a>
						<?php endif ?>
					<?php endif ?>
					
					<a class="btn-next btn btn-lg" href="<?php echo $this->Html->url(isset($quick_register_code) ? getUserQuickRegisterUrl(array('code' => $quick_register_code)) : getUserRegisterUrl()) ?>" title="<?php echo h(__('Załóż konto', true)) ?>">
						<?php __('Załóż konto') ?>
					</a>
				<?php endif ?>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
	
	<?php
		if ($order_editable):
			 /* Pola do edycji adresu dostawy */
			echo $this->element(TEMPLATE_NAME.DS.'order'.DS.'show'.DS.'shipping_address');
			
			/* Dodawanie produktu do zamówienia */
			echo $this->element(TEMPLATE_NAME.DS.'order'.DS.'show'.DS.'add_product');
		endif;
	?>
</div>