<?php if ($services = getServicesForProductList($product_id, $combination_id)): ?>
	<div class="product-services">
		<?php
			if (setting('MODULE_SERVICES_CHOOSING_ONE_SERVICE') == 'false'):
				$service_input_type = 'checkbox';
			else:
				$service_input_type = 'radio';
			endif;
			
			$current_service_type = '';
			$sort_services        = array();
			
			foreach ($services as $service_key => $service):
				if (setting('MODULE_SERVICES_CHOOSING_ONE_SERVICE') == 'true'):
					$service_key = 0;
				elseif (setting('MODULE_SERVICES_CHOOSING_ONE_SERVICE') == 'true_in_group'):
					$service_key = md5($service['Service']['code']);
				endif;
				
				$service['Service']['key']  = $service_key;
				
				if (!setting('MODULE_SERVICES_FORCE_ZERO_PRICE_WHEN_SERVICE')):
					$service['Product']['prices'] = getProductPrice($service['Product']['id']);
					$service['Product']['name']   = $service['Product']['name'].' - '.showPrice(getDefaultPricesType() == 'netto' ? $service['Product']['prices']['netto_price'] : $service['Product']['prices']['price']);
				endif;
				
				$service_code = $service['Service']['code'] ? $service['Service']['code'] : __('Wybierz dodatkowo', true);
				
				$sort_services[$service_code][] = $service;
			endforeach;
			
			if (!isset($service_prefix)):
				$service_prefix = '';
			endif;
		?>
		
		<?php foreach ($sort_services as $service_type => $services): ?>
			<?php foreach ($services as $service_key => $service): ?>
				<?php if ($current_service_type != $service_type): ?>
					<?php $current_service_type = $service_type ?>
					
					<h3 class="product-service-label">
						<?php echo $service_type ?>:
					</h3>
				<?php endif ?>
				
				<div class="product-service-row <?php echo $service_input_type ?> <?php echo setting('MODULE_SERVICES_USER_QUANTITY') ? '' : 'width100' ?>">
					<?php
						echo $this->Form->input(
							'Service'.'.'.$service['Service']['key'].'.product_id',
							array(
								'type'             => $service_input_type,
								'label'            => $service['Product']['name'],
								'div'              => false,
								'data-type'        => 'change-service',
								'data-service-key' => $service['Service']['key'],
								'data-prefix'      => $service_prefix,
								'value'            => $service_input_type == 'checkbox' ? $service['Product']['id'] : null,
								'hiddenField'      => false,
								'id'               => $service_prefix? $service_prefix.'Service'.$service['Service']['key'].'ProductId' : null,
								'options'          => array(
									$service['Product']['id'] => $service['Product']['name']
								)
							)
						)
					?>
					
					<?php if (setting('MODULE_SERVICES_USER_QUANTITY')): ?>
						<div class="product-service-quantity">
							<?php
								echo $this->Form->input(
									'Service'.'.'.$service['Service']['key'].'.quantity',
									array(
										'type'               => 'text',
										'data-type'          => 'change-service-quantity',
										'data-service-key'   => $service['Service']['key'],
										'data-service-id'    => $service['Product']['id'],
										'data-step'          => getProductQuantityStep($service['Product']['id']),
										'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
										'data-max'           => 999,
										'data-unit'          => getProductUnit($service['Product']['id']),
										'data-show-controls' => 1,
										'data-prefix'        => $service_prefix,
										'div'                => false,
										'label'              => false,
										'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
										'default'            => number_format(getProductDefaultQuantity($service['Product']['id']), (int)setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'), ',', ''),
										'disabled'           => 'disabled',
										'id'                 => $service_prefix ? $service_prefix.'Service'.$service['Service']['key'].'Quantity' : null
									)
								)
							?>
						</div>
					<?php endif ?>
				</div>
				
				<?php if (canAddCommentToProductInCart($service['Product']['id'])): ?>
					<?php
						$class = 'hide';
						
						if (!empty($this->data['Service'][$service['Service']['key']]['product_id']) && $this->data['Service'][$service['Service']['key']]['product_id'] == $service['Product']['id']):
							$class = "";
						endif;
					?>
					
					<div class="<?php echo $class ?>" data-type="service-product-custom-description" data-prefix="<?php echo $service_prefix ?>" data-product-id="<?php echo $service['Product']['id'] ?>">
						<hr>
						
						<h3>
							<?php __('Dodatkowe informacje do usługi') ?>
						</h3>
						
						<?php
							echo $this->Form->input(
								'Service'.'.'.$service['Service']['key'].'.description',
								array(
									'div'         => false,
									'label'       => false,
									'type'        => 'textarea',
									'class'       => 'form-control',
									'disabled'    => $class == 'hide' ? 'disabled' : '',
									'data-prefix' => $service_prefix,
									'id'          => $service_prefix ? $service_prefix.'Service'.$service['Service']['key'].'Description' : null
								)
							)
						?>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		<?php endforeach ?>
	</div>
<?php endif ?>