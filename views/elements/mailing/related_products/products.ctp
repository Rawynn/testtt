<?php if (!empty($related_products)): ?>
	<?php
		$cells          = 4;
		$product_ids   = Set::extract($related_products, '{n}.RelatedProduct.related_product_id');
		$rows_         = ceil((count($related_products) / $cells));
		$img_dimension = floor((600 / $cells));
		$td_width      = floor((640 / $cells));
	?>
	
	<table cellpadding="0" cellspacing="0" style="width: 640px;" width="640">
		<?php for ($i = 0 ; $i < $rows_; $i++): ?>
			<?php
				$ids = array();
				
				for ($z = 0 ; $z < $cells ; $z++):
					if (!empty($product_ids)):
						$ids[] = array_shift($product_ids);
					else:
						$ids[] = 0;
					endif;
				endfor;
			?>
			
			<tr>
				<?php foreach ($ids as $product_id): ?>
					<?php
						$get_params = array(
							'reminder' => 'related_product'
						);
						
						if (setting('MODULE_CAMPAIGNS_RELATED_PRODUCTS_REMINDER_CAMPAIGN_ID')):
							$get_params['campaign-id'] = setting('MODULE_CAMPAIGNS_RELATED_PRODUCTS_REMINDER_CAMPAIGN_ID');
						endif;
					?>
					
					<td style="text-align: center; padding-left: 5px; padding-right: 5px; padding-top: 15px; padding-bottom: 10px; vertical-align: middle; width: <?php echo $td_width ?>">
						<?php if ($product_id > 0):?>
							<a href="<?php echo Router::url(getProductUrl($product_id), $get_params, true) ?>" target="_blank">
								<?php echo getProductImage($product_id, $img_dimension, $img_dimension) ?>
							</a>
						<?php endif ?>
					</td>
				<?php endforeach ?>
			</tr>
			<tr>
				<?php foreach ($ids as $product_id): ?>
					<td style="text-align: center; padding-left: 5px; padding-right: 5px; padding-bottom: 15px; font-weight: bold; vertical-align: middle;">
						<?php if ($product_id > 0): ?>
							<a style="color: #333333; font-size: 12px; font-weight: bold; font-family: sans-serif; text-decoration: none;" href="<?php echo Router::url(getProductUrl($product_id), true) ?>" target="_blank"><?php echo getProductName($product_id) ?></a>
						<?php endif ?>
					</td>
				<?php endforeach ?>
			</tr>
		<?php endfor ?>
	</table>
<?php endif ?>