<?php if (get('show') == 'modal'): ?>
	<?php if ($combinations = getProductCombinations($product['product_id'], !checkCanAddNotSellableProductToCart())): ?>
		<div class="change-combination modal fade" id="ChangeCombination<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Zmień wariant produktu') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->input(
								'UserCart.'.$key.'.combination_id',
								array(
									'type'      => 'radio',
									'data-type' => 'change-combination',
									'data-key'  => $key,
									'div'       => 'radio',
									'legend'    => false,
									'options'   => $combinations,
									'value'     => $product['combination_id'],
									'separator' => '<br>',
									'escape'    => false,
									'disabled'  => $cart_blocked
								)
							)
						?>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
<?php else: ?>
	<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'update_cart') ?>
<?php endif ?>