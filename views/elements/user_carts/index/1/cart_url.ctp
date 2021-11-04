<?php if (setting('GLOBAL_UNIQUE_CARTS_URLS') && getCartProducts() && !getCartUserCartOfferId()): ?>
	<div class="get-cart-url">
		<a href="#" title="<?php echo h(__('Udostępnij koszyk', true)) ?>" data-type="share-cart">
			<?php __('Udostępnij koszyk') ?> <i class="fa fa-angle-right"></i>
		</a>
		
		<div class="modal fade" id="CartURL" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						
						<h2>
							<?php __('Udostępnij koszyk') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<div data-type="share-cart-ok">
							<?php __('Aby udostępnić ten koszyk przekaż poniższy adres URL') ?>:
							
							<input type="text" value="" class="form-control share-url" data-type="share-cart-url"/>
						</div>
						
						<div data-type="share-cart-error" class="hide">
							<?php __('Wystąpił błąd. Proszę spróbować jeszcze raz.') ?>
						</div>
					</div>
					
					<div class="modal-footer modal-actions">
						<a class="btn-next btn btn-primary btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Zamknij') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>