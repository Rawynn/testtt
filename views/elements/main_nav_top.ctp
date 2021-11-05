<nav class="main-nav-top">
	<?php if ($categories = getCategoryTree('all')): ?>
		<ul>
			<li>
				<a data-type="slidemenu" data-target="MainNav2" href="#" title="<?php echo h(__('Wszystkie produkty')) ?>">
					<?php __('Wszystkie produkty') ?> <i class="fa fa-angle-down"></i>
				</a>
				<?php 
					/* Nawigacja - kategorie */
					echo $this->element(
						TEMPLATE_NAME.DS.'main_nav',
						array(
							'cache' => array(
								'time' => Configure::read('Cache.short_time'),
										'key'  => getStandardCacheKey()
									)
								)
						)
				?>
			</li>

			<li>
				<a data-type="slidemenu" data-target="MainNav3" href="#" title="<?php echo h(__('Okolicznościowe')) ?>">
					<?php __('Kategorie specjalne') ?> <i class="fa fa-angle-down"></i>
				</a>
				<?php 
					/* Nawigacja - kategorie */
					echo $this->element(
						TEMPLATE_NAME.DS.'main_nav2',
						array(
							'cache' => array(
								'time' => Configure::read('Cache.short_time'),
										'key'  => getStandardCacheKey()
									)
								)
						)
				?>
			</li>

			<?php foreach (getSectionStaticPages(10) as $page): ?>
				<?php
					if ($page['StaticPage']['only_url']):
						$url = $page['StaticPage']['url'];
					else:
						$url = getStaticPageUrl($page['StaticPage']['id']);
					endif;
				?>
				
				<li>
					<a <?php echo ($page['StaticPage']['title'] == 'Outlet')? 'rel="nofollow"' : '';?>  href="<?php echo $this->Html->url($url) ?>" title="<?php echo h($page['StaticPage']['title']) ?>">
						<?php echo $page['StaticPage']['title'] ?>
					</a>
				</li>
			<?php endforeach ?>
			<li>
				<a href="<?php echo $this->Html->url('/blog') ?>" title="<?php echo h(__('Blog')) ?>">
					<?php __('Blog') ?>
				</a>
			</li>
		</ul>
	<?php endif ?>
</nav>
