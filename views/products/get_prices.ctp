<?php
	$product_fields = getProductsFields(
		$products,
		array(
			'`Product`.`new`',
			'`Product`.`bestseller`',
			'`Product`.`inventory_availibility_status_id`',
			'`Product`.`unit`',
			'`InventoryAvailibilityStatus`.`sellable`'
		),
		array(
			'InventoryAvailibilityStatus'
		)
	);
	
	$inventory_statuses                        = getInventoryAvailibilityStatusesList(null, false);
	$prices_type                               = getDefaultPricesType();
	$user_access_to_cart                       = userAccessToAddToCart();
	$user_access_to_product_quantity           = userAccessToProductQuantity();
	$user_access_to_price                      = userAccessToPrice();
	$user_can_add_not_sellable_product_to_cart = checkCanAddNotSellableProductToCart();
	
	if ($user_access_to_price):
		$products_prices = getProductsPrices($products);
	endif;
	
	if ($user_access_to_product_quantity):
		$scheduled_quantities = Set::combine(getScheduledProductsQuantity($products), '{n}.Product.id', '{n}.Product.quantity');
		$units                = getProductUnitsList('short');
	endif;
?>

<?php $product_prices = array() ?>

<?php foreach ($products as $product_id): ?>
	<?php
		$price = array();
		
		if ($user_access_to_price):
			$price = $products_prices[$product_id];
			
			if ($price['price'] || !setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') || !$price['price'] && setting('GLOBAL_ORDERS_WITH_ZERO_PRICE_PRODUCTS') && (setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && $price['loyalty_points_price'] === null) || !setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES')):
				if (isset($price['base_price'])):
					$product_prices[$product_id]['discount-price'] = showPrice($prices_type == 'netto' ? $price['netto_price'] : $price['price']);
					$product_prices[$product_id]['base-price']     = showPrice($prices_type == 'netto' ? $price['netto_base_price'] : $price['base_price']);
				else :
					$product_prices[$product_id]['price'] = showPrice($prices_type == 'netto' ? $price['netto_price'] : $price['price']);
				endif;
			elseif ($price['price'] == 0 && setting('MODULE_LOYALTY_PRODUCTS_POINTS_PRICES') && $price['loyalty_points_price'] !== null):
				$product_prices[$product_id]['price'] = showProductLoyaltyPrice($product_id, $price['loyalty_points_price']);
			else:
				$product_prices[$product_id]['price'] = '-';
			endif;
		else:
			$product_prices[$product_id]['price-container'] = 0;
			$product_prices[$product_id]['price-label']     = 0;
		endif;
		
		$product_prices[$product_id]['sellable'] = 1;
		
		if (!$user_access_to_cart || isset($excluded_products[$product_id])):
			$product_prices[$product_id]['sellable'] = 0;
			
			if (setting('MODULE_B2B_SHOW_AVAILABILITY_TO_NOT_LOGGED_USERS')):
				$product_prices[$product_id]['ias'] = $inventory_statuses[$product_fields[$product_id]['Product']['inventory_availibility_status_id']];
			else:
				$product_prices[$product_id]['ias'] = '';
			endif;
		elseif (module('INVENTORY')):
			$product_prices[$product_id]['ias'] = $inventory_statuses[$product_fields[$product_id]['Product']['inventory_availibility_status_id']];
			
			if (!$user_can_add_not_sellable_product_to_cart):
				$product_prices[$product_id]['sellable'] = (int) $product_fields[$product_id]['InventoryAvailibilityStatus']['sellable'];
			endif;
		endif;
		
		if ($user_access_to_product_quantity):
			$product_prices[$product_id]['quantity'] = showQuantityValue($scheduled_quantities[$product_id], $product_id, $units[$product_fields[$product_id]['Product']['unit']]);
		else:
			$product_prices[$product_id]['quantity'] = '-';
		endif;
		
		$prod_description = strip_tags(getProductDescription($product_id));
		$strlen_description = strlen($prod_description);
		$substr_description = substr($prod_description, 0, 200);
		$explode_description = explode(' ', $substr_description);
		array_pop($explode_description);
		$implode_description = implode(' ', $explode_description);
		
		if ( $strlen_description > 200 ) {
			$product_prices[$product_id]['desc'] = $implode_description.'...';
		} else {
			$product_prices[$product_id]['desc'] = $prod_description;
		};
		
		$product_prices[$product_id]['code'] = getProductCode($product_id);
		$product_prices[$product_id]['label-promotion']  = isset($price['base_price']) && !$price['sale_id'] ? 1 : 0;
		$product_prices[$product_id]['label-sale']       = isset($price['base_price']) && $price['sale_id'] ? 1 : 0;
		$product_prices[$product_id]['label-bestseller'] = (int) $product_fields[$product_id]['Product']['bestseller'];
		$product_prices[$product_id]['label-new']        = (int) $product_fields[$product_id]['Product']['new'];
		
		$product_prices[$product_id]['group-add-checkbox-sellable'] = $product_prices[$product_id]['sellable'];
	?>
<?php endforeach ?>

<?php echo json_encode($product_prices) ?>