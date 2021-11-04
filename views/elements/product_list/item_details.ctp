<li class="product-box details" data-type="product" data-product-id="<?php echo $product['Product']['id'] ?>" data-updated="false">
	<div class="product-column col-left product-image">
		<a class="preload-image" data-type="product-url" data-loaded="false" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
			<?php
				/* Rozmiar zdjęcia - #17463 */
				$image_size = 400;
				
				if (!empty($_COOKIE['window_size'])):
					$window_size = explode('x', $_COOKIE['window_size']);
					
					if (count($window_size) == 2 && is_numeric($window_size[0]) && $window_size[0] < $image_size):
						$image_size = $window_size[0];
					endif;
				endif;
				
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
							'blazy'      => true,
							'background' => array(
								'R' => 255,
								'G' => 255,
								'B' => 255
							),
							'blazy' => true
						),
						'html'  => array(
							'image' => array(
								'alt' => !empty($product['ProductMedium']['title']) ? h($product['ProductMedium']['title']) : h($product['Product']['name'])
							)
						)
					)
				)
			?>
		</a>
	</div>
	
	<div class="product-column col-middle">
		<?php
			/* Grupowe dodawanie produktów do koszyka */
			echo $this->element(
				TEMPLATE_NAME.DS.'product_list'.DS.'group_add_checkbox',
				array(
					'product' => $product
				)
			)
		?>
		
		<h2 class="product-name">
			<a data-type="product-url" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
				<?php echo $product['Product']['name'] ?>
			</a>
			
			<div class="product-labels">
				<div class="product-label promotion hide" data-type="field-label-promotion" data-update="toggle">
					<?php __('Promocja') ?>
				</div>
				
				<div class="product-label sale hide" data-type="field-label-sale" data-update="toggle">
					<?php __('Wyprzedaż') ?>
				</div>
				
				<div class="product-label new hide" data-type="field-label-new" data-update="toggle">
					<?php __('Nowość') ?>
				</div>
				
				<div class="product-label bestseller hide" data-type="field-label-bestseller" data-update="toggle">
					<?php __('Bestseller') ?>
				</div>
			</div>
		</h2>
		<div class="clearfix"></div>
		
		<ul class="attribute-list">
			<?php if ($product['Producer']['name']): ?>
				<li>
					<span><?php __('Producent') ?>:</span> <strong><?php echo $product['Producer']['name'] ?></strong>
				</li>
			<?php endif ?>
			
			<?php if ($attributes = getProductAttributesForListing($product['Product']['id'], ' / ')): ?>
				<?php foreach ($attributes as $attribute_name => $attribute_values): ?>
					<li>
						<span><?php echo $attribute_name ?>:</span> <strong><?php echo $attribute_values ?></strong>
					</li>
				<?php endforeach ?>
			<?php endif ?>
		</ul>
	</div>
	
	<div class="product-column col-right">
		<div class="price-container">
			<span class="price-label" data-type="field-price-label" data-update="toggle"><?php __('Cena') ?>:</span>
			
			<span class="price" data-type="field-price" data-update="inject"></span>
			
			<span class="discount-price" data-type="field-discount-price" data-update="inject"></span>
			<span class="base-price" data-type="field-base-price" data-update="inject"></span>
		</div>
		
		<ul class="attribute-list">
			<?php if (module('INVENTORY')): ?>
				<li>
					<span><?php __('Dostępność') ?>:</span> <strong data-type="field-ias" data-update="inject"></strong>
				</li>
			<?php endif ?>
			
			<?php if (module('B2B')): ?>
				<li>
					<span><?php __('Stan magazynowy') ?>:</span> <strong data-type="field-quantity" data-update="inject"></strong>
				</li>
			<?php endif ?>
		</ul>
		
		<?php if (!isBot()): ?>
			<a class="product-add-cart btn btn-primary btn-block" data-type="add-to-cart" href="<?php echo $this->Html->url(getProductAddToCartUrl($product['Product']['id'])) ?>" title="<?php echo h(getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true)) ?>">
				<?php echo getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true) ?>
				
				<i class="fa fa-caret-right" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if ((module('WISHLIST') && setting('MODULE_WISHLIST_LINKS_ON_LISTINGS') && !isBot()) || (module('COMPARE'))): ?>
			<ul class="product-options">
				<?php if (module('WISHLIST') && setting('MODULE_WISHLIST_LINKS_ON_LISTINGS') && !isBot()): ?>
					<li>
						<a class="product-add-wishlist btn-add-wishlist btn btn-link" data-type="add-to-wishlist" href="<?php echo $this->Html->url(getProductAddToWishlistUrl($product['Product']['id'])) ?>" title="<?php echo h(__('Dodaj do schowka', true)) ?>">
							<?php __('Do schowka') ?> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
					</li>
				<?php endif ?>
				
				<?php if (module('COMPARE')): ?>
					<li>
						<a class="btn btn-link" data-type="add-to-compare" href="<?php echo $this->Html->url(getProductAddToCompareUrl($product['Product']['id'])) ?>" title="<?php echo h(__('Dodaj do porównania', true)) ?>">
							<?php __('Porównaj') ?> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
					</li>
				<?php endif ?>
			</ul>
		<?php endif ?>
	</div>
</li>