<div class="product-section order-section">
	<div class="order-section-header">
		<h2>
			<?php
				echo sprintf(
					__('Potwierdzenie zamówienie nr %s', true),
					getOrderFullId($order['Order']['id'], true)
				)
			?>
		</h2>
	</div>
	<div class="info-order">
		<div class="squers"><span class="squer"></span><span class="squer"></span><span class="squer"></span></div>
		<p><?php __('Dziękujemy za dokonanie zakupów w naszym sklepie Peripetie.cz')?></p>
		<p>
			<?php echo sprintf(
				__('Twoje zamówienie nr %s zostało przekazane do realizacji.', true),
				getOrderFullId($order['Order']['id'], true)
			)?>
		</p>
	</div>
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

	<?php if (!(setting('MODULE_RODO_EXTERNAL_MARKETING_CODES_REQUIRE_PERMISSIONS') && isset($_COOKIE['AtomStore']['MARKETING_COOKIES_ACCEPTED']) && !$_COOKIE['AtomStore']['MARKETING_COOKIES_ACCEPTED'])): ?>
		<div id="heureka-garance-box"></div>
		<script type="text/javascript">
			(function (apiKey, elm) {
				var loadScript = function (b,c){var a=document.createElement("script");a.type="text/javascript";c=c||function(){};if(a.readyState){a.onreadystatechange=function(){if(a.readyState=="loaded"||a.readyState=="complete"){a.onreadystatechange=null;c()}}}else{a.onload=function(){c()}}a.src=b;document.getElementsByTagName("head")[0].appendChild(a)};
				var heurekaHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				loadScript(heurekaHost + 'heureka.cz/direct/js/cache/1-overeno.js', function () {
					HeurekaOvereno.setKey(apiKey);
					HeurekaOvereno.getBadge(elm);
				});
			})('3E0D66922FBD9F2087670B1979EA39DD', 'heureka-garance-box');
		</script>
	
		<?php
			// Heureka Overeno service
		
			$this->log('=====================START=====================', 'heureka_ping');
	
			$base_url   = 'http://www.heureka.cz/direct/dotaznik/objednavka.php';
			$heureka_id = '804908fdfe8d64be4ed5e29e660a1631';
		
			if (strtoupper($this->Session->read('Configure.currency')) == 'EUR'):
				$base_url   = 'http://www.heureka.sk/direct/dotaznik/objednavka.php';
				$heureka_id = '42468852234f7f77f682ba0de42a2d7e';
			endif;
	
			$url = $base_url . '?id=' . $heureka_id . '&email=' . urlencode($order['Order']['email']);
	
			foreach ($order['OrderProduct'] as $product):
				$url .= '&itemId[]=' . urlencode($product['product_id']);
			endforeach;
	
			$url .= '&orderid=' . urlencode($order['Order']['id']);
	
			$parsed = parse_url($url);
		
			$this->log('URL: '.$url, 'heureka_ping');
	
			$fp = fsockopen($parsed['host'], 80, $errno, $errstr, 5);
	
			if ($fp):
				$return = '';
			
				$out = "GET " . $parsed['path'] . "?" . $parsed['query'] . " HTTP/1.1\r\n" .
					 "Host: " . $parsed['host'] . "\r\n" .
					 "Connection: Close\r\n\r\n";
	
				fputs($fp, $out);
			
				while (!feof($fp)){
					$return .= fgets($fp, 128);
				}
			
				$returnParsed = explode("\r\n\r\n", $return);
			
				$this->log('SUCESS: '.(empty($returnParsed[1]) ? '' : trim($returnParsed[1])), 'heureka_ping');
			
				fclose($fp);
			else:
				$this->log('ERROR: '.$errno.' - '.$errstr, 'heureka_ping');
			endif;
		
			$this->log('=====================KONIEC=====================', 'heureka_ping');
		?>
		<iframe src="http://www.zbozi.cz/action/42417/conversion?chsum=eLz3fLmv6YNwC_jxMRxM3Q==&uniqueId=<?php echo $order['Order']['id']; ?>" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="position:absolute; top:-3000px; left:-3000px; width:1px; height:1px; overflow:hidden;"></iframe>
		
		<!-- Měřicí kód Sklik.cz -->
		<script type="text/javascript">
		var seznam_cId = 100034191;
		var seznam_value = <?php echo getOrderProductsNettoPrice($order['Order']['id']) ?>;
		</script>
		<script type="text/javascript" src="https://www.seznam.cz/rs/static/rc.js" async></script>
		
	<?php endif ?>
	
	<table class="table product-table">
		<colgroup>
			<col width="10%">
			<col width="50%">
			<col width="20%">
			<col width="20%">
			<col width="10%">
		</colgroup>
		
		<thead>
			<tr class="product-header">
				<th class="product-price-header" colspan="2">
					<?php __('Zamówione produkty') ?>
				</th>
				
				<th class="product-price-header">
					<?php __('Cena') ?>
				</th>
				
				<th class="product-quantity-header">
					<?php __('Ilość') ?>
				</th>
				
				<th class="product-data-header">
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
						
						<div class="form-control quantity-input"><?php echo $product['quantity'] ?></div>
					</td>
					<td class="product-price product-sum">
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
<table class="table table-order-sum">
	<tr>
		<td class="hheader"><?php __('Forma płatności')?></td>
		<td>
			<?php echo $order['Order']['payment_method'] ?>
			<?php if ($payment_description = getPaymentMethodDescription($order['Order']['payment_method_id'], $order['Order']['id'])): ?>
				<br/><br/>
				<p>
					<?php echo $payment_description ?>
				</p>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<td class="hheader"><?php __('Forma dostawy')?></td>
		<td>
			<?php echo $order['Order']['shipping_method'] ?>
			<?php if ($shipping_description = getShippingMethodDescription($order['Order']['shipping_method_id'], $order['Order']['id'])): ?>
				<br/><br/>
				<?php echo $shipping_description ?>
			<?php endif ?>
		</td>
	</tr>
	<?php if ($order['Order']['shipping_method_id']): ?>
		<tr>
			<td class="hheader"><?php __('Adres dostawy')?></td>
			<td>
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
			</td>
		</tr>
	<?php endif;?>
	<?php if ($order['Order']['payment_method_id']): ?>
		<tr>
			<td class="hheader">
				<?php
					if ($order['Order']['invoice'] == 1):
						__('Dane do faktury');
					else:
						__('Dane do rachunku');
					endif;
				?>
			</td>
			<td>
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
			</td>
		</tr>
	<?php endif;?>
	<?php if($order['NewOrderStatusHistory']['comments']):?>
		<tr>
			<td class="hheader"><?php __('Komentarze do zamówienia')?></td>
			<td><?php echo $order['NewOrderStatusHistory']['comments']?></td>
		</tr>
	<?php endif;?>
