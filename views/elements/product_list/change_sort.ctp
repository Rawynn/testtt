<?php if (checkFiltersAvailable('sorting')): ?>
	<div class="product-listing-sort" data-type="product-sort">
		<?php
			echo $this->Form->input(
				'change_sort',
				array(
					'type'    => 'select',
					'div'     => false,
					'label'   => __('Sotruj wg', true).':',
					'class'   => 'form-control',
					'options' => getProductListOrders(true),
					'value'   => getProductChangeSortValue()
				)
			)
		?>
	</div>
<?php endif ?>