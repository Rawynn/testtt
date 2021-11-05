<?php
	$banners = array();
	
	if (isset($banner_categories) || isset($banner_producer_id)):
		if (!isset($banner_categories)):
			$banner_categories = null;
		endif;
		
		if (!isset($banner_producer_id)):
			$banner_producer_id = null;
		endif;
		
		$banners = getBannersForSection($section, $banner_categories, $banner_producer_id);
	else:
		$banners = getBannersForSection($section);
	endif;
?>

<?php if (!empty($banners['Data']['Banner'])): ?>
	<?php
		$width         = $banners['Data']['BannerSection']['width'];
		$height        = $banners['Data']['BannerSection']['height'];
		$banners_count = count($banners['Data']['Banner']);
		
		/* Dostasowanie do szerokości okna przeglądarki - #17463 */
		if (!empty($_COOKIE['window_size'])):
			$window_size = explode('x', $_COOKIE['window_size']);
			
			if (count($window_size) == 2 && is_numeric($window_size[0]) && $window_size[0] < $width):
				$width = $window_size[0];
			endif;
		endif;
	?>
	
	<div class="<?php echo isset($container_class) ? $container_class : '' ?> banners">
		<?php if ($banners['Data']['BannerSection']['show_all']): ?>
					<?php foreach ($banners['Data']['Banner'] as $key => $banner): ?>
							<?php if ($banner['Banner']['html']): ?>
								<?php echo $banner['Banner']['html'] ?>
							<?php else: ?>
								<?php if ($banner['Banner']['filename']): ?>
									<?php
										$banner_file = IMAGES.$banners['Info']['image_path'].DS.$banner['Banner']['filename'];
										$mime        = mime_content_type($banner_file);
									?>
									
									<?php if ($mime == 'image/svg+xml'): ?>
										<div class="item">
											<a href="<?php echo $this->Html->url(getBannersClickUrl($banner['Banner']['id'])) ?>" title="<?php echo h($banner['Banner']['name']) ?>">
											<?php
												echo $this->Html->image(
													$banners['Info']['image_path'].DS.$banner['Banner']['filename'],
													array(
														'width' => $width
													)
												)
											?>
											</a>
										</div>
									<?php else: ?>
										<?php $baner_type = getimagesize($banner_file) ?>
										
										<?php if (substr($baner_type['mime'], 0, 5) == 'image'): ?>
											<div class="item">
												<a href="<?php echo $this->Html->url(getBannersClickUrl($banner['Banner']['id'])) ?>" title="<?php echo h($banner['Banner']['name']) ?>">
												<?php
													echo $this->Image->resize(
														$banners['Info']['image_path'].DS.$banner['Banner']['filename'],
														$width,
														$height,
														true,
														array(
															'alt' => __($banner['Banner']['name'], true)
														)
													)
												?>
												</a>
											</div>
										<?php endif ?>
									<?php endif ?>
								<?php endif ?>
							<?php endif ?>
					<?php endforeach ?>
			
		<?php else: ?>
			<?php foreach ($banners['Data']['Banner'] as $key => $banner): ?>
				<div class="item">
					<?php if ($banner['Banner']['html']):?>
						<?php echo $banner['Banner']['html'] ?>
					<?php else:?>
						<?php if ($banner['Banner']['filename']): ?>
							<?php
								$banner_file = IMAGES.$banners['Info']['image_path'].DS.$banner['Banner']['filename'];
								$mime       = mime_content_type($banner_file);
							?>
							
							<?php if ($mime == 'image/svg+xml'): ?>
								<a href="<?php echo $this->Html->url(getBannersClickUrl($banner['Banner']['id'])) ?>" title="<?php echo h($banner['Banner']['name']) ?>">
									<?php
										echo $this->Html->image(
											$banners['Info']['image_path'].DS.$banner['Banner']['filename'],
											array(
												'width' => $width
											)
										)
									?>
								</a>
							<?php else: ?>
								<?php $baner_type = getimagesize($banner_file) ?>
								
								<?php if (substr($baner_type['mime'], 0, 5) == 'image'): ?>
									<a href="<?php echo $this->Html->url(getBannersClickUrl($banner['Banner']['id'])) ?>" title="<?php echo h($banner['Banner']['name']) ?>" data-banner-id="<?php echo $banner['Banner']['id'] ?>" data-banner-name="<?php echo h($banner['Banner']['name']) ?>" data-banner-description="<?php echo h($banner['Banner']['description']) ?>" data-banner-section-name="<?php echo h($banners['Data']['BannerSection']['name']) ?>">
										<?php
											echo $this->Image->resize(
												$banners['Info']['image_path'].DS.$banner['Banner']['filename'],
												$width,
												$height
											)
										?>
									</a>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
<?php endif ?>