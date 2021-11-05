<div class="modal fade" id="order-add-product" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<?php
			echo $this->Form->create(
				'Order',
				array(
					'url'           => getOrderUrl($id, $code),
					'class'         => 'form',
					'data-submit'   => 'once',
					'escapeInputs'  => false,
					'id'            => 'OrdersAddProductForm'
				)
			)
		?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h2>
						<?php __('Dodaj produkt') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->input(
							'add_product',
							array(
								'type'  => 'hidden',
								'value' => 1
							)
						);
						
						echo $this->Form->input(
							'product_id',
							array(
								'type'      => 'hidden',
								'value'     => '',
								'data-type' => 'order-add-product-product-id'
							)
						);
						
						echo $this->Form->input(
							'user_id',
							array(
								'type'      => 'hidden',
								'value'     => $order['Order']['user_id'],
								'data-type' => 'order-add-product-user-id',
								'disabled'  => 'disabled'
							)
						);
					?>
					
					<div class="form-row">
						<label for="OrderProductName">
							<?php __('Wybierz produkt') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'product_name',
								array(
									'type'             => 'text',
									'data-type'        => 'autocomplete',
									'data-ac'          => 'true',
									'data-ac-url'      => $this->Html->url(getOrdersProductsAutocompleterUrl($order['Order']['user_id'])),
									'data-ac-handler'  => '[data-type=order-add-product-product-id-container]',
									'data-ac-extended' => 'false',
									'data-ac-copy'     => '[data-type=order-add-product-product-id]',
									'data-trigger'     => 'autocomplete-select',
									'div'              => array(
										'data-type' => 'order-add-product-product-id-container',
										'class'     => 'autocompleter-container'
									),
									'label'            => false,
									'class'            => 'form-control'
								)
							)
						?>
					</div>
					
					<div data-type="order-add-product-combinations-container" class="form-row order-add-product-combinations-row hide">
						<div data-type="order-add-product-combinations" class="radio-list"></div>
					</div>
					
					<?php
						echo $this->Form->input(
							'product_price',
							array(
								'type'      => 'text',
								'div'       => 'form-row',
								'label'     => __('Cena', true).':',
								'class'     => 'form-control form-hidden',
								'value'     => '-',
								'disabled'  => 'disabled',
								'data-type' => 'order-add-product-price'
							)
						);
						
						echo $this->Form->input(
							'quantity',
							array(
								'type'               => 'text',
								'data-type'          => 'change-quantity-input',
								'data-step'          => 1,
								'data-precision'     => (int)setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
								'data-unit'          => __('szt.', true),
								'data-show-controls' => 1,
								'data-min'           => 0,
								'div'                => 'form-row',
								'label'              => __('Ilość', true).':',
								'class'              => 'form-control quantity-input precision-'.(int)setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
								'value'              => showQuantityValue(1)
							)
						);
					?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Anuluj') ?>
					</a>
					
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
				</div>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>