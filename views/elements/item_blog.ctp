<li>
	<h3>
		<a href="<?php echo $this->Html->url(getBlogUrl($blog['Blog']['id'])) ?>" title="<?php echo h($blog['Blog']['title']) ?>">
			<?php echo $blog['Blog']['title'] ?>
		</a>
		
		<time class="blog-date" datetime='<?php echo date(DATE_W3C, strtotime($blog['Blog']['created'])) ?>'>
			<?php echo showDate($blog['Blog']['created']) ?>
		</time>
	</h3>
	
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
						'width'      => 75,
						'height'     => 75,
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
								'class'       => 'blog-thumbnail img-thumbnail preload-image',
								'data-loaded' => 'false'
							)
						)
					)
				)
			)
		?>
	<?php endif ?>
	
	<?php if ($blog['Blog']['intro'] && $show_intro): ?>
		<div class="blog-intro cms-content">
			<?php echo $blog['Blog']['intro'] ?>
		</div>
	<?php endif ?>
	
	<a class="blog-more btn btn-link pull-right" href="<?php echo $this->Html->url(getBlogUrl($blog['Blog']['id'])) ?>" title="<?php echo h($blog['Blog']['title']) ?>">
		<?php __('Więcej') ?> <i class="fa fa-chevron-right"></i>
	</a>
</li>