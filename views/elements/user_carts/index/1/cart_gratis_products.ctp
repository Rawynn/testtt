<?php if ($products_gratis = getCartGratisProductsForAmountsList()): ?>
	<div class="gratis-products-section">
		<?php
			$selected = getCartProductGratisFormAmountSelectedId();
			
			echo $this->Form->input(
				'GratisForAmount.product_id',
				array(
					'type'      => 'hidden',
					'data-type' => 'selected-gratis-product',
					'value'     => getCartProductGratisFormAmountSelectedId(),
					'disabled'  => $cart_blocked
				)
			);
		?>
		
		<div class="info-left">
			<p>
				<span><?php __('Produkt gratisowy') ?></span> <?php __('wybierz produkt z listy') ?>
			</p>
		</div>
		
		<div class="info-right">
			<ul class="gratis-products-list product-list small">
				<?php foreach ($products_gratis as $id => $product_gratis): ?>
					<li>
						<div class="product-box small">
							<span class="product-image preload-image" data-loaded="false">
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => getProductMainPhotoId($id, 'filename'),
												'dir'      => getProductMainPhotoId($id, 'dir'),
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 120,
												'height'     => 120,
												'no_photo'   => true,
												'watermark'  => $id,
												'blazy'      => true,
												'background' => array(
													'R' => 255,
													'G' => 255,
													'B' => 255
												)
											),
											'html'  => array(
												'image' => array(
													'alt' => h($product_gratis)
												)
											)
										)
									)
								?>
							</span>
							
							<span class="product-name">
								<?php echo $product_gratis ?>
							</span>
							
							<?php if (module('KITS') && ($kit_id = getProductField($id, 'kit_id'))): ?>
								<?php if ($kit_variants = getProductKitCombinations($id, null, true, true, true)): ?>
									<?php foreach ($kit_variants as $kit_product_id => $kit_product): ?>
										<?php
											$selected_combination = getCartProductGratisFormAmountSelectedCombinationId($kit_product_id);
											
											if ($selected_combination && setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM')):
												$selected_combination = reset($selected_combination);
											endif;
											
											if (setting('MODULE_KITS_COMBINATION_FOR_EVERY_KIT_PRODUCT_ITEM')):
												for ($i = 1; $i <= $kit_product['quantity']; $i++):
													echo $this->Form->input(
														'GratisForAmount.combination_id.'.$kit_product_id.'.'.$i,
														array(
															'type'                => 'select',
															'data-type'           => 'gratis-combination',
															'data-product-id'     => $id,
															'data-kit-product-id' => $kit_product_id,
															'data-i'              => $i,
															'div'                 => false,
															'label'               => false,
															'class'               => 'hide',
															'options'             => $kit_product['combinations'],
															'value'               => $selected_combination,
															'id'                  => 'GratisForAmountCombinationId'.$id.'_'.$kit_product_id.'_'.$i,
															'disabled'            => $cart_blocked || getCartProductGratisFormAmountSelectedId() != $id ? 'disabled' : ''
														)
													);
												endfor;
											else:
												echo $this->Form->input(
													'GratisForAmount.combination_id.'.$kit_product_id,
													array(
														'type'                => 'select',
														'data-type'           => 'gratis-combination',
														'data-product-id'     => $id,
														'data-kit-product-id' => $kit_product_id,
														'div'                 => false,
														'label'               => false,
														'class'               => 'hide',
														'options'             => $kit_product['combinations'],
														'value'               => $selected_combination,
														'id'                  => 'GratisForAmountCombinationId'.$id.'_'.$kit_product_id,
														'disabled'            => $cart_blocked || getCartProductGratisFormAmountSelectedId() != $id ? 'disabled' : ''
													)
												);
											endif;
										?>
									<?php endforeach ?>
									
									<a class="gratis-product <?php echo getCartProductGratisFormAmountSelectedId() == $id ? 'selected': '' ?>" data-type="gratis-product" data-product-id="<?php echo $id ?>" href="#CartGratisModal<?php echo $id ?>" data-toggle="modal" title="<?php echo h($product_gratis) ?>" role="button"></a>
								<?php else: ?>
									<a class="gratis-product <?php echo getCartProductGratisFormAmountSelectedId() == $id ? 'selected': '' ?>" data-type="gratis-product" data-product-id="<?php echo $id ?>" href="#" title="<?php echo h($product_gratis) ?>"></a>
								<?php endif ?>
							<?php else: ?>
								<?php if ($combinations = getProductCombinations($id, true)): ?>
									<?php
										echo $this->Form->input(
											'GratisForAmount.combination_id',
											array(
												'type'            => 'select',
												'data-type'       => 'gratis-combination',
												'data-product-id' => $id,
												'div'             => false,
												'label'           => false,
												'class'           => 'hide',
												'options'         => $combinations,
												'value'           => getCartProductGratisFormAmountSelectedCombinationId(),
												'id'              => 'GratisForAmountCombinationId'.$id,
												'disabled'        => $cart_blocked || getCartProductGratisFormAmountSelectedId() != $id ? 'disabled' : ''
											)
										)
									?>
									
									<a class="gratis-product <?php echo getCartProductGratisFormAmountSelectedId() == $id ? 'selected': '' ?>" data-type="gratis-product" data-product-id="<?php echo $id ?>" href="#CartGratisModal<?php echo $id ?>" data-toggle="modal" title="<?php echo h($product_gratis) ?>" role="button"></a>
								<?php else: ?>
									<a class="gratis-product <?php echo getCartProductGratisFormAmountSelectedId() == $id ? 'selected': '' ?>" data-type="gratis-product" data-product-id="<?php echo $id ?>" href="#" title="<?php echo h($product_gratis) ?>"></a>
								<?php endif ?>
							<?php endif ?>
							
							<a href="#CartGratisModal<?php echo $id ?>" data-toggle="modal" title="<?php echo h($product_gratis) ?>" class="more" role="button">
								<?php __('Zobacz szczegóły') ?><i class="fa fa-caret-right"></i>
							</a>
						</div>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
<?php endif ?>