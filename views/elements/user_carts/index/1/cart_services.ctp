<?php if (module('SERVICES')): ?>
	<?php
		if (!isset($cart_blocked)):
			$cart_blocked = false;
		endif;
	?>
	
	<?php if ($services): ?>
		<?php
			if ($services_for_products):
				$services_in_cart = getProductServicesInCart($product_id, $combination_id, $width, $height, $price, $selected_kit_products, $add_time);
			else:
				$services_in_cart = getServicesInCart();
			endif;
			
			if (setting('MODULE_SERVICES_CHOOSING_ONE_SERVICE') == 'false'):
				$service_input_type = 'checkbox';
			else:
				$service_input_type = 'radio';
			endif;
			
			if (!isset($quantity)):
				$quantity = 1;
			endif;
			
			$sort_services = array();
			
			if (!setting('MODULE_SERVICES_FORCE_ZERO_PRICE_WHEN_SERVICE')):
				/* Pobieram ceny */
				$services_prices = getProductsPrices(Set::extract($services, '{n}.Product.id'));
			endif;
			
			foreach ($services as $service_key => $service):
				if ($services_for_products):
					$service['Service']['prefix'] = 'ServiceProduct.'.$key;
				else:
					$service['Service']['prefix'] = 'Service';
				endif;
				
				if (setting('MODULE_SERVICES_CHOOSING_ONE_SERVICE') == 'true'):
					$service_key = 0;
				elseif (setting('MODULE_SERVICES_CHOOSING_ONE_SERVICE') == 'true_in_group'):
					$service_key = md5($service['Service']['code']);
				endif;
				
				$service['Service']['key']  = $service_key;
				$service['Service']['cart'] = isset($services_in_cart[$service['Product']['id']]) ? $services_in_cart[$service['Product']['id']] : false;
				
				if (!setting('MODULE_SERVICES_FORCE_ZERO_PRICE_WHEN_SERVICE')):
					$service['Product']['prices'] = $services_prices[$service['Product']['id']];
				endif;
				
				$service_code = $service['Service']['code'] ? $service['Service']['code'] : __('Wybierz', true);
				
				$sort_services[$service_code][] = $service;
			endforeach;
			
			if (!$services_for_products):
				/* Czy można dodać komentarz do produktu */
				$can_add_comments_to_products = canAddCommentToProductsInCart(Set::extract($services, '{n}.Product.id'));
			endif;
			
			if (setting('MODULE_SERVICES_USER_QUANTITY')):
				/* Kroki w produktach */
				$products_quantity_step = getProductsQuantityStep(Set::extract($services, '{n}.Product.id'));
			endif;
		?>
		
		<tr class="product-row service-row service-for-cart-<?php echo $services_for_products ? 'false' : 'true' ?> service-label">
			<?php
				$colspan = 6;
				
				if (userIsSalesrep()):
					if (getDefaultPricesType() == 'netto'):
						$colspan = 12;
					else:
						$colspan = 11;
					endif;
					
					if ($edit_offer_mode):
						$colspan++;//Dla kolumny Nr
					endif;
				endif;
			?>
			
			<?php if ($services_for_products): ?>
				<?php $colspan-- ?>
				
				<td class="service-empty-column">
					&nbsp;
				</td>
			<?php endif ?>
			
			<td colspan="<?php echo $colspan ?>" class="<?php echo $services_for_products ? 'product-service' : '' ?>">
				<h2>
					<?php
						if ($services_for_products):
							__('Dodatkowo do produktu');
						else:
							__('Dodatkowo do wyboru');
						endif;
					?>:
				</h2>
			</td>
		</tr>
		
		<?php $current_service_type = '' ?>
		
		<?php foreach ($sort_services as $service_type => $services): ?>
			<?php foreach ($services as $service_key => $service): ?>
				<tr class="product-row service-row">
					<?php if ($services_for_products): ?>
						<td class="service-empty-column">
							&nbsp;
						</td>
					<?php endif ?>
					
					<?php if ($current_service_type != $service_type): ?>
						<?php
							$current_service_type = $service_type
						?>
						
						<td class="service-type <?php echo $services_for_products ? 'product-service-type' : '' ?>" rowspan="<?php echo count($services) ?>">
							<?php echo $service_type ?>:
						</td>
					<?php endif ?>
					
					<td class="service-list" colspan="<?php echo $services_for_products ? 1 : 2 ?>">
						<div class="input <?php echo $service_input_type ?>">
							<?php
								$options = array(
									'div'              => false,
									'type'             => $service_input_type,
									'label'            => $service['Product']['name'],
									'data-type'        => 'change-service',
									'data-product-key' => $key,
									'checked'          => $service['Service']['cart'] ? true : false,
									'value'            => $service_input_type == 'checkbox' ? $service['Product']['id'] : null,
									'hiddenField'      => false,
									'disabled'         => $cart_blocked
								);
								
								if ($service_input_type != 'checkbox'):
									$options['options'] = array(
										$service['Product']['id'] => $service['Product']['name']
									);
								endif;
								
								echo $this->Form->input($service['Service']['prefix'].'.'.$service['Service']['key'].'.product_id', $options);
							?>
							
							<?php if (!$services_for_products && $service['Service']['cart'] && $can_add_comments_to_products[$service['Product']['id']]): ?>
								<a data-toggle="modal" href="#EditProductCustomDescription<?php echo getCartServiceKeyInCart($service['Product']['id']) ?>" role="button" title="<?php echo h(__('Wprowadź informacje dodatkowe', true)) ?>">
									<i class="fa fa-edit"></i>
								</a>
							<?php endif ?>
						</div>
					</td>
					
					<?php if (userIsSalesrep()): ?>
						<td class="service-empty-column">
							&nbsp;
						</td>
						<td class="service-empty-column">
							&nbsp;
						</td>
						<td class="service-empty-column">
							&nbsp;
						</td>
						<td class="service-empty-column">
							&nbsp;
						</td>
						<td class="service-empty-column">
							&nbsp;
						</td>
					<?php endif ?>
					
					<td class="service-price">
						<?php if (!setting('MODULE_SERVICES_FORCE_ZERO_PRICE_WHEN_SERVICE')): ?>
							<?php echo showPrice(getDefaultPricesType() == 'netto' ? $service['Product']['prices']['netto_price'] : $service['Product']['prices']['price']) ?>
						<?php endif ?>
					</td>
					
					<?php if (userIsSalesrep() && getDefaultPricesType() == 'netto'): ?>
						<td class="service-price">
							<?php echo getProductTaxValue($service['Product']['id']) ?>%
						</td>
					<?php endif ?>
					
					<td class="service-quantity">
						<?php if (setting('MODULE_SERVICES_USER_QUANTITY')): ?>
							<?php
								echo $this->Form->input(
									$service['Service']['prefix'].'.'.$service['Service']['key'].'.quantity',
									array(
										'type'               => 'text',
										'data-type'          => 'change-service-quantity',
										'data-service-id'    => $service['Product']['id'],
										'data-product-key'   => $key,
										'data-step'          => $products_quantity_step[$service['Product']['id']],
										'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
										'data-max'           => getProductQuantityInputDataMax($service['Product']['id']),
										'data-unit'          => getProductUnit($service['Product']['id']),
										'data-show-controls' => 1,
										'data-trigger'       => 'cart.change.service.quantity',
										'div'                => false,
										'label'              => false,
										'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
										'value'              => showQuantityValue($service['Service']['cart'] ? $service['Service']['cart'] : $quantity),
										'disabled'           => $service['Service']['cart'] ? false : 'disabled'
									)
								)
							?>
						<?php else: ?>
							<?php echo showQuantityValue($quantity, $service['Product']['id']) ?>
						<?php endif ?>
					</td>
					<td class="service-summary">
						<?php if (!setting('MODULE_SERVICES_FORCE_ZERO_PRICE_WHEN_SERVICE')): ?>
							<span>
								<?php echo showPrice(getCartServicePrice($service, $quantity)) ?>
							</span>
						<?php else: ?>
							<span>-</span>
						<?php endif ?>
						
						<?php if (isset($services_in_cart[$service['Product']['id']]) && $service_input_type == 'radio'): ?>
							<br>
							
							<a class="service-delete" data-type="delete-service" data-product-key="<?php echo $key ?>" data-service-id="<?php echo $service['Product']['id'] ?>" href="#" title="<?php echo h(__('Usuń usługę z koszyka', true)) ?>">
								<?php __('usuń') ?> <i class="fa fa-times"></i>
							</a>
						<?php else: ?>
							<span class="service-delete inactive">&nbsp;</span>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endforeach ?>
	<?php endif ?>
<?php endif ?>