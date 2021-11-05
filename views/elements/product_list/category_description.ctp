<?php if (getCurrentPaginatePage() == 1): ?>
	
	<?php if ($category['Category']['description']): ?>
		<div class="category-description">
			<?php
				echo $this->element(
					'_default'.DS.'miniature',
					array(
						'file'  => array(
							'type'     => configuration('Category.dir'),
							'filename' => $category['Category']['logo'],
							'dir'      => ''
						),
						'image' => array(
							'resize'     => 'resize',
							'width'      => 150,
							'height'     => 150,
							'blazy'      => true,
							'background' => array(
								'R' => 255,
								'G' => 255,
								'B' => 255
							)
						),
						'html'  => array(
							'image' => array(
								'alt' => isset($category['Category']['name']) ? h($category['Category']['name']) : ''
							),
							'tag' => array(
								'name'       => 'div',
								'properties' => array(
									'class'       => 'category-thumbnail img-thumbnail preload-image',
									'data-loaded' => 'false'
								)
							)
						)
					)
				)
			?>
			
			<div>
				<?php echo $category['Category']['description'] ?>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>