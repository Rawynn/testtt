<div class="modal fade" id="DeleteCart<?php echo $cart['UserCart']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Usuń koszyk') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<p class="text-center">
					<?php echo sprintf(__('Czy na pewno chcesz usunąć koszyk "%s"?', true), $cart['UserCart']['name']) ?>
				</p>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
					<?php __('Nie') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserCartDeleteUrl($cart['UserCart']['id'])) ?>">
					<?php __('Tak') ?>
				</a>
			</div>
		</div>
	</div>
</div>