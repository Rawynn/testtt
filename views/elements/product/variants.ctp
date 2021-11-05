<?php
	if (!empty($this->data['SelectAttribute']['step'])):
		$step = $this->data['SelectAttribute']['step'] + 1;
	else:
		$step = 1;
	endif;
?>

<div class="product-variants form" data-type="product-variant-container">
	<?php if ($attributes = getProductAttributesToSelect($product_id, $step)): ?>
		<?php
			echo $this->Form->hidden(
				'SelectAttribute.step',
				array(
					'data-type' => 'product-variant-step',
					'value'     => ''
				)
			)
		?>
		
		<?php foreach ($attributes as $key => $attribute): ?>
			<?php
				echo $this->Form->input(
					'AttributeValue.'.$attribute['Attribute']['id'],
					array(
						'type'                  => 'select',
						'data-type'             => 'change-product-variant',
						'data-disabled-options' => json_encode($attribute['DisabledAttributeValue']),
						'data-index'            => $key,
						'div'                   => 'variant-step form-row',
						'label'                 => $attribute['Attribute']['name'].':',
						'class'                 => 'form-control',
						'empty'                 => __('wybierz', true),
						'options'               => $attribute['AttributeValue'],
						'disabled'              => $attribute['AttributeValue'] ? false : true
					)
				)
			?>
		<?php endforeach ?>
	<?php endif ?>
</div>