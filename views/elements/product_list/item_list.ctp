<li class="product-box list" data-type="product" data-product-id="<?php echo $product['Product']['id'] ?>" data-updated="false">
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
		
		<div class="product-name <?php echo module('B2B') ? 'shift-right' : '' ?>">
			<h2>
				<a data-type="product-url" href="<?php echo $this->Html->url(getProductUrl($product['Product']['id'])) ?>" title="<?php echo h($product['Product']['name']) ?>">
					<?php echo $product['Product']['name'] ?>
				</a>
			</h2>
			
			<?php if ($product['Producer']['name']): ?>
				<span class="producer-name">
					<?php if (module('B2B') && $product['Product']['code']): ?>
						<?php echo sprintf(__('kod: %s', true), $product['Product']['code']) ?> <span class="divider">|</span>
					<?php endif ?>
					
					<?php echo $product['Producer']['name'] ?>
				</span>
			<?php endif ?>
		</div>
		<div class="clearfix"></div>
		
		<ul class="attribute-list">
			<?php if (module('B2B')): ?>
				<li class="quantity">
					<span><?php __('Stan') ?>:</span> <strong data-type="field-quantity" data-update="inject"></strong>
				</li>
			<?php endif ?>
				
			<?php if (module('INVENTORY')): ?>
				<li>
					<span><?php __('Dostępność') ?>:</span> <strong data-type="field-ias" data-update="inject"></strong>
				</li>
			<?php endif ?>
			
			<?php if ((int) setting('MODULE_B2B_FULL_PACKAGES_DISCOUNT') > 0): ?>
				<?php if ($product['Product']['items_per_package'] > 0): ?>
					<li>
						<?php echo sprintf(__('<strong>Opakowanie zbiorcze:</strong> %s szt.', true), $product['Product']['items_per_package'] ) ?>
					</li>
				<?php endif ?>
			<?php endif ?>
		</ul>
	</div>
	
	<div class="product-column col-right <?php echo module('B2B') ? 'shift-right' : '' ?>">
		<div class="price-container">
			<span class="price-label" data-type="field-price-label" data-update="toggle">
				<?php __('Cena') ?>:
			</span>
			
			<span class="price" data-type="field-price" data-update="inject"></span>
			
			<span class="discount-price" data-type="field-discount-price" data-update="inject"></span>
			<span class="base-price" data-type="field-base-price" data-update="inject"></span>
		</div>
		
		<?php if (!isBot()): ?>
			<a class="cart-add-list btn btn-primary" data-type="add-to-cart" href="<?php echo $this->Html->url(getProductAddToCartUrl($product['Product']['id'])) ?>" title="<?php echo h(getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true)) ?>">
				<i class="fa fa-shopping-cart"></i>
			</a>
		<?php endif ?>
	</div>
</li>