<?php if ($gallery_images): ?>
	<?php
		$count_images = count($gallery_images);
		
		if ($count_images < 5):
			$nr_columns = 12 / $count_images;
		else:
			$nr_columns = 3;
		endif
	?>
	
	<div class="news-gallery row">
		<?php foreach ($gallery_images as $key => $gallery_image): ?>
			<a class="col-xs-<?php echo $nr_columns ?> preload-image" href="#" data-type="news-gallery" data-medium-id="<?php echo $key ?>" data-loaded="false">
				<?php
					$filename = isset($gallery_image['filename']) ? $gallery_image['filename'] : false;
					$dir      = isset($gallery_image['dir']) ? $gallery_image['dir'] : false;
					
					$url = $this->Image->resize(
						configuration('Gallery.dir').DS.$dir.DS.$filename,
						1920,
						1080,
						true,
						array(),
						true,
						false,
						$dir,
						setting('MODULE_WATERMARKS_FILENAME')
					);
					
					echo $this->element(
						'_default'.DS.'miniature',
						array(
							'file'  => array(
								'type'     => configuration('Gallery.dir'),
								'filename' => $filename,
								'dir'      => $dir,
							),
							'image' => array(
								'resize'     => 'resize',
								'width'      => 350,
								'height'     => 350,
								'no_photo'   => true,
								'watermark'  => $gallery_image['id'],
								'blazy'      => true,
								'background' => array(
									'R' => 255,
									'G' => 255,
									'B' => 255
								)
							),
							'html'  => array(
								'image' => array(
									'alt'        => isset($gallery_name) ? h($gallery_name) : '',
									'itemprop'   => $key == 0 ? 'image' : '',
									'data-url'   => $url,
									'data-thumb' => $this->Image->resize(
										configuration('Gallery.dir').DS.$dir.$filename,
										50,
										50,
										true,
										array(),
										true,
										false,
										$dir,
										false
									)
								)
							)
						)
					)
				?>
			</a>
		<?php endforeach ?>
	</div>
<?php endif ?>