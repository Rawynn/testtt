<div class="product-variants variants-with-quantity">
	<table class="table-flat">
		<?php foreach ($variants as $combination_id => $combination_name): ?>
			<tr>
				<td>
					<label for="UserCartCombinationQuantity<?php echo $combination_id ?>">
						<?php echo $combination_name ?>
					</label>
				</td>
				<td>
					<?php
						$availability_label = '';
						
						if (module('INVENTORY') && module('B2B')):
							$availability_label = sprintf(__(' z %s dostępnych', true), getScheduledCombinationQuantity($combination_id));
						endif;
						
						echo $this->Form->input(
							'UserCart.combination_quantity.'.$combination_id,
							array(
								'type'               => 'text',
								'data-step'          => getProductQuantityStep($product_id),
								'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
								'data-min'           => 0,
								'data-max'           => getProductQuantityInputDataMax($product_id, $combination_id),
								'data-unit'          => getProductUnit($product_id).$availability_label,
								'data-show-controls' => 1,
								'div'                => false,
								'label'              => false,
								'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
								'default'            => number_format(0, (int)setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'), ',', ''),
								'value'              => getCartProductTotalQuantity($product_id, $combination_id)
							)
						)
					?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>