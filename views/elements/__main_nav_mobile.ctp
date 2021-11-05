<nav class="main-nav" data-id="MainNav" data-group="subcategory-top">
	<?php if ($menu = getMainMenu(1, true)): ?>
		<ul class="main-nav-list nav-justified" id="MainNav" data-toggle-extended-elements="top-navigation">
			<li class="mobile-close-nav">
				<span data-type="show-menu-mobile">
					&times;
				</span>
			</li>
			
			<?php foreach ($menu as $item): ?>
				<li>
					<?php if ($item['children']): ?>
						<a data-type="slidemenu" data-target="<?php echo $item['Menu']['id'] ?>" href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($item['Menu']['seo_name'], array('remove' => true))) ?>">
							<i class="fa fa-angle-left"></i> <?php echo $item['Menu']['name'] ?> <i class="fa fa-angle-right"></i>
						</a>
						
						<div class="sub-cat" data-id="<?php echo $item['Menu']['id'] ?>" data-group="subcategory">
							<?php foreach (array_chunk($item['children'], 5, true) as $sub_menu): ?>
								<div class="row">
									<?php foreach ($sub_menu as $sub_menu_depth_1): ?>
										<div class="sub-categories">
											<?php if ($sub_menu_depth_1['children']): ?>
												<a href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
													<i class="fa fa-angle-left"></i> <?php echo $sub_menu_depth_1['Menu']['name'] ?> <i class="fa fa-angle-right"></i>
												</a>
												
												<ul class="sub-categories-list navigation-list">
													<?php foreach ($sub_menu_depth_1['children'] as $sub_menu_depth_2): ?>
														<li>
															<a href="<?php echo $this->Html->url($sub_menu_depth_2['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_2['Menu']['seo_name'], array('remove' => true))) ?>">
																<?php echo $sub_menu_depth_2['Menu']['name'] ?>
															</a>
														</li>
													<?php endforeach ?>
												</ul>
												
												<?php if ($sub_menu_depth_2['Menu']['model'] == 'Category'): ?>
													<hr class="sub-sco-hr" />
													
													<ul class="sub-categories-options sub-sco">
														<li>
															<a href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
																<?php __('Pokaż wszystkie') ?> <i class="fa fa-angle-right" aria-hidden="true"></i>
															</a>
														</li>
													</ul>
												<?php endif ?>
											<?php else: ?>
												<a class="only-link" href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
													<?php echo $sub_menu_depth_1['Menu']['name'] ?>
												</a>
											<?php endif ?>
										</div>
									<?php endforeach ?>
								</div>
							<?php endforeach ?>
							
							<?php if ($item['Menu']['model'] == 'Category'): ?>
								<hr>
								
								<ul class="sub-categories-options">
									<li>
										<a href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
											<?php __('Pokaż wszystkie') ?> <i class="fa fa-angle-right" aria-hidden="true"></i>
										</a>
									</li>
								</ul>
							<?php endif ?>
						</div>
					<?php else: ?>
						<a href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($item['Menu']['seo_name'], array('remove' => true))) ?>">
							<?php echo $item['Menu']['name'] ?>
						</a>
					<?php endif ?>
				</li>
			<?php endforeach ?>
			
			
			
			
		</ul>
	<?php endif ?>
	
</nav>
<nav class="main-nav" data-id="special-menu">
<?php if ($menu2 = getMainMenu(2, true)): ?>		
		<ul id="special-menu" class="main-nav-list nav-justified">
			<?php foreach ($menu2 as $item): ?>
			<li>
				<?php if ($item['children']): ?>
					<a data-type="slidemenu" data-target="<?php echo $item['Menu']['id'] ?>" href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($item['Menu']['seo_name'], array('remove' => true))) ?>">
						<i class="fa fa-angle-left"></i> <?php echo $item['Menu']['name'] ?> <i class="fa fa-angle-right"></i>
					</a>
					
					<div class="sub-cat" data-id="<?php echo $item['Menu']['id'] ?>" data-group="subcategory">
						<?php foreach (array_chunk($item['children'], 5, true) as $sub_menu): ?>
							<div class="row">
								<?php foreach ($sub_menu as $sub_menu_depth_1): ?>
									<div class="sub-categories">
										<?php if ($sub_menu_depth_1['children']): ?>
											<a href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
												<i class="fa fa-angle-left"></i> <?php echo $sub_menu_depth_1['Menu']['name'] ?> <i class="fa fa-angle-right"></i>
											</a>
											
											<ul class="sub-categories-list navigation-list">
												<?php foreach ($sub_menu_depth_1['children'] as $sub_menu_depth_2): ?>
													<li>
														<a href="<?php echo $this->Html->url($sub_menu_depth_2['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_2['Menu']['seo_name'], array('remove' => true))) ?>">
															<?php echo $sub_menu_depth_2['Menu']['name'] ?>
														</a>
													</li>
												<?php endforeach ?>
											</ul>
											
											<?php if ($sub_menu_depth_2['Menu']['model'] == 'Category'): ?>
												<hr class="sub-sco-hr" />
												
												<ul class="sub-categories-options sub-sco">
													<li>
														<a href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
															<?php __('Pokaż wszystkie') ?> <i class="fa fa-angle-right" aria-hidden="true"></i>
														</a>
													</li>
												</ul>
											<?php endif ?>
										<?php else: ?>
											<a class="only-link" href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
												<?php echo $sub_menu_depth_1['Menu']['name'] ?>
											</a>
										<?php endif ?>
									</div>
								<?php endforeach ?>
							</div>
						<?php endforeach ?>
						
						<?php if ($item['Menu']['model'] == 'Category'): ?>
							<hr>
							
							<ul class="sub-categories-options">
								<li>
									<a href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
										<?php __('Pokaż wszystkie') ?> <i class="fa fa-angle-right" aria-hidden="true"></i>
									</a>
								</li>
							</ul>
						<?php endif ?>
					</div>
				<?php else: ?>
					<a href="<?php echo $this->Html->url($item['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($item['Menu']['seo_name'], array('remove' => true))) ?>">
						<?php echo $item['Menu']['name'] ?>
					</a>
				<?php endif ?>
			<?php endforeach ?>
			<li>
				<a href="<?php echo $this->Html->url('/producenci') ?>" title="<?php echo h(__('Producenci')) ?>">
					<?php __('Producenci') ?>
				</a>
			</li>
			<li>
				<a href="<?php echo $this->Html->url('/blog') ?>" title="<?php echo h(__('Blog')) ?>">
					<?php __('Blog') ?>
				</a>
			</li>
			<li>
				<?php echo $this->element(TEMPLATE_NAME.DS.'header_user_status_mobile') ?>
			</li>
		</ul>
	<?php endif ?>
</nav>