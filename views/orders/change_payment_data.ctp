<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Informacja') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<p class="text-center">
					<?php echo $message ?>
				</p>
				
				<?php if ($status == 'OK'): ?>
					<script type="text/javascript">
						$("[data-type=order-change-payment-data][data-order-id=<?php echo $id ?>]").prop("disabled", true).trigger("toggle-disabled");
					</script>
				<?php endif ?>
			</div>
			
			<div class="modal-footer">
				<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
					<?php __('OK') ?>
				</a>
			</div>
		</div>
	</div>
</div>