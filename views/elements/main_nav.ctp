<nav class="main-nav">
	<?php if ($categories = getCategoryTree('all')): ?>
		<ul class="main-nav-list nav-justified" id="MainNav" data-toggle-extended-elements="top-navigation">
			<li class="mobile-close-nav">
				<span data-type="show-menu-mobile">
					&times;
				</span>
			</li>
			
			<?php foreach ($categories as $category): ?>
				<?php if($category['Category']['id'] == 398 || $category['Category']['id'] == 515 || $category['Category']['id'] == 708 || $category['Category']['id'] == 1212 || $category['Category']['id'] == 393 || $category['Category']['id'] == 700 || $category['Category']['id'] == 895 || $category['Category']['id'] == 1184 ):?>
				<?php else:?>
				<li>
					<?php if ($category['children']): ?>
						<a data-target="<?php echo $category['Category']['id'] ?>" href="<?php echo $this->Html->url(getCategoryUrl($category['Category']['id'])) ?>" title="<?php echo h(Sanitize::html($category['Category']['seo_name'] ? $category['Category']['seo_name'] : $category['Category']['name'], array('remove' => true))) ?>">
							<i class="fa fa-chevron-left"></i> <?php echo $category['Category']['name'] ?> <i class="fa fa-chevron-right"></i>
						</a>
						
						<div class="sub-cat" data-id="<?php echo $category['Category']['id'] ?>" data-group="subcategory">
							<div class="container">
								<div class="col-sm-9">
								<?php foreach (array_chunk($category['children'], ceil(count($category['children'])/3), true) as $sub_category_group): ?>
									<div class="col-sm-4">
									<div class="row">
										<?php foreach ($sub_category_group as $sub_category_depth_1): ?>
											<div class="sub-categories">
												<?php if ($sub_category_depth_1['children']): ?>
													<a href="<?php echo $this->Html->url(getCategoryUrl($sub_category_depth_1['Category']['id'])) ?>" title="<?php echo h(Sanitize::html($sub_category_depth_1['Category']['seo_name'] ? $sub_category_depth_1['Category']['seo_name'] : $sub_category_depth_1['Category']['name'], array('remove' => true))) ?>">
														<i class="fa fa-chevron-left"></i> <?php echo $sub_category_depth_1['Category']['name'] ?> <i class="fa fa-chevron-right"></i>
													</a><span data-target="box<?php echo $sub_category_depth_1['Category']['id']?>" class="down" ></span>
													
													<ul class="sub-categories-list navigation-list" data-id="box<?php echo $sub_category_depth_1['Category']['id']?>">
														<?php foreach ($sub_category_depth_1['children'] as $sub_category_depth_2): ?>
															<li>
																<a href="<?php echo $this->Html->url(getCategoryUrl($sub_category_depth_2['Category']['id'])) ?>" title="<?php echo h(Sanitize::html($sub_category_depth_2['Category']['seo_name'] ? $sub_category_depth_2['Category']['seo_name'] : $sub_category_depth_2['Category']['name'], array('remove' => true))) ?>">
																	<?php echo $sub_category_depth_2['Category']['name'] ?>
																</a>
															</li>
														<?php endforeach ?>
													</ul>
												<?php else: ?>
													<a class="only-link" href="<?php echo $this->Html->url(getCategoryUrl($sub_category_depth_1['Category']['id'])) ?>" title="<?php echo h(Sanitize::html($sub_category_depth_1['Category']['seo_name'] ? $sub_category_depth_1['Category']['seo_name'] : $sub_category_depth_1['Category']['name'], array('remove' => true))) ?>">
														<?php echo $sub_category_depth_1['Category']['name'] ?>
													</a>
												<?php endif ?>
											</div>
										<?php endforeach ?>
									</div>
									</div>
								<?php endforeach ?>
								</div>
								<div class="col-sm-3">
									<div class="item">
										<?php $products = getRecommendedProducts(1, array($category['Category']['id']))?>
										<ul class="product-list gallery">
											<?php 
											foreach ($products as $product):
											echo $this->element(
													'_default'.DS.'product_item',
													array(
															'type'    => 'gallery',
															'path'    => TEMPLATE_NAME.DS.'product_list'.DS.'item_gallery_menu',
															'product' => $product
													)
													);
											endforeach;
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					<?php else: ?>
						<a href="<?php echo $this->Html->url(getCategoryUrl($category['Category']['id'])) ?>" title="<?php echo h(Sanitize::html($category['Category']['seo_name'] ? $category['Category']['seo_name'] : $category['Category']['name'], array('remove' => true))) ?>">
							<?php echo $category['Category']['name'] ?>
						</a>
					<?php endif ?>
				</li>
				<?php endif;?>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
</nav>