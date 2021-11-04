<?php if (($min_cart_total = getCartMinTotal()) > 0 && getCartSumProductsPrice() < $min_cart_total): ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'error',
				'message' => sprintf(
					__('Minimalna wartość koszyka przy której można złożyć zamówienie to %s. Prosimy o zwiększenie wartości koszyka o %s.', true), showPrice($min_cart_total), showPrice($min_cart_total - getCartSumProductsPrice())
				)
			)
		)
	?>
<?php endif ?>