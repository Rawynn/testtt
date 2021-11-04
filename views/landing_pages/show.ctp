<div class="landing-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $landing_page['LandingPage']['name'] ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($gallery): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'landing_page'.DS.'gallery', array(
						'gallery_name'   => $gallery['Gallery']['name'],
						'gallery_images' => $gallery['GalleryImage']
					)
				)
			?>
		<?php endif ?>
		
		<?php if ($banners): ?>
			<div class="banners">
				<?php foreach ($banners as $banner): ?>
					<?php if ($banner['Banner']['filename']): ?>
						<?php
							$banner_image = $this->Html->image(
								configuration('Banner.dir').DS.$banner['Banner']['filename'],
								array(
									'alt'   => $banner['Banner']['name'],
									'title' => $banner['Banner']['name']
								)
							)
						?>
						
						<div class="item">
							<?php if ($banner['Banner']['url']): ?>
								<a href="<?php echo $this->Html->url($banner['Banner']['url']) ?>" title="<?php echo h($banner['Banner']['name']) ?>">
									<?php echo $banner_image ?>
								</a>
							<?php else: ?>
								<?php echo $banner_image ?>
							<?php endif ?>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		<?php endif ?>
		
		<div class="cms-content">
			<?php echo $landing_page['LandingPage']['content'] ?>
		</div>
		
		<?php if ($products): ?>
			<ul class="product-list gallery col-4" data-type="product-list" data-from="landing-page" data-url="<?php echo $this->Html->url(getLandingPageClickUrl($landing_page['LandingPage']['id'])) ?>" data-campaign-id="<?php echo $landing_page['LandingPage']['campaign_id'] ?>">
				<?php
					foreach ($products as $product):
						echo $this->element(
							'_default'.DS.'product_item',
							array(
								'type'    => 'gallery',
								'path'    => TEMPLATE_NAME.DS.'product_list'.DS.'item_gallery',
								'product' => $product
							)
						);
					endforeach;
				?>
			</ul>
			
			<?php if (setting('OPTIMALIZATION_FRONTEND_LANDING_PAGE_PRODUCTS_PAGINATION') && !$landing_page['LandingPage']['products_limit']): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'paginator',
						array(
							'class' => 'list-page-paginator'
						)
					)
				?>
			<?php endif ?>
		<?php endif ?>
	</div>
</div>