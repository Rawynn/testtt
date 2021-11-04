<?php foreach (getCartProducts() as $key => $product): ?>
	<?php if (canAddCommentToProductInCart($product['product_id'])): ?>
		<div class="modal fade" id="EditProductCustomDescription<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Wprowadź informacje dodatkowe') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->create(
								'UserCartProduct',
								array(
									'url'       => '#',
									'class'     => 'form',
									'id'        => 'UserCartChangeProductCustomDescription'.$key,
									'data-type' => 'change-cart-product-custom-description',
									'data-key'  => $key
								)
							)
						?>
							<div class="form-inner">
								<?php
									echo $this->Form->input(
										'custom_description',
										array(
											'type'      => 'textarea',
											'div'       => false,
											'label'     => false,
											'class'     => 'form-control',
											'value'     => $product['custom_description'],
											'escape'    => false,
											'id'        => 'UserCartProductCustomDescription'.$key,
											'data-type' => 'product-custom-description-'.$key
										)
									)
								?>
							</div>
							
							<div class="form-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
							</div>
						<?php echo $this->Form->end() ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
<?php endforeach ?>