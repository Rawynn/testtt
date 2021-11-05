<?php if ($combinations = getProductCombinations($product_id, true)): ?>
	<div class="combination">
		<ul data-type="product-row-attributes">
			<?php if (($product_possible_combinations = getProductPossibleCombinations($product_id)) && isset($combination_id) && $combination_id): ?>
				<?php $current_combination = $product_possible_combinations[$combination_id] ?>
				
				<?php foreach ($current_combination as $attribute): ?>
					<li>
						<?php echo $attribute['attribute_name'] ?>:
						
						<span data-attribute-id="<?php echo $attribute['attribute_id'] ?>">
							<?php echo $attribute['attribute_value_name'] ?>
						</span>
					</li>
				<?php endforeach ?>
			<?php else: ?>
				<?php $combination_attributes = getCombinationAttributes($product_id) ?>
				
				<?php foreach ($combination_attributes as $attribute): ?>
					<li>
						<?php echo $attribute['Attribute']['name'] ?>:
						
						<span data-attribute-id="<?php echo $attribute['Attribute']['id'] ?>">
							-
						</span>
					</li>
				<?php endforeach ?>
			<?php endif ?>
		</ul>
		
		<a data-toggle="modal" href="#ChangeCombination<?php echo $product_id ?>" role="button" title="<?php echo h(__('zmień', true)) ?>">
			<?php __('zmień') ?> <i class="fa fa-angle-right"></i>
		</a>
		
		<div class="change-combination-modal modal fade" id="ChangeCombination<?php echo $product_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						
						<h2>
							<?php __('Zmień wariant produktu') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->input(
								'Wishlist.'.$key.'.combination_id',
								array(
									'type'      => 'radio',
									'data-type' => 'change-combination',
									'div'       => 'radio',
									'legend'    => false,
									'options'   => $combinations,
									'value'     => isset($combination_id) ? $combination_id : null,
									'separator' => '<br>',
									'escape'    => false
								)
							)
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>