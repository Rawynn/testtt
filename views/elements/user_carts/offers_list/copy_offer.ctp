<?php
	$id = $offer['UserCart']['id'];
	
	if ($user_cart_offer):
		$id .= '_'.$user_cart_offer['id'];
	endif;
?>

<div class="modal fade" id="CopyOffer<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Skopiuj ofertę') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getUserCartCopyOfferUrl($offer['UserCart']['id'], $user_cart_offer ? $user_cart_offer['id'] : 0),
							'id'          => 'UserCartCopyOfferForm'.$id,
							'data-submit' => 'once',
							'class'       => 'form',
							'data-type'   => 'user-cart-copy-offer-form-'.str_replace('_', '-', $id)
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'offer_name',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Nazwa oferty', true).':',
								'class'   => 'form-control',
								'default' => $offer['UserCart']['name'],
								'id'      => 'UserCartOfferName'.$id
							)
						)
					?>
				<?php echo $this->Form->end() ?>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
					<?php __('Anuluj') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" href="#" data-type="user-cart-copy-offer" data-user-cart-id="<?php echo $offer['UserCart']['id'] ?>" data-user-cart-offer-id="<?php echo $user_cart_offer ? $user_cart_offer['id'] : '' ?>">
					<?php __('Skopiuj') ?>
				</a>
			</div>
		</div>
	</div>
</div>