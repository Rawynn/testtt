<div class="product-variants kit-variants" data-type="product-variant-container">
	<?php if (setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM')): ?>
		<?php foreach ($extended_kit_variants as $kit_product): ?>
			<?php $product_id = $kit_product['product_id'] ?>
			
			<p class="kit-variant-label">
				<?php if (checkKitProductsIsSelectable($product_id, $product['Product']['kit_id'])): ?>
					<?php
						echo $this->Form->input(
							'KitProduct.'.$product_id.'.product_id',
							array(
								'label'       => getProductName($product_id),
								'type'        => 'checkbox',
								'id'          => 'KitProductProductId'.$product_id,
								'hiddenField' => false,
								'data-type'   => 'kit-product-product-selector'
							)
						)
					?>
				<?php else: ?>
					<?php echo getProductName($product_id) ?>:
				<?php endif ?>
			</p>
			
			<?php for ($i = 1; $i <= $kit_product['quantity']; $i++): ?>
				<?php
					if (!empty($this->data['SelectAttribute'][$product_id][$i]['step'])):
						$step = $this->data['SelectAttribute'][$product_id][$i]['step'] + 1;
					else:
						$step = 1;
					endif;
				?>
				
				<?php if ($attributes = getProductAttributesToSelect($product_id, $step, true, $product['Product']['kit_id'], $i)): ?>
					<div data-type="product-kit-variant-container">
						<?php
							echo $this->Form->hidden(
								'SelectAttribute.'.$product_id.'.'.$i.'.step',
								array(
									'data-type' => 'product-variant-step',
									'value'     => ''
								)
							)
						?>
						
						<?php foreach ($attributes as $key => $attribute): ?>
							<?php
								echo $this->Form->input(
									'AttributeValue.'.$product_id.'.'.$i.'.'.$attribute['Attribute']['id'],
									array(
										'type'                  => 'select',
										'data-type'             => 'change-product-variant',
										'data-disabled-options' => json_encode($attribute['DisabledAttributeValue']),
										'data-index'            => $key,
										'div'                   => 'variant-step form-row',
										'label'                 => $attribute['Attribute']['name'].':',
										'class'                 => 'form-control',
										'empty'                 => __('Wybierz', true),
										'options'               => $attribute['AttributeValue'],
										'disabled'              => $attribute['AttributeValue'] ? false : true
									)
								)
							?>
						<?php endforeach ?>
					</div>
					
					<hr>
				<?php endif ?>
			<?php endfor ?>
		<?php endforeach ?>
	<?php else: ?>
		<?php foreach ($kit_variants as $product_id => $variants): ?>
			<p class="kit-variant-label">
				<?php if (checkKitProductsIsSelectable($product_id, $product['Product']['kit_id'])): ?>
					<?php
						echo $this->Form->input(
							'KitProduct.'.$product_id.'.product_id',
							array(
								'label'       => getProductName($product_id),
								'type'        => 'checkbox',
								'id'          => 'KitProductProductId'.$product_id,
								'hiddenField' => false,
								'data-type'   => 'kit-product-product-selector'
							)
						)
					?>
				<?php else: ?>
					<?php echo getProductName($product_id) ?>:
				<?php endif ?>
			</p>
			
			<?php
				if (!empty($this->data['SelectAttribute'][$product_id]['step'])):
					$step = $this->data['SelectAttribute'][$product_id]['step'] + 1;
				else:
					$step = 1;
				endif;
			?>
			
			<?php if ($attributes = getProductAttributesToSelect($product_id, $step, true, $product['Product']['kit_id'])): ?>
				<div data-type="product-kit-variant-container">
					<?php
						echo $this->Form->hidden(
							'SelectAttribute.'.$product_id.'.step',
							array(
								'data-type' => 'product-variant-step',
								'value'     => ''
							)
						)
					?>
					
					<?php foreach ($attributes as $key => $attribute): ?>
						<?php
							echo $this->Form->input(
								'AttributeValue.'.$product_id.'.'.$attribute['Attribute']['id'],
								array(
									'type'                  => 'select',
									'data-type'             => 'change-product-variant',
									'data-disabled-options' => json_encode($attribute['DisabledAttributeValue']),
									'data-index'            => $key,
									'div'                   => 'variant-step form-row',
									'label'                 => $attribute['Attribute']['name'].':',
									'class'                 => 'form-control',
									'empty'                 => __('Wybierz', true),
									'options'               => $attribute['AttributeValue'],
									'disabled'              => $attribute['AttributeValue'] ? false : true
								)
							)
						?>
					<?php endforeach ?>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
</div>