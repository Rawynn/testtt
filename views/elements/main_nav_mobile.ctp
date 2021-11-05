<?php if ($menu = getMainMenu(1, true)): ?>
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
<?php endif ?>
<?php if ($menu2 = getMainMenu(2)): ?>		
	<li>
		<a data-type="slidemenu" data-target="1" href="<?php echo $this->Html->url(getModel('Menu')->getTranslateField('url', 2)) ?>" title="<?php echo h(Sanitize::html(getModel('Menu')->getTranslateField('name', 2), array('remove' => true))) ?>">
			<i class="fa fa-angle-left"></i> <?php echo getModel('Menu')->getTranslateField('name', 2)?> <i class="fa fa-angle-right"></i>
		</a>
		<div class="sub-cat" data-id="1" data-group="subcategory">
			<div class="row">
				<?php foreach ($menu2 as $sub_menu_depth_1): ?>
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
						<?php else: ?>
							<a class="only-link" href="<?php echo $this->Html->url($sub_menu_depth_1['Menu']['url']) ?>" title="<?php echo h(Sanitize::html($sub_menu_depth_1['Menu']['seo_name'], array('remove' => true))) ?>">
								<?php echo $sub_menu_depth_1['Menu']['name'] ?>
							</a>
						<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</li>
<?php endif ?>
<?php if ($menu3 = getMainMenu(16, true)): ?>
	<li>
		<a href="<?php echo $this->Html->url(getModel('Menu')->getTranslateField('url', 16)) ?>" title="<?php echo h(Sanitize::html(getModel('Menu')->getTranslateField('name', 16), array('remove' => true))) ?>">
			<?php echo Sanitize::html(getModel('Menu')->getTranslateField('name', 16), array('remove' => true)) ?>
		</a>
	</li>
<?php endif ?>
<?php if ($menu4 = getMainMenu(17, true)): ?>
	<li>
		<a href="<?php echo $this->Html->url(getModel('Menu')->getTranslateField('url', 17)) ?>" title="<?php echo h(Sanitize::html(getModel('Menu')->getTranslateField('name', 17), array('remove' => true))) ?>">
			<?php echo Sanitize::html(getModel('Menu')->getTranslateField('name', 17), array('remove' => true)) ?>
		</a>
	</li>
<?php endif ?>