</table>

<hr />

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
				<td class="summary-label order-cost-summary">
					<?php __('Kwota do zapłaty') ?>
				</td>
				<td class="summary-value order-cost-summary">
					<span>
						<?php echo showOrderPrice(getOrderPriceToPay($order['Order']['id']), $order['Order']['id']) ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="summary-label">
					<?php __('Koszt dostawy') ?>:
				</td>
				<td class="summary-value">
					<span>
						<?php echo showOrderPrice($order['Order']['shipping_price'], $order['Order']['id']) ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="summary-label">
					<?php __('Koszt płatności') ?>:
				</td>
				<td class="summary-value">
					<span>
						<?php echo showOrderPrice($order['Order']['payment_price'], $order['Order']['id']) ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="summary-label">
					<?php __('Rabat') ?>:
				</td>
				<td class="summary-value">
					<span>
						<?php echo showOrderPrice($order['Order']['coupon_value'], $order['Order']['id']) ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="summary-label">
					<?php __('Bon') ?>:
				</td>
				<td class="summary-value">
				<?php $voucher_value = getOrderVoucherValue($order['Order']['id']) ?>
					<span>
						<?php echo showOrderPrice($voucher_value, $order['Order']['id']) ?>
					</span>
				</td>
			</tr>
			
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
		<?php endif ?>
	</table>
</div>
