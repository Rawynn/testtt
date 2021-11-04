<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'home'.DS.'tab_box',
		array(
			'products' => $is_first ? getMainpageNewProducts() : array(),
			'is_first' => $is_first,
			'box_name' => $box_name
		)
	)
?>