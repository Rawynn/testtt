<?php
	/* Ustawienie błędów walidacji - NIE USUWAĆ!!! */
	echo $this->element('_default'.DS.'cart_validation_errors')
?>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'index',
		array(
			'step' => $step
		)
	)
?>