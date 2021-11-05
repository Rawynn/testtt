<div class="product-listing-limit form-row" data-type="product-limit">
	<?php
		echo $this->Form->input(
			'ProductList.limit',
			array(
				'type'     => 'select',
				'data-url' => $this->Html->url(getChangeProductLimitUrl()),
				'div'      => false,
				'label'    => __('Produktów na stronie', true).':',
				'class'    => 'form-control',
				'options'  => array(
					20     => 20,
					40     => 40,
					60     => 60
				),
				'value' => $user_limit
			)
		)
	?>
</div>