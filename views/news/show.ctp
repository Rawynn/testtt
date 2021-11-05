<div class="news-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $news['News']['title'] ?>
			
			<?php if (setting('MODULE_NEWS_SHOW_DATES')): ?>
				<time class="news-date" datetime="<?php echo date(DATE_W3C, strtotime($news['News']['created'])) ?>">
					<?php echo showDate($news['News']['created']) ?>
				</time>
			<?php endif ?>
		</h1>
	</div>
	
	<div class="page-content cms-content">
		<?php if ($gallery): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'news'.DS.'gallery', array(
						'gallery_name'   => $gallery['Gallery']['name'],
						'gallery_images' => $gallery['GalleryImage']
					)
				)
			?>
		<?php endif ?>
		
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
		
		<?php if ($news['News']['intro']): ?>
			<div class="news-intro">
				<?php echo $news['News']['intro'] ?>
			</div>
		<?php endif ?>
		
		<?php if ($news['News']['content']): ?>
			<div class="news-content">
				<?php echo $news['News']['content'] ?>
			</div>
		<?php endif ?>
	</div>
</div>