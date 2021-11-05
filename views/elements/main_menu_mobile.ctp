<nav class="main-nav" data-id="MainNav" data-group="subcategory-top">
	<ul class="main-nav-list nav-justified" id="MainNav" data-toggle-extended-elements="top-navigation">
		<li class="mobile-close-nav">
			<span data-type="show-menu-mobile">
				&times;
			</span>
		</li>
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'main_nav_mobile',array(
					'cache' => array(
						'time' => Configure::read('Cache.short_time'),
						'key' => getStandardCacheKey()
					)
				)
			);
		?>
		<li>
			<?php echo $this->element(TEMPLATE_NAME.DS.'header_user_status_mobile') ?>
		</li>
	</ul>
</nav>