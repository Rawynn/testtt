<?php if ($gallery): ?>
	<?php $watermark = getProductField($product_id, 'watermark') ?>
	
	<div id="blueimp-image-carousel" class="product-gallery-mobile blueimp-gallery blueimp-gallery-carousel" data-type="mobile-gallery">
		<div class="slides"></div>
		<h3 class="title"></h3>
		<a class="prev">‹</a>
		<a class="next">›</a>
		<ol class="indicator"></ol>
	</div>
	
	<div class="product-gallery">
		<div class="carousel row" data-interval="false" id="ProductGallery">
			<div class="carousel-box <?php echo (count($gallery) > 1) ? 'carousel-indicators-true' : '' ?>">
				<?php if (count($gallery) > 1): ?>
					<a class="carousel-control left" href="#ProductGallery" data-slide="prev">
						<i class="arrow-left-grey"></i>
					</a>
					
					<a class="carousel-control right" href="#ProductGallery" data-slide="next">
						<i class="arrow-right-grey"></i>
					</a>
				<?php endif ?>
				
				<div class="carousel-inner">
					<?php foreach ($gallery as $key => $medium): ?>
						<a class="main-item <?php echo $key == 0 ? 'active' : '' ?> item" href="#" data-type="product-gallery" data-medium-id="<?php echo $key ?>">
							<span class="preload-image" data-loaded="false">
								<?php
									$filename = isset($medium['ProductMedium']['filename']) ? $medium['ProductMedium']['filename'] : false;
									$dir      = isset($medium['ProductMedium']['dir']) ? $medium['ProductMedium']['dir'] : false;
									
									$url = getProductMediumUrl($medium);
									
									if (setting('MODULE_WATERMARKS_FILENAME') && $watermark):
										$url = $this->Image->resize(
											configuration('ProductMedium.dir').DS.$medium['ProductMedium']['dir'].$medium['ProductMedium']['filename'],
											1920,
											1080,
											true,
											array(),
											true,
											false,
											$medium['ProductMedium']['dir'],
											setting('MODULE_WATERMARKS_FILENAME')
										);
									endif;
									
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => $filename,
												'dir'      => $dir,
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 730,
												'height'     => 730,
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
													'alt'        => !empty($medium['ProductMedium']['title']) ? h($medium['ProductMedium']['title']) : h($product_name),
													//'itemprop'   => $key == 0 ? 'image' : '',
													'data-url'   => $url,
													'data-thumb' => $this->Image->resize(
														configuration('ProductMedium.dir').DS.$dir.$filename,
														50,
														50,
														true,
														array(),
														true,
														false,
														$dir,
														false
													)
												)
											)
										)
									);
								?>
								<?php if ($key == 0) : ?>
									<meta itemprop="image" content="<?php echo $url ?>">
								<?php endif; ?>
							</span>
						</a>
					<?php endforeach ?>
				</div>
			</div>
			
			<?php if(count($gallery) > 1):?>
				<ul class="carousel-indicators">
					<?php foreach ($gallery as $key => $medium): ?>
						<li data-target="#ProductGallery" data-slide-to="<?php echo $key ?>" data-combinations="<?php echo !empty($medium['ProductMedium']['combinations']) ? implode(',', $medium['ProductMedium']['combinations']) : null ?>" class="<?php echo $key == 0 ? 'active' : '' ?>">
							
							<span class="preload-image" data-loaded="false">
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => isset($medium['ProductMedium']['filename']) ? $medium['ProductMedium']['filename'] : false,
												'dir'      => isset($medium['ProductMedium']['dir']) ? $medium['ProductMedium']['dir'] : false,
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 200,
												'height'     => 200,
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
													'alt' => !empty($medium['ProductMedium']['title']) ? h($medium['ProductMedium']['title']) : h($product_name)
												)
											)
										)
									)
								?>
							</span>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
		</div>
	</div>
<?php else: ?>
	<div class="product-gallery">
		<?php
			/* Wyświetlenie pustego zdjęcia */
			echo $this->element(
				'_default'.DS.'miniature',
				array(
					'file'  => null,
					'image' => array(
						'resize'     => 'resize',
						'width'      => 680,
						'height'     => 680,
						'no_photo'   => true,
						'watermark'  => $product_id,
						'background' => array(
							'R' => 255,
							'G' => 255,
							'B' => 255
						)
					),
					'html'  => array(
						'image' => null
					)
				)
			)
		?>
	</div>
<?php endif ?>
