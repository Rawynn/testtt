<?php if (getCurrentPaginatePage() == 1): ?>
	<?php if ($category['Category']['id']): ?>
		<?php
			/* Banery kategorii */
			echo $this->element(
				TEMPLATE_NAME.DS.'banners',
				array(
					'container_class'   => 'category-banners',
					'carousel_id'       => 'CategoryBanners',
					'section'           => 2,
					'banner_categories' => $category['Category']['id']
				)
			)
		?>
	<?php endif ?>
	
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
			
			<div class="cms-content">
				<?php echo $category['Category']['description'] ?>
			</div>
			
			<span class="category-more">
				<span class="show-category"><?php __('czytaj dalej') ?><i class="fa fa-plus" aria-hidden="true"></i></span>
				<span class="hide-category"><?php __('zwiń') ?><i class="fa fa-minus" aria-hidden="true"></i></span>
			</span>
		</div>
	<?php endif ?>
<?php endif ?>