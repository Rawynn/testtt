<?php
	$code = $this->Html->tag(
		'p',
		null
	);
		$code .= __('Numer wniosku kredytowego/decyzja to: ', true);
		
		$code .= $this->Html->tag('strong', $_GET['id_wniosku']);
		
		$code .= '<br><br>';
		
		$code .= $this->Html->tag('strong', __('W przypadku pozytywnej wstępnej weryfikacji oczekuj na kontakt telefoniczny z konsultantem Żagiel S.A.', true));
		
		$code .= '<br><br>';
		
		$code .= __('Podczas rozmowy telefonicznej sporządzi razem z Tobą umowę ratalną.', true);
		
		$code .= '<br><br>';
		
		$code .= __('Przygotuj: dowód osobisty oraz drugi dokument tożsamości.', true);
	$code .= $this->Html->tag('/p');
?>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'header' => __('Potwierdzenie złożenia wniosku ratalnego', true),
			'code'   => $code
		)
	)
?>