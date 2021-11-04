<table class="product">
	<?php foreach ($products as $product_id): ?>
		<tr>
			<td class="preload-image" data-loaded="false">
				<?php
					$name = getProductName($product_id);
					
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
					);
				?>
			</td>
			<td>
				<span class="product-name">
					<?php echo $name ?>
				</span>
				
				<span class="product-quantity">
					<?php $price = getProductPrice($product_id) ?>
					
					<span class="price"><?php echo showPrice($price['price']) ?></span>
				</span>
			</td>
		</tr>
	<?php endforeach ?>
</table>