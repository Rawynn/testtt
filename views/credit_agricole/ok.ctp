<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'type'    => 'success',
			'header'  => __('Wniosek został złożony poprawnie - dziękujemy', true),
			'message' => __('W ciągu 24h skontaktuje się z Tobą doradca Credit Agricole Bank Polska S.A., potem Twoje zamówienie będzie mogło być zrealizowane.', true)
		)
	)
?>