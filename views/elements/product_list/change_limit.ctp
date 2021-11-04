<div class="product-listing-limit form-row" data-type="product-limit">
	<?php
		echo $this->Form->input(
			'ProductList.limit',
			array(
				'type'     => 'select',
				'data-url' => $this->Html->url(getChangeProductLimitUrl()),
				'div'      => false,
				'label'    => __('Liczba produktów na stronie', true).':',
				'class'    => 'form-control',
				'options'  => array(
					16     => 16,
					24     => 24,
					48     => 48
				),
				'value' => $user_limit
			)
		)
	?>
</div>