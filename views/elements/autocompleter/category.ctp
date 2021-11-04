<div class="product-box small">
	<?php
		if ($category_logo && file_exists(IMAGES.Configure::read('Category.dir').DS.$category_logo)):
			$category_logo = $this->element(
				'_default'.DS.'miniature',
				array(
					'file'  => array(
						'type'     => configuration('Category.dir'),
						'filename' => $category_logo,
						'dir'      => ''
					),
					'image' => array(
						'resize'     => 'resize',
						'width'      => 70,
						'height'     => 70,
						'no_photo'   => true,
						'watermark'  => 0,
						'blazy'      => true,
						'background' => array(
							'R' => 255,
							'G' => 255,
							'B' => 255
						)
					),
					'html'  => array(
						'image' => array(
							'alt' => h($category_name)
						)
					)
				)
			);
		else:
			$category_logo = '';
		endif;
	?>
	
	<span class="product-image preload-image <?php echo !$category_logo ? 'no-image' : '' ?>" data-loaded="<?php echo $category_logo ? 'false' : 'true' ?>">
		<?php echo $category_logo ?>
	</span>
	
	<span class="category-box">
		<span class="category-name">
			<?php
				if (preg_match_all('/'.get('term').'/i', $category_name, $matches)):
					foreach ($matches[0] as $match):
						$category_name = str_replace($match, '<span class="highlight">'.$match.'</span>', $category_name);
					endforeach;
				endif;
				
				echo $category_name;
			?>
		</span>
		
		<?php if ($parent_name && $parent_name != $category_name): ?>
			<span class="parent-name">
				<?php __('w') ?> <span><?php echo $parent_name ?></span>
				<i class="fa fa-caret-right" aria-hidden="true"></i>
			</span>
		<?php endif ?>
	</span>
</div>