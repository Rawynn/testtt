<?php if (module('WISHLIST')):?>
	<div data-type="wishlist-box">
		<?php if ($products = getWishlistProducts(true)): ?>
			<section class="wishlist-box aside-box">
				<h2 class="box-header">
					<?php __('Schowek') ?>
				</h2>
				
				<a class="responsive-toggle" data-type="toggle" href="#BoxWishlist">
					<?php __('Schowek') ?>
				</a>
				
				<div class="box-content" id="BoxWishlist">
					<?php
						/* Źródło wejścia na kartę produktu */
						$get = array(
							'from' => 'wishlist-box'
						);
						
						if (isHomePageView()):
							$get['from'] .= ' main';
						endif;
					?>
					
					<ul class="product-list small">
						<?php foreach ($products as $product_id => $combinations): ?>
							<?php $name = getProductName($product_id) ?>
							
							<?php foreach ($combinations as $combination_id => $quantity): ?>
								<li>
									<a class="product-box small" href="<?php echo $this->Html->url(getProductUrl($product_id, $get)) ?>" title="<?php echo h($name) ?>">
										<span class="product-image preload-image" data-loaded="false">
											<?php
												echo $this->element(
													'_default'.DS.'miniature',
													array(
														'file'  => array(
															'type'     => configuration('ProductMedium.dir'),
															'filename' => (($filename = getCombinationField($combination_id, 'filename')) ? $filename : getProductMainPhotoId($product_id, 'filename')),
															'dir'      => (($dir = getCombinationField($combination_id, 'dir')) ? $dir : getProductMainPhotoId($product_id, 'dir'))
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
									
									<a class="delete" href="<?php echo $this->Html->url(getProductDelereFromWishlistUrl($product_id, array(), null, 1, $combination_id)) ?>" title="<?php echo h(__('Usuń', true)) ?>">&times;</a>
								</li>
							<?php endforeach ?>
						<?php endforeach ?>
					</ul>
					
					<div class="box-options">
						<a class="btn" href="<?php echo $this->Html->url(getWishlistUrl()) ?>" title="<?php echo h(__('Do schowka', true)) ?>"><?php __('Do schowka') ?></a>
					</div>
				</div>
			</section>
		<?php endif ?>
	</div>
<?php endif ?>