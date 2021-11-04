<?php if ($edit_offer_mode && !$cart_blocked): ?>
	<?php foreach (getCartProducts() as $key => $product): ?>
		<div class="modal fade" id="EditProductName<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Wprowadź nazwę produktu') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<div class="form">
							<?php
								echo $this->Form->input(
									'Cart.product_name',
									array(
										'type'      => 'text',
										'div'       => false,
										'label'     => false,
										'class'     => 'form-control share-url',
										'name'      => 'data[Cart][product_name]['.$key.']',
										'value'     => $product['product_name'] ? $product['product_name'] : getProductNameInCart($product),
										'escape'    => false,
										'id'        => 'UserCartProductProductName'.$key,
										'data-type' => 'user-cart-product-name-'.$key
									)
								)
							?>
						</div>
					</div>
					
					<div class="modal-footer modal-actions">
						<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Anuluj') ?>
						</a>
						
						<a class="btn-next btn btn-primary btn-lg" data-type="change-cart-product-name-submit" data-key="<?php echo $key ?>">
							<?php __('Zapisz') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach ?>
<?php endif ?>