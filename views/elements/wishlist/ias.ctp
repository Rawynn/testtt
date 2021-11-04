<?php if (module('INVENTORY')): ?>
	<div class="ias">
		<?php if ($producer_name = getProductProducerName($product_id)): ?>
			<span class="product-producer">
				<?php echo $producer_name ?>
			</span>
			
			<span class="separator">|</span>
		<?php endif ?>
		
		<span class="product-ias"><?php echo getProductInventoryAvailibilityStatusName($product_id) ?></span>
	</div>
<?php endif ?>