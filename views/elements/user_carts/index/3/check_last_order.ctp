<?php if (setting('MODULE_USERS_AND_ORDERS_CHECK_USER_LAST_ORDER_MINUTES')): ?>
	<div class="add-cart-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-type="check-last-order-warning">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Ostrzeżenie')?>
					</h2>
				</div>
				
				<div class="modal-body">
					<p class="message info">
						<?php echo sprintf(__('UWAGA! W ciągu ostatnich %s minut kupiłeś następujące produkty. Czy na pewno chcesz dokonać zakupu?', true), setting('MODULE_USERS_AND_ORDERS_CHECK_USER_LAST_ORDER_MINUTES')) ?>
					</p>
					
					<div data-type="check-last-order-warning-products"></div>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="<?php echo $this->Html->url(getCartUrl()) ?>" title="<?php echo h(__('Anuluj', true)) ?>">
						<?php __('Anuluj') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="#" data-type="check-last-order-warning-confirmation" title="<?php echo h(__('Zamawiam', true)) ?>">
						<?php __('Zamawiam') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>