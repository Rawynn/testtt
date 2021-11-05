<?php if (module('OPINIONS') && getLoggedUserId()): ?>
	<?php $product_id = getUserProductWithoutRating(getLoggedUserId()) ?>
	
	<?php if ($product_id):?>
		<?php
			$url = Set::merge(
				getProductUrl($product_id, isHomePageView() ? array('from' => 'main') : array()),
				array(
					'#' => 'opinie'
				)
			);
			
			$name = getProductName($product_id);
		?>
		
		<section class="opinion-box aside-box">
			<h2 class="box-header">
				<?php __('Dodaj recenzję') ?>
			</h2>
			
			<a class="responsive-toggle" data-type="toggle" href="#BoxOpinion">
				<?php __('Dodaj recenzję') ?>
			</a>
			
			<div class="box-content" id="BoxOpinion">
				<p>
					<?php __('Kupiłeś w naszym sklepie') ?>:
				</p>
				
				<ul class="product-list small">
					<li>
						<a class="product-box small" data-type="product" data-product-id="<?php echo $product_id ?>" data-updated="false" href="<?php echo $this->Html->url($url) ?>" title="<?php echo h($name) ?>">
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
												'width'      => 75,
												'height'     => 75,
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
							</span>
							
							<span class="product-name">
								<?php echo $name ?>
							</span>
						</a>
					</li>
				</ul>
				
				<p>
					<?php
						echo sprintf(
							__('Podziel się swoją %s na temat tego produktu.', true),
							$this->Html->link(__('opinią', true), $url)
						)
					?>
				</p>
			</div>
		</section>
	<?php endif;?>
<?php endif;?>