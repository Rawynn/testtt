<?php if (module('SERVICES') && $added_product_info && !$added_product_info['services']): ?>
	<?php if ($services = getServicesForProductList($added_product_info['product_id'], $added_product_info['combination_id'])): ?>
		<?php
			echo $this->Form->create(
				'Service',
				array(
					'url'         => getProductAddServiceUrl($added_product_info['id']),
					'data-submit' => 'once',
					'class'       => 'form'
				)
			)
		?>
			<div class="product-page">
				<div data-type="cart-add-product-services" class="product-options">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'product'.DS.'services',
							array(
								'product_id'     => $added_product_info['product_id'],
								'combination_id' => $added_product_info['combination_id'],
								'service_prefix' => 'Cart'
							)
						)
					?>
				</div>
			</div>
			
			<input class="btn btn-primary pull-right" type="submit" value="<?php echo h(__('Wybierz', true)) ?>">
			<div class="clearfix"></div>
		<?php echo $this->Form->end() ?>
	<?php endif ?>
<?php endif ?>