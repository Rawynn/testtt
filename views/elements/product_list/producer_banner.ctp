<?php if (getCurrentPaginatePage() == 1): ?>
	<?php if ($producer['Producer']['id']): ?>
		<?php
			/* Banery kategorii */
			echo $this->element(
				TEMPLATE_NAME.DS.'banners',
				array(
					'container_class'    => 'category-banners',
					'carousel_id'        => 'ProducerBanners',
					'section'            => 3,
					'banner_producer_id' => $producer['Producer']['id']
				)
			)
		?>
	<?php endif ?>
<?php endif ?>