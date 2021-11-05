<div class="add-compare-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="AddProductToCompare">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<div class="hheader">
					<?php __('Dodanie produktu do porównywarki') ?>
				</div>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'    => 'success',
							'message'  => $message,
							'no_close' => true
						)
					)
				?>
				
				<table class="product">
					<?php foreach ($products as $product_id): ?>
						<tr>
							<td class="preload-image" data-loaded="false">
								<?php $name = getProductName($product_id) ?>
								
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => getProductMainPhotoId($product_id, 'filename'),
												'dir'      => getProductMainPhotoId($product_id, 'dir')
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 150,
												'height'     => 150,
												'no_photo'   => true,
												'watermark'  => $product_id,
												'blazy'      => true,
												'background' => array(
													'R' => 255,
													'G' => 255,
													'B' => 255
												)
											),
											'html'  => array(
												'image' => array(
													'alt' => h($name)
												)
											)
										)
									)
								?>
							</td>
							<td>
								<span class="product-name">
									<?php echo $name ?>
								</span>
								<span class="product-quantity">
									<?php $price = getProductPrice($product_id) ?>
									
									<span class="price"><?php echo showPrice(getDefaultPricesType() == 'netto' ? $price['netto_price'] : $price['price']) ?></span>
								</span>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Kontynuuj', true)) ?>">
					<?php __('Kontynuuj') ?>
				</a>
				
				<a class="btn-next btn btn-primary btn-lg" data-toggle="modal" href="#ComparisonTable" role="button" data-type="show-comparison-table" title="<?php echo h(__('Otwórz porównywarkę', true)) ?>">
					<?php __('Otwórz porównywarkę') ?>
				</a>
			</div>
			
			<span class="hide" data-type="compare-products-count"><?php echo getProductsCountInComparison() ?></span>
		</div>
	</div>
</div>