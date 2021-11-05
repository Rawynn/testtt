<?php if (!empty($product_id)) : ?>
	<ul style="margin: 0; list-style-type: none; padding: 0;">
		<li style="font-family: Arial, Helvetica, sans-serif; color: #333333; display: inline-block; width: 46%;">
			<?php 
				$url      = getNewsletterProductUrl($product_id, $newsletter_id);
				$filename = getProductMainPhotoId($product_id);
				$dir      = getProductMainPhotoId($product_id, 'dir');
			?>
			
			<a href="<?php echo $this->Html->url($url); ?>" style="display: block; padding: 20px 0;" title="<?php echo getProductName($product_id) ?>">
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
			
			<?php $product_name = getProductName($product_id) ?>
			
			<?php if (!empty($product_name)): ?>
				<a href="<?php echo $this->Html->url($url) ?>" style="color: #333333; text-decoration: none; font-weight: bold; display: inline-block; margin: 10px 0; text-align: left;" title="<?php echo getProductName($product_id) ?>">
					<?php
						if ($product_name_length_limit):
							echo $this->Text->truncate($product_name, $product_name_length_limit);
						else:
							echo $product_name;
						endif;
					?>
				</a>
			<?php endif; ?>
			
			<p style="color: #999999; font-size: 12px; text-align: left; margin: 0 0 10px;">
				<?php echo getProductProducerName($product_id) ?>
			</p>
			
			<div style="font-size: 18px; color: #c53030; text-align: left;">
				<?php
					$price = getProductPrice($product_id);
					$netto = getDefaultPricesType() == 'netto';
				?>
				
				<span style="display: inline-block; margin-top: 7px;">
					<?php echo showPrice($netto ? $price['netto_price'] : $price['price']) ?>
				</span>
				
				<?php if (!empty($price['base_price'])) : ?>
					<span style="font-size: 12px; color: #999999; text-decoration: line-through; margin-left: 5px;">
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
			</div>
		</li>
	</ul>
	
	<div style="clear: both;"></div>
<?php endif ?>