<?php
	$__products = array();
	
	foreach ($products as $key => $product_id) :
		$__products[ceil(($key + 1)/ 2) - 1][] = $product_id;
	endforeach;
	
	$products = $__products;
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:700px; width: 100%; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">
	<?php foreach ($products as $key => $__products): ?>
		<tr>
			<td>
				<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 700px; width: 100%;">
					<tr>
						<?php foreach ($__products as $__key => $product_id) : ?>
							<?php
								$url      = getNewsletterProductUrl($product_id, $newsletter_id);
								$filename = getProductMainPhotoId($product_id);
								$dir      = getProductMainPhotoId($product_id, 'dir');
							?>
							<td style="width:46%; text-align: center; padding: 20px 0;">
								<a href="<?php echo $this->Html->url($url); ?>" title="<?php echo getProductName($product_id) ?>" target="_blank">
									<?php
										echo $this->element(
											'_default'.DS.'miniature',
											array(
												'file'  => array(
													'type'     => configuration('ProductMedium.dir'),
													'filename' => $filename,
													'dir'      => $dir
												),
												'image' => array(
													'resize'     => 'resize',
													'width'      => 200,
													'height'     => 200,
													'no_photo'   => true,
													'watermark'  => $product_id,
													'background' => array(
														'R' => 255,
														'G' => 255,
														'B' => 255
													)
												),
												'html'  => array(
													'image' => array(
														'alt' => getProductName($product_id)
													)
												)
											)
										)
									?>
								</a>
							</td>
							
							<?php if (isset($__products[$__key + 1])): ?>
								<td rowspan="7" style="width: 8%"></td>
							<?php endif ?>
						<?php endforeach ?>
					</tr>
					<tr>
						<td colspan="5" height="10"></td>
					</tr>
					<tr>
						<?php foreach ($__products as $__key => $product_id): ?>
							<?php $url = getNewsletterProductUrl($product_id, $newsletter_id) ?>
							
							<td style="font-weight: bold; vertical-align: middle;">
								<a href="<?php echo $this->Html->url($url) ?>" style="color: #333333; text-decoration: none;" title="<?php echo getProductName($product_id) ?>" target="_blank">
									<?php
										$product_name = getProductName($product_id);
										
										if ($product_name_length_limit):
											echo $this->Text->truncate($product_name, $product_name_length_limit);
										else:
											echo $product_name;
										endif;
									?>
								</a>
							</td>
						<?php endforeach;?>
					</tr>
					<tr>
						<td colspan="5" height="10"></td>
					</tr>
					<tr>
						<?php foreach ($__products as $__key => $product_id): ?>
							<td style="color: #999999; font-size: 12px;">
								<?php echo getProductProducerName($product_id) ?>
							</td>
						<?php endforeach;?>
					</tr>
					<tr>
						<td colspan="5" height="10"></td>
					</tr>
					<tr>
						<?php foreach ($__products as $__key => $product_id): ?>
							<td style="font-size: 18px; color: #c53030; padding-bottom: 15px; border-bottom: 1px solid #dddddd;">
								<?php
									$price = getProductPrice($product_id);
									$url   = getNewsletterProductUrl($product_id, $newsletter_id);
									$netto = getDefaultPricesType() == 'netto';
								?>
								
								<span style="display: inline-block; margin-top: 7px;">
									<?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?>
								</span>
								
								<?php if (!empty($price['base_price'])): ?>
									<span style="font-size: 12px; color: #999999; display: inline-block; text-decoration: line-through; margin-left: 5px;">
										<?php echo showPrice($netto ? $price['netto_base_price'] : $price['base_price']) ?>
									</span>
								<?php endif ?>
								
								<a href="<?php echo $this->Html->url($url) ?>" style="float: right;" title="<?php echo getProductName($product_id) ?>" target="_blank">
									<?php
										echo $this->Html->image(
											$this->Html->url('/img/layout/'.TEMPLATE_NAME.'/newsletter/add_to_cart.png', true),
											array(
												'alt'   => __('Dodaj do koszyka', true),
												'style' => 'text-decoration: none;'
											)
										)
									?>
								</a>
							</td>
						<?php endforeach ?>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="20"></td>
		</tr>
	<?php endforeach ?>
</table>