<div class="form-row field-checkbox" data-type="survey-row-combo" data-multiplication="<?php echo $events ? 'true' : 'false' ?>" data-url="<?php echo $multiplication ? $this->Html->url(getSurveyAddAnswerUrl($id, $current + 1)) : null ?>">
	<label>
		<?php echo $label ?>
		
		<?php if ($multiplication): ?>
			<span>(<?php echo $current ?>)</span>
		<?php endif ?>
	</label>
	
	<div class="input-group">
		<?php if (isset($answers)): ?>
			<?php foreach ($answers as $answer): ?>
				<div class="checkbox">
					<?php
						if ($multiplication):
							$name             = 'data[SurveyResponse]['.$id.']['.$current.'][possible_answer_id][]';
							$name_explication = 'SurveyResponse.'.$id.'.'.$current.'.text.'.$answer['id'];
							
							$options = array(
								'data-id' => $current.'-'.$answer['id'],
								'id'      => 'SurveyCheckbox-'.$id.'-'.$current.'-'.$answer['id']
							);
							
							$is_checked = isset($this->data['SurveyResponse'][$id][$current]['possible_answer_id']) && in_array($answer['id'], $this->data['SurveyResponse'][$id][$current]['possible_answer_id']);
						else:
							$name             = 'data[SurveyResponse]['.$id.'][possible_answer_id][]';
							$name_explication = 'SurveyResponse.'.$id.'.text.'.$answer['id'];
							
							$options = array(
								'data-id' => $answer['id'],
								'id'      => 'SurveyCheckbox-'.$id.'-'.$answer['id']
							);
							
							$is_checked = isset($this->data['SurveyResponse'][$id]['possible_answer_id']) && in_array($answer['id'], $this->data['SurveyResponse'][$id]['possible_answer_id']);
						endif;
					?>
					
					<?php
						echo $this->Form->input(
							$name,
							Set::merge(
								array(
									'type'          => 'checkbox',
									'data-type'     => 'survey-combo-input',
									'value'         => $answer['id'],
									'checked'       => $is_checked,
									'label'         => $answer['possible_answer'],
									'div'           => false,
									'hiddenField'   => false,
									'name'          => $name
								),
								$options
							)
						)
					?>
					
					<?php if ($answer['explication']): ?>
						<div class="explication <?php echo $is_checked ? '' : 'hide' ?>" data-type="survey-explication-toggle">
							<?php
								echo $this->Form->input(
									$name_explication,
									Set::merge(
										$options,
										array(
											'type'        => 'text',
											'data-type'   => 'survey-explication',
											'data-id'     => $options['data-id'],
											'div'         => false,
											'label'       => false,
											'class'       => 'form-control',
											'id'          => $options['id'].'-explication',
											'disabled'    => !$is_checked
										)
									)
								)
							?>
						</div>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>