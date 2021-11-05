<div class="product-section order-section">
	<?php
		if (!$order['Order']['confirmed']):
			echo $this->element(
				TEMPLATE_NAME.DS.'message'.DS.'message',
				array(
					'class'    => 'info',
					'message'  => __('Na Twój adres e-mail została wysłana wiadomość z linkiem do potwierdzenia zamówienia. Kliknij w niego aby zakończyć proces składania zamówienia.', true),
					'no_close' => true
				)
			);
		endif;
	?>
	
	<?php
		/* Umożliwienie edycji danych do faktury */
		echo $this->element(
			TEMPLATE_NAME.DS.'order'.DS.'add'.DS.'payment_data',
			array(
				'order' => $order
			)
		)
	?>
	
	<?php
		$payment_form = $this->element(
			'_default'.DS.'payment_form',
			array(
				'order'        => $order,
				'target'       => isset($target) ? $target : '',
				'button_class' => 'btn btn-primary js-submit'
			)
		)
	?>
	
	<?php if (strlen(trim($payment_form)) > 0): ?>
		<hr>
		
		<div class="shipping-section payment-section order-section">
			<div class="order-section-header">
				<h2>
					<?php __('Opłać zamówienie') ?>
				</h2>
			</div>
			
			<div class="order-section-inner">
				<?php echo $payment_form ?>
			</div>
		</div>
	<?php endif ?>
	
	<?php
		/* Dodatkowe skrypty do dodawania zamówienia - NIE USUWAĆ!!! */
		echo $this->element(
			'_default'.DS.'add_order_scripts',
			array(
				'order' => $order
			)
		)
	?>
	
	<table class="table product-table sect-sum">
		<colgroup>
			<col width="10%">
			<col width="46%">
			<col width="20%">
			<col width="12%">
			<col width="12%">
		</colgroup>
		
		<thead>
			<tr class="product-header">
				<th class="product-data-header" colspan="2">
					<?php __('Zamówione produkty') ?>
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
			<?php foreach ($order['OrderProduct'] as $product): ?>
				<?php $product_url = getProductUrl($product['product_id']) ?>
				
				<tr class="product-row">
					<td class="product-image">
						<span class="preload-image" data-loaded="false">
							<?php
								echo $this->element(
									'_default'.DS.'miniature',
									array(
										'file'  => array(
											'type'     => configuration('ProductMedium.dir'),
											'filename' => $product['filename'] ? $product['filename'] : (($filename = getCombinationField($product['combination_id'], 'filename')) ? $filename : getProductMainPhotoId($product['product_id'], 'filename')),
											'dir'      => $product['filename'] ? $product['dir'] : (($dir = getCombinationField($product['combination_id'], 'dir')) ? $dir : getProductMainPhotoId($product['product_id'], 'dir'))
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
							
							<?php if (checkProductIsVisible($product['product_id'])): ?>
								<a href="<?php echo $this->Html->url($product_url) ?>" title="<?php echo h($product_name) ?>">
									<?php echo $product_name ?>
								</a>
							<?php else: ?>
								<span>
									<?php echo $product_name ?>
								</span>
							<?php endif ?>
							
							<?php if ($product['gratis']): ?>
								<span class="label">
									<?php __('Gratis') ?>
								</span>
							<?php endif ?>
						</div>
						
						<?php if (!empty($product['combination_name'])): ?>
							<div class="combination">
								<?php echo $product['combination_name'] ?>
							</div>
						<?php endif ?>
						
						<?php if (!empty($product['description'])): ?>
							<br />
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
						<span>
						<?php echo showQuantityValue($product['quantity'], $product['product_id']) ?>
						</span>
					</td>
					<td class="product-price product-summary">
						<span class="table-responsive-label">
							<?php __('Wartość') ?>:
						</span>
						
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

<hr>

<div class="row">
	<?php if ($order['Order']['payment_method_id']): ?>
		<div class="shipping-section payment-section order-section summary-sect">
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
					<p>
						<?php echo $payment_description ?>
					</p>
				<?php endif ?>
			</div>
		</div>
	<?php endif ?>
	<?php if ($order['Order']['shipping_method_id']): ?>
		<div class="shipping-section order-section summary-sect">
			<div class="order-section-header">
				<h2>
					<?php __('Forma dostawy') ?>
				</h2>
			</div>
			
			<div class="order-section-inner">
				<h3>
					<?php echo $order['Order']['shipping_method'] ?> -
					<strong>
						<?php if (module('B2B') && checkIsNoCalculateShippingMethod($order['Order']['shipping_method_id'])): ?>
							-
						<?php else:?>
							<?php echo showOrderPrice($order['Order']['shipping_price'], $order['Order']['id']) ?>
						<?php endif ?>
					</strong>
				</h3>
				
				<?php if ($shipping_description = getShippingMethodDescription($order['Order']['shipping_method_id'], $order['Order']['id'])): ?>
					<?php echo $shipping_description ?>
				<?php endif ?>
			</div>
		</div>
	<?php endif ?>
	
	<div class="clearfix"></div>
	
	<?php if ($order['Order']['shipping_method_id']): ?>
		<div class="shipping-address-section order-section summary-sect">
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
								'state_name'   => getStateName($order['Order']['shipping_state_id']),
								'country_name' => getCountryName($order['Order']['shipping_country_id'], getCurrentLanguageField('locale')),
								'phone'        => null
							)
						);
					endif;
				?>
			</div>
		</div>
	<?php endif ?>
	
	<?php if ($order['Order']['payment_method_id']): ?>
		<div class="payment-address-section order-section summary-sect">
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
							'state_name'   => getStateName($order['Order']['payment_state_id']),
							'country_name' => getCountryName($order['Order']['payment_country_id'], getCurrentLanguageField('locale')),
							'phone'        => null
						)
					)
				?>
			</div>
		</div>
	<?php endif ?>
	<?php if($order['NewOrderStatusHistory']['comments']):?>
		<div class="order-section summary-sect">
			<div class="order-section-header">
				<h2><?php __('Komentarz')?></h2>
			</div>
			<div class="order-section-inner"><?php echo $order['NewOrderStatusHistory']['comments']?></div>
		</div>
	<?php endif;?>
</div>
<hr />

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

<div class="order-summary">
	
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
			
			<?php if ($order['Order']['coupon_value']): ?>
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
				<td class="summary-label">
					<?php __('Koszt dostawy') ?>:
				</td>
				<td class="summary-value">
					<span>
						<?php echo showPrice($order['Order']['shipping_price']) ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="summary-label">
					<?php __('Koszt płatności') ?>:
				</td>
				<td class="summary-value">
					<span>
						<?php echo showPrice($order['Order']['payment_price']) ?>
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
<?php if($order['Order']['payment_method'] == 'Tpay.com - szybkie płatności elektroniczne (zaznacz swój bank)'):?>
	<script>
		$( function() {
			setTimeout(function() {
			    $('.btn-primary.js-submit').trigger('click');
			}, 4000);
		});
	</script>
<?php endif;?>