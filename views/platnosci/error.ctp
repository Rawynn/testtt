<?php
	$code = '';
	
	if (isset($order)):
		$code .= $this->Html->tag(
			'h3',
			__('Możesz ponownie spróbować zapłacić poprzez szybkie płatności za pomocą poniższego linka', true)
		);
		
		$code .= $this->element(
			'_default'.DS.'payment_form',
			array(
				'order'        => $order,
				'button_class' => 'btn btn-primary js-submit'
			)
		);
	endif
?>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'type'    => 'error',
			'header'  => __('Błąd', true),
			'message' => __('Wystąpił błąd. Twoja płatność nie została przyjęta.', true),
			'code'    => $code
		)
	)
?>