<?php if ($pages_menu = getSectionStaticPages(6)): ?>
	<a class="responsive-toggle inverse" data-type="toggle" href="#StaticPagesMenu" title="<?php echo h(__('Menu', true)) ?>">
		<?php __('Menu') ?> <i class="icon-reorder pull-right"></i>
	</a>
	
	<ul class="menu nav-justified" id="StaticPagesMenu">
		<?php foreach ($pages_menu as $key => $page_menu): ?>
			<?php $current_url = parse_url(Router::url($this->here, true)) ?>
			
			<?php if ($page_menu['StaticPage']['only_url'] == 1): ?>
				<li class="<?php echo strpos($current_url['path'], $page_menu['StaticPage']['url']) ? 'active' : '' ?>">
					<?php
						echo $this->Html->link(
							$page_menu['StaticPage']['title'],
							$page_menu['StaticPage']['url'],
							array(
								'escape' => false,
								'title'  => h($page_menu['StaticPage']['title'])
							)
						)
					?>
				</li>
			<?php else: ?>
				<li class="<?php echo $page_menu['StaticPage']['id'] ==  $page['StaticPage']['id'] ? 'active' : '' ?>">
					<?php
						echo $this->Html->link(
							$page_menu['StaticPage']['title'],
							getStaticPageUrl($page_menu['StaticPage']['id']),
							array(
								'escape' => false,
								'title'  => h($page_menu['StaticPage']['title'])
							)
						)
					?>
				</li>
			<?php endif ?>
		<?php endforeach ?>
	</ul>
<?php endif ?>