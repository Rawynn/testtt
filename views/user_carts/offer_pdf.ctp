<style type="text/css">
	.products tr.offer-union td{
		background: #F0F0F0;
	}
</style>

<div class="logo fl">
	<table class="photo">
		<tr>
			<td>
				<?php
					if ($logo = getTemplatePath('logo')):
						$size   = @getimagesize($logo);
						$height = 92;
						
						if ($size):
							if ($size[1] < $height):
								$height = $size[1];
							endif;
						endif;
						
						echo $this->Html->image(
							$logo,
							array(
								'height' => $height
							)
						);
					else:
						echo '<span>'.setting('GLOBAL_STORE_COMPANY').'</span>';
					endif;
				?>
			</td>
		</tr>
	</table>
</div>

<div class="fl top_center" style="width: 441px;">
	<div class="top_center_name center bold border">
		<?php echo sprintf(__('Oferta "%s"', true), $offer['UserCart']['name']) ?>
	</div>
	
	<div class="top_center_date center border" style="width: 137px; float: left;">
		<strong class="date"><?php echo $offer_number ?></strong><br/>
		<small><?php __('numer oferty') ?></small>
	</div>
	
	<div style="width: 1px; float: left; height: 10px;"></div>
	
	<div class="top_center_date center border" style="width: 138px; float: left;">
		<strong class="date"><?php echo showDate(date('Y-m-d')) ?></strong><br/>
		<small><?php __('data wydruku') ?></small>
	</div>
	
	<div class="top_center_date center border" style="width: 138px; float: right;">
		<strong class="date"><?php echo !empty($expire) ? showDate($expire) : '-' ?></strong><br/>
		<small><?php __('data wygaśnięcia') ?></small>
	</div>
</div>

<div class="clear" style="height: 20px;"></div>

<?php if (!empty($user_cart_offer)): ?>
	<div class="seller_address fl border">
		<?php
			echo __('Ofertę sporządził', true).': <strong>'.$user_cart_offer['UserCart']['username'].'</strong><br/>';
			echo __('Sprzedawca', true).': <strong>'.setting('GLOBAL_STORE_COMPANY').'</strong><br/>';
			echo __('Adres', true).': <strong>'.setting('GLOBAL_STORE_STREET').', '.setting('GLOBAL_STORE_POSTCODE').' '.setting('GLOBAL_STORE_CITY').'</strong><br/>';
			echo __('NIP', true).': <strong>'.setting('GLOBAL_STORE_NIP').'</strong><br/>';
			
			if (setting('MODULE_INVOICE_SHOW_SELLER_REGON') && setting('GLOBAL_STORE_REGON')):
				echo __('REGON', true).': <strong>'.setting('GLOBAL_STORE_REGON').'</strong><br/>';
			endif;
			
			echo __('Numer telefonu', true).': <strong>'.($user_cart_offer['UserCart']['phone'] ? $user_cart_offer['UserCart']['phone'] : setting('GLOBAL_CONTACT_PHONE_1')).'</strong><br/>';
		?>
	</div>
	
	<div class="buyer_address fl border" style="height: <?php echo setting('MODULE_INVOICE_SHOW_SELLER_REGON') && setting('GLOBAL_STORE_REGON') ? 92 : 77 ?>px;">
		<?php
			echo __('Oferta dla kontrahenta', true).': <strong>'.$user_cart_offer['UserCartOffer']['name'].'</strong><br/>';
			
			if ($user_cart_offer['UserCartOffer']['address']):
				echo __('Adres', true).': <strong>'.$user_cart_offer['UserCartOffer']['address'].'</strong><br/>';
			endif;
			
			if ($user_cart_offer['UserCartOffer']['phone']):
				echo __('Telefon', true).': <strong>'.$user_cart_offer['UserCartOffer']['phone'].'</strong><br/>';
			endif;
			
			echo __('E-mail', true).': <strong>'.$user_cart_offer['UserCartOffer']['email'].'</strong><br/>';
		?>
	</div>
	
	<div class="clear" style="height: 20px;"></div>
<?php endif ?>

