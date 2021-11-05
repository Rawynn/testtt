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

<div class="form-row field-<?php echo $type ?>" data-type="survey-row-input">
	<label data-type="survey-label" for="<?php echo $options['id'] ?>">
		<?php echo $label ?>
		
		<?php if ($multiplication): ?>
			<span>(<?php echo $current ?>)</span>
		<?php endif ?>
	</label>
	
	<?php
		echo $this->Form->input(
			$name,
			Set::merge(
				array(
					'type'      => $type,
					'data-type' => 'survey-input',
					'label'     => false,
					'div'       => false,
					'class'     => 'form-control'
				),
				$options
			)
		)
	?>
</div>