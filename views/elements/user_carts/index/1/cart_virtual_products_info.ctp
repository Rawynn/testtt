<?php if (isCodPaymentMethodExcludedByVirtualProducts()): ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'notice',
				'message' => __('Ze względu na produkty wirtualne w koszyku nie są dostępne pobraniowe formy płatności.', true)
			)
		)
	?>
<?php endif ?>