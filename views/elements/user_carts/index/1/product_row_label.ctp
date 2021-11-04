<?php if (strlen($label) > 0 && getGlobals('current_product_label') != $label): ?>
	<?php setGlobals('current_product_label', $label) ?>
	
	<tr class="product-row product-label-row product-label-label">
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
				<?php echo $label ?>
				
				<?php if ($edit_offer_mode && !$cart_blocked): ?>
					<a data-toggle="modal" href="#EditProductLabel<?php echo $key ?>" role="button" title="<?php echo h(__('Zmień nagłówek', true)) ?>">
						<i class="fa fa-edit"></i>
					</a>
					
					<a data-toggle="modal" href="#DeleteProductLabel<?php echo $key ?>" role="button" title="<?php echo h(__('Usuń nagłówek', true)) ?>">
						<i class="fa fa-times"></i>
					</a>
				<?php endif ?>
			</h2>
			
			<?php if ($edit_offer_mode && !$cart_blocked): ?>
				<div class="modal fade" id="EditProductLabel<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
										'Cart.label',
										array(
											'type'        => 'text',
											'div'         => 'form-row',
											'label'       => __('Nagłówek / etykieta', true).':',
											'class'       => 'form-control',
											'id'          => 'CartLabel'.$key,
											'value'       => $label
										)
									)
								?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="change-user-cart-label" data-key="<?php echo $key ?>">
									<?php __('Zmień') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="DeleteProductLabel<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								
								<h2>
									<?php __('Usuń nagłówek / etykietę') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<?php __('Czy na pewno chcesz usunąć ten nagłówek?') ?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="delete-user-cart-label" data-key="<?php echo $key ?>">
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