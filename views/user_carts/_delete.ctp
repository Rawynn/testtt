<div class="modal fade" id="DeleteProduct<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Usunięcie produktu z koszyka') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<p class="text-center">
					<?php __('Czy na pewno chcesz usunąć ten produkt z koszyka?') ?>
				</p>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
					<?php __('Nie') ?>
				</a>
				
				<a
					class="btn-next btn btn-primary btn-lg"
					href="<?php echo $this->Html->url(getProductDeleteFromCartUrl($product)) ?>"
					data-type="delete-product-from-cart"
					data-product-id="<?php echo $product['product_id'] ?>"
					data-product-name="<?php echo h(getProductName($product['product_id'])) ?>"
					data-product-category="<?php echo h(getProductMainCategoryFullName($product['product_id'], '/')) ?>"
					data-product-brand="<?php echo h(getProductProducerName($product['product_id'])) ?>"
					data-product-variant="<?php echo h($product['combination_id'] && is_numeric($product['combination_id']) ? getCombinationName($product['combination_id']) : '') ?>"
					data-product-price="<?php echo number_format($product['single_price'], 2, '.', '') ?>"
					data-product-quantity="<?php echo (int) $product['quantity'] ?>"
				>
					<?php __('Tak') ?>
				</a>
			</div>
		</div>
	</div>
</div>