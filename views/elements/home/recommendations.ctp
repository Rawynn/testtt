<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'home'.DS.'tab_box',
		array(
			'products' => $is_first ? getRecommendedProductsForUser(setting('MODULE_MAIN_RECOMMENDED_ENTRIES_NUMBER')) : array(),
			'is_first' => $is_first,
			'box_name' => $box_name
		)
	)
?>