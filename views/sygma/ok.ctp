<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'type'    => 'success',
			'header'  => __('Potwierdzenie złożenia wniosku ratalnego', true),
			'message' => __('Dziękujemy za złożenie wniosku ratalnego. Niedługo poinformujemy Cię o decyzji.', true)
		)
	)
?>