<div class="bound-special-info <?php echo !($product_filters = getPossibleProductFiltersForBoundSpecialInCart()) ? 'hide' : (count($product_filters) > 1 ? 'many-specials' : '') ?>" data-type="bound-specials-info-toggle">
	<?php if (count($product_filters) == 1): ?>
		<?php
			$product_filter_id = reset(array_keys($product_filters));
			$product_filter    = reset($product_filters);
		?>
		
		<?php
			echo sprintf(
				__('Zamawiając te produkty możesz skorzystać z promocji %s na dowolny produkt z listy %s.', true),
				'<span>'.round($product_filter['percentage']).'%</span>',
				$this->Html->link(
					getProductFilterName($product_filter_id),
					getProductFilterUrl($product_filter_id)
				)
			)
		?>
	<?php else: ?>
		<?php __('Zamawiając te produkty możesz skorzystać') ?>:<br/>
		
		<?php foreach ($product_filters as $product_filter_id => $product_filter): ?>
			- <?php
				echo sprintf(
					__('z promocji %s na dowolny produkt z listy %s.', true),
					'<span>'.round($product_filter['percentage']).'%</span>',
					$this->Html->link(
						getProductFilterName($product_filter_id),
						getProductFilterUrl($product_filter_id)
					)
				)
			?> <br/>
		<?php endforeach ?>
	<?php endif ?>
</div>