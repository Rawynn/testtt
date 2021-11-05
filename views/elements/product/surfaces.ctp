<?php if (module('SURFACES') && $surfaces): ?>
	<div class="surfaces form-row">
		<label>
			<?php __('Wymiary') ?>:
		</label>
		
		<?php
			echo $this->Form->input(
				'width',
				array(
					'type'        => 'text',
					'div'         => false,
					'label'       => false,
					'class'       => 'form-control',
					'placeholder' => __('Szer.', true)
				)
			)
		?>
		
		<span class="unit">m.</span>
		
		<span class="separator">x</span>
		
		<?php
			echo $this->Form->input(
				'height',
				array(
					'type'        => 'text',
					'div'         => false,
					'label'       => false,
					'class'       => 'form-control',
					'placeholder' => __('Wys.', true)
				)
			)
		?>
		
		<span class="unit">m.</span>
	</div>
<?php endif ?>