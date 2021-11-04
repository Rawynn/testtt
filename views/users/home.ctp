<div class="home-page">
	<?php 
	$current_url = getCurrentUrl();
	switch ($current_url['language']) {
		case "pol":
			$i = 3;
			$a = 6;
			break;
		case "cze":
			$i = 11;
			$a = 19;
			break;
		case "slo":
			$i = 12;
			$a = 20;
			break;
		case "deu":
			$i = 13;
			$a = 21;
			break;
		case "hun":
			$i = 14;
			$a = 22;
			break;
	}
	?>
	<h2 class="mark-text"><?php __('Kolekcja by Santoro London')?></h2>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'banners_collection',
			array(
				'container_class' => 'collection-banners',
				'section'         => $i
			)
		)
	?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'banners_homepage',
			array(
				'container_class' => 'homepage-banners',
				'section'         => $a
			)
		)
	?>
</div>