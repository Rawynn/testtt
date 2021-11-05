<div class="compare-modal modal fade" data-type="comparison-modal" id="ComparisonTable" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<div class="hheader">
					<?php __('Porównaj produkty') ?>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="comparison-table-container" data-type="comparison-table-container" data-loaded="false" data-url="<?php echo $this->Html->url(getUsersAjaxUrl('comparison_table')) ?>"></div>
			</div>
			
			<div class="modal-footer">
				<div class="comparison-options">
					<a class="btn btn-lg pull-left" data-dismiss="modal" href="#" aria-hidden="true">
						<?php __('Zamknij') ?>
					</a>
					
					<?php
						echo $this->Form->input(
							'comparison_differences',
							array(
								'type'        => 'checkbox',
								'data-type'   => 'show-only-differences',
								'label'       => __('Pokaż tylko różnice', true),
								'div'         => 'only-differences checkbox pull-right',
								'hiddenField' => false
							)
						)
					?>
				</div>
			</div>
		</div>
	</div>
</div>