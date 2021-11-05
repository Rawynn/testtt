<?php if ($products = getSimilarProducts($product_id, 4)): ?>
	<?php addCampaignViewBox($campaign_id = getSectionCampaignId('similar')) ?>
	
	<h2>
		<?php __('Produkt niedostępny. Zobacz produkty podobne') ?>
	</h2>
	
	<ul class="product-list gallery col-4" data-from="similar" data-campaign-id="<?php echo $campaign_id ?>">
		<?php
			foreach ($products as $product):
				echo $this->element(
					'_default'.DS.'product_item',
					array(
						'type'    => 'gallery',
						'path'    => TEMPLATE_NAME.DS.'product_list'.DS.'item_gallery',
						'product' => $product
					)
				);
			endforeach;
		?>
	</ul>
<?php endif ?>