<?php
	$places   = getCurrencyPrecision();
	$order_id = $order_details['Order']['id'];
?>

<?php foreach ($products as $product): ?>
	<tr>
		<td style="padding-top: 5pt; padding-bottom: 5pt; font-size: 9pt;">
			<?php
				echo getProductImage(
					array(
						'product_id'     => $product['OrderProduct']['product_id'],
						'combination_id' => $product['OrderProduct']['combination_id'],
						'filename'       => $product['OrderProduct']['filename'],
						'dir'            => $product['OrderProduct']['dir']
					),
					100,
					100
				)
			?>
		</td>
		<td style="font-size: 9pt; padding: 5pt 10pt 5pt 10pt;">
			<p style="margin: 0; font-weight: bold; color: #555555;">
				<?php
					$product_name = '';
					
					if ($product['OrderProduct']['product_price'] == 0 || $product['OrderProduct']['gratis'] == 1):
						$product_name .= '<span style="color: red;">'.__('GRATIS', true).'</span> ';
					endif;
					
					$product_name .= $product['OrderProduct']['product_name'];
					
					if ($product['OrderProduct']['width'] !== null || $product['OrderProduct']['height'] !== null):
						$product_name .= ' ['.number_format($product['OrderProduct']['width'], 3, ',', '').' x '.number_format($product['OrderProduct']['height'], 3, ',', '').' m]';
					endif;
					
					echo $product_name;
				?>
			</p>
			
			<p style="margin: 0;">
				<?php echo $product['OrderProduct']['combination_name'] ? $product['OrderProduct']['combination_name'] : '-' ?>
			</p>
		</td>
		<td style="text-align: center; font-size: 9pt; padding-left: 10pt; padding-right: 10pt;">
			<?php echo showQuantityValue($product['OrderProduct']['quantity'], $product['OrderProduct']['product_id']) ?>
		</td>
		<td style="text-align: center; font-size: 9pt; padding-left: 10pt; padding-right: 10pt;">
			<?php echo showOrderPrice(round($product['OrderProduct']['product_price'] * (1 + $product['OrderProduct']['tax_value'] / 100), $places), $order_id) ?>
		</td>
		<td style="text-align: right; font-size: 9pt; padding-left: 10pt;">
			<?php echo showOrderPrice(round($product['OrderProduct']['product_price'] * (1 + $product['OrderProduct']['tax_value'] / 100), $places) * $product['OrderProduct']['quantity'], $order_id) ?>
		</td>
	</tr>
<?php endforeach ?>