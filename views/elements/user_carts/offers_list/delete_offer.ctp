<?php
	$id = $offer['UserCart']['id'];
	
	if ($user_cart_offer):
		$id .= '_'.$user_cart_offer['id'];
	endif;
?>

<div class="modal fade" id="DeleteOffer<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Usuń ofertę') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php echo sprintf(__('Czy na pewno chcesz usunąć ofertę "%s"?', true), $offer['UserCart']['name']) ?>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
					<?php __('Anuluj') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserCartDeleteOfferUrl($offer['UserCart']['id'], $user_cart_offer ? $user_cart_offer['id'] : 0)) ?>">
					<?php __('Usuń') ?>
				</a>
			</div>
		</div>
	</div>
</div>