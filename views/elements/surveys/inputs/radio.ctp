<div class="form-row field-radio" data-type="survey-row-combo" data-multiplication="<?php echo $events ? 'true' : 'false' ?>" data-url="<?php echo $multiplication ? $this->Html->url(getSurveyAddAnswerUrl($id, $current + 1)) : null ?>">
	<label>
		<?php echo $label ?>
		
		<?php if ($multiplication): ?>
			<span>(<?php echo $current ?>)</span>
		<?php endif ?>
	</label>
	
	<div class="input-group">
		<?php if (isset($answers)): ?>
			<?php foreach ($answers as $answer): ?>
				<div class="radio">
					<?php
						if ($multiplication):
							$name             = 'SurveyResponse.'.$id.'.'.$current.'.possible_answer_id';
							$name_explication = 'SurveyResponse.'.$id.'.'.$current.'.text.'.$answer['id'];
							
							$options = array(
								'data-id' => $current.'-'.$answer['id'],
								'id'      => 'SurveyRadio-'.$id.'-'.$current.'-'.$answer['id']
							);
							
							$is_checked = isset($this->data['SurveyResponse'][$id][$current]['possible_answer_id']) && $this->data['SurveyResponse'][$id][$current]['possible_answer_id'] == $answer['id'];
						else:
							$name             = 'SurveyResponse.'.$id.'.possible_answer_id';
							$name_explication = 'SurveyResponse.'.$id.'.text.'.$answer['id'];
							
							$options = array(
								'data-id' => $answer['id'],
								'id'      => 'SurveyRadio-'.$id.'-'.$answer['id']
							);
							
							$is_checked = isset($this->data['SurveyResponse'][$id]['possible_answer_id']) && $this->data['SurveyResponse'][$id]['possible_answer_id'] == $answer['id'];
						endif;
					?>
					
					<?php
						echo $this->Form->input(
							$name,
							Set::merge(
								array(
									'type'          => 'radio',
									'data-type'     => 'survey-combo-input',
									'options'       => array(
										$answer['id'] => $answer['possible_answer']
									),
									'checked'       => $is_checked,
									'div'           => false,
									'hiddenField'   => false
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