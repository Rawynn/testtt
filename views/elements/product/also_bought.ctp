<?php if ($products = getProductBuying($product_id, 4, false)): ?>
	<?php addCampaignViewBox($campaign_id = getSectionCampaignId('also-bought')) ?>
	<div class="line">
		<h2>
			<?php __('Klienci, którzy kupili ten produkt, kupili także') ?>
		</h2>
	</div>
	
	<ul class="product-list gallery col-4" data-from="also-bought" data-campaign-id="<?php echo $campaign_id ?>">
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