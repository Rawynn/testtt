<?php if ($products): ?>
	<?php foreach ($products as $product): ?>
		<?php $url = $this->Html->url(getProductUrl($product['Product']['id'])) ?>
		
		<item>
			<?php
				echo $this->Xml->elem(
					'title',
					null,
					array(
						'value' => $product['Product']['name'].'; '.showPrice($product['Rss_price']['price']),
						'cdata' => true
					)
				);
				
				echo $this->Xml->elem('link', null, $url);
				
				$product_image = '';
				
				if ($product['ProductMedium'] && strpos($product['ProductMedium'][0]['mime'], 'image') !== false):
					$product_image = $this->element(
						'_default'.DS.'miniature',
						array(
							'file' => array(
								'type'     => configuration('ProductMedium.dir'),
								'filename' => $product['ProductMedium'][0]['filename'],
								'dir'      => $product['ProductMedium'][0]['dir'],
							),
							'image' => array(
								'resize'     => 'resize',
								'width'      => 60,
								'height'     => 60,
								'no_photo'   => false,
								'watermark'  => $product['Product']['id']
							),
							'html' => array(
								'image' => array()
							)
						)
					);
				endif;
				
				$description = '
					<span style="float: left; margin-right: 15px;">
						<p>'.$product_image.'</p>
					</span>'.
					$product['Product']['description']
				;
				
				if (isset($product['Attr']) && $product['Attr'] != ''):
					$description .= '<b>'.__('Dane techniczne', true).':</b><br/>'.$product['Attr'];
				endif;
				
				echo $this->Xml->elem(
					'description',
					null,
					array(
						'value' => $description,
						'cdata' => true
					)
				);
				
				$created = date('Y-m-d H:i:s');
				
				if (isset($product['Rss']['created'])):
					$created = $product['Rss']['created'];
				elseif (isset($product['Rss'][0])):
					foreach ($product['Rss'] as $rss):
						if ($rss[$type] == 1):
							$created = $rss['created'];
							
							break;
						endif;
					endforeach;
				endif;
				
				echo $this->Xml->elem(
					'pubDate',
					null,
					date('D, d M Y H:i:s O', strtotime($created))
				);
				
				echo $this->Xml->elem('guid', null, $url);
			?>
		</item>
	<?php endforeach ?>
<?php endif ?>