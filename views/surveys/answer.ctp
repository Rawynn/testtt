<div class="survey-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $survey['Survey']['name'] ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php
			echo $this->element(
				'surveys'.DS.'generate_form',
				array(
					'render_title' => false
				)
			)
		?>
	</div>
</div>