<?php if ($status == 'ok'): ?>
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
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'payment_message',
			array(
				'type'    => 'error',
				'header'  => __('Błąd', true),
				'message' => __('Wystąpił błąd. Twoja płatność nie została przyjęta do realizacji.', true)
			)
		)
	?>
<?php endif ?>