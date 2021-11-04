<div class="product-box small product">
	<span class="product-image preload-image" data-loaded="false">
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
						'width'      => 70,
						'height'     => 70,
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
							'alt' => h($product_name)
						)
					)
				)
			)
		?>
	</span>
	
	<span class="product-name">
		<?php
			if (preg_match_all('/'.get('term').'/i', $product_name, $matches)):
				foreach ($matches[0] as $match):
					$product_name = str_replace($match, '<span class="highlight">'.$match.'</span>', $product_name);
				endforeach;
			endif;
			
			echo $product_name;
		?>
	</span>
	
	<?php if (userAccessToPrice()): ?>
		<span class="product-price">
			<?php
				$price = getProductPrice($product_id);
				$netto = getDefaultPricesType() == 'netto';
			?>
			
			<span class="price"><?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?></span> <span class="base-price"><?php echo isset($price['base_price']) ? showPrice($netto ? $price['netto_base_price'] : $price['base_price']) : '' ?></span>
		</span>
	<?php endif ?>
</div>