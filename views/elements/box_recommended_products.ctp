<?php if ($products = getRecommendedProducts()): ?>
	<section class="recommended-products-box aside-box">
		<h2 class="box-header">
			<?php __('Polecane') ?>
		</h2>
		
		<a class="responsive-toggle" data-type="toggle" href="#BoxRecommendedProducts">
			<?php __('Polecane') ?>
		</a>
		
		<div class="box-content" id="BoxRecommendedProducts">
			<ul class="product-list small">
				<?php foreach ($products as $product): ?>
					<li>
						<a class="product-box small" data-type="product" data-product-id="<?php echo $product['Product']['id'] ?>" data-updated="false" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'], isHomePageView() ? array('from' => 'main') : array())) ?>" title="<?php echo h($product['Product']['name']) ?>">
							<span class="product-image preload-image" data-loaded="false">
								<?php
									echo $this->element(
										'_default'.DS.'miniature',
										array(
											'file'  => array(
												'type'     => configuration('ProductMedium.dir'),
												'filename' => getProductMainPhotoId($product['Product']['id'], 'filename'),
												'dir'      => getProductMainPhotoId($product['Product']['id'], 'dir')
											),
											'image' => array(
												'resize'     => 'resize',
												'width'      => 75,
												'height'     => 75,
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
							</span>
							
							<span class="product-name">
								<?php echo $product['Product']['name'] ?>
							</span>
							
							<span class="product-price">
								<span class="price" data-type="field-price" data-update="inject"></span>
							</span>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</section>
<?php endif ?>