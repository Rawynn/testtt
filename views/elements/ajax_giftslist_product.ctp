<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'gifts_list'.DS.'input_product',
		array(
			'key'         => getPageParamValue('key'),
			'show_delete' => false
		)
	)
?>