<?php
	$steps = array(
		1 => array(
			'title' => __('Zawartość koszyka', true),
			'class' => 'cart-page order-show-page'
		),
		2 => array(
			'title' => __('Dane adresowe', true),
			'class' => 'order-form-page'
		),
		3 => array(
			'title' => __('Dane adresowe', true),
			'class' => 'order-form-page'
		),
		4 => array(
			'title' => __('Potwierdzenie', true),
			'class' => 'order-add-page order-show-page'
		)
	)
?>

<div class="<?php echo $steps[$step]['class'] ?> order-page page">
	<div class="order-header page-header">
		<?php if (!getCartIsOffer()): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'menu_cart_steps',
					array(
						'step'   => $step,
						'placed' => $step == 4 ? true : false
					)
				)
			?>
		<?php endif ?>
	</div>
	
	<div class="page-content">
		<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.$step) ?>
	</div>
</div>