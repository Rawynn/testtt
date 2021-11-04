<?php if (isProductShowView()): ?>
	<?php
		echo $this->Form->hidden(
			'SurveyResponse.'.$id.'.text',
			array(
				'value' => getCurrentProductId()
			)
		)
	?>
<?php else: ?>
	<?php
		if ($multiplication):
			$name    = 'SurveyResponse.'.$id.'.'.$current.'.text';
			$name_ac = 'SurveyResponse.'.$id.'.'.$current.'.text_autocompleter';
			
			$options = array(
				'id'      => 'SurveyText-'.$id.'-'.$current,
				'data-id' => $id.'-'.$current
			);
			$options_ac = array(
				'data-multiplication' => $events ? 'true' : 'false',
				'data-url'            => $this->Html->url(getSurveyAddAnswerUrl($id, $current + 1)),
				'id'                  => 'SurveyTextAutocompleter-'.$id.'-'.$current,
				'data-id'             => $id.'-'.$current
			);
			
			if (!empty($this->data['SurveyResponse'][$id][$current]['text']) && empty($this->data['SurveyResponse'][$id][$current]['text_autocompleter'])):
				$this->Form->data['SurveyResponse'][$id][$current]['text_autocompleter'] = getProductName($this->data['SurveyResponse'][$id][$current]['text']);
			endif;
		else:
			$name    = 'SurveyResponse.'.$id.'.text';
			$name_ac = 'SurveyResponse.'.$id.'.text_autocompleter';
			
			$options = array(
				'data-id'=> $id,
				'id'     => 'SurveyText-'.$id
			);
			$options_ac = array(
				'data-id' => $id,
				'id'      => 'SurveyTextAutocompleter-'.$id
			);
			
			if (!empty($this->data['SurveyResponse'][$id]['text']) && empty($this->data['SurveyResponse'][$id]['text_autocompleter'])):
				$this->Form->data['SurveyResponse'][$id]['text_autocompleter'] = getProductName($this->data['SurveyResponse'][$id]['text']);
			endif;
		endif;
	?>
	
	<div class="form-row" data-type="survey-row-product">
		<label for="<?php echo $options['id'] ?>">
			<?php echo $label ?>
			
			<?php if ($multiplication): ?>
				<span>(<?php echo $current ?>)</span>
			<?php endif ?>
		</label>
		
		<?php
			echo $this->Form->input(
				$name_ac,
				Set::merge(
					array(
						'type'             => 'text',
						'data-type'        => 'survey-autocomplete',
						'data-validate'    => $validate,
						'data-ac'          => 'true',
						'data-ac-url'      => $this->Html->url(getComplaintProductsAutocompleterUrl()),
						'data-ac-handler'  => '#'.$options['id'].'-container',
						'data-ac-extended' => 'false',
						'data-ac-copy'     => '[data-type=survey-autocomplete-id][data-id="'.$options['data-id'].'"]',
						'label'            => false,
						'div'              => array(
							'class' => 'autocomplete-container',
							'id'    => $options['id'].'-container'
						),
						'class'            => 'form-control'
					),
					$options_ac
				)
			)
		?>
		
		<?php
			echo $this->Form->hidden(
				$name,
				Set::merge(
					array(
						'data-type' => 'survey-autocomplete-id'
					),
					$options
				)
			)
		?>
	</div>
<?php endif ?>