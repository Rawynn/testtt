<?php if ($items): ?>
	<?php foreach ($items as $item): ?>
		<?php $url = $this->Html->url(getBlogUrl($item['Blog']['id'])) ?>
		
		<item>
			<?php
				echo $this->Xml->elem(
					'title',
					null,
					array(
						'value' => $item['Blog']['title'],
						'cdata' => true
					)
				);
				
				echo $this->Xml->elem('link', null, $url);
				
				$blog_image = '';
				
				if ($item['Blog']['logo']):
					$blog_image = $this->element(
						'_default'.DS.'miniature',
						array(
							'file'  => array(
								'type'     => configuration('Blog.dir'),
								'filename' => $item['Blog']['logo'],
								'dir'      => ''
							),
							'image' => array(
								'resize' => 'resize',
								'width'  => 60,
								'height' => 60
							),
							'html'  => array(
								'image' => array()
							)
						)
					);
				endif;
				
				$description = '
					<span style="float: left; margin-right: 15px;">
						<p>'.$blog_image.'</p>
					</span>'.
					$item['Blog']['intro'].$item['Blog']['content']
				;
				
				echo $this->Xml->elem(
					'description',
					null,
					array(
						'value' => $description,
						'cdata' => true
					)
				);
				
				echo $this->Xml->elem(
					'pubDate',
					null,
					date('D, d M Y H:i:s O', strtotime($item['Blog']['created']))
				);
				
				echo $this->Xml->elem('guid', null, $url);
			?>
		</item>
	<?php endforeach ?>
<?php endif ?>