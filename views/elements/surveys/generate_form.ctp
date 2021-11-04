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
	echo $this->Form->create(
		'Survey',
		array(
			'class'         => 'form survey-form survey-'.$survey['Survey']['id'],
			'data-type'     => 'survey-form',
			'data-validate' => 'true',
			'data-submit'   => 'once',
			'id'            => 'survey-'.$survey['Survey']['id'],
			'type'          => 'file',
			'url'           => getSurveyUrl($survey['Survey']['id'], isset($subscriber_code) ? $subscriber_code : null)
		)
	)
?>
	<?php if (isset($render_title) && $render_title): ?>
		<h2 class="survey-title">
			<?php echo $survey['Survey']['name'] ?>
		</h2>
	<?php endif ?>
	
	<?php foreach ($survey['SurveyQuestion'] as $key => $field): ?>
		<?php if ($field['multiplication'] == 0): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'surveys'.DS.'inputs'.DS.$fields_type[$field['type']]['element'],
					array(
						'id'             => $field['id'],
						'type'           => $fields_type[$field['type']]['type'],
						'validate'       => isset($fields_type[$field['type']]['validate']) ? $fields_type[$field['type']]['validate'] : null,
						'answers'        => isset($field['SurveyPossibleAnswer']) ? $field['SurveyPossibleAnswer'] : null,
						'value'          => $field['type'] == 4 && !$this->Form->data ? getUserEmail() : false,
						'label'          => $field['question'],
						'multiplication' => false,
						'events'         => false
					)
				)
			?>
		<?php else: ?>
			<?php
				$count = 1;
				
				if (isset($this->data['SurveyResponse'][$field['id']])):
					$count = count($this->data['SurveyResponse'][$field['id']]);
					
					if (in_array($field['type'], array(2,3,5))):
						$count++;
					endif;
				endif;
				
				if ($field['type'] == 4 && !$this->Form->data && $count == 1):
					if (getUserEmail()):
						$count++;
					endif;
				endif;
			?>
			
			<?php for ($i = 1; $i <= $count; $i++): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'surveys'.DS.'inputs'.DS.$fields_type[$field['type']]['element'],
						array(
							'id'             => $field['id'],
							'type'           => $fields_type[$field['type']]['type'],
							'validate'       => isset($fields_type[$field['type']]['validate']) && $i == 1 ? $fields_type[$field['type']]['validate'] : null,
							'answers'        => isset($field['SurveyPossibleAnswer']) ? $field['SurveyPossibleAnswer'] : null,
							'value'          => $field['type'] == 4 && !$this->Form->data && $i == 1 ? getUserEmail() : false,
							'label'          => $field['question'],
							'multiplication' => true,
							'current'        => $i,
							'events'         => $i == $count || $count == 1 ? true : false
						)
					)
				?>
			<?php endfor ?>
		<?php endif ?>
		
		<?php if (in_array($field['type'], array(6))): ?>
			<span class="form-info">
				<?php echo sprintf(__('Maksymalna wielkość pliku: %sMB', true), setting('GLOBAL_SURVEY_RESPONSE_ATTACHMENT_MAX_SIZE')) ?>
			</span>
			
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo setting('GLOBAL_SURVEY_RESPONSE_ATTACHMENT_MAX_SIZE') * 1024 * 1024 ?>" />
		<?php endif ?>
	<?php endforeach ?>
	
	<?php if (module('RECAPTCHA') && isset($survey['Survey']['captcha']) && $survey['Survey']['captcha']): ?>
		<div class="form-row">
			<label>
				&nbsp;
			</label>
			
			<div class="captcha">
				<div class="g-recaptcha" id="recaptcha-survey-<?php echo $survey['Survey']['id'] ?>"></div>
			</div>
		</div>
	<?php endif ?>
	
	<?php
		echo $this->Form->hidden(
			'SurveyResponse.referer',
			array(
				'value' => !empty($this->data['SurveyResponse']['referer']) ? $this->data['SurveyResponse']['referer'] : FULL_BASE_URL.$_SERVER['REQUEST_URI']
			)
		)
	?>
	
	<span class="form-info required-info">
		<?php __('Pola oznaczone (*) są wymagane') ?>
	</span>
	
	<div class="form-actions align-input">
		<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
	</div>
<?php echo $this->Form->end() ?>