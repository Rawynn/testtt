<li>
	<h3>
		<?php if (setting('MODULE_NEWS_LINK_ENTRY')): ?>
			<a href="<?php echo $this->Html->url(getNewsUrl($news['News']['id'])) ?>" title="<?php echo h($news['News']['title']) ?>">
				<?php echo $news['News']['title'] ?>
			</a>
		<?php else: ?>
			<?php echo $news['News']['title'] ?>
		<?php endif ?>
		
		<?php if (setting('MODULE_NEWS_SHOW_DATES')): ?>
			<time class="news-date" datetime='<?php echo date(DATE_W3C, strtotime($news['News']['created'])) ?>'>
				<?php echo showDate($news['News']['created']) ?>
			</time>
		<?php endif ?>
	</h3>
	
	<?php if ($news['News']['filename']): ?>
		<?php
			echo $this->element(
				'_default'.DS.'miniature',
				array(
					'file'  => array(
						'type'     => configuration('News.dir'),
						'filename' => $news['News']['filename'],
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
							'alt' => $news['News']['title']
						),
						'tag'   => array(
							'name'       => 'div',
							'properties' => array(
								'class'       => 'news-thumbnail img-thumbnail preload-image',
								'data-loaded' => 'false'
							)
						)
					)
				)
			)
		?>
	<?php endif ?>
	
	<?php if ($news['News']['intro'] && $show_intro): ?>
		<div class="news-intro cms-content">
			<?php echo $news['News']['intro'] ?>
		</div>
	<?php endif ?>
	
	<?php if (setting('MODULE_NEWS_SHOW_MORE')): ?>
		<a class="news-more btn btn-link pull-right" href="<?php echo $this->Html->url(getNewsUrl($news['News']['id'])) ?>" title="<?php echo h($news['News']['title']) ?>">
			<?php __('Więcej') ?> <i class="fa fa-chevron-right"></i>
		</a>
	<?php endif ?>
</li>