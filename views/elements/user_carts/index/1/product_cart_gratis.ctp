<?php foreach ($products_gratis as $product_id => $product_gratis): ?>
	<div id="CartGratisModal<?php echo $product_id ?>" class="cart-gratis-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Wybierz produkt gratisowy') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<table class="product">
						<colgroup>
							<col width="25%">
							<col width="75%">
						</colgroup>
						
						<?php if (module('KITS') && ($kit_id = getProductField($product_id, 'kit_id'))): ?>
							<?php
								$kit_products = getKitProducts($kit_id);
								$kit_variants = getProductKitCombinations($product_id, null, true, true, true);
							?>
							
							<?php foreach ($kit_products as $key => $kit_product): ?>
								<?php
									$kit_product_id = $kit_product['product_id'];
									
									$name         = getProductName($kit_product_id);
									$producer     = getProductProducer($kit_product_id);
									$combinations = isset($kit_variants[$kit_product_id]) ? $kit_variants[$kit_product_id]['combinations'] : null;
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
										<?php echo showQuantityValue($kit_product['quantity'], $kit_product_id) ?> x <a href="<?php echo $this->Html->url(getProductUrl($kit_product_id)) ?>" class="product-name" target="_blank" title="<?php echo h($name) ?>">
											<?php echo $name ?>
										</a>
										
										<?php if ($producer): ?>
											<span class="product-producer">
												<strong><?php __('Producent') ?>:</strong>
												
												<?php echo $producer['Producer']['name'] ?>
											</span>
										<?php endif ?>
										
										<?php if ($combinations): ?>
											<strong><?php __('Wybierz wariant produktu') ?>:</strong>
											
											<?php
												$selected_combination = getCartProductGratisFormAmountSelectedCombinationId($kit_product_id);
												
												if ($selected_combination && setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM')):
													$selected_combination = reset($selected_combination);
												endif;
												
												echo $this->Form->input(
													'GratisForAmount.combination_id.'.$kit_product_id,
													array(
														'type'                => 'select',
														'data-product-id'     => $product_id,
														'data-kit-product-id' => $kit_product_id,
														'data-type'           => 'gratis-for-amount-combinations-select',
														'data-quantity'       => $kit_product['quantity'],
														'div'                 => false,
														'label'               => false,
														'class'               => 'form-control',
														'options'             => $combinations,
														'value'               => $selected_combination,
														'id'                  => 'GratisForAmountCombinationIdSecond'.$product_id.'_'.$kit_product_id
													)
												);
											?>
										<?php endif ?>
									</td>
								</tr>
								
								<?php if (isset($kit_products[$key + 1])): ?>
									<tr>
										<td colspan="2">
											<hr>
										</td>
									</tr>
								<?php endif ?>
							<?php endforeach ?>
							
							<tr>
								<td colspan="2">
									<button class="btn-next btn btn-primary btn-lg" data-type="select-gratis" data-product-id="<?php echo $product_id ?>">
										<?php __('Wybierz ten gratis') ?>
									</button>
								</td>
							</tr>
						<?php else: ?>
							<tr>
								<td>
									<?php
										$name         = getProductName($product_id);
										$producer     = getProductProducer($product_id);
										$description  = getProductDescription($product_id);
										$combinations = getProductCombinations($product_id, true);
									?>
									
									<?php
										echo $this->element(
											'_default'.DS.'miniature',
											array(
												'file' => array(
													'type'     => configuration('ProductMedium.dir'),
													'filename' => getProductMainPhotoId($product_id, 'filename'),
													'dir'      => getProductMainPhotoId($product_id, 'dir')
												),
												'image' => array(
													'resize'    => 'resize',
													'width'     => 150,
													'height'    => 150,
													'no_photo'  => true,
													'watermark' => $product_id,
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
									<a href="<?php echo $this->Html->url(getProductUrl($product_id)) ?>" class="product-name" target="_blank" title="<?php echo h($name) ?>">
										<?php echo $name ?>
									</a>
									
									<?php if ($producer): ?>
										<span class="product-producer">
											<strong><?php __('Producent') ?>:</strong>
											
											<?php echo $producer['Producer']['name'] ?>
										</span>
									<?php endif ?>
									
									<?php if ($description): ?>
										<span class="product-description">
											<strong><?php __('Opis') ?>:</strong>
											
											<?php echo $description ?>
										</span>
									<?php endif ?>
									
									<?php if ($combinations): ?>
										<strong><?php __('Wybierz wariant produktu') ?>:</strong>
										
										<?php
											echo $this->Form->input(
												'GratisForAmount.combination_id',
												array(
													'type'            => 'select',
													'data-product-id' => $product_id,
													'data-type'       => 'gratis-for-amount-combinations-select',
													'div'             => false,
													'label'           => false,
													'class'           => 'form-control',
													'options'         => $combinations,
													'value'           => getCartProductGratisFormAmountSelectedCombinationId(),
													'id'              => 'GratisForAmountCombinationIdSecond'.$product_id
												)
											)
										?>
									<?php endif ?>
								</td>
							</tr>
							
							<tr>
								<td colspan="2">
									<button class="btn-next btn btn-primary btn-lg" data-type="select-gratis" data-product-id="<?php echo $product_id ?>">
										<?php __('Wybierz ten gratis') ?>
									</button>
								</td>
							</tr>
						<?php endif ?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>