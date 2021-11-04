<?php if ($offer_union && getGlobals('current_offer_union') != $offer_union): ?>
	<?php setGlobals('current_offer_union', $offer_union) ?>
	
	<tr class="product-row <?php echo strlen($product_label) > 0 ? 'product-label-row' : '' ?> offer-union-row offer-union-label">
		<?php
			$colspan = 6;
			
			if (userIsSalesrep()):
				if (getDefaultPricesType() == 'netto'):
					$colspan = 12;
				else:
					$colspan = 11;
				endif;
				
				if ($edit_offer_mode):
					$colspan++;//Dla kolumny Nr
				endif;
			endif;
		?>
		
		<td colspan="<?php echo $colspan ?>">
			<h2>
				<?php echo $offer_union_name ?>
				
				<?php if ($edit_offer_mode && !$cart_blocked): ?>
					<a data-toggle="modal" href="#EditOfferUnionLabel<?php echo $offer_union ?>" role="button" title="<?php echo h(__('Zmień nagłówek', true)) ?>">
						<i class="fa fa-edit"></i>
					</a>
					
					<a data-toggle="modal" href="#DeleteOfferUnionLabel<?php echo $offer_union ?>" role="button" title="<?php echo h(__('Usuń możliwość wyboru', true)) ?>">
						<i class="fa fa-times"></i>
					</a>
				<?php endif ?>
			</h2>
			
			<?php if ($edit_offer_mode && !$cart_blocked): ?>
				<div class="modal fade" id="EditOfferUnionLabel<?php echo $offer_union ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								
								<h2>
									<?php __('Ustaw nagłówek / etykietę') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<?php
									echo $this->Form->input(
										'Cart.union_label',
										array(
											'type'  => 'text',
											'div'   => 'form-row',
											'label' => __('Nagłówek / etykieta', true).':',
											'class' => 'form-control',
											'id'    => 'CartUnionLabel'.$offer_union,
											'value' => $offer_union_name
										)
									)
								?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="change-user-cart-union-label" data-union="<?php echo $offer_union ?>">
									<?php __('Zmień') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="DeleteOfferUnionLabel<?php echo $offer_union ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								
								<h2>
									<?php __('Usuń możliwość wyboru') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<?php __('Czy na pewno chcesz usunąć tą możliwość wyboru?') ?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="delete-user-cart-union-label" data-union="<?php echo $offer_union ?>">
									<?php __('Usuń') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
		</td>
	</tr>
<?php endif ?>