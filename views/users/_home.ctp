<div class="home-page">
	<h2 class="mark-text"><?php __('Kolekcja by Santoro London')?></h2>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'banners_collection',
			array(
				'container_class' => 'collection-banners',
				'section'         => 3
			)
		)
	?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'banners_homepage',
			array(
				'container_class' => 'homepage-banners',
				'section'         => 6
			)
		)
	?>
</div>