<?php if (setting('GLOBAL_PRODUCT_PAGE_USER_CART_QTY')): ?>
	<?php if (!module('B2B') || (module('B2B') && !$has_variants)): ?>
		<div class="quantity form-row">
			<?php
				echo $this->Form->input(
					'quantity',
					array(
						'type'                => 'text',
						'data-step'           => getProductQuantityStep($product_id),
						'data-precision'      => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
						'data-max'            => getProductQuantityInputDataMax($product_id),
						'data-unit'           => getProductUnit($product_id),
						'data-show-controls'  => 1,
						'data-trigger'        => 'product.change.quantity',
						'data-product-id'     => $product_id,
						'data-combination-id' => 0,
						'data-type'           => 'product-change-quantity-input',
						'data-url'            => $this->Html->url(getUsersAjaxUrl('product_availability_status')),
						'div'                 => false,
						'label'               => __('Ilość', true).':',
						'class'               => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
						'default'             => number_format(getProductDefaultQuantity($product_id), (int)setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'), ',', '')
					)
				)
			?>
		</div>
	<?php endif ?>
<?php endif ?>