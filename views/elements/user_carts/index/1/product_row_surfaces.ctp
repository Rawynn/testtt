<?php
	if (module('SURFACES') && $surface):
		echo $this->Form->hidden(
			'UserCart.'.$key.'.width',
			array(
				'value'    => $width,
				'disabled' => $cart_blocked
			)
		);
		
		echo $this->Form->hidden(
			'UserCart.'.$key.'.height',
			array(
				'value'    => $height,
				'disabled' => $cart_blocked
			)
		);
	endif;
?>