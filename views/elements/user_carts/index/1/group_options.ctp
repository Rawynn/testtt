<tr class="product-row group-options-row group-options-services-<?php echo getServicesList() ? 'true' : 'false' ?>">
	<?php
		$colspan = 7;
		
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
		<?php if (userIsSalesrep()): ?>
			<div class="left-options">
				<label><?php __('Zaznaczone') ?>:</label>
				
				<?php
					$options = array(
						'quantity'          => __('ustaw ilość', true),
						'margin'            => __('ustaw marżę %', true),
						'rabat'             => __('ustaw rabat %', true),
						'price'             => __('zmień cenę +/-', true),
						'update_price'      => __('zaktualizuj ceny', true),
						'description'       => __('skopiuj opis', true),
						'clear_description' => __('wyczyść opis', true),
						'offer_union'       => __('zezwól na wybór', true),
						'label'             => __('nagłówek/etykieta', true),
						'delete'            => __('usuń', true)
					);
					
					if (!$is_offer):
						unset($options['description']);
						unset($options['clear_description']);
						unset($options['offer_union']);
						unset($options['label']);
						unset($options['update_price']);
					endif;
					
					echo $this->Form->input(
						'Cart.group_options',
						array(
							'div'       => false,
							'label'     => false,
							'type'      => 'select',
							'class'     => 'form-control',
							'empty'     => __('-wybierz akcję-', true),
							'disabled'  => 'disabled',
							'data-type' => 'cart-group-actions-select',
							'options'   => $options
						)
					);
				?>
				
				<span class="cart-group-options hide" data-type="cart-group-options-quantity">
					<?php
						echo $this->Form->input(
							'Cart.quantity',
							array(
								'type'               => 'text',
								'data-step'          => getProductQuantityStep(0),
								'data-precision'     => (int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
								'data-unit'          => '',
								'data-show-controls' => 1,
								'div'                => false,
								'label'              => false,
								'class'              => 'form-control quantity-input precision-'.(int) setting('MODULE_B2B_DECIMAL_QUANTITIES_PRECISION'),
								'value'              => showQuantityValue(1)
							)
						)
					?>
				</span>
				
				<span class="cart-group-options hide" data-type="cart-group-options-margin">
					<?php
						echo $this->Form->input(
							'Cart.margin',
							array(
								'type'  => 'text',
								'div'   => false,
								'label' => false,
								'class' => 'form-control quantity-input precision-0',
								'value' => number_format(0, 2, ',', '').'%'
							)
						)
					?>
				</span>
				
				<span class="cart-group-options hide" data-type="cart-group-options-rabat">
					<?php
						echo $this->Form->input(
							'Cart.rabat',
							array(
								'type'  => 'text',
								'div'   => false,
								'label' => false,
								'class' => 'form-control quantity-input precision-0',
								'value' => number_format(0, 2, ',', '').'%'
							)
						)
					?>
				</span>
				
				<span class="cart-group-options hide" data-type="cart-group-options-price">
					<?php
						echo $this->Form->input(
							'Cart.price_change_type',
							array(
								'div'       => false,
								'label'     => false,
								'type'      => 'select',
								'class'     => 'form-control',
								'data-type' => 'cart-group-options-produce-change-type',
								'options'   => array(
									'+' => '+',
									'-' => '-'
								)
							)
						);
						
						echo $this->Form->input(
							'Cart.price',
							array(
								'type'  => 'text',
								'div'   => false,
								'label' => false,
								'class' => 'form-control quantity-input precision-0',
								'value' => number_format(0, 2, ',', '')
							)
						);
					?>
				</span>
				
				<div class="modal fade" id="CartOfferUnionModal" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								
								<h2>
									<?php __('Zezwól na wybór') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<?php
									echo $this->Form->input(
										'Cart.offer_union_name',
										array(
											'type'        => 'text',
											'div'         => 'form-row no-margin',
											'label'       => __('Nagłówek / tytuł', true).':',
											'class'       => 'form-control',
											'placeholder' => __('np. Wybierz ilość', true)
										)
									)
								?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="save-user-cart-offer-union">
									<?php __('Zapisz') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="CartLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
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
											'div'         => 'form-row no-margin',
											'label'       => __('Nagłówek / etykieta', true).':',
											'class'       => 'form-control'
										)
									)
								?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="save-user-cart-label">
									<?php __('Zapisz') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="CartUpdatePriceModal" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								
								<h2>
									<?php __('Zaktualizuj ceny') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<div class="radio">
									<input type="radio" name="data[UserCart][update_price_type]" checked="checked" value="1" id="UserCartUpdatePriceType1" data-type="user-cart-change-update-price-type"/>
									
									<label for="UserCartUpdatePriceType1">
										<?php __('ustaw ceny sprzedaży wg aktualnego cennika') ?>
									</label>
								</div>
								
								<div class="radio">
									<input type="radio" name="data[UserCart][update_price_type]" value="2" id="UserCartUpdatePriceType2" data-type="user-cart-change-update-price-type"/>
									
									<table class="table-radio-label" data-type="user-cart-change-update-price-type-2">
										<tbody>
											<tr>
												<td>
													<?php __('zaktualizuj') ?>:
												</td>
												<td>
													<?php
														echo $this->Form->input(
															'UserCart.update_purchase_price',
															array(
																'type'     => 'checkbox',
																'label'    => __('ceny zakupu', true),
																'disabled' => 'disabled'
															)
														);
														
														echo $this->Form->input(
															'UserCart.update_suggested_price',
															array(
																'type'     => 'checkbox',
																'label'    => __('ceny katalogowe', true),
																'disabled' => 'disabled'
															)
														);
													?>
												</td>
											</tr>
											<tr>
												<td>
													<?php __('zachowaj') ?>:
												</td>
												<td>
													<?php
														echo $this->Form->input(
															'UserCart.keep_type',
															array(
																'type'     => 'radio',
																'legend'   => false,
																'disabled' => 'disabled',
																'default'  => 'single_price',
																'options'  => array(
																	'single_price'      => __('ceny sprzedaży', true),
																	'rabat_percentage'  => __('% rabatu', true),
																	'margin_percentage' => __('% marży', true),
																	'margin_value'      => __('wartość marży', true)
																)
															)
														)
													?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="save-user-cart-upate-price">
									<?php __('Wyślij') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<a class="btn btn-primary btn-form-size hide" href="#" data-type="cart-group-actions-submit">
					<?php __('Wykonaj') ?>
				</a>
			</div>
			
			<div class="right-options">
				<?php if (userIsSalesrep()): ?>
					<a class="btn btn-primary btn-form-size" data-toggle="modal" title="<?php echo h(__('Dodaj produkt', true)) ?>" href="#AddProductToCart" role="button" <?php echo $cart_blocked ? 'disabled' : '' ?>>
						<?php __('Dodaj produkt') ?>
					</a>
				<?php endif ?>
				
				<?php if (checkEditPricesInCartAvailable()): ?>
					<a class="btn btn-primary btn-form-size <?php echo !getCartHasAnyLockedPrices() ? 'hide' : '' ?>" data-type="reset-prices-toggle" title="<?php echo h(__('Resetuj ceny', true)) ?>" <?php echo $cart_blocked ? 'disabled' : '' ?> href="<?php echo $this->Html->url(getCartUrl(null, array('reset-prices' => 1))) ?>">
						<?php __('Resetuj ceny') ?>
					</a>
				<?php endif ?>
				
				<?php if ($edit_offer_mode): ?>
					<a class="btn btn-primary btn-form-size" href="#" data-type="cart-save-products-order" title="<?php echo h(__('Zapisz kolejność', true)) ?>" disabled>
						<?php __('Zapisz kolejność') ?>
					</a>
					
					<?php if ($attributes): ?>
						<a class="btn btn-primary btn-form-size" data-toggle="modal" title="<?php echo h(__('Dołącz atrybuty', true)) ?>" href="#AddAtributesToCart" role="button" <?php echo $cart_blocked ? 'disabled' : '' ?>>
							<?php __('Dołącz atrybuty') ?>
						</a>
					<?php endif ?>
					
					<a class="btn btn-primary btn-form-size" data-toggle="modal" title="<?php echo h(__('Sortuj', true)) ?>" href="#SortProducts" role="button" <?php echo $cart_blocked ? 'disabled' : '' ?>>
						<?php __('Sortuj') ?>
					</a>
					
					<a class="btn btn-primary btn-form-size" title="<?php echo h(__('Ponumeruj', true)) ?>" href="<?php echo $this->Html->url(getCartRenumberProductsUrl()) ?>" <?php echo $cart_blocked ? 'disabled' : '' ?>>
						<?php __('Ponumeruj') ?>
					</a>
				<?php endif ?>
			</div>
		<?php else: ?>
			<a class="btn btn-primary btn-form-size" data-toggle="modal" href="#DeleteCheckedProducts" data-type="cart-delete-product-button" role="button" title="<?php echo h(__('Usuń zaznaczone', true)) ?>" disabled>
				<?php __('Usuń zaznaczone') ?>
			</a>
			
			<div class="modal fade" id="DeleteCheckedProducts" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>
							
							<h2>
								<?php __('Usunięcie produktów z koszyka') ?>
							</h2>
						</div>
						
						<div class="modal-body">
							<p class="text-center">
								<?php __('Czy na pewno chcesz usunąć zaznaczone produkty z koszyka?') ?>
							</p>
						</div>
						
						<div class="modal-footer modal-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Nie') ?>
							</a>
							
							<a class="btn-next btn btn-primary btn-lg" data-type="product-delete-checked-button" href="#">
								<?php __('Tak') ?>
							</a>
						</div>
					</div>
				</div>
			</div>
			
			<?php if (checkEditPricesInCartAvailable()): ?>
				<a class="btn btn-primary btn-form-size <?php echo !getCartHasAnyLockedPrices() ? 'hide' : '' ?>" data-type="reset-prices-toggle" title="<?php echo h(__('Resetuj ceny', true)) ?>" <?php echo $cart_blocked ? 'disabled' : '' ?> href="<?php echo $this->Html->url(getCartUrl(null, array('reset-prices' => 1))) ?>">
					<?php __('Resetuj ceny') ?>
				</a>
			<?php endif ?>
		<?php endif ?>
	</td>
</tr>