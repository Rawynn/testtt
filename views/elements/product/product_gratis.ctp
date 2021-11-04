<?php foreach ($gratis_for_products as $gratis_products): ?>
	<?php foreach ($gratis_products as $gratis_product): ?>
		<?php $product_id = $gratis_product['product_id'] ?>
		
		<div id="ProductGratisModal<?php echo $product_id ?>" class="cart-gratis-modal product-gratis-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Produkt gratisowy') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<table class="product">
							<colgroup>
								<col width="25%">
								<col width="75%">
							</colgroup>
							
							<?php if (module('KITS') && ($kit_id = getProductField($product_id, 'kit_id'))): ?>
								<?php $kit_products = getKitProducts($kit_id) ?>
								
								<?php foreach ($kit_products as $key => $kit_product): ?>
									<?php
										$kit_product_id = $kit_product['product_id'];
										
										$name     = getProductName($kit_product_id);
										$producer = getProductProducer($kit_product_id);
									?>
									
									<tr>
										<td class="preload-image" data-loaded="true">
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
															'resize'     => 'resize',
															'width'      => 150,
															'height'     => 150,
															'no_photo'   => true,
															'watermark'  => $kit_product_id,
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
							<?php else: ?>
								<tr>
									<td class="preload-image" data-loaded="true">
										<?php
											$name        = $gratis_product['product_name'];
											$producer    = getProductProducer($product_id);
											$description = getProductDescription($product_id);
										?>
										
										<?php
											echo $this->element(
												'_default'.DS.'miniature',
												array(
													'file' => array(
														'type'     => configuration('ProductMedium.dir'),
														'filename' => isset($gratis_product['product_image']) ? $gratis_product['product_image'] : getProductMainPhotoId($product_id, 'filename'),
														'dir'      => isset($gratis_product['product_image_dir']) ? $gratis_product['product_image_dir'] : getProductMainPhotoId($product_id, 'dir')
													),
													'image' => array(
														'resize'     => 'resize',
														'width'      => 150,
														'height'     => 150,
														'no_photo'   => true,
														'watermark'  => $product_id,
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
									</td>
								</tr>
							<?php endif ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach ?>
<?php endforeach ?>