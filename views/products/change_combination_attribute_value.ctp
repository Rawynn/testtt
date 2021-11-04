<?php
	$output = array();
	
	if (getPageParamValue('type') == 'unavailable'):
		$output['variants'] = $this->element(
			TEMPLATE_NAME.DS.'product'.DS.'unavailable_variants',
			array(
				'product_id' => $product_id
			)
		);
	else:
		if (isset($kit_variants)):
			$output['variants'] = $this->element(
				TEMPLATE_NAME.DS.'product'.DS.'kit_variants',
				array(
					'kit_variants' => $kit_variants
				)
			);
		else:
			$output['variants'] = $this->element(
				TEMPLATE_NAME.DS.'product'.DS.'variants',
				array(
					'product_id' => $product_id
				)
			);
		endif;
		
		if (module('SERVICES') && $combination_id):
			$output['services'] = $this->element(
				TEMPLATE_NAME.DS.'product'.DS.'services',
				array(
					'product_id'     => $product_id,
					'combination_id' => $combination_id
				)
			);
		endif;
		
		$product_price = getProductPrice($product_id, $selected_combinations ? $selected_combinations : $combination_id, null, false, $selected_kit_products);
		
		if ($product_price['price'] || !setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES')):
			$output['fields']['product-price']       = showPrice($product_price['price']);
			$output['fields']['product-netto-price'] = showPrice($product_price['netto_price']);
			
			if (isset($product_price['base_price'])):
				$output['fields']['product-base-price']       = showPrice($product_price['base_price']);
				$output['fields']['product-base-netto-price'] = showPrice($product_price['netto_base_price']);
			else:
				$output['fields']['product-base-price']       = '';
				$output['fields']['product-base-netto-price'] = '';
			endif;
		elseif (!$product_price['price'] && setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && getProductLoyaltyPrice($product_id)):
			$output['fields']['product-price']            = showProductLoyaltyPrice($product_id);
			$output['fields']['product-netto-price']      = showProductLoyaltyPrice($product_id);
			$output['fields']['product-base-price']       = '';
			$output['fields']['product-base-netto-price'] = '';
		else:
			$output['fields']['product-price']            = '-';
			$output['fields']['product-netto-price']      = '-';
			$output['fields']['product-base-price']       = '';
			$output['fields']['product-base-netto-price'] = '';
		endif;
		
		/* Informacja o dostępności */
		if (setting('MODULE_INVENTORY_SHOW_AVAILIBILITY')):
			$quantity = !empty($this->data['User']['quantity']) ? str_replace(',', '.', $this->data['User']['quantity']) : getProductField($product_id, 'min_order');
			
			$output['fields']['product-availability'] = $combination_id ? getCartCombinationAvailibilityStatusName($combination_id, $quantity) : (getProductField($product_id, 'has_combinations') ? getProductInventoryAvailibilityStatusName($product_id) : getCartProductAvailibilityStatusName($product_id, $quantity));
		endif;
		
		/* Kod produktu */
		$output['fields']['product-code'] = $combination_id && ($combination_code = getCombinationCode($combination_id)) ? $combination_code : getProductCode($product_id);
		
		/* ID wariantu */
		$output['inputs']['product-change-quantity-input']['combination-id'] = (int) $combination_id;
		
		/* Dostępna ilość */
		$output['inputs']['product-change-quantity-input']['max'] = getProductQuantityInputDataMax($product_id, $combination_id);
		
		/* ID wariantu */
		$output['combination_id'] = (int) $combination_id;
		
		/* Cena */
		$output['price'] = number_format($product_price['price'], 2, '.', '');
	endif;
	
	echo json_encode($output);
?>