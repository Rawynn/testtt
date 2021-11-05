<?php if ($is_first): ?>
	<?php if ($products): ?>
		<?php addCampaignViewBox($campaign_id = getSectionCampaignId($box_name)) ?>
		
		<ul class="product-list gallery col-5" data-from="main main-<?php echo Inflector::slug($box_name, '-') ?>" data-campaign-id="<?php echo $campaign_id ?>">
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
	<?php else: ?>
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'message'.DS.'message',
				array(
					'class'   => 'flat no-items',
					'message' => __('Brak produktów do wyświetlenia.', true)
				)
			)
		?>
	<?php endif ?>
<?php endif ?>