<div>
	<?php
		$sum_netto       = 0;
		$sum_vat         = 0;
		$sum_brutto      = 0;
		$sum_netto_vats  = array();
		$sum_vat_vats    = array();
		$sum_brutto_vats = array();
		
		$summary = true;
		
		if (!empty($user_cart_offer)):
			$summary = (bool) $user_cart_offer['UserCartOffer']['summary'];
		endif;
		
		if ($summary && userIsSalesrep()):
			/* Handlowiec - jeżeli jest jakiś produkt do wyboru - nie wyświetlam podsumowania */
			foreach ($offer['UserCartProduct'] as $product):
				if ($product['offer_union']):
					$summary = false;
					
					break;
				endif;
			endforeach;
		endif;
	?>
	
	<table class="products">
		<thead>
			<tr>
				<?php foreach ($selected_columns as $column): ?>
					<th>
						<?php echo ucfirst($columns[$column]) ?>
					</th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<?php
				$current_offer_union   = null;
				$current_product_label = null;
			?>
			
			<?php foreach ($offer['UserCartProduct'] as $key => $product): ?>
				<?php
					$product['product_price'] = round($product['single_price'] / (1 + $product['tax_value'] / 100), 2);
					
					if (($product['tax_value'] * 100) % 100 == 0):
						$product['tax_value'] = (float) $product['tax_value'];
					endif;
					
					$tax_value_key = $product['tax_value'];
					
					if ($product['Tax']['released']):
						$tax_value_key = __('zw', true);
					elseif ($product['Tax']['excluded']):
						$tax_value_key = __('np', true);
					endif;
					
					if (!isset($sum_netto_vats[$tax_value_key])):
						$sum_netto_vats[$tax_value_key] = 0;
					endif;
					
					if (!isset($sum_vat_vats[$tax_value_key])):
						$sum_vat_vats[$tax_value_key] = 0;
					endif;
					
					if (!isset($sum_brutto_vats[$tax_value_key])):
						$sum_brutto_vats[$tax_value_key] = 0;
					endif;
					
					$sum_netto                       += $product['netto_price'];
					$sum_netto_vats[$tax_value_key]  += $product['netto_price'];
					$sum_vat                         += $product['vat_value'];
					$sum_vat_vats[$tax_value_key]    += $product['vat_value'];
					$sum_brutto                      += $product['brutto_price'];
					$sum_brutto_vats[$tax_value_key] += $product['brutto_price'];
					
					/* Czy wyświetlić link do produktu */
					$show_product_link = true;
					
					if (!empty($user_cart_offer)):
						$show_product_link = (bool) $user_cart_offer['UserCartOffer']['link_products'];
					endif;
					
					if ($show_product_link):
						$show_product_link = checkProductIsVisible($product['product_id']);
					endif;
				?>
				
				<?php if ($product['label'] && $product['label'] != $current_product_label): ?>
					<tr>
						<td colspan="<?php echo count($selected_columns) ?>">
							<strong><?php echo $product['label'] ?></strong>
						</td>
					</tr>
					
					<?php $current_product_label = $product['label'] ?>
				<?php endif ?>
				
				<?php if ($product['offer_union'] && $product['offer_union'] != $current_offer_union): ?>
					<tr class="offer-union">
						<td colspan="<?php echo count($selected_columns) ?>">
							<strong><?php echo $product['offer_union_name'] ?></strong>
						</td>
					</tr>
					
					<?php $current_offer_union = $product['offer_union'] ?>
				<?php endif ?>
				
				<tr class="<?php echo $product['offer_union'] ? 'offer-union' : '' ?>">
					<?php foreach ($selected_columns as $column): ?>
						<?php if ($column == 'lp'): ?>
							<td>
								<?php echo $product['number'] ?>.
							</td>
						<?php elseif ($column == 'photo'): ?>
							<?php if ($product['image_show']): ?>
								<td class="center" style="vertical-align: middle;" rowspan="<?php echo $product['image_rowspan'] ?>">
									<?php
										$product_photo = getProductImage(
											array(
												'product_id'     => $product['product_id'],
												'combination_id' => $product['combination_id'],
												'filename'       => $product['filename'],
												'dir'            => $product['dir']
											),
											50,50
										)
									?>
									
									<?php if ($show_product_link): ?>
										<a href="<?php echo $this->Html->url(getProductUrl($product['product_id']), true)?>" target="_blank" style="color: black; text-decoration: none;">
											<?php echo $product_photo ?>
										</a>
									<?php else: ?>
										<?php echo $product_photo ?>
									<?php endif ?>
								</td>
							<?php endif ?>
						<?php elseif ($column == 'name'): ?>
							<td>
								<?php
									$product_name = '';
									
									if (strlen($product['product_name']) > 0):
										$product_name = $product['product_name'];
									else:
										$product_name = getProductName($product['product_id']);
										
										if ($product['width'] !== null || $product['height'] !== null):
											$product_name .= ' ['.number_format($product['width'], 3, ',', '').' x '.number_format($product['height'], 3, ',', '').' m]';
										endif;
									endif;
								?>
								
								<?php if ($show_product_link): ?>
									<a href="<?php echo $this->Html->url(getProductUrl($product['product_id']), true)?>" target="_blank" style="color: black; text-decoration: none;">
										<?php echo $product_name ?>
									</a>
								<?php else: ?>
									<?php echo $product_name ?>
								<?php endif ?>
								
								<?php if ($product['custom_description'] || $product['attributes']): ?>
									<br/><br/>
									
									<span class="gray"><?php
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
									?></span>
								<?php endif ?>
							</td>
						<?php elseif ($column == 'combination'): ?>
							<td>
								<?php
									if ($product['combination_id'] && is_numeric($product['combination_id'])):
										echo getCombinationName($product['combination_id']);
									else:
										echo '-';
									endif;
								?>
							</td>
						<?php elseif ($column == 'code'): ?>
							<td>
								<?php echo $product['code'] ? $product['code'] : '-' ?>
							</td>
						<?php elseif ($column == 'producer'): ?>
							<td>
								<?php
									if ($producer = getProductProducerName($product['product_id'])):
										echo $producer;
									else:
										echo '-';
									endif;
								?>
							</td>
						<?php elseif ($column == 'producer_logo'): ?>
							<td class="center">
								<?php
									if ($producer_logo = getProductField($product['product_id'], 'Producer.logo', array('Producer'))):
										echo $this->Image->resize(Configure::read('Producer.dir').DS.$producer_logo, 100, 100);
									endif;
								?>
							</td>
						<?php elseif ($column == 'availibility'): ?>
							<td>
								<?php
									if ($product['combination_id'] && is_numeric($product['combination_id'])):
										echo getCombinationInventoryAvailibilityStatusName($product['combination_id']);
									else:
										echo getProductInventoryAvailibilityStatusName($product['product_id']);
									endif;
								?>
							</td>
						<?php elseif ($column == 'suggested_netto_price'): ?>
							<td class="right">
								<?php echo showPrice($product['suggested_netto_price'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'suggested_brutto_price'): ?>
							<td class="right">
								<?php echo showPrice($product['suggested_brutto_price'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'rabat'): ?>
							<td>
								<?php echo $product['rabat'] ? number_format($product['rabat'], 2, ',', '').'%' : '-' ?>
							</td>
						<?php elseif ($column == 'netto_price'): ?>
							<td class="right">
								<?php echo showPrice($product['single_price'] / (1 + $product['tax_value'] / 100), false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'brutto_price'): ?>
							<td class="right">
								<?php echo showPrice($product['single_price'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'vat'): ?>
							<td class="right">
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
							</td>
						<?php elseif ($column == 'quantity'): ?>
							<td class="right">
								<?php echo showQuantityValue($product['quantity']) ?>
							</td>
						<?php elseif ($column == 'suggested_netto_value'): ?>
						<td class="right">
								<?php echo showPrice($product['suggested_netto_value'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'suggested_brutto_value'): ?>
							<td class="right">
								<?php echo showPrice($product['suggested_brutto_value'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'netto_value'): ?>
							<td class="right">
								<?php echo showPrice($product['netto_price'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'vat_value'): ?>
							<td class="right">
								<?php echo showPrice($product['vat_value'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'brutto_value'): ?>
							<td class="right">
								<?php echo showPrice($product['brutto_price'], false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif (strpos($column, 'attribute:') === 0): ?>
							<?php
								/* Atrybut - #18663 */
								$attribute_id = str_replace('attribute:', '', $column);
								
								$product_attribute_value = getProductAttributeValue($product['product_id'], $attribute_id);
							?>
							
							<td>
								<?php echo $product_attribute_value ? implode(', ', $product_attribute_value) : '-' ?>
							</td>
						<?php endif ?>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
			
			<?php if ($offer['UserCart']['shipping_method_price'] > 0): ?>
				<tr>
					<?php
						$shipping_method_price = $offer['UserCart']['shipping_method_price'];
						$tax_value             = 0;
						
						if (!empty($offer['ShippingMethod']['Tax']['value'])):
							$tax_value = $offer['ShippingMethod']['Tax']['value'];
						endif;
						
						$shipping_method_vat_value   = round($shipping_method_price * $tax_value / (100 + $tax_value), $precision);
						$shipping_method_netto_price = $shipping_method_price - $shipping_method_vat_value;
						
						if (($tax_value * 100) % 100 == 0):
							$tax_value = (float) $tax_value;
						endif;
						
						$tax_value_key = $tax_value;
						
						if (!empty($offer['ShippingMethod']['Tax']['released'])):
							$tax_value_key = __('zw', true);
						elseif (!empty($offer['ShippingMethod']['Tax']['excluded'])):
							$tax_value_key = __('np', true);
						endif;
						
						if (!isset($sum_netto_vats[$tax_value_key])):
							$sum_netto_vats[$tax_value_key] = 0;
						endif;
						
						if (!isset($sum_vat_vats[$tax_value_key])):
							$sum_vat_vats[$tax_value_key] = 0;
						endif;
						
						if (!isset($sum_brutto_vats[$tax_value_key])):
							$sum_brutto_vats[$tax_value_key] = 0;
						endif;
						
						$sum_netto                       += $shipping_method_netto_price;
						$sum_netto_vats[$tax_value_key]  += $shipping_method_netto_price;
						$sum_vat                         += $shipping_method_vat_value;
						$sum_vat_vats[$tax_value_key]    += $shipping_method_vat_value;
						$sum_brutto                      += $shipping_method_price;
						$sum_brutto_vats[$tax_value_key] += $shipping_method_price;
					?>
					
					<?php foreach ($selected_columns as $column): ?>
						<?php if ($column == 'lp'): ?>
							<td>
								<?php echo (++$key) + 1 ?>.
							</td>
						<?php elseif ($column == 'photo'): ?>
							<td class="center">
								<?php if ($offer['UserCart']['shipping_method_id'] && file_exists(WWW_ROOT.'img'.DS.Configure::read('Shipping.dir').DS.$offer['UserCart']['shipping_method_id'])): ?>
									<?php echo $this->Image->resize(Configure::read('Shipping.dir').DS.$offer['UserCart']['shipping_method_id'], 90, 70) ?>
								<?php endif ?>
							</td>
						<?php elseif ($column == 'name'): ?>
							<td>
								<?php echo $offer['UserCart']['shipping_method_id'] ? __('Dostawa', true).': '.getShippingMethodName($offer['UserCart']['shipping_method_id']) : '-' ?>
							</td>
						<?php elseif ($column == 'combination'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'code'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'producer'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'producer_logo'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'availibility'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'suggested_netto_price'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'suggested_brutto_price'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'rabat'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'netto_price'): ?>
							<td class="right">
								<?php echo showPrice($shipping_method_netto_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'brutto_price'): ?>
							<td class="right">
								<?php echo showPrice($shipping_method_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'vat'): ?>
							<td class="right">
								<?php
									if (!empty($offer['ShippingMethod']['Tax']['released'])):
										__('zw');
									elseif (!empty($offer['ShippingMethod']['Tax']['excluded'])):
										__('np');
									else:
										if (($tax_value * 100) % 100 > 0):
											echo number_format($tax_value, 2, ',', '').'%';
										else:
											echo $tax_value.'%';
										endif;
									endif;
								?>
							</td>
						<?php elseif ($column == 'quantity'): ?>
							<td class="right">
								1
							</td>
						<?php elseif ($column == 'suggested_netto_value'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'suggested_brutto_value'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'netto_value'): ?>
							<td class="right">
								<?php echo showPrice($shipping_method_netto_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'vat_value'): ?>
							<td class="right">
								<?php echo showPrice($shipping_method_vat_value, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'brutto_value'): ?>
							<td class="right">
								<?php echo showPrice($shipping_method_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif (strpos($column, 'attribute:') === 0): ?>
							<td>
								-
							</td>
						<?php endif ?>
					<?php endforeach ?>
				</tr>
			<?php endif ?>
			
			<?php if ($offer['UserCart']['payment_method_price'] > 0): ?>
				<tr>
					<?php
						$payment_method_price = $offer['UserCart']['payment_method_price'];
						$tax_value            = 0;
						
						if (!empty($offer['PaymentMethod']['Tax']['value'])):
							$tax_value = $offer['PaymentMethod']['Tax']['value'];
						endif;
						
						$payment_method_vat_value   = round($payment_method_price * $tax_value / (100 + $tax_value), $precision);
						$payment_method_netto_price = $payment_method_price - $payment_method_vat_value;
						
						if (($tax_value * 100) % 100 == 0):
							$tax_value = (float) $tax_value;
						endif;
						
						$tax_value_key = $tax_value;
						
						if (!empty($offer['PaymentMethod']['Tax']['released'])):
							$tax_value_key = __('zw', true);
						elseif (!empty($offer['PaymentMethod']['Tax']['excluded'])):
							$tax_value_key = __('np', true);
						endif;
						
						if (!isset($sum_netto_vats[$tax_value_key])):
							$sum_netto_vats[$tax_value_key] = 0;
						endif;
						
						if (!isset($sum_vat_vats[$tax_value_key])):
							$sum_vat_vats[$tax_value_key] = 0;
						endif;
						
						if (!isset($sum_brutto_vats[$tax_value_key])):
							$sum_brutto_vats[$tax_value_key] = 0;
						endif;
						
						$sum_netto                       += $payment_method_netto_price;
						$sum_netto_vats[$tax_value_key]  += $payment_method_netto_price;
						$sum_vat                         += $payment_method_vat_value;
						$sum_vat_vats[$tax_value_key]    += $payment_method_vat_value;
						$sum_brutto                      += $payment_method_price;
						$sum_brutto_vats[$tax_value_key] += $payment_method_price;
					?>
					
					<?php foreach ($selected_columns as $column): ?>
						<?php if ($column == 'lp'): ?>
							<td>
								<?php echo (++$key) + 1 ?>.
							</td>
						<?php elseif ($column == 'photo'): ?>
							<td>
								&nbsp;
							</td>
						<?php elseif ($column == 'name'): ?>
							<td>
								<?php echo $offer['UserCart']['payment_method_id'] ? __('Płatność', true).': '.getPaymentMethodName($offer['UserCart']['payment_method_id']) : '-' ?>
							</td>
						<?php elseif ($column == 'combination'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'code'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'producer'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'producer_logo'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'availibility'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'suggested_netto_price'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'suggested_brutto_price'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'rabat'): ?>
							<td>
								-
							</td>
						<?php elseif ($column == 'netto_price'): ?>
							<td class="right">
								<?php echo showPrice($payment_method_netto_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'brutto_price'): ?>
							<td class="right">
								<?php echo showPrice($payment_method_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'vat'): ?>
							<td class="right">
								<?php
									if (!empty($offer['PaymentMethod']['Tax']['released'])):
										__('zw');
									elseif (!empty($offer['PaymentMethod']['Tax']['excluded'])):
										__('np');
									else:
										if (($tax_value * 100) % 100 > 0):
											echo number_format($tax_value, 2, ',', '').'%';
										else:
											echo $tax_value.'%';
										endif;
									endif;
								?>
							</td>
						<?php elseif ($column == 'quantity'): ?>
							<td class="right">
								1
							</td>
						<?php elseif ($column == 'suggested_netto_value'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'suggested_brutto_value'): ?>
							<td class="right">
								-
							</td>
						<?php elseif ($column == 'netto_value'): ?>
							<td class="right">
								<?php echo showPrice($payment_method_netto_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'vat_value'): ?>
							<td class="right">
								<?php echo showPrice($payment_method_vat_value, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif ($column == 'brutto_value'): ?>
							<td class="right">
								<?php echo showPrice($payment_method_price, false, $currency['Currency']['code']) ?>
							</td>
						<?php elseif (strpos($column, 'attribute:') === 0): ?>
							<td>
								-
							</td>
						<?php endif ?>
					<?php endforeach ?>
				</tr>
			<?php endif ?>
			
			<?php if ($summary): ?>
				<tr>
					<td colspan="<?php echo count($selected_columns) ?>" style="padding: 3px 0px; border-left: 0px; border-right: 0px; border-bottom: 0px;">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="<?php echo count($selected_columns) - 4 ?>" style="padding: 3px 0px; border: 0px;">
						&nbsp;
					</td>
					<th>
						<?php __('Wartość netto') ?>
					</th>
					<th>
						<?php __('Stawka VAT') ?>
					</th>
					<th>
						<?php __('Kwota VAT') ?>
					</th>
					<th>
						<?php __('Wartość brutto') ?>
					</th>
				</tr>
				<tr>
					<td colspan="<?php echo count($selected_columns) - 5 ?>" style="border-left: 0px; border-top: 0px; border-bottom: 0px;">
						&nbsp;
					</td>
					<th>
						<?php __('RAZEM') ?>
					</th>
					<td class="right">
						<?php echo showPrice($sum_netto, false, $currency['Currency']['code']) ?>
					</td>
					<td class="center">
						X
					</td>
					<td class="right">
						<?php echo showPrice($sum_vat, false, $currency['Currency']['code']) ?>
					</td>
					<td class="right">
						<?php echo showPrice($sum_brutto, false, $currency['Currency']['code']) ?>
					</td>
				</tr>
				
				<?php if (!empty($sum_netto_vats)): ?>
					<?php $i = 0 ?>
					
					<?php foreach ($sum_netto_vats as $vat => $value): ?>
						<tr>
							<td colspan="<?php echo count($selected_columns) - 5 ?>" style="border-left: 0px; border-top: 0px; border-bottom: 0px;">
								&nbsp;
							</td>
							<th>
								<?php echo $i == 0 ? __('W tym', true) : '' ?>
							</th>
							<td class="right">
								<?php echo showPrice($sum_netto_vats[$vat], false, $currency['Currency']['code']) ?>
							</td>
							<td class="center">
								<?php
									if (is_numeric($vat)):
										if (($vat * 100) % 100 > 0):
											echo number_format($vat, 2, ',', '').'%';
										else:
											echo $vat.'%';
										endif;
									else:
										echo $vat;
									endif;
								?>
							</td>
							<td class="right">
								<?php echo showPrice($sum_vat_vats[$vat], false, $currency['Currency']['code']) ?>
							</td>
							<td class="right">
								<?php echo showPrice($sum_brutto_vats[$vat], false, $currency['Currency']['code']) ?>
							</td>
						</tr>
						
						<?php $i++ ?>
					<?php endforeach ?>
				<?php endif ?>
			<?php endif ?>
		</tbody>
	</table>
</div>

<?php if ($summary): ?>
	<div class="clear" style="height: 20px;"></div>
	
	<div class="block" style="padding: 10px 5px; width: 346px;">
		<?php
			echo __('Wartość oferty').': ';
			
			echo showPrice($sum_brutto, true, $currency['Currency']['code']);
		?>
	</div>
	
	<div class="clear" style="height: 20px;"></div>
	
	<?php if (Configure::read('Config.language') == 'pol'): ?>
		<div class="block" style="padding: 10px 5px;">
			Słownie: <?php echo priceToText(number_format($sum_brutto, 2, '.', '')) ?>
		</div>
		
		<div class="clear" style="height: 20px;"></div>
	<?php endif ?>
<?php endif ?>

<?php if (!empty($user_cart_offer['UserCartOffer']['comments']) && $user_cart_offer['UserCartOffer']['comments_on_pdf']): ?>
	<div class="block" style="padding: 10px 5px;">
		<?php echo nl2br($user_cart_offer['UserCartOffer']['comments']) ?>
	</div>
	
	<div class="clear" style="height: 20px;"></div>
<?php endif ?>

<?php if ($user_cart_fields): ?>
	<div class="block" style="padding: 10px 5px;">
		<?php
			foreach ($user_cart_fields as $user_cart_field_name => $user_cart_field_value):
				echo $user_cart_field_name.': '.$user_cart_field_value.'<br/>';
			endforeach;
		?>
	</div>
	
	<div class="clear" style="height: 20px;"></div>
<?php endif ?>

<div class="clear"></div>