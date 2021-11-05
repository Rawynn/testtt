<?php
	$output = array();
	
	if (isCartAnyAmountGratisChanged()):
		$output['reload'] = $this->Html->url(getCartUrl());
	else:
		if (!isset($keys) && isset($key)):
			$keys = array($key);
		endif;
		
		if (isset($keys)):
			/* Ceny produktów w koszyku */
			$products = getCartProducts(getDefaultPricesType(), userIsSalesrep());
			
			foreach ($keys as $key):
				if (isset($products[$key])):
					if (!$products[$key]['loyalty_points']):
						$product_price         = userIsSalesrep() ? number_format($products[$key]['single_price'], 2, ',', '') : showPrice($products[$key]['single_price']);
						$product_base_price	   = userIsSalesrep() ? number_format($products[$key]['product_base_price'], 2, ',', '') : showPrice($products[$key]['product_base_price']);
						$product_summary_price = showPrice($products[$key]['price']);
					else:
						$product_price         = showProductLoyaltyPrice($products[$key]['product_id']);
						$product_summary_price = showProductLoyaltyPrice($products[$key]['product_id'], $products[$key]['quantity'] * getProductLoyaltyPrice($products[$key]['product_id']));
						
						if ($products[$key]['single_price'] > 0):
							$product_base_price    = $products[$key]['product_base_price'] > $products[$key]['single_price'] ? '<span class="base-price">'.showPrice($products[$key]['product_base_price']).'</span>' : '';
							$product_price         = showPrice($products[$key]['single_price']).$product_base_price.'<br>'.$product_price;
							$product_summary_price = showPrice($products[$key]['price']).'<br>'.$product_summary_price;
						endif;
					endif;
					
					$output['product'][$key]['fields'] = array(
						'price'         => $product_price,
						'base-price'    => $product_base_price,
						'single-price'  => showPrice($products[$key]['single_price'], false),
						'summary-price' => $product_summary_price,
						'quantity'      => showQuantityValue($products[$key]['quantity'])
					);
					
					if (module('INVENTORY')):
						if ($products[$key]['combination_id'] && is_numeric($products[$key]['combination_id'])):
							$output['product'][$key]['fields']['ias'] = getCartCombinationAvailibilityStatusName($products[$key]['combination_id'], getFullProductQuantityInCart($key));
						else:
							$output['product'][$key]['fields']['ias'] = getCartProductAvailibilityStatusName($products[$key]['product_id'], getFullProductQuantityInCart($key));
						endif;
					endif;
					
					if (userIsSalesrep()):
						$output['product'][$key]['fields']['number']          = $products[$key]['number'];
						$output['product'][$key]['fields']['purchase-price']  = showPrice($products[$key]['purchase_price'], false);
						$output['product'][$key]['fields']['suggested-price'] = showPrice($products[$key]['suggested_price'], false);
						
						$output['product'][$key]['fields']['margin']       = number_format($products[$key]['margin'], 2, ',', '').'%';
						$output['product'][$key]['fields']['margin-value'] = showPrice($products[$key]['margin_value']);
						
						$output['product'][$key]['fields']['rabat'] = number_format($products[$key]['rabat'], 2, ',', '').'%';
						
						$output['product'][$key]['fields']['custom-description'] = $products[$key]['custom_description'];
					endif;
					
					$output['product'][$key]['loyalty'] = array(
						'hide'     => getLoggedUserId() && isset($no_user_points) && $no_user_points === true ? 1 : 0,
						'selected' => $products[$key]['loyalty_points'],
						'points'   => isset($__points) ? h(sprintf(__('wymień punkty - %s pkt.', true), $__points)) : 0
					);
					
					/* Kombinacje */
					if ($products[$key]['combination_id']):
						if (is_array($products[$key]['combination_id']) && module('KITS') && ($kit_id = getProductField($products[$key]['product_id'], 'kit_id'))):
							/* Zestaw */
							if (setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM')):
								if ($extended_kit_variants = getProductExtendedKitCombinations($products[$key]['product_id'], $products[$key]['selected_kit_products'], true, true)):
									foreach ($extended_kit_variants as $kit_product):
										for ($item_number = 1; $item_number <= $kit_product['quantity']; $item_number++):
											$output['combination'][$key]['kit_combinations'][$kit_product['product_id']][$item_number] = isset($products[$key]['combination_id'][$kit_product['product_id']][$item_number]) ? $kit_product['variants'][$products[$key]['combination_id'][$kit_product['product_id']][$item_number]] : '-';
										endfor;
									endforeach;
								endif;
							elseif ($kit_variants = getProductKitCombinations($products[$key]['product_id'], $products[$key]['selected_kit_products'], true, true)):
								foreach ($kit_variants as $kit_product_id => $kit_product_combinations):
									$output['combination'][$key]['kit_combinations'][$kit_product_id] = isset($products[$key]['combination_id'][$kit_product_id]) ? $kit_product_combinations[$products[$key]['combination_id'][$kit_product_id]] : '-';
								endforeach;
							endif;
						else:
							/* Zwykły produkt */
							$product_combinations = getProductPossibleCombinations($products[$key]['product_id']);
							
							if ($product_combinations):
								$current_combination  = $product_combinations[$products[$key]['combination_id']];
								
								foreach ($current_combination as $attribute):
									$output['combination'][$key]['attributes'][$attribute['attribute_id']] = $attribute['attribute_value_name'];
								endforeach;
							endif;
						endif;
						
						$output['combination'][$key]['image'] = $this->element(
							'_default'.DS.'miniature',
							array(
								'file'  => array(
									'type'     => configuration('ProductMedium.dir'),
									'filename' => $products[$key]['filename'] ? $products[$key]['filename'] : (($filename = getCombinationField($products[$key]['combination_id'], 'filename')) ? $filename : getProductMainPhotoId($products[$key]['product_id'], 'filename')),
									'dir'      => $products[$key]['filename'] ? $products[$key]['dir'] : (($dir = getCombinationField($products[$key]['combination_id'], 'dir')) ? $dir : getProductMainPhotoId($products[$key]['product_id'], 'dir'))
								),
								'image' => array(
									'resize'     => 'resize',
									'width'      => 200,
									'height'     => 200,
									'no_photo'   => true,
									'watermark'  => $products[$key]['product_id'],
									'background' => array(
										'R' => 255,
										'G' => 255,
										'B' => 255
									)
								),
								'html'  => array(
									'image' => array(
										'alt' => h(getProductName($products[$key]['product_id']))
									)
								)
							)
						);
					endif;
				endif;
				
				if (isset($product['min_order'])):
					if ($product['lower_quantity'] != $product['more_quantity']):
						$output['product'][$key]['warnings']['quantity'] =  sprintf(__('Minimum logistyczne: %s (możliwe wartości: %s/%s).', true), showQuantityValue($product['min_order'], $product['product_id']), showQuantityValue($product['lower_quantity'], $product['product_id']), showQuantityValue($product['more_quantity'], $product['product_id']));
					else:
						$output['product'][$key]['warnings']['quantity'] =  sprintf(__('Minimum logistyczne: %s (możliwa wartość: %s).', true), showQuantityValue($product['min_order'], $product['product_id']), showQuantityValue($product['lower_quantity'], $product['product_id']));
					endif;
				endif;
			endforeach;
		endif;
		
		/* Wybrana forma dostawy */
		$output['shipping']['id'] = getCartShippingMethodId();
		
		/* Formy dostawy - etykiety */
		$output['shipping']['labels'] = getShippingMethodsList(true, false, true, getDefaultPricesType());
		
		/* Formy dostawy - wykluczenia */
		foreach (getShippingMethodExclusionsExtended() as $exclusion => $type):
			if ($type != array('payment_method')):
				$output['shipping']['exclusion'][] = $exclusion;
			endif;
		endforeach;
		
		/* Formy dostawy - darmowa dostawa za punkty */
		$output['shipping']['loyalty'] = isFreeLoyaltyShippingInCart() ? 1 : 0;
		
		/* Formy dostawy - informacja o darmowej dostawie */
		$output['shipping']['free'] = ($deficiency = getCartFreeShippingDeficiency()) ? showPrice($deficiency) : 0;
		
		/* Formy dostawy - informacja o produktach do darmowej dostawy */
		$output['shipping']['free_products'] = $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'free_shipping_products',
			array(
				'deficiency' => $deficiency
			)
		);
		
		/* Formy dostawy - sms */
		$output['shipping']['sms'] = array(
			'show'   => (int) getShippingMethodSmsCost(getCartShippingMethodId()),
			'select' => (int) getCartSMS()
		);
		
		/* Wybrana forma płatności */
		$output['payment']['id'] = getCartPaymentMethodId();
		
		/* Formy płatności - etykiety */
		$output['payment']['labels'] = getPaymentMethodsList(true, false, getCurrencyPrecision(), getDefaultPricesType());
		
		/* Formy płatności - wykluczenia */
		$output['payment']['exclusion'] = getShippingMethodExclusions(getCartShippingMethodId());
		
		/* Formy płatności - Raty Żagiel */
		$output['payment']['zagiel'] = array(
			'show'  => module('ZAGIEL') && !(getCartPaymentMethodId() == setting('MODULE_ZAGIEL_PAYMENT_METHOD_ID')) ? 0 : 1,
			'price' => number_format(getCartPriceToPay(), 2, '.', '')
		);
		
		/* Formy płatności - Raty BGŻ BNP Paribas*/
		$output['payment']['paribas'] = array(
			'show'  => module('SYGMA') && !(getCartPaymentMethodId() == setting('MODULE_SYGMA_PAYMENT_METHOD_ID')) ? 0 : 1,
			'price' => number_format(getCartPriceToPay(), 2, '.', '')
		);
		
		/* Formy płatności - Platforma Finansowa */
		$output['payment']['platforma_finansowa'] = array(
			'show'  => module('MODULE_PLATFORMA_FINANSOWA') && !(in_array(getCartPaymentMethodId(), explode(',', setting('MODULE_PLATFORMA_FINANSOWA_I_RATY_PAYMENT_METHOD_ID')))) ? 0 : 1,
			'price' => number_format(getCartPriceToPay(), 2, '.', '')
		);
		
		/* Formy płatności - Credit Agricole */
		$output['payment']['credit_agricole'] = array(
			'show'  => module('MODULE_CREDIT_AGRICOLE') && !(in_array(getCartPaymentMethodId(), explode(',', setting('MODULE_CREDIT_AGRICOLE_PAYMENT_METHOD_ID')))) ? 0 : 1,
			'price' => number_format(getCartPriceToPay(), 2, '.', '')
		);
		
		/* Dropshipping - wartość pobrania */
		$output['payment']['dropshipping_cod_value'] = array(
			'show' => getCartDropshipping() && isCodInCart() && !in_array(getCartPaymentMethodId(), $output['payment']['exclusion']) ? 1 : 0
		);
		
		/* Uaktualnienie kosztów dostawy/płatności/kuponu itd. koszyka */
		$coupon_price = getCartCouponPrice();
		
		$shipping_price_in_cart = showShippingPriceInCart(getDefaultPricesType());
		
		if (module('B2B') && checkIsNoCalculateShippingMethod(getCartShippingMethodId())):
			$shipping_price_in_cart = '-';
		endif;
		
		$voucher = getCartVoucher();
		
		$loyalty_price = getCartLoyaltyPaymentAllowedPrice();
		
		/* Darmowa dostawa od */
		$free_shipping_from = getCartFreeShippingFromPrice();
		
		$output['costs'] = array(
			//Cena kosztów dostawy
			array(
				'field' => 'cart-shipping-price',
				'value' => $shipping_price_in_cart
			),
			array(
				'field' => 'cart-shipping-price-input',
				'value' => showShippingPriceInCart(getDefaultPricesType(), false)
			),
			//Cena kosztów płatności
			array(
				'field' => 'cart-payment-price',
				'value' => showPrice(getCartPaymentMethodPrice(getDefaultPricesType()))
			),
			array(
				'field' => 'cart-payment-price-input',
				'value' => showPrice(getCartPaymentMethodPrice(getDefaultPricesType()), false)
			),
			//Cena bez kosztów dostawy/płatności
			array(
				'field' => 'cart-price',
				'value' => showPrice(getCartSumProductsPrice(getDefaultPricesType()))
			),
			//Cena całkowita brutto
			array(
				'field' => 'cart-total-price',
				'value' => showPrice(getCartPriceToPay())
			),
			//Cena całkowita brutto przed przedpłatą
			array(
				'field' => 'cart-base-price',
				'value' => showPrice(getCartBasePrice())
			),
			//Cena całkowita netto
			array(
				'field' => 'cart-total-netto-price',
				'value' => showPrice(getCartPriceToPay('netto'))
			),
			// Kwota VAT
			array(
				'field' => 'cart-total-vat',
				'value' => showPrice(getCartVatValue())
			),
			//Całkowita ilość
			array(
				'field' => 'cart-sum-quantity',
				'value' => showQuantityValue(getRealProductsCountInCart()).' '.__('szt.', true)
			),
			//Koszt kuponu rabatowego
			array(
				'field' => 'cart-coupon-price',
				'value' => $coupon_price != 0 ? showPrice((-1) * $coupon_price) : '-'
			),
			//Wykorzystane punkty programy lojalnościowego
			array(
				'field'  => 'cart-point-delete',
				'value'  => ($delete_loyalty_points = getCartDeletePoints()),
				'toggle' => (int) $delete_loyalty_points
			),
			//Dodane punkty programy lojalnościowego
			array(
				'field'  => 'cart-point-add',
				'value'  => ($add_loyalty_points = getCartAddPoints()),
				'toggle' => (int) $add_loyalty_points
			),
			//Czas dostawy
			array(
				'field'  => 'cart-shipping-time',
				'value'  => ($shipping_method_time = anticipateCartDeliveryTime()) ? $shipping_method_time : '-',
				'toggle' => (int) $shipping_method_time
			),
			//Wartość bonu
			array(
				'field' => 'cart-voucher-price',
				'value' => $voucher ? showPrice((-1) * $voucher['price']) : ''
			),
			//Przedpłata z kredytu kupieckiego
			array(
				'field' => 'cart-credit-payment',
				'value' => getCartCreditPayment() > 0  ? showPrice((-1) * getCartCreditPayment()) : ''
			),
			//Marża na koszyku
			array(
				'field' => 'cart-margin-sum',
				'value' => showPrice(getCartMarginSum())
			),
			//Zapłata punktami progrmau lojalnościowego
			array(
				'field' => 'loyalty-price-price',
				'value' => getCartLoyaltyPrice('price') ? showPrice((-1) * getCartLoyaltyPrice('price')) : '-'
			),
			//Zapłata punktami progrmau lojalnościowego
			array(
				'field' => 'loyalty-price-label',
				'value' => $loyalty_price ? sprintf(__('Wykorzystaj punkty programu lojalnościowego %s pkt -> %s.', true), $loyalty_price['points'], showPrice($loyalty_price['price'])) : ''
			),
			array(
				'field' => 'free-shipping-from-price',
				'valie' => $free_shipping_from ? showPrice($free_shipping_from) : ''
			)
		);
		
		/* Znizki ilościowe */
		if (setting('MODULE_B2B_FULL_PACKAGES_DISCOUNT') > 0):
			if ($full_package_discount = getFullPackageDiscountInCart(getDefaultPricesType())):
				$products          = '';
				$discount_products = getFullPackageDiscountProductsInCart(getDefaultPricesType());
				
				foreach ($discount_products as $discount_product):
					$products .= $this->Html->tag(
						'li',
						false
					);
						$products .= getProductName($discount_product['product_id']);
						$products .= ': ';
						$products .= $this->Html->tag(
							'strong',
							showPrice($discount_product['package_discount'])
						);
					$products .= $this->Html->tag(
						'/li'
					);
				endforeach;
				
				$output['discount'] = array(
					'show'     => 1,
					'price'    => showPrice((-1) * $full_package_discount),
					'products' => $products
				);
			else:
				$output['discount'] = array(
					'show'     => 0,
					'price'    => '-',
					'products' => ''
				);
			endif;
		endif;
		
		/* Promocje wiązane */
		$output['bound_specials'] = $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'bound_specials');
		
		/* Pobranie */
		$output['cod'] = (int) isCodInCart();
		
		/* Możliwość resetu ceny */
		$output['reset_prices'] = (int) getCartHasAnyLockedPrices();
		
		/* Ostrzeżenie przed bonem */
		$output['voucher_message'] = $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'1'.DS.'cart_voucher_message');
		
		/* PayPal Express Checkout */
		$output['paypal_express_checkout'] = getCartPaymentMethodId() == setting('MODULE_PAYPAL_EXPRESS_CHECKOUT_PAYMENT_METHOD_ID');
		
		/* Boks koszyka */
		$output['cart_box'] = $this->element(
			TEMPLATE_NAME.DS.'boxes'.DS.'cart',
			array(
				'id' => 'Cart'
			)
		);
	endif;
	
	echo json_encode($output);
?>