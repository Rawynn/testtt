<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'type'    => 'success',
			'header'  => __('Potwierdzenie zapłaty', true),
			'message' => __('Twoja płatność została przyjęta do realizacji.', true)
		)
	)
?>