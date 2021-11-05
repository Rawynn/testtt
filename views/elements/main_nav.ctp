<nav class="main-nav" data-id="MainNav2" data-group="subcategory-top">
	<?php if ($menu = getMainMenu(1, true)): ?>
		<div class="container">
		<div class="row">
		<ul class="col-md-3 col-sm-4 parent">
			<?php foreach ($menu as $item): ?>
				<li>
					<?php if ($item['children']): ?>
						<a data-target="men<?php echo $item['Menu']['foreign_key'] ?>" href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($item['Menu']['seo_name'], array('remove' => true))) ?>">
							<?php echo $item['Menu']['name'] ?> <i class="fa fa-angle-right"></i>
						</a>
					<?php else: ?>
						<a class="single" href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($item['Menu']['seo_name'], array('remove' => true))) ?>">
							<?php echo $item['Menu']['name'] ?>
						</a>
					<?php endif ?>
				</li>
			<?php endforeach ?>
				<li>
					<a class="single" href="<?php echo $this->Html->url(getCategoryUrl(1)) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
						<?php __('Pokaż wszystkie') ?>
					</a>
				</li>
		</ul>
		<ul class="col-md-3 col-sm-4 child1">
			<li>
				<?php foreach ($menu as $item): ?>
					<?php if ($item['children']): ?>
						<ul id="men<?php echo $item['Menu']['foreign_key'] ?>" >
							<?php foreach ($item['children'] as $sub_menu_depth_1):?>
								<li>
									<?php if ($sub_menu_depth_1['children']): ?>
										<a data-target="men<?php echo $sub_menu_depth_1['Menu']['foreign_key'] ?>" href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
											<?php echo $sub_menu_depth_1['Menu']['name'] ?> <i class="fa fa-angle-right"></i>
										</a>
									<?php else:?>
										<a class="only-link" href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
											<?php echo $sub_menu_depth_1['Menu']['name'] ?>
										</a>
									<?php endif;?>
								</li>
							<?php endforeach;?>
						</ul>
					<?php endif;?>
				<?php endforeach;?>
			</li>
		</ul>
		<ul class="col-md-3 col-sm-4 child2">
		<li>
			<?php foreach ($menu as $item): ?>
				<?php if ($item['children']): ?>
					
					<?php foreach ($item['children'] as $sub_menu_depth_1):?>
						<?php if ($sub_menu_depth_1['children']): ?>
							<ul id="men<?php echo $sub_menu_depth_1['Menu']['foreign_key'] ?>">
								<?php foreach ($sub_menu_depth_1['children'] as $sub_menu_depth_2): ?>
									<li>
										<a href="<?php echo $this->Html->url($sub_menu_depth_2['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_2['Menu']['seo_name'], array('remove' => true))) ?>">
											<?php echo $sub_menu_depth_2['Menu']['name'] ?>
										</a>
									</li>
								<?php endforeach ?>
							</ul>
						<?php endif;?>
					<?php endforeach;?>
					
				<?php endif;?>
			<?php endforeach;?>
			</li>
		</ul>
		<?php $banners = getBannersForSection(8);?>
		<div class="last col-sm-3 <?php echo (!empty($banners['Data']['Banner']))? 'banner-menu': ''; ?>">
			
			<?php if (!empty($banners['Data']['Banner'])): ?>
				<?php $width         = $banners['Data']['BannerSection']['width'];
				$height        = $banners['Data']['BannerSection']['height'];?>
				<?php foreach ($banners['Data']['Banner'] as $key => $banner): ?>
					<a href="<?php echo $this->Html->url(getBannersClickUrl($banner['Banner']['id'])) ?>" title="<?php echo h($banner['Banner']['name']) ?>" data-banner-id="<?php echo $banner['Banner']['id'] ?>" data-banner-name="<?php echo h($banner['Banner']['name']) ?>" data-banner-description="<?php echo h($banner['Banner']['description']) ?>" data-banner-section-name="<?php echo h($banners['Data']['BannerSection']['name']) ?>">
						<?php
							echo $this->Image->resize(
								$banners['Info']['image_path'].DS.$banner['Banner']['filename'],
								$width,
								$height
							)
						?>
					</a>
				<?php endforeach;?>
			<?php else:?>
				<?php $recommend_products = getRecommendedProducts(1);?>
				<?php if ( $recommend_products ) : ?>
		
			<?php foreach ( $recommend_products as $product ) : ?>
			<ul class="product-list gallery col-12">
				<?php
					echo $this->element(
						'_default'.DS.'product_item',
						array(
							'type'    => 'gallery',
							'path'    => TEMPLATE_NAME.DS.'product_list'.DS.'item_gallery',
							'product' => $product
						)
					);
				?>
			</ul>
			<?php endforeach; ?>
		
	<?php endif ?>
			<?php endif;?>
		</div>
		</div>
		</div>
	<?php endif ?>
</nav>