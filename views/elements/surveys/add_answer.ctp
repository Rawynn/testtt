<?php
	$fields_type = array(
		// Pole typu tekst
		0 => array(
			'element'  => 'text',
			'type'     => 'text',
			'validate' => 'validate(required)'
		),
		// Pole typu textarea
		1 => array(
			'element'  => 'text',
			'type'     => 'textarea',
			'validate' => ''
		),
		// Pole typu radio
		2 => array(
			'element' => 'radio',
			'type'    => 'radio'
		),
		// Pole typu checkbox
		3 => array(
			'element' => 'checkbox',
			'type'    => 'checkbox'
		),
		// Pole typu e-mail
		4 => array(
			'element'  => 'text',
			'type'     => 'text',
			'validate' => 'validate(required, email)'
		),
		// Pole typu temat
		5 => array(
			'element' => 'radio',
			'type'    => 'radio'
		),
		// Pole typu plik
		6 => array(
			'element'  => 'text',
			'type'     => 'file',
			'validate' => ''
		),
		// Pole typu produkt
		7 => array(
			'element'  => 'product',
			'type'     => 'text',
			'validate' => 'validate(required)'
		)
	)
?>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'surveys'.DS.'inputs'.DS.$fields_type[$question['SurveyQuestion']['type']]['element'],
		array(
			'id'             => $question['SurveyQuestion']['id'],
			'type'           => $fields_type[$question['SurveyQuestion']['type']]['type'],
			'validate'       => null,
			'answers'        => isset($question['SurveyPossibleAnswer']) ? $question['SurveyPossibleAnswer'] : null,
			'value'          => $question['SurveyQuestion']['type'] == 4 && !$this->Form->data && $i == 1 ? getUserEmail() : false,
			'label'          => $question['SurveyQuestion']['question'],
			'multiplication' => true,
			'current'        => $i,
			'events'         => true
		)
	)
?>