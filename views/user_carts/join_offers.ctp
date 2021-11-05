<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="UserCartJoinOffersModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Łączenie ofert') ?>
				</h2>
			</div>
			
			<?php if (isset($users_count_error)): ?>
				<div class="modal-body">
					<p class="text-center">
						<?php __('Nie możesz łączyć ofert różnych klientów.') ?>
					</p>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
						<?php __('OK') ?>
					</a>
				</div>
			<?php elseif (isset($offers_count_error)): ?>
				<div class="modal-body">
					<p class="text-center">
						<?php __('Proszę wybrać co najmniej dwie oferty.') ?>
					</p>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
						<?php __('OK') ?>
					</a>
				</div>
			<?php elseif ($step == 1): ?>
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'   => getUserCartJoinOffersUrl(2),
								'class' => 'form'
							)
						)
					?>
						<?php
							if (!empty($this->data['UserCart'])):
								foreach ($this->data['UserCart'] as $user_cart_id => $checked):
									echo $this->Form->hidden(
										'UserCart.'.$user_cart_id,
										array(
											'value' => $checked
										)
									);
								endforeach;
							endif;
							
							if (!empty($this->data['UserCartOffer'])):
								foreach ($this->data['UserCartOffer'] as $user_cart_offer_id => $checked):
									echo $this->Form->hidden(
										'UserCartOffer.'.$user_cart_offer_id,
										array(
											'value' => $checked
										)
									);
								endforeach;
							endif;
						?>
						
						<div class="form-inner">
							<?php
								echo $this->Form->input(
									'Offer.name',
									array(
										'div'   => 'form-row',
										'label' => __('Nazwa oferty', true).':',
										'type'  => 'text',
										'class' => 'form-control'
									)
								)
							?>
							
							<div class="form-row checkbox-group">
								<label>
									&nbsp;
								</label>
								
								<div class="checkbox-group-checkboxes">
									<?php
										echo $this->Form->input(
											'Offer.delete_empty_offers',
											array(
												'div'   => 'checkbox',
												'label' => __('usuń oferty niewysłane i szkice', true),
												'type'  => 'checkbox'
											)
										)
									?>
								</div>
							</div>
						</div>
						
						<table class="join-offer-products">
							<?php $i = 0 ?>
							
							<?php foreach ($products as $product_id => $combinations): ?>
								<?php foreach ($combinations as $combination_id => $duplicated_products): ?>
									<?php if (count($duplicated_products) > 1): ?>
										<tr>
											<td colspan="2">
												<hr>
											</td>
										</tr>
										<tr>
											<td>
												<?php
													echo getProductName($product_id);
													
													if ($combination_id && is_numeric($combination_id)):
														echo ' - '.getCombinationName($combination_id);
													endif;
													
													echo $this->Form->hidden(
														'OfferProduct.'.$i.'.product_id',
														array(
															'value' => $product_id
														)
													);
													
													echo $this->Form->hidden(
														'OfferProduct.'.$i.'.combination_id',
														array(
															'value' => $combination_id
														)
													);
												?>
											</td>
											<td class="options">
												<?php
													$options = array();
													
													if (setting('MODULE_B2B_OFFER_PRODUCT_TO_CART_AGAIN_MODE')):
														$options['all'] = __('wszystkie produkty', true);
													endif;
													
													$options['select'] = __('do wyboru', true);
													
													echo $this->Form->input(
														'OfferProduct.'.$i.'.action',
														array(
															'div'       => false,
															'label'     => false,
															'type'      => 'select',
															'class'     => 'form-control',
															'options'   => $options,
															'data-type' => 'change-join-offers-product-action',
															'data-i'    => $i
														)
													);
												?>
											</td>
										</tr>
										<tr class="label-row" data-type="join-offers-product-label-row" data-i="<?php echo $i ?>">
											<td colspan="2">
												<?php
													echo $this->Form->input(
														'OfferProduct.'.$i.'.label',
														array(
															'div'         => false,
															'label'       => false,
															'type'        => 'text',
															'class'       => 'form-control',
															'value'       => '',
															'placeholder' => __('np. Wybierz', true)
														)
													)
												?>
											</td>
										</tr>
										<tr class="products-row" data-type="join-offers-duplicated-products-row" data-i="<?php echo $i ?>">
											<td colspan="2">
												<table class="products-list">
													<?php foreach ($duplicated_products as $product): ?>
														<tr>
															<td class="checkbox-item">
																<?php
																	echo $this->Form->input(
																		'OfferProduct.'.$i.'.products.'.$product['id'].'.selected',
																		array(
																			'div'             => false,
																			'label'           => false,
																			'type'            => 'checkbox',
																			'checked'         => true,
																			'data-type'       => 'join-offers-products-select',
																			'data-product-id' => $product['id']
																		)
																	)
																?>
															</td>
															<td class="product-label">
																<?php echo __('ilość', true).': ' ?>
															</td>
															<td class="quantity-item">
																<?php
																	echo $this->Form->input(
																		'OfferProduct.'.$i.'.products.'.$product['id'].'.quantity',
																		array(
																			'div'             => false,
																			'label'           => false,
																			'class'           => 'form-control quantity-input',
																			'value'           => showQuantityValue($product['quantity']),
																			'data-type'       => 'join-offers-products-quantity',
																			'data-product-id' => $product['id']
																		)
																	)
																?>
															</td>
															<td class="product-label">
																<?php echo __('cena', true).': ' ?>
															</td>
															<td class="price-item">
																<?php
																	echo $this->Form->input(
																		'OfferProduct.'.$i.'.products.'.$product['id'].'.price',
																		array(
																			'div'             => false,
																			'label'           => false,
																			'class'           => 'form-control price-input',
																			'value'           => showPrice($product['single_price'], false),
																			'data-type'       => 'join-offers-products-price',
																			'data-product-id' => $product['id']
																		)
																	)
																?>
															</td>
														</tr>
													<?php endforeach ?>
												</table>
											</td>
										</tr>
										
										<?php $i++ ?>
									<?php endif ?>
								<?php endforeach ?>
							<?php endforeach ?>
						</table>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Połącz')) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>