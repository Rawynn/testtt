<li>
	<?php if ($blog['Blog']['logo']): ?>
		<?php
			echo $this->element(
				'_default'.DS.'miniature',
				array(
					'file'  => array(
						'type'     => configuration('Blog.dir'),
						'filename' => $blog['Blog']['logo'],
						'dir'      => ''
					),
					'image' => array(
						'resize'     => 'resize',
						//'width'      => 252,
						//'height'     => 121,
						'width'      => 350,
						'height'     => 170,
						'blazy'      => true,
						'background' => array(
							'R' => 255,
							'G' => 255,
							'B' => 255
						)
					),
					'html'  => array(
						'image' => array(
							'alt' => $blog['Blog']['title']
						),
						'tag'   => array(
							'name'       => 'div',
							'properties' => array(
								'class'       => 'blog-thumbnail preload-image',
								'data-loaded' => 'false'
							)
						)
					)
				)
			)
		?>
	<?php else:?>
		<?php 
			echo $this->element(
				'_default'.DS.'miniature',
				array(
						'file'  => null,
						'image' => array(
								'resize'     => 'resize',
								'width'      => 280,
								'height'     => 130,
								'no_photo'   => true,
								'blazy'      => true,
								'watermark'  => false,
								'background' => array(
										'R' => 255,
										'G' => 255,
										'B' => 255
								)
						),
						'html'  => array(
						'image' => array(
							'alt' => $blog['Blog']['title']
						),
						'tag'   => array(
							'name'       => 'div',
							'properties' => array(
								'class'       => 'blog-thumbnail preload-image',
								'data-loaded' => 'false'
							)
						)
					)
				)
				)
		?>
	<?php endif ?>
	<h3>
		<a href="<?php echo $this->Html->url(getBlogUrl($blog['Blog']['id'])) ?>" title="<?php echo h($blog['Blog']['title']) ?>">
			<?php echo $blog['Blog']['title'] ?>
		</a>
	</h3>
	
	
	
	<?php if ($blog['Blog']['intro'] && $show_intro): ?>
		<div class="blog-intro">
			<?php echo $blog['Blog']['intro'] ?>
		</div>
	<?php endif ?>
	
	<a class="blog-more btn btn-link pull-right" href="<?php echo $this->Html->url(getBlogUrl($blog['Blog']['id'])) ?>" title="<?php echo h($blog['Blog']['title']) ?>">
		<?php __('czytaj więcej') ?> <i class="fa fa-angle-right"></i>
	</a>
</li>