<li>
	<?php 
		$sizes = getProductCombinations($product['Product']['id'], true, false, false, true, false, 17);
		$i = 0;
	?>
	<div class="product-box gallery clearfix" data-type="product" data-product-id="<?php echo $product['Product']['id'] ?>" data-updated="false">
		<?php
			/* Rozmiar zdjęcia - #17463 */
			$image_size = 400;
			
			if (!empty($_COOKIE['window_size'])):
				$window_size = explode('x', $_COOKIE['window_size']);
				
				if (count($window_size) == 2 && is_numeric($window_size[0]) && $window_size[0] < $image_size):
					$image_size = $window_size[0];
				endif;
			endif;
		?>
		
		<div class="product-image <?php echo isset($product['SecondProductMedium']) && $product['SecondProductMedium'] ? 'double-image' : '' ?>">
			<div class="preload-image image-main" data-loaded="true">
				<?php
					echo $this->element(
						'_default'.DS.'miniature',
						array(
							'file'  => array(
								'type'     => configuration('ProductMedium.dir'),
								'filename' => isset($product['ProductMedium']['filename']) ? $product['ProductMedium']['filename'] : getProductMainPhotoId($product['Product']['id'], 'filename'),
								'dir'      => isset($product['ProductMedium']['dir']) ? $product['ProductMedium']['dir'] : getProductMainPhotoId($product['Product']['id'], 'dir'),
							),
							'image' => array(
								'resize'     => 'resize',
								'width'      => $image_size,
								'height'     => $image_size,
								'no_photo'   => true,
								'watermark'  => $product['Product']['id'],
								'background' => array(
									'R' => 255,
									'G' => 255,
									'B' => 255
								)
							),
							'html'  => array(
								'image' => array(
									'alt' => !empty($product['ProductMedium']['title']) ? h($product['ProductMedium']['title']) : h($product['Product']['name'])
								)
							)
						)
					)
				?>
			</div>
			
			<?php if (isset($product['SecondProductMedium']) && $product['SecondProductMedium']): ?>
				<div class="preload-image image-second" data-loaded="false">
					<?php
						echo $this->element(
							'_default'.DS.'miniature',
							array(
								'file'  => array(
									'type'     => configuration('ProductMedium.dir'),
									'filename' => isset($product['SecondProductMedium']['filename']) ? $product['SecondProductMedium']['filename'] : false,
									'dir'      => isset($product['SecondProductMedium']['dir']) ? $product['SecondProductMedium']['dir'] : false,
								),
								'image' => array(
									'resize'     => 'resize',
									'width'      => $image_size,
									'height'     => $image_size,
									'no_photo'   => true,
									'watermark'  => $product['Product']['id'],
									'blazy'      => true,
									'background' => array(
										'R' => 255,
										'G' => 255,
										'B' => 255
									)
								),
								'html'  => array(
									'image' => array(
										'alt' => h($product['Product']['name'])
									)
								)
							)
						)
					?>
				</div>
			<?php endif ?>
			
			<a class="product-hover-opacity" data-type="product-url" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>"></a>
		</div>
		<div class="product-labels">
			<div class="product-label new hide" data-type="field-label-new" data-update="toggle">
				<?php __('Nowość') ?>
			</div>
		</div>
		<h2 class="product-name">
			<a data-type="product-url" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
				<?php echo $product['Product']['name'] ?>
			</a>
		</h2>
		
		<div class="product-price-container" data-type="field-price-container" data-update="toggle">
			<span class="price" data-type="field-price" data-update="inject"></span>
			
			<span class="base-price" data-type="field-base-price" data-update="inject"></span>
			<span class="discount-price" data-type="field-discount-price" data-update="inject"></span>
		</div>
		<div class="hoverable">
			<div class="available_sizes">
				<?php
					if ($sizes):
						echo $this->Html->tag(
							'span',
							__('Rozmiar', true).': '
						);
						
						foreach ($sizes as $size):
							$available_size = explode(": ", $size);
							$comma = ($i < count($sizes) - 1) ? ' | ' : '';
							
							echo $available_size[1].$comma;
							
							$i++;
						endforeach;
					endif
				?>
			</div>
			<?php if (module('WISHLIST') && setting('MODULE_WISHLIST_LINKS_ON_LISTINGS')): ?>
				<a class="product-add-wishlist" data-type="add-to-wishlist" href="<?php echo $this->Html->url(getProductAddToWishlistUrl($product['Product']['id'])) ?>" title="<?php echo h(__('Dodaj do schowka', true)) ?>">
					<i class="sprite sprite-heart-o"></i>
				</a>
			<?php endif ?>
		</div>
		<?php
			/* Gupowe dodawanie produktów do koszyka */
			echo $this->element(
				TEMPLATE_NAME.DS.'product_list'.DS.'group_add_checkbox',
				array(
					'product' => $product
				)
			)
		?>
	</div>
</li>