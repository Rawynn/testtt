<div class="modal fade" id="AskProduct" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<div class="hheader">
					<?php __('Zapytaj o produkt') ?>
				</div>
			</div>
			
			<div class="modal-body product-ask">
				<?php echo generateSurveyForm(1) ?>
			</div>
		</div>
	</div>
</div>