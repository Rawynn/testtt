<?php if ($products = getProductAssocations($product_id, 4, false)): ?>
	<?php addCampaignViewBox($campaign_id = getSectionCampaignId('also-viewed')) ?>
	<div class="line">
		<h2>
			<?php __('Klienci, którzy oglądali ten produkt, oglądali także') ?>
		</h2>
	</div>
	<ul class="product-list gallery col-4" data-from="also-viewed" data-campaign-id="<?php echo $campaign_id ?>">
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