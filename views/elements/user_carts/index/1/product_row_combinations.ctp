<?php if (module('KITS') && $kit_id): ?>
	<?php if (setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM')): ?>
		<?php if ($extended_kit_variants = getProductExtendedKitCombinations($product_id, $selected_kit_products, true, true)): ?>
			<div class="combination">
				<?php $selected_combinations = is_array($combination_id) ? $combination_id : array() ?>
				
				<ul data-type="product-row-attributes">
					<?php foreach ($extended_kit_variants as $kit_product): ?>
						<?php for ($item_number = 1; $item_number <= $kit_product['quantity']; $item_number++): ?>
							<?php $selected_combination_id = isset($selected_combinations[$kit_product['product_id']][$item_number]) ? $selected_combinations[$kit_product['product_id']][$item_number] : 0 ?>
							
							<li>
								<?php echo getProductName($kit_product['product_id']) ?>:
								
								<span data-kit-product-id="<?php echo $kit_product['product_id'] ?>" data-kit-item-number="<?php echo $item_number ?>">
									<?php echo isset($kit_product['variants'][$selected_combination_id]) ? $kit_product['variants'][$selected_combination_id] : '-' ?>
								</span>
							</li>
						<?php endfor ?>
					<?php endforeach ?>
				</ul>
				
				<?php if (!$cart_blocked): ?>
					<a data-toggle="modal" href="#ChangeCombination<?php echo $key ?>" role="button" title="<?php echo h(__('zmień', true)) ?>">
						<?php __('zmień') ?> <i class="fa fa-angle-right"></i>
					</a>
					
					<div class="change-kit-combination modal fade" id="ChangeCombination<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
									<table class="product">
										<?php foreach ($extended_kit_variants as $kit_product): ?>
											<?php
												$name     = getProductName($kit_product['product_id']);
												$producer = getProductProducer($kit_product['product_id']);
											?>
											
											<?php for ($item_number = 1; $item_number <= $kit_product['quantity']; $item_number++): ?>
												<tr>
													<td>
														<?php
															echo $this->element(
																'_default'.DS.'miniature',
																array(
																	'file' => array(
																		'type'     => configuration('ProductMedium.dir'),
																		'filename' => getProductMainPhotoId($kit_product['product_id'], 'filename'),
																		'dir'      => getProductMainPhotoId($kit_product['product_id'], 'dir')
																	),
																	'image' => array(
																		'resize'    => 'resize',
																		'width'     => 150,
																		'height'    => 150,
																		'no_photo'  => true,
																		'watermark' => $kit_product['product_id'],
																		'background' => array(
																			'R' => 255,
																			'G' => 255,
																			'B' => 255
																		)
																	),
																	'html' => array(
																		'image' => array(
																			'alt' => h($name)
																		)
																	)
																)
															)
														?>
													</td>
													<td>
														<a href="<?php echo $this->Html->url(getProductUrl($kit_product['product_id'])) ?>" class="product-name" target="_blank" title="<?php echo h($name) ?>">
															<?php echo $name ?>
														</a>
														
														<?php if ($producer): ?>
															<span class="product-producer">
																<strong><?php __('Producent') ?>:</strong>
																
																<?php echo $producer['Producer']['name'] ?>
															</span>
														<?php endif ?>
														
														<strong><?php __('Wybierz wariant produktu') ?>:</strong>
														
														<?php
															echo $this->Form->input(
																'UserCart.'.$key.'.combination_id.'.$kit_product['product_id'].'.'.$item_number,
																array(
																	'type'                => 'select',
																	'data-type'           => 'kit-combination-select',
																	'data-kit-product-id' => $kit_product['product_id'],
																	'data-product-key'    => $key,
																	'div'                 => false,
																	'label'               => false,
																	'options'             => $kit_product['variants'],
																	'value'               => isset($selected_combinations[$kit_product['product_id']][$item_number]) ? $selected_combinations[$kit_product['product_id']][$item_number] : 0,
																	'class'               => 'form-control',
																	'disabled'            => $cart_blocked
																)
															)
														?>
													</td>
												</tr>
											<?php endfor ?>
										<?php endforeach ?>
										
										<tr>
											<td colspan="2">
												<button class="btn-next btn btn-primary btn-lg" data-type="change-kit-combination" da>
													<?php __('Zmień') ?>
												</button>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php endif ?>
		</div>
		<?php endif ?>
	<?php elseif ($kit_variants = getProductKitCombinations($product_id, $selected_kit_products, true, true)): ?>
		<div class="combination">
			<?php $selected_combinations = is_array($combination_id) ? $combination_id : array() ?>
			
			<ul data-type="product-row-attributes">
				<?php foreach ($kit_variants as $kit_product_id => $kit_product_combinations): ?>
					<?php $selected_combination_id = isset($selected_combinations[$kit_product_id]) ? $selected_combinations[$kit_product_id] : 0 ?>
					
					<li>
						<?php echo getProductName($kit_product_id) ?>:
						
						<span data-kit-product-id="<?php echo $kit_product_id ?>">
							<?php echo isset($kit_product_combinations[$selected_combination_id]) ? $kit_product_combinations[$selected_combination_id] : '-' ?>
						</span>
					</li>
				<?php endforeach ?>
			</ul>
			
			<?php if (!$cart_blocked): ?>
				<a data-toggle="modal" href="#ChangeCombination<?php echo $key ?>" role="button" title="<?php echo h(__('zmień', true)) ?>">
					<?php __('zmień') ?> <i class="fa fa-angle-right"></i>
				</a>
				
				<div class="change-kit-combination modal fade" id="ChangeCombination<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
								<table class="product">
									<?php
										$i = 1;
										$count_kv = count($kit_variants);
									?>
									<?php foreach ($kit_variants as $kit_product_id => $kit_product_combinations): ?>
										<?php
											$name     = getProductName($kit_product_id);
											$producer = getProductProducer($kit_product_id);
										?>
										
										<tr>
											<td>
												<?php
													echo $this->element(
														'_default'.DS.'miniature',
														array(
															'file' => array(
																'type'     => configuration('ProductMedium.dir'),
																'filename' => getProductMainPhotoId($kit_product_id, 'filename'),
																'dir'      => getProductMainPhotoId($kit_product_id, 'dir')
															),
															'image' => array(
																'resize'    => 'resize',
																'width'     => 150,
																'height'    => 150,
																'no_photo'  => true,
																'watermark' => $kit_product_id,
																'background' => array(
																	'R' => 255,
																	'G' => 255,
																	'B' => 255
																)
															),
															'html' => array(
																'image' => array(
																	'alt' => h($name)
																)
															)
														)
													)
												?>
											</td>
											<td>
												<a href="<?php echo $this->Html->url(getProductUrl($kit_product_id)) ?>" class="product-name" target="_blank" title="<?php echo h($name) ?>">
													<?php echo $name ?>
												</a>
												
												<?php if ($producer): ?>
													<span class="product-producer">
														<strong><?php __('Producent') ?>:</strong>
														
														<?php echo $producer['Producer']['name'] ?>
													</span>
												<?php endif ?>
												
												<strong><?php __('Wybierz wariant produktu') ?>:</strong>
												
												<?php
													echo $this->Form->input(
														'UserCart.'.$key.'.combination_id.'.$kit_product_id,
														array(
															'type'                => 'select',
															'data-type'           => 'kit-combination-select',
															'data-kit-product-id' => $kit_product_id,
															'data-product-key'    => $key,
															'div'                 => false,
															'label'               => false,
															'options'             => $kit_product_combinations,
															'value'               => isset($selected_combinations[$kit_product_id]) ? $selected_combinations[$kit_product_id] : 0,
															'class'               => 'form-control',
															'disabled'            => $cart_blocked
														)
													)
												?>
											</td>
										</tr>
										
										<?php if ($count_kv != $i): ?>
											<tr>
												<td colspan="2">
													<hr>
												</td>
											</tr>
										<?php endif ?>
										<?php $i++ ?>
									<?php endforeach ?>
									
									<tr>
										<td colspan="2">
											<button class="btn-next btn btn-primary btn-lg" data-type="change-kit-combination">
												<?php __('Zmień') ?>
											</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	<?php endif ?>
<?php elseif ($has_combinations): ?>
	<div class="combination" data-type="product-combination-box" data-key="<?php echo $key ?>">
		<?php
			echo $this->Form->hidden(
				'UserCart.'.$key.'.combination_id',
				array(
					'value'    => $combination_id,
					'disabled' => $cart_blocked
				)
			)
		?>
		
		<ul data-type="product-row-attributes">
			<?php foreach ($combination_attributes as $attribute_value): ?>
				<li>
					<?php echo $attribute_value['name'] ?>:
					
					<span data-attribute-id="<?php echo $attribute_value['attribute_id'] ?>">
						<?php echo $attribute_value['value'] ?>
					</span>
				</li>
			<?php endforeach ?>
		</ul>
		
		<?php if (!$cart_blocked): ?>
			<a href="#" data-type="change-combination-link" data-key="<?php echo $key ?>" title="<?php echo h(__('zmień', true)) ?>">
				<?php __('zmień') ?> <i class="fa fa-angle-right"></i>
			</a>
		<?php endif ?>
	</div>
<?php else: ?>
	<?php
		if (isset($combination_id) && is_array($combination_id)):
			echo $this->Form->hidden(
				'UserCart.'.$key.'.combination_id',
				array(
					'value'    => serialize($combination_id),
					'disabled' => $cart_blocked
				)
			);
		endif;
	?>
<?php endif ?>