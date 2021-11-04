<?php $places = getCurrencyPrecision() ?>

<table cellpadding="0" cellspacing="0" width="100%" border="0" style="margin-top: 15px; margin-bottom: 15px; width: 100%;">
	<tr>
		<td colspan="7" style="padding: 7px; font-size: 14px; ; background: #ebebeb; text-align: center; font-weight: bold; color: #000000;">
			<?php __('Produkty w Twoim koszyku') ?>
		</td>
	</tr>
	<tr>
		<td colspan="7" style="height: 15px; font-size: 15px;">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom: 3px solid #000000; font-weight: bold; font-size: 13px;">
			<?php __('PRODUKT') ?>
		</td>
		<td style="border-bottom: 3px solid #000000; font-weight: bold; font-size: 13px; text-align: center;">
			<?php __('ILOŚĆ') ?>
		</td>
		<td style="border-bottom: 3px solid #000000; font-weight: bold; font-size: 13px; text-align: center;">
			<?php __('CENA') ?>
		</td>
		<td style="border-bottom: 3px solid #000000; font-weight: bold; font-size: 13px; text-align: right;">
			<?php __('ŁĄCZNIE') ?>
		</td>
	</tr>
	
	<?php foreach ($products as $product): ?>
		<tr>
			<td style="padding-top: 5pt; padding-bottom: 5pt; font-size: 9pt;">
				<?php
					echo getProductImage(
						array(
							'product_id'     => $product['product_id'],
							'combination_id' => $product['combination_id']
						),
						100,
						100
					)
				?>
			</td>
			<td style="font-size: 9pt; padding: 5pt 10pt 5pt 10pt;">
				<p style="margin: 0; font-weight: bold; color: #555555;">
					<?php echo getProductName($product['product_id']) ?>
				</p>
				
				<p style="margin: 0;">
					<?php
						$combination_name = '';
						
						if ($product['combination_id'] > 0):
							$combination_name = getCombinationName($product['combination_id']);
							
							if ($combination_name):
								$combination_name = '-'.$combination_name;
							endif;
						endif;
						
						echo $combination_name;
					?>
				</p>
			</td>
			<td style="text-align: center; font-size: 9pt; padding-left: 10pt; padding-right: 10pt;">
				<?php echo showQuantityValue($product['quantity'], $product['product_id']) ?>
			</td>
			<td style="text-align: center; font-size: 9pt; padding-left: 10pt; padding-right: 10pt;">
				<?php echo showPrice($product['single_price']) ?>
			</td>
			<td style="text-align: right; font-size: 9pt; padding-left: 10pt;">
				<?php echo showPrice($product['price']) ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>