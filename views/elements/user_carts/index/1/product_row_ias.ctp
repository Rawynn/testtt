<?php if (module('INVENTORY')): ?>
	<div class="ias">
		<?php if ($producer_name = getProductProducerName($product_id)): ?>
			<span class="product-producer">
				<?php echo $producer_name ?>
			</span>
			
			<span class="separator">|</span>
		<?php endif ?>
		
		<span data-type="product-row-ias" class="product-ias">
			<?php
				if ($combination_id && is_numeric($combination_id)):
					echo getCartCombinationAvailibilityStatusName($combination_id, $quantity);
				else:
					echo getCartProductAvailibilityStatusName($product_id, $quantity);
				endif;
			?>
		</span>
	</div>
<?php endif ?>