<?php if ($products): ?>
	<?php addCampaignViewBox($campaign_id = getSectionCampaignId('cms_content')) ?>
	
	<ul class="product-list gallery col-4" data-from="content" data-campaign-id="<?php echo $campaign_id ?>">
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