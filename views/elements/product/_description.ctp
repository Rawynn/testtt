<?php if($description):?>
<div class="product-description cms-content <?php echo ($attributes || $kit_products)? 'less': '' ?>" itemprop="description">
	<div class="hheader"><?php echo $name;?></div>
	<?php echo $description ?>
</div>
<?php endif;?>
<?php if ($attributes || $kit_products): ?>
<div class="product-specification <?php echo $description? '' : 'more_prod'?>">
	<div class="hheader"><?php __('Dane techniczne:')?></div>
	<?php if (!$kit_products): ?>
		<?php if ($attributes): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'product'.DS.'attributes_table',
					array(
						'attributes'   => $attributes,
						'hide_leading' => (isset($hide_leading)) ? $hide_leading : false
					)
				)
			?>
		<?php endif ?>
	<?php else: ?>
		<p class="text-muted">
			<?php __('Aby zobaczyć dane techniczne produktu wchodzącego w zestaw kliknij w nazwę') ?>
		</p>
		
		<?php foreach ($kit_products as $kit_product): ?>
			<?php if ($kit_product['AttributeValue']): ?>
				<a class="accordion-label" data-type="toggle" href="#KitProductAttributes<?php echo $kit_product['KitProduct']['product_id'] ?>">
					<?php echo $kit_product['KitProduct']['name'] ?>
				</a>
				
				<div class="accordion-content" id="KitProductAttributes<?php echo $kit_product['KitProduct']['product_id'] ?>">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'product'.DS.'attributes_table',
							array(
								'attributes' => $kit_product['AttributeValue']
							)
						)
					?>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
</div>
<?php endif;?>