<?php if (getCurrentPaginatePage() == 1): ?>
	<?php if ($category['Category']['id']): ?>
		<?php
			/* Banery kategorii */
			echo $this->element(
				TEMPLATE_NAME.DS.'banners',
				array(
					'container_class'   => 'category-banners',
					'carousel_id'       => 'CategoryBanners',
					'section'           => 2,
					'banner_categories' => $category['Category']['id']
				)
			)
		?>
	<?php endif ?>
<?php endif ?>