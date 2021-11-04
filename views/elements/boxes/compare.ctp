<?php if ($products = getProductsInComparison()): ?>
	<section class="wishlist-box aside-box">
		<h5 class="box-header hheader">
			<?php __('Porównaj') ?>
		</h5>
		
		<a class="responsive-toggle" data-type="toggle" href="#BoxCompare">
			<?php __('Porównaj') ?>
		</a>
		
		<div class="box-content" id="BoxCompare">
			<ul class="product-list small">
				<?php foreach ($products as $product): ?>
					<li>
						<a class="product-box small" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
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
						</a>
						
						<a class="delete" href="<?php echo $this->Html->url(getProductDeleteFromCompareUrl($product['Product']['id'])) ?>" title="<?php echo h(__('Usuń', true)) ?>">&times;</a>
					</li>
				<?php endforeach ?>
			</ul>
			
			<div class="box-options">
				<a class="btn" data-toggle="modal" href="#ComparisonTable" role="button" data-type="show-comparison-table" title="<?php echo h(__('Porównaj', true)) ?>"><?php __('Porównaj') ?></a>
			</div>
		</div>
	</section>
<?php endif ?>