<div class="modal fade" id="EditProductImage<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Zmiana zdjęcia produktu') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'   => getUserCartEditImageUrl($key),
							'class' => 'product-options form',
							'id'    => 'UserCartEditImageForm'.$key,
							'type'  => 'file'
						)
					)
				?>
					<div class="form-inner">
						<?php
							echo $this->element(
								'_default'.DS.'miniature',
								array(
									'file'  => array(
										'type'     => configuration('ProductMedium.dir'),
										'filename' => $product['filename'] ? $product['filename'] : (($filename = getCombinationField($product['combination_id'], 'filename')) ? $filename : getProductMainPhotoId($product['product_id'], 'filename')),
										'dir'      => $product['filename'] ? $product['dir'] : (($dir = getCombinationField($product['combination_id'], 'dir')) ? $dir : getProductMainPhotoId($product['product_id'], 'dir'))
									),
									'image' => array(
										'resize'     => 'resize',
										'width'      => 570,
										'height'     => 570,
										'no_photo'   => true,
										'watermark'  => $product['product_id'],
										'background' => array(
											'R' => 255,
											'G' => 255,
											'B' => 255
										)
									),
									'html'  => array(
										'image' => array(
											'alt' => h(getProductNameInCart($product))
										)
									)
								)
							)
						?>
						
						<?php
							echo $this->Form->input(
								'file',
								array(
									'type'      => 'file',
									'div'       => 'form-row',
									'label'     => __('Zmień zdjęcie', true).':',
									'class'     => 'form-control',
									'id'        => 'UserCartEditImageFile'.$key
								)
							)
						?>
					</div>
					
					<div class="form-actions">
						<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Anuluj') ?>
						</a>
						
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zmień zdjęcie', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>