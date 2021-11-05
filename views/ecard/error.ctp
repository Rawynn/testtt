<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'type'    => 'error',
			'header'  => __('Błąd', true),
			'message' => __('Wystąpił błąd. Twoja płatność nie została przyjęta.', true)
		)
	)
?>