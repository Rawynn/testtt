<?php
	if ($multiplication):
		$name = 'SurveyResponse.'.$id.'.'.$current.'.text';
		$options = array(
			'data-multiplication' => $events ? 'true' : 'false',
			'data-url'            => $this->Html->url(getSurveyAddAnswerUrl($id, $current + 1)),
			'id'                  => 'SurveyText-'.$id.'-'.$current
		);
	else:
		$name = 'SurveyResponse.'.$id.'.text';
		$options = array(
			'id' => 'SurveyText-'.$id
		);
	endif;
	
	if ($value):
		$options['value'] = $value;
	endif;
	
	if ($validate != ''):
		$options['data-validate'] = $validate;
	endif;
?>

<div class="form-row form-block field-<?php echo $type ?>" data-type="survey-row-input">
	
	<?php
		echo $this->Form->input(
			$name,
			Set::merge(
				array(
					'type'      => $type,
					'data-type' => 'survey-input',
					'label'     => false,
					'placeholder' => $label,
					'div'       => false,
					'class'     => 'form-control'
				),
				$options
			)
		)
	?>
</div>