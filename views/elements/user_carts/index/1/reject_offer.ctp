<?php if ($cart_blocked): ?>
	<div class="save-offer">
		<div class="modal fade" id="RejectOffer" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Odrzuć ofertę') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<p class="text-center">
							<?php __('Czy na pewno chcesz odrzucić tę ofertę?') ?>
						</p>
					</div>
					
					<div class="modal-footer modal-actions">
						<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Nie') ?>
						</a>
						
						<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getOfferRejectUrl($user_cart_parent_id, getCartUserCartOfferId())) ?>">
							<?php __('Tak') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